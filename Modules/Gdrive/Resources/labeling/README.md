# Auto-labeling de fotos (status `labeling`)

Quando um Assignment entra no status **`labeling`**, o pipeline:

1. Copia todas as imagens de `Kruger Pictures/` (+ subpastas) do Drive do job.
2. Deduplica (dHash perceptual + near-duplicate). Mantém a mais nítida de cada
   grupo. Se sobrar menos que `min_photos` (50), afrouxa o limiar.
3. Reduz cada foto e manda pra IA (Claude Sonnet 5, **Batches API**) descrever.
4. Ordena pelas categorias de `vocabulary.md`, numera `001…NNN`.
5. Carimba a label na foto (faixa preta + texto branco) e sobe em `Labeling/`.
   As descartadas (originais) vão pra `Labeling/_discarded/`.
6. Move o job pro status `preparing_billing`.

## Arquivos editáveis (sem tocar em PHP)

- `system_prompt.md` — papel + regras de como decidir a descrição.
- `vocabulary.md` — descrições preferidas. **A ordem das seções `##` é a ordem
  de numeração das fotos.**
- `rules.md` — regras de negócio (vão crescendo).
- `banned.md` — palavras que a IA nunca pode usar.

Depois de editar, rode `php artisan config:clear` só se o config estiver cacheado
(os `.md` são lidos do disco a cada job, não precisam de clear).

## Setup

```bash
# no container php-fpm
php artisan migrate            # cria a tabela quee_labeling
php artisan config:clear
```

`.env`:
```
ANTHROPIC_API_KEY=sk-ant-...
LABELING_AI_DRIVER=anthropic
LABELING_AI_MODEL=claude-sonnet-5
LABELING_AI_MODE=sync          # sync = termina em minutos (~2x custo) | batch = ~50% mais barato, SLA até 24h
LABELING_SYNC_CONCURRENCY=5    # chamadas paralelas no modo sync
```

**`sync`** resolve tudo dentro do `queue_labeling` (não usa `poll_labeling`).
**`batch`** envia o lote e o `poll_labeling` coleta depois. Use `batch` só em
storm surge, quando o custo importa mais que a pressa.

## Cron (servidor online)

```
*/5  * * * *  curl -fsS https://SEU_DOMINIO/gdrive/add_queue_labeling/  > /dev/null
*/2  * * * *  curl -fsS https://SEU_DOMINIO/gdrive/queue_labeling/      > /dev/null
*/2  * * * *  curl -fsS https://SEU_DOMINIO/gdrive/poll_labeling/       > /dev/null
```

- `add_queue_labeling` — enfileira jobs em `labeling`.
- `queue_labeling` — processa 1 job: baixa, deduplica, envia o batch. Um por vez.
- `poll_labeling` — coleta batches prontos, carimba, sobe, muda status.

## Acompanhamento

Tabela `quee_labeling`: coluna `history` (log HTML por etapa), `status`
(`pending` → `processing` → `awaiting_ai` → `complete` / `error`), `batch_id`,
`payload` (manifesto JSON).
