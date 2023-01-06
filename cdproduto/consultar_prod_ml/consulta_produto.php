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

    <main>

        <div id="janela_pesquisa">

            <form>
                <input type="text" name="produto" id="ps_titulo"
                    placeholder="Pesquisa / Produto / Não use caracteres especias ex. ~">
                <input type="image" id="btn_pesquisar" name="pesquisa"
                    src="https://img.icons8.com/ios/50/000000/search-more.png" />
            </form>


        </div>
        <div class="result">

        </div>
        <div class="pg">
            <div class="paginacao">

                <div class="pg_proximo" onclick="pgRetor()">Anterior</div>
                <span id="input_pg">0</span>
                <div class="pg_anterior" onclick="pgProx()">Proximo</div>

            </div>
        </div>


    </main>
</body>

</html>
<script src="../../jquery.js"></script>
<script>
//funcao para pesquisar as solicitacoes

var count = 0
var titulo = document.getElementById("ps_titulo")

$(document).ready(function() {
    $(".pg").css("display", "none")
})

function pgProx() {
    count++
    $("#input_pg").html(count);
    var valorPg = $("#input_pg").text();
    $.ajax({
        type: "GET",
        url: "consulta_tabela.php?titulo=" + titulo.value + "&pg=prx&pagina=" + valorPg*50 + "",
        success: function(result) {
            return $(".result").html(result),window.scrollTo(0,0);
        },
    })
}

function pgRetor() {
    var valorPg = $("#input_pg").text();
    if (valorPg > 0) {
        count--
        $("#input_pg").html(count);
        var valorPg = $("#input_pg").text();
        $.ajax({
            type: "GET",
            url: "consulta_tabela.php?titulo=" + titulo.value + "&pg=ant&pagina=" + valorPg*50 + "",
            success: function(result) {
                return $(".result").html(result),window.scrollTo(0,0);
            },
        })
    }
}

$('#janela_pesquisa #btn_pesquisar').click(function(e) {
    e.preventDefault();
    $("#input_pg").html(0);

    $.ajax({
        type: 'GET',
        url: "consulta_tabela.php?titulo=" + titulo.value,
        success: function(result) {
            if (titulo.value != "") {
                return $(".result").html(result), $(".pg").css("display", "block");
            } else {
                return $(".result").html(
                    "<div class='alert_bloco'><img class='alert_img' src='../../images/alert_consulta_ml.svg'><br><p>Favor informe uma descrição para sua pesquisa</p></div>"
                    )
            }
        },
    });
})
</script>
<?php
    // Fechar conexao
    mysqli_close($conecta);
?>