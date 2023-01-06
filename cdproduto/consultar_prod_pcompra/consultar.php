<?php 
include("../../conexao/sessao.php");
require_once("../../conexao/conexao.php"); 



?>
<!doctype html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- estilo -->
    <link href="../../_css/estilo.css" rel="stylesheet">
    <link href="../../_css/pesquisa_tela.css" rel="stylesheet">

    <a href="https://icons8.com/icon/59832/cardápio"></a>
</head>

<body>
    <?php include("../../_incluir/topo.php"); ?>
    <?php include("../../_incluir/body.php"); ?>
    <?php include("../../_incluir/funcoes.php"); ?>
</body>

<main>
    <div class="titulo_cabecalho">
    <p>Produtos de pedidos de compra</p><img src="../../images/pedido_compra.png">
    </div>
    <div class="result">

    </div>
</main>

</html>
<script src="../../jquery.js"></script>
<script>
$(document).ready(function(e) {
    $.ajax({
        type: "GET",
        url: "tabela.php",
        success: function(result) {
            return $(".result").html(result);
        },
    })
})
</script>