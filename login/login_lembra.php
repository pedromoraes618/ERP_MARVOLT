<?php
include "../conexao/conexao.php";
session_start();
date_default_timezone_set('America/Fortaleza');
$data_hora = date('d/m/Y H:i:s');


if (isset($_COOKIE['algnmarvolt'])) {
    $chave_aleatoria = $_COOKIE['algnmarvolt'];
     $login = "SELECT * FROM usuarios WHERE cl_chave_aleatoria = '$chave_aleatoria'";
     $consulta_login = mysqli_query($conecta, $login);
    if($consulta_login){
    $informacao = mysqli_fetch_assoc($consulta_login);
        if (!empty($informacao)){
            $_SESSION["user_portal"] = $informacao["usuarioID"];
           $id_user =  $_SESSION["user_portal"];
             echo "ok";
             $hoje = date('y-m-d');
            $mensagem = "Usuario acessou o sistema data e horario $data_hora";
            $inserir = "INSERT INTO tb_log ";
            $inserir .= "(cl_data_modificacao,cl_usuario,cl_descricao)";
            $inserir .= " VALUES ";
            $inserir .= "('$hoje','$id_user','$mensagem' )";
            $operacao_insert_log = mysqli_query($conecta, $inserir);
            }
        }
  }





?>