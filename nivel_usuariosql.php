<?php //pegar o nivel do usuario
if($_SESSION["user_portal"]){
    $user= $_SESSION["user_portal"];
    $saudacao = "SELECT usuarios.usuario,usuarios.nivel,usuarios.nome, tb_nivel_usuario.descricao FROM usuarios
     inner join tb_nivel_usuario on usuarios.nivel = tb_nivel_usuario.nivel_usuarioID where usuarioID = {$user}";
    $saudacao_login = mysqli_query($conecta,$saudacao);
    if (!$saudacao_login){
        die ("Falha no banco de dados");
    }
    $saudacao_login = mysqli_fetch_assoc($saudacao_login);
    $nome = $saudacao_login['usuario'];
    $nivel = $saudacao_login['nivel'];
    $descricaoNivel = $saudacao_login['descricao'];
}