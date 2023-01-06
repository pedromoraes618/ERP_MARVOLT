<?php 
include("../../conexao/sessao.php");
include("../../conexao/conexao.php"); 


?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">

    <!-- estilo -->
    <link href="../../_css/estilo.css" rel="stylesheet">
    <link href="../../_css/pesquisa_tela.css" rel="stylesheet">
    <link href="../../_css/relatorio.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>

<body class="rla_operacional">
    <?php include_once("../../_incluir/topo.php"); ?>
    <?php include_once("../../_incluir/body.php"); ?>

    <main>
        <div class="bloco-principal">
            <section id="topo">
                <div class="title">
                    <h3>Relatorio Geral</h3>
                </div>
                <div class="topo-1">
                    <div class="btn_operacional">
                        <button id="btn_pesquisar" class="button">Pesquisar</button>
                  
                            <button id="btn_gerar_pdf" class="button">Gerar PDF</button>
                      
                    </div>

                    <div class="filtro-ano">
                        <div class="title">
                            <h4>Ano</h4>
                        </div>
                        <div class="bloco">
                            <diiv id="filtro-1" class="filtro-group">
                                <select id="ano_ini" name="ano">

                                    <?php
                                    for ($anoInicio = date('Y') - 3; $anoInicio <= date('Y'); $anoInicio++)
                                    {
                                        ?>
                                    <option <?php if($anoInicio == 2019){
                                        ?> selected <?php
                                    } ?> value="<?php echo $anoInicio?>"><?php echo $anoInicio ?>
                                    </option>

                                    <?php
                                    }
                                    ?>

                                </select>
                                <select id="ano_fim" name="ano">

                                    <?php
                                    for ($anoInicio = date('Y') - 3; $anoInicio <= date('Y'); $anoInicio++)
                                    {
                                        ?>
                                    <option <?php if($anoInicio == date('Y')){
                                        ?> selected <?php
                                    } ?> value="<?php echo $anoInicio?>"><?php echo $anoInicio ?>
                                    </option>

                                    <?php
                                    }
                                ?>

                                </select>
                            </diiv>

                        </div>

                    </div>
                </div>
            </section>
            <section class="operacional">
                <div class="dados-1">

                </div>
                <div class="dados-2">

                </div>
                <div class="dados-3">

                </div>
                <div class="dados-4">

                </div>
                <div class="dados-5">

                </div>
                <div class="dados-6">

                </div>
            </section>


        </div>
    </main>
    <script src="../../jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
</body>

</html>

<script>
var ano_ini = document.getElementById("ano_ini")
var ano_fim = document.getElementById("ano_fim")
$(document).ready(function(e) {
    $('.bloco-principal .operacional').css("display", "none")
})

$("#btn_gerar_pdf").click(function(e) {
    window.open("pdf/pdf.php?&filtroano_ini="+ano_ini.value+"&filtroano_fim="+ano_fim.value, "mozillaTab");
})


$("#btn_pesquisar").click(function(e) {
    $('.bloco-principal .operacional').fadeIn(500)
    $('.bloco-principal .operacional').slideDown(100)
    $('.bloco-principal .operacional').css("display", "")
    $.ajax({
        type: 'GET',
        data: "filtroano_ini=" + ano_ini.value + "&filtroano_fim=" + ano_fim.value,
        url: "receita/dados.php",
        success: function(result) {
            return $(".operacional .dados-1").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano_ini=" + ano_ini.value + "&filtroano_fim=" + ano_fim.value,
        url: "despesa/dados.php",
        success: function(result) {
            return $(".operacional .dados-2").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano_ini=" + ano_ini.value + "&filtroano_fim=" + ano_fim.value,
        url: "estoque/dados.php",
        success: function(result) {
            return $(".operacional .dados-3").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano_ini=" + ano_ini.value + "&filtroano_fim=" + ano_fim.value,
        url: "patrimonio/dados.php",
        success: function(result) {
            return $(".operacional .dados-4").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano_ini=" + ano_ini.value + "&filtroano_fim=" + ano_fim.value,
        url: "receita_aliquidar/dados.php",
        success: function(result) {
            return $(".operacional .dados-5").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano_ini=" + ano_ini.value + "&filtroano_fim=" + ano_fim.value,
        url: "despesa_a_pagar/dados.php",
        success: function(result) {
            return $(".operacional .dados-6").html(result);
        },
    });
})
</script>