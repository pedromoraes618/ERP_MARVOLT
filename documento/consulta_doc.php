<?php 
include("../conexao/sessao.php");
require_once("../conexao/conexao.php"); 



?>
<!doctype html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- estilo -->
    <link href="../_css/estilo.css" rel="stylesheet">
    <link href="../_css/pesquisa_tela.css" rel="stylesheet">
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <a href="https://icons8.com/icon/59832/cardápio"></a>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include("../_incluir/topo.php"); ?>
    <?php include("../_incluir/body.php"); ?>
    <?php include("../_incluir/funcoes.php"); ?>

    <main>

        <div id="janela_pesquisa">
            <a
                onclick="window.open('anexar_arquivo.php', 
'cadastro_usuario', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1200, HEIGHT=650');">
                <input type="submit" id="adicionar_certificadp" style="width: 150px;" name="adicionar_certificadp"
                    value="Adicionar Certificado">
            </a>
            <form>
                <input type="text" name="produto" id="pesquisa_a"
                    placeholder="Pesquisa / Descrição">
                <input type="image" id="btn_pesquisar" name="pesquisa"
                    src="https://img.icons8.com/ios/50/000000/search-more.png" />
            </form>


        </div>
        <div class="result">

        </div>



    </main>
</body>

</html>
<script src="../jquery.js"></script>

<script src="sweetalert2.min.js"></script>
<script>
//funcao para pesquisar as solicitacoes
var pesquisa_a = document.getElementById("pesquisa_a")

$(document).ready(function(e) {

    $.ajax({
        type: 'GET',
        data: "pesquisa_a=",
        url: "tabela/tabela_doc.php",
        success: function(result) {
            return $(".result").html(result)
        },
    });
})


$('#janela_pesquisa #btn_pesquisar').click(function(e) {
    e.preventDefault();

    $.ajax({
        type: 'GET',
        data: "pesquisa_a=" + pesquisa_a.value,
        url: "tabela/tabela_doc.php",
        success: function(result) {

            return $(".result").html(result)

        },
    });
})

</script>
<?php
    // Fechar conexao
    mysqli_close($conecta);
?>