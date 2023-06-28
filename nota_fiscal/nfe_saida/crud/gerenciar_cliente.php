<?php
if (isset($_GET['consultar_cliente'])) {
    include "../../../../../conexao/conexao.php";
    include "../../../../../_incluir/funcoes.php";
    $consulta = $_GET['consultar_cliente'];

    if ($consulta == "detalhado") {
        $pesquisa = utf8_decode($_GET['conteudo_pesquisa']); //filtro
        $remove_chars = array('.', '/', '-');
        $pesquisa = str_replace(($remove_chars), '', $pesquisa); // remover caracteres especias
        $select = "SELECT * FROM clientes where razaosocial LIKE '%{$pesquisa}%' or nome_fantasia LIKE '%{$pesquisa}%' or cpfcnpj  LIKE '%{$pesquisa}%'";
        $consultar_clientes = mysqli_query($conecta, $select);
        if (!$consultar_clientes) {
            die("Falha no banco de dados");
        }
    }
}else{
    include "../../../../../conexao/conexao.php";
    include "../../../../../_incluir/funcoes.php";
    $consulta = $_GET['consultar_transportadora'];
    if ($consulta == "detalhado") {
        $pesquisa = utf8_decode($_GET['conteudo_pesquisa']); //filtro
        $remove_chars = array('.', '/', '-');
        $pesquisa = str_replace(($remove_chars), '', $pesquisa); // remover caracteres especias
        $select = "SELECT * FROM clientes where (razaosocial LIKE '%{$pesquisa}%' or nome_fantasia LIKE '%{$pesquisa}%' or cpfcnpj  LIKE '%{$pesquisa}%') and clienteftID ='3' ";
        $consultar_clientes = mysqli_query($conecta, $select);
        if (!$consultar_clientes) {
            die("Falha no banco de dados");
        }
    }
}
