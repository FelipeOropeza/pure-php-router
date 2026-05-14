# Pure PHP Router

Um sistema de roteamento MVC construído do zero em PHP puro, sem frameworks. O objetivo do projeto é entender na prática como funcionam as camadas de um framework web moderno — rota, controller, model, query builder e layout — implementando cada uma manualmente.

## Tecnologias

- **PHP 8+**
- **PDO** — acesso ao banco de dados
- **MySQL** — banco de dados relacional
- **Composer** — gerenciamento de dependências e autoload PSR-4
- [`vlucas/phpdotenv`](https://github.com/vlucas/phpdotenv) — variáveis de ambiente
- [`symfony/var-dumper`](https://symfony.com/doc/current/components/var_dumper.html) — debug aprimorado

## Como Rodar

**Pré-requisitos:** PHP 8+, Composer e MySQL instalados.

**1. Clone o repositório:**
```bash
git clone <url-do-repositorio>
cd rotas
```

**2. Instale as dependências:**
```bash
composer install
```

**3. Configure as variáveis de ambiente:**
```bash
cp .env.example .env
```
Abra o `.env` e preencha com as suas credenciais:
```dotenv
DB_HOST=localhost
DB_NAME=nome_do_banco
DB_USER=seu_usuario
DB_PASS=sua_senha
```

**4. Inicie o servidor de desenvolvimento:**
```bash
composer run start
```
Acesse em: `http://localhost:8000`

## Próximos Passos

Consulte o [`melhorias.md`](./melhorias.md) para ver o mapa completo de melhorias planejadas, bugs conhecidos e o que estudar para implementar cada funcionalidade nova.
