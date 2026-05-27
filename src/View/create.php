<form action="/createPost" method="post">
    <h1>Adicionar novo post</h1>
    <input type="text" name="title" placeholder="Título do post" required>
    <br><br>
    <input type="text" name="description" placeholder="Descrição do post" required>
    <br><br>
    <input type="text" name="author" placeholder="Autor do post" required>
    <br><br>
    <input type="submit" value="Salvar" class="button"> <a href="/" class="button">Voltar</a>
</form>
<style>
    .button {
        text-decoration: none;
        background-color: #000;
        color: #fff;
        padding: 10px;
    }
</style>