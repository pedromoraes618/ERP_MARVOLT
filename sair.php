<?php 
session_start();
unset($_SESSION["user_portal"]);
if (isset($_COOKIE['algnmarvolt'])) {//verificar se tem algum cookie de lembrar
    setcookie("algnmarvolt",null, -1,'/');//remover o cookie de login automatico
}
header("Location: ../../marvolt/login.php");
?>