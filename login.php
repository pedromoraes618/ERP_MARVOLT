<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Effmax</title>

    <!-- estilo -->
    <link href="_css/estilo.css" rel="stylesheet">
    <link href="_css/login.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>
</head>

<body>

    <?php include_once("_incluir/funcoes.php"); ?>

    <main>
        <div id="janela_principal">
            <form>
                <div class="img">
                    <img src="images/logoapp.jpg">
                </div>

                <h2>Login</h2>
                <input type="text" name="usuario" id="usuario" placeholder="Usuário" placeholder="Digite o seu usuario">
                <div class="input-senha">
                    <input type="password" name="senha" placeholder="Senha" id="senha" placeholder="Digite a sua senha">
                    <i id="mostrar_senha" onclick="mostrarOcultarSenha()" class="fa-solid fa-eye"></i>
                </div>
                <label>
                    <input name="lembrar_senha" id="lembrar_senha" type="checkbox" />
                    Lembrar Senha

                </label>

                <!-- <input type="checkbox" name="mostrarSenha"  id="mostrarSenha">
                <label id="mostrarSenha" for="mostrarSenha">Mostrar senha</label> -->

                <button type="button" name="btn_login" id="btn_login" class="btn btn-success">Login</button>
                <div id="footer">
                    <p><a href="resetar_senha.php">Resertar senha</a></p>
                </div>
            </form>
        </div>
    </main>


</body>
<script src="jquery.js"></script>
<script src="js/login.js"></script>
<script>
function mostrarOcultarSenha() {
    var senha = document.getElementById("senha");
    if (senha.type == "password") {
        senha.type = "text";
    } else {
        senha.type = "password";
    }

}
</script>

</html>