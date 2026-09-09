# krugerLast — Análise de Performance e Arquitetura de Relatórios

Data: 2026-09-09
Escopo original: exploração real do código, do banco (via `docker exec mysql`) e do ambiente Docker rodando localmente.

**Atualização 2026-09-09 (mesma data): itens 1, 2 (parcial), 3 e o índice do item recomendado foram implementados e validados com dados reais.** Ver seção 7.

---

## 1. Ambiente

Containers ativos (`docker ps`): `mysql`, `php-fpm`, `nginx`, `redis`, `redis-webui`. Todos up.

Configuração efetiva (`.env`):

| Item | Valor atual | Observação |
|---|---|---|
| `CACHE_DRIVER` | `file` | Redis está rodando e disponível, mas não é usado para cache |
| `QUEUE_CONNECTION` | `sync` | Não existe nenhuma `Job` real no código (`Modules/**/Jobs`) — tudo roda de forma síncrona, na mesma request |
| `SESSION_DRIVER` | `file` | Idem cache |
| `REDIS_HOST` | `127.0.0.1` | Inconsistente com Docker Compose — o `php-fpm` está em container separado do `redis`; o host correto na rede `backend` é `redis` (nome do serviço). Hoje isso não quebra nada porque Redis não é usado, mas é uma armadilha pronta para quando alguém tentar ativar cache/queue via Redis e não entender por que não conecta. |

**Conclusão:** há um recurso de infraestrutura pago (container Redis rodando) que hoje não entrega valor nenhum ao sistema.

---

## 2. Arquitetura observada

- Laravel 8.54 modular (`nwidart/laravel-modules`), ~23 módulos em `Modules/`.
- Padrão dominante nos módulos "de negócio" (Assignments, Employees, etc.): Controller fino → Repository → Entity, com regras específicas em `Scopes/`/`Traits/`.
- **Os módulos `Reports` e `Dashboard` não seguem esse padrão** — não têm pasta `Repositories/`. Toda a lógica de query, agregação e formatação fica direto dentro dos componentes Livewire (`Http/Livewire/**`), em arquivos de 100–280 linhas. Isso explica por que criar um relatório novo hoje significa copiar um componente inteiro (ver seção 4).

---

## 3. Gargalo de performance identificado

### 3.1 `AssignmentFinanceRepository` — carregamento e cálculo sempre "no máximo"

Arquivo: [`Modules/Assignments/Repositories/AssignmentFinanceRepository.php`](../Modules/Assignments/Repositories/AssignmentFinanceRepository.php)

```php
protected $with    = ['scheduling','referral','commissions','carrier','status','status_collection',
                       'event','phones','user_updated','user_created','job_types','invoices',
                       'payments','tags', 'workers', 'commissions','reports'];

protected $appends = ['finance','follow_up_date', 'lien_date_view', 'projected_lien_date_view'];
```

- `$with` faz **13 relações serem carregadas em toda query** feita através desse repositório, independente da tela precisar de 2 ou de todas as 13. Esse repositório é a base de praticamente todo relatório financeiro/follow-up do sistema (Dashboard, Reports/Mkt, Reports/Info, etc.).
- `$appends` inclui `finance`, que dispara `getFinanceAttribute()` (linhas 56–240) **toda vez que o model é acessado/serializado**. Esse accessor faz cerca de 10 operações de soma/filtro sobre as coleções `invoices`, `payments` e `reports`, mais lógica condicional de status (switch com múltiplos casos) — **por linha**, não em lote.

### 3.2 Filtro de negócio aplicado em PHP, depois do `->get()`, não no SQL

Exemplo real em [`Modules/Dashboard/Http/Livewire/List/Fallowup30.php:118-130`](../Modules/Dashboard/Http/Livewire/List/Fallowup30.php):

```php
$list = AssignmentFinanceRepository::Collection($this->selectedStatus)
    ->whereDate('follow_up', '<=', $today)
    ->search($searchAssignment)
    ->when(...)
    ->get();                                    // <- traz TUDO que bate no status/follow_up

$list = $list
    ->where('finance.collection.days_from_billing', '>', 29)   // <- filtro real, em PHP,
    ->where('finance.collection.days_from_billing', '<', 45);  //    sobre Collection já carregada
$total_collection = $list->sum('finance.invoices.total');
$list = $list->sortBy($this->sortBy);                          // <- sort também em PHP
```

`days_from_billing` só existe depois que `finance` (o accessor pesado) já foi calculado para a linha inteira. Ou seja: **o banco não filtra por faixa de dias — o PHP calcula o financeiro completo de cada assignment candidato, e só depois descarta a maioria.**

### 3.3 Escala real, confirmada no banco

```
SELECT COUNT(*) FROM assignments;                              -> 44.144
SELECT COUNT(*) FROM assignments WHERE status_id IN (5,6,9,10,24); -> 29.736
```

O status acima é exatamente o filtro usado pelos relatórios de follow-up/collection. Ou seja, esses relatórios são candidatos a carregar **até ~30 mil registros**, cada um com 13 relações eager-loaded e um accessor de ~10 agregações, para no fim mostrar só a fatia que cai numa janela de dias específica. Isso é consistente com relatórios "lentos" na prática.

Índices existentes em `assignments` (`SHOW INDEX`): `id` (PK), `created_by`, `updated_by`, `referral_id`, `status_id`, `status_collection_id`. Não há índice composto em `(status_id, follow_up)`, que é exatamente a combinação usada no `WHERE` desses relatórios — mesmo se o filtro de data fosse movido pro SQL, valeria revisar esse índice.

### 3.4 N+1 potencial secundário

Em [`Modules/Reports/Http/Livewire/Mkt/Search.php:136`](../Modules/Reports/Http/Livewire/Mkt/Search.php): `$job->referral->type->name` dentro de um loop. `referral` está no `$with` do repositório, mas `referral.type` (relação aninhada) não — cada iteração pode disparar uma query adicional dependendo de como `type()` está definida no model `Referral`. Não confirmei o impacto exato (não medi query count em runtime), mas é um padrão a verificar com `DB::listen` ou Telescope/Debugbar numa próxima etapa.

---

## 4. Duplicação de código nos relatórios de follow-up

`Fallowup30.php`, `Fallowup45.php`, `Fallowup60.php`, `Fallowup90.php` (em `Modules/Dashboard/Http/Livewire/List/`) são **o mesmo componente copiado 4 vezes** — confirmado via `diff`. A única diferença funcional real entre eles é a faixa de dias no filtro (`>29 <45`, `>44`, etc. — os números nem seguem um padrão consistente entre os arquivos). O resto (propriedades, `mount()`, `getFormBuilder()`, `filter()`, `render()`) é idêntico, com pequenas diferenças de formatação de código (indentação/espaçamento) que sugerem edição manual arquivo por arquivo ao longo do tempo.

**Consequência prática:** qualquer correção de bug ou melhoria (inclusive a otimização da seção 3) precisa ser replicada manualmente em 4 lugares — e claramente já não está sendo (os thresholds divergem entre arquivos). Isso também é o principal motivo de "criar uma ferramenta de relatório nova" ser lento hoje: o caminho natural é copiar um desses arquivos de novo.

---

## 5. Recomendações, em ordem de custo/risco

| # | Ação | Impacto esperado | Risco / esforço |
|---|---|---|---|
| 1 | Ativar Redis para `CACHE_DRIVER`/`SESSION_DRIVER` (e `QUEUE_CONNECTION` se houver trabalho assíncrono futuro) e corrigir `REDIS_HOST` | Baixo a médio (mais notável se dados de referência — referrals, job types, status — forem cacheados) | Baixo — mudança de config, reversível |
| 2 | Mover o filtro `days_from_billing`/faixa de dias para o SQL (via `whereHas` em `invoices`/subquery, ou coluna calculada) em vez de filtrar a Collection depois do `get()` | Alto — deve reduzir drasticamente linhas carregadas e chamadas ao accessor `finance` nos relatórios de follow-up | Médio/Alto — `getFinanceAttribute()` tem lógica de negócio não trivial (máquina de estados de status) que precisaria ser parcialmente replicada ou refatorada para SQL/query scope |
| 3 | Consolidar `Fallowup30/45/60/90` num único componente parametrizado por range de dias | Facilita manutenção e criação de novos relatórios de follow-up; corrige a divergência de thresholds encontrada | Baixo/Médio — mecânico, mas precisa confirmar com o usuário do sistema qual threshold de cada tela é o "correto" antes de unificar |
| 4 | Adicionar `protected $with` mais enxuto por caso de uso (ou usar `::with([...])` explícito por tela em vez de sempre carregar as 13 relações) | Médio — reduz volume de dados trazido do banco em telas que não precisam de tudo | Médio — requer mapear quais relações cada tela realmente usa |
| 5 | Paginar as listas de relatório em vez de `->get()` tudo | Alto para UX/memória em relatórios grandes | Médio — pode exigir mover ordenação/agrupamento (hoje feitos em PHP sobre a Collection) para o SQL |

Itens 2, 4 e 5 são relacionados — a raiz comum é que `AssignmentFinanceRepository` foi desenhado para "trazer tudo e computar em PHP", o que funciona em volumes pequenos mas não escala para ~30 mil linhas.

---

## 6. Próximos passos sugeridos (histórico — ver seção 7 para o que foi feito)

Quando você quiser seguir, dá pra atacar isoladamente qualquer item da tabela acima — o item 1 (Redis) é o mais seguro para começar; os itens 2–5 mexem em código usado por múltiplas telas de relatório e merecem teste manual nas telas afetadas antes de ir pra produção.

---

## 7. O que foi implementado

Todas as mudanças abaixo foram testadas contra o banco real do ambiente local (44.144 assignments) antes de serem aplicadas definitivamente.

### 7.1 Redis (item 1) — feito

`.env`: `CACHE_DRIVER` e `SESSION_DRIVER` mudados de `file` para `redis`; `REDIS_HOST` corrigido de `127.0.0.1` para `redis` (nome do serviço no Docker). Validado com uma request HTTP real — chaves aparecendo no Redis (`redis-cli KEYS "*"`), sem erro 500.

`QUEUE_CONNECTION` **não foi alterado** (continua `sync`) — não existe nenhum worker de fila (`queue:work`/supervisor) rodando no ambiente, e não há nenhuma classe `Job` no código. Mudar para `redis` sem um worker supervisionado faria qualquer job enfileirado nunca rodar, silenciosamente. Se no futuro vocês quiserem processamento assíncrono de verdade, aí sim faz sentido ativar.

### 7.2 N+1 de `referral.type` (item da seção 3.4) — feito

[`AssignmentFinanceRepository.php`](../Modules/Assignments/Repositories/AssignmentFinanceRepository.php): `$with` passou a carregar `referral.type` (relação aninhada) em vez de só `referral`. Confirmado via `DB::enableQueryLog()` que o carregamento continua em lote (não cresce por linha).

### 7.3 Índice composto (apoio ao item 2) — feito

Nova migration `2026_09_09_000001_add_reporting_indexes` adiciona:
- `assignments (status_id, follow_up)`
- `finance_billing (assignment_id, type, billed_date)`

Já rodada no ambiente local (`module:migrate Assignments`). **Nota honesta:** sozinho, o índice em `assignments` não mudou o plano de execução do MySQL para a query base desses relatórios (o otimizador ainda prefere full scan quando o filtro de status cobre ~68% da tabela) — o ganho real veio do item 7.4 abaixo. O índice em `finance_billing` é o que sustenta esse filtro.

### 7.4 Filtro de "dias desde o billing" movido parcialmente para o SQL (item 2) — feito, de forma conservadora

Adicionei dois scopes reutilizáveis em [`AssignmentScope.php`](../Modules/Assignments/Scopes/AssignmentScope.php): `scopeBilledDaysAgoAtLeast($minDays)` e `scopeBilledDaysAgoAtMost($maxDays)`. Eles fazem uma pré-filtragem no SQL (via `whereHas('invoices', ...)` na data de billing, com margem de segurança de alguns dias) **antes** do `->get()`.

Importante: isso é uma pré-filtragem de superconjunto, não uma substituição da lógica de negócio. O cálculo exato de `days_from_billing` (que depende do accessor `finance`, com toda a máquina de estados de status) **continua rodando em PHP exatamente como antes**, sobre um conjunto menor de linhas. Ou seja: **o resultado final é idêntico ao de antes** — validei isso comparando o hash dos IDs retornados (antes vs. depois) para os 4 relatórios, usando dados reais do banco, e bateu 100% nos quatro casos.

Aplicado em `Fallowup30.php`, `Fallowup45.php`, `Fallowup60.php`, `Fallowup90.php`, com os mesmos thresholds que cada arquivo já usava (ver seção 7.6 sobre isso).

No ambiente local (volume pequeno, 53 assignments candidatos por causa do filtro `follow_up`), a redução observada foi de ~30-50% menos linhas carregadas antes da filtragem final em PHP. Em produção, com mais dados e follow_up dates mais dispersas, a redução tende a ser maior.

### 7.5 Deduplicação de Fallowup30/45/60/90 (item 3) — feito, parcialmente

Os 4 arquivos tinham duas "famílias" de boilerplate idêntico entre si (30/45 usam listas plucked id→nome; 60/90 usam coleções completas de model — telas diferentes, bindings diferentes). Extraí cada família para uma trait:

- [`Modules/Dashboard/Traits/FollowupReportCompactFields.php`](../Modules/Dashboard/Traits/FollowupReportCompactFields.php) (usada por Fallowup30 e Fallowup45)
- [`Modules/Dashboard/Traits/FollowupReportFullFields.php`](../Modules/Dashboard/Traits/FollowupReportFullFields.php) (usada por Fallowup60 e Fallowup90)

As 4 classes agora têm ~35-45 linhas cada (só `render()` com a lógica específica), em vez de ~140. Testei os 4 componentes de ponta a ponta com `Livewire::test()` (mount + render + compilação da view) autenticado como usuário real — os 4 renderizam sem erro e retornam totais calculados a partir de dados reais.

**Não fiz a unificação completa em um único componente parametrizado** porque, ao comparar os 4 arquivos de perto, achei duas divergências de comportamento que não são só o range de dias — ver seção 7.6. Prefiro não decidir isso sozinho.

### 7.6 Duas inconsistências que encontrei e NÃO resolvi sozinho

Preferi documentar e perguntar a vocês em vez de "corrigir" silenciosamente uma regra de negócio de relatório financeiro:

1. **Os ranges de dias se sobrepõem e têm buracos.** Fallowup30 = 29 < dias < 45 (faixa 30-44). Fallowup45 = dias > 44, sem teto (inclui 45, 60, 90+, tudo junto). Fallowup60 = dias < 60, sem piso (inclui 0 a 59 — sobrepõe com o próprio Fallowup30, que é um subconjunto de 0-59). Fallowup90 = dias > 59, sem teto (sobrepõe com Fallowup45 a partir de 60). Concretamente: um assignment com 50 dias desde o billing aparece em Fallowup45 **e** Fallowup60 ao mesmo tempo; um com 100 dias aparece em Fallowup45 **e** Fallowup90 ao mesmo tempo. Se a intenção é ter faixas exclusivas (algo como "30-44 / 45-59 / 60-89 / 90+"), os limites atuais não fazem isso.
2. **A lógica do filtro de referral/carrier é diferente entre as duas famílias.** Fallowup30/45 fazem `whereIn` (aceita múltiplos valores por filtro); Fallowup60/90 fazem `where` simples (só um valor). Pode ser intencional (telas diferentes, casos de uso diferentes) ou pode ser deriva de copy-paste.

Não alterei nenhum desses dois pontos — mantive o comportamento de cada arquivo exatamente como estava, só removendo a duplicação de código ao redor. Se vocês confirmarem quais são os ranges/regras corretas, aí sim dá pra unificar os 4 num componente único de verdade (parametrizado) e ainda fechar a sobreposição.

### 7.7 O que ficou de fora, propositalmente

- **`$with` mais enxuto por tela** (item 4 da tabela original): não mexi. Afeta ~15 componentes que usam `AssignmentFinanceRepository`/`Assignment`, cada um precisaria ser mapeado individualmente para saber quais relações usa de fato — risco de quebrar uma tela por remover uma relação que ela precisa não documentada. Fica para uma rodada dedicada.
- **Paginação real no banco** (item 5): hoje a ordenação (`sortBy`) é feita em PHP porque pode ordenar por `days_from_billing`, que é um campo calculado (não existe como coluna). Paginar de verdade no SQL exigiria mover esse cálculo para o banco também — mudança maior, não fiz.
