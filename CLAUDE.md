# krugerLast

Sistema Laravel modular (nwidart/laravel-modules) rodando em Docker.

## Stack

- Laravel 8.54, PHP 7.3/8.0
- Livewire (UI reativa dentro dos módulos, `Http/Livewire`)
- MySQL/MariaDB, Redis (+ redis-webui)
- Nginx + php-fpm
- Docker Compose definido em `../docker-compose.yml` (um nível acima deste repo) — serviços: `mysql`, `php-fpm`, `nginx`, `redis`, `redis-webui`, helper de redis. PostgreSQL e laravel-echo-server estão comentados/não ativos.

## Arquitetura

Tudo fica dentro de `Modules/<NomeDoModulo>/`, cada módulo com sua própria estrutura Laravel completa (Config, Console, Database/Migrations, Database/Seeders, Entities, Http/Controllers, Http/Livewire, Http/Middleware, Http/Requests, Providers, Repositories, Resources, Routes, Scopes, Tests, Traits).

Módulos atuais: Activity, Addons, Alacrity, Assignments, Car, Charts, Component, Core, Dashboard, Element, Employees, Gdrive, Integration, Menu, Notes, Packages, Password, Profile, Referrals, Reports, Scheduling, Theme, User.

Há também `Themes/` (temas de front-end) e `packages/` (pacotes locais fora de `Modules/`).

Padrão comum: Controller fino → Repository (em `Repositories/`) → Entities (models). Regras de negócio específicas costumam ficar em `Scopes/` e `Traits/`.

## Convenções ao mexer no código

- Ao adicionar/alterar uma feature, procure primeiro o módulo correspondente — evite criar código fora de `Modules/` a menos que seja infra genuinamente compartilhada.
- Migrations ficam em `Modules/<Modulo>/Database/Migrations` — nunca editar uma migration já mergeada em `main`, criar uma nova.
- Testes existem em `Modules/<Modulo>/Tests/{Feature,Unit}` mas a cobertura é desigual entre módulos — não assumir que existe teste para algo só porque a pasta existe.
- O histórico de commits no `main` tem muitas mensagens não descritivas (ex: "dwdwdw", "assdaasd") — não usar `git log`/`git blame` como fonte confiável de contexto de negócio; confirmar com o usuário quando a motivação de uma mudança não for óbvia pelo código.
- Não commitar nem sobrescrever `.env`, `DEV-firebase-credentials.json`, `DEV-google-services.json`, `firebase-credentials.json`, `google-services.json` — contêm credenciais.

## Rodando localmente

O ambiente sobe via Docker Compose a partir de `/Users/felipebenks/Desktop/Projects/docker` (não daqui). Comandos artisan/composer devem rodar dentro do container `php-fpm`.
