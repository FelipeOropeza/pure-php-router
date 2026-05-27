# Mapa de Melhorias do Projeto

Análise feita com base no código atual do projeto (maio/2026). O documento está dividido em duas partes:
- **Parte 1:** O que já foi implementado, com verificação de qualidade e pequenas melhorias pontuais.
- **Parte 2:** O que ainda falta implementar — apenas o que pesquisar, sem resposta pronta.

---

# PARTE 1 — Já Implementado

## ✅ 1. Singleton no Banco de Dados (`database.php`)

**O que foi feito:** `Database::getConnection()` usa `private static ?PDO $conn = null`. Na primeira chamada, abre a conexão e salva. Nas próximas, retorna a mesma instância. Correto.

**Pequena melhoria detectada:** O `catch` usa `die()`, que é a forma mais primitiva de parar a aplicação. Quando o sistema de Tratamento Global de Exceções (item 12) for implementado, o `die()` precisará ser substituído para que o handler global consiga capturar o erro e renderizar uma página amigável.

---

## ✅ 2. Query Builder com múltiplos WHERE (`query.php`)

**O que foi feito:** O `get()` itera corretamente sobre `$query['where']` com `foreach` e monta a cláusula `WHERE` completa com `AND`. Correto.

**Bug detectado no `orderBy`:** O método armazena os campos como array (preparado para múltiplos), mas na hora de montar o SQL só pega o índice `[0]` — o mesmo bug que o `WHERE` antigo tinha. Precisa ser corrigido para iterar todos os campos, igual ao que foi feito no `WHERE`.

---

## ✅ 3. Segurança no Request (`request.php`)

**O que foi feito:** Usa `filter_input_array(INPUT_POST, $filters)` com filtro customizável. Correto. Nenhuma melhoria crítica necessária.

---

## ✅ 4. Chave Primária Dinâmica (`model.php`)

**O que foi feito:** `protected string $primaryKey` existe e é usado corretamente em `delete` e `update`. Correto. Nenhuma melhoria necessária.

---

## ✅ 5. Sistema de Layout com Output Buffering (`controller.php`)

**O que foi feito:** `view()` usa `ob_start()` / `ob_get_clean()` para capturar o HTML da view e injetar no layout. Correto.

---

## ✅ 6. Variáveis de Ambiente (`.env`)

**O que foi feito:** Usa `vlucas/phpdotenv`. O `index.php` carrega o `.env` antes de tudo. Correto.

**Verificar:** Confirme que o `.env` está listado no `.gitignore`. O `.env.example` deve existir no repositório com as chaves mas sem os valores reais, para servir de guia.

---

## ✅ 7. Autoloading PSR-4 (`composer.json`)

**O que foi feito:** `"psr-4": {"App\\": "src/"}` configurado no Composer. Nenhum `require_once` manual necessário. Correto. Nenhuma melhoria necessária.

---

# PARTE 2 — A Implementar

> Nesta seção você encontra apenas **o que pesquisar**. O código é por sua conta.

---

## ✅ 8. Status Codes HTTP Corretos (`route.php`)

**O Problema:** O `route.php` usa `header("HTTP/1.0 404 Not Found")`. O protocolo HTTP/1.0 é antigo e o PHP tem uma função nativa moderna para isso.

**O que pesquisar:**
- `http_response_code()` PHP — como usar e a diferença para o `header()` manual
- Lista de códigos de status HTTP (404, 405, 500...) e o que cada um significa

---

## ✅ 9. Rotas Dinâmicas com Parâmetros (`route.php`)

**O Problema:** O router só faz match de string exata. Rotas como `/user/{id}` não funcionam.

**O que pesquisar:**
- **`preg_match()` em PHP** — como testar se uma string bate com um padrão
- **`preg_replace()` em PHP** — como transformar um padrão como `/user/{id}` em uma regex válida
- **Grupos de captura em Regex** — como extrair o valor de `{id}` da URL acessada
- **Spread operator (`...$array`) em PHP** — como passar um array de argumentos para uma função dinamicamente

---

## ✅ 10. Tipagem Estrita e Recursos do PHP 8+

**O Problema:** Sem tipagem estrita, o PHP converte tipos silenciosamente, o que pode esconder bugs. Além disso, o código de classes pode ser mais enxuto.

**O que pesquisar:**
- **`declare(strict_types=1)` em PHP** — o que faz e onde colocar
- **Constructor Property Promotion (PHP 8.0)** — como declarar e inicializar propriedades diretamente no construtor
- **Enums em PHP (PHP 8.1)** — o que são, como criar e quando usar no lugar de strings soltas
- **Propriedades `readonly` em PHP (PHP 8.1)** — o que são e qual problema elas resolvem

---

## ✅ 11. Middlewares (Interceptadores de Rota)

**O Problema:** Não existe camada entre a rota e o Controller. Proteger rotas exige repetir lógica em cada método.

**O que pesquisar:**
- **Interfaces em PHP (`interface`)** — o que são, como criar e como implementar em uma classe
- **Design Pattern Pipeline / Chain of Responsibility** — como executar uma fila de objetos em sequência
- **`class_exists()` e instanciação dinâmica de classes em PHP** — como criar um objeto a partir de um nome de classe guardado em uma string

---

## ✅ 12. Tratamento Global de Exceções (Quase feito)

**O Problema:** Erros não tratados exibem mensagens cruas na tela (vaza informação de segurança) ou mostram tela em branco. O `die()` no `database.php` é o principal exemplo disso.

**O que pesquisar:**
- **`set_exception_handler()` em PHP** — como registrar uma função que captura todas as exceções não tratadas
- **`set_error_handler()` em PHP** — diferença entre erro e exceção no PHP e como tratar ambos
- **Hierarquia de exceções em PHP (`Exception`, `Error`, `Throwable`)** — entender a diferença entre os tipos
- **Como criar exceções customizadas** — estender a classe `Exception` para criar `RouteNotFoundException`, `ViewNotFoundException`, etc.
- **Variável de ambiente `APP_ENV`** — como usar para exibir detalhes do erro em desenvolvimento e esconder em produção
