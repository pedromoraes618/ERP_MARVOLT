<?php
include "../conexao/conexao.php";
session_start();

date_default_timezone_set('America/Fortaleza');
$data_hora = date('d/m/Y H:i:s');


$usuario =  $_POST["usuario"];
$senha =  $_POST["senha"];
$chave_aleatoria =  $_POST["chave_aleatorio"];
$login = "SELECT * FROM usuarios WHERE usuario = '{$usuario}' and senha='{$senha}'";
$acesso = mysqli_query($conecta, $login);

if( $acesso ){
$informacao = mysqli_fetch_assoc($acesso);
if (empty($informacao)){
echo "Login sem sucesso";
}else{
    $_SESSION["user_portal"] = $informacao["usuarioID"];
    $id_user = $_SESSION["user_portal"];
    $update = "UPDATE usuarios set cl_chave_aleatoria = '$chave_aleatoria' where usuarioID = $id_user";
    $operacao_update_chave_aleatorio = mysqli_query($conecta, $update);
    echo"ok";
    
$hoje = date('y-m-d');
$mensagem = "Usuario acessou o sistema data e horario $data_hora";
$inserir = "INSERT INTO tb_log ";
$inserir .= "(cl_data_modificacao,cl_usuario,cl_descricao)";
$inserir .= " VALUES ";
$inserir .= "('$hoje','$id_user','$mensagem' )";
$operacao_insert_log = mysqli_query($conecta, $inserir);

}
}