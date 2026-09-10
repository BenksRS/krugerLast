# Few-shot examples

Cada entrada em `examples.json` vira um par (foto → label esperado) enviado ao
modelo antes da foto real. Use pra corrigir erros recorrentes que as regras de
texto sozinhas não resolvem (ex.: identificar equipamento).

## Como adicionar

1. Coloca a **foto original** (sem a faixa de label) neste diretório, ex.:
   `mini-skid-pov.jpg`. Pode reduzir pra ~1024px pra economizar token.
2. Adiciona uma entrada em `examples.json`:
   ```json
   {
     "image": "mini-skid-pov.jpg",
     "description": "Mini Skid Working",
     "category": "Crew and Equipment",
     "from_vocabulary": true,
     "note": "explicação só pra humano, não vai pro prompt"
   }
   ```
3. Commit + push. O próximo job já usa (os `.md`/`.json` são lidos a cada job).

## Cuidados

- Máximo 8 exemplos são usados (os primeiros do arquivo). Cada imagem adiciona
  ~1–1.5k tokens por request — mas o prefixo (system + few-shot) fica em cache,
  então só a 1ª foto de cada job paga o valor cheio.
- `description` tem que ser exatamente como você quer que apareça na foto.
- Use exemplos **inequívocos** — foto ruim ensina o modelo errado.
