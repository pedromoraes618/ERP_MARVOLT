<?php
 require_once("conexao/conexao.php"); 
include("conexao/sessao.php");

?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">

    <!-- estilo -->
    <link href="_css/estilo.css" rel="stylesheet">
    <link href="_css/inicial.css" rel="stylesheet">

</head>

<body>
    <?php include_once("_incluir/topo.php"); ?>
    <?php include_once("_incluir/body.php"); ?>
    <?php include_once("_incluir/funcoes.php"); ?>

    <main>
        <?php
        if($nivel == 4 or $nivel ==  5){
         include("_incluir/dashboard.php");
        }
         ?>

        <div class="logo-img"><img src="images/marvolt.png"></div>

        <a style="cursor: pointer;"
            onclick="window.open('../../../marvolt/lembrete/lembrete.php', 
        'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">
            <i title="Lembrete" id="lembrete" class="fa-brands fa-discourse"></i>
        </a>

    </main>


</body>
<script src="jquery.js"></script>
<script>
$(document).ready(function(e) {
    //se existe um localstorage, adicionar nome para o elemento lembrete
    if (JSON.parse(localStorage.getItem("lembrete_add"))) {
        document.getElementById("lembrete").style.display = "none";
    }
})
$('#lembrete').click(function() {
    var lembrete_add = "lembrete_add"
    document.getElementById("lembrete").style.display = "none";
    localStorage.setItem("lembrete_add", JSON.stringify({
        lembrete_add
    }))

});
$(".bloco .bloco-4").mouseover(function(e) {
    e.preventDefault();

    $(".bloco .bloco-4 ul").css("display", "block")

})

$(".bloco .bloco-4").mouseout(function(e) {
    e.preventDefault();
    $(".bloco .bloco-4 ul").css("display", "none")
})
</script>


</html>



<?php
    // Fechar conexao
    mysqli_close($conecta);
?>