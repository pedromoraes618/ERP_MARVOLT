<?php 
include("../../conexao/sessao.php");
include("../../conexao/conexao.php"); 
include("include/mes.php"); 

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

<body>
    <?php include_once("../../_incluir/topo.php"); ?>
    <?php include_once("../../_incluir/body.php"); ?>


    <main>
        <div class="bloco-principal">
            <section id="topo">
                <div class="title">
                    <h3>Dashboard</h3>
                </div>
                <div class="topo-1">
                    <div class="btn">
                        <button id="btn_d" class="button">Despesa</button>
                        <button id="btn_r" class="button">Receita</button>
                        <button id="btn_c" class="button">Comparativo</button>
                        <button id="btn_rs" class="button">Resumo</button>
                    </div>

                    <div class="filtro">
                        <div class="title">
                            <h4>Mês</h4>
                        </div>
                        <div class="bloco">
                            <diiv id="filtro-1" class="filtro-group">
                                <select id="mes_ini" name="mes_ini">
                                    <option value="0">Não definido</option>
                                    <?php
                                    while($row = mysqli_fetch_assoc($consulta_mes_ini)){
                                    $mes_id = utf8_encode($row['cl_id']);
                                    ?>
                                    <option <?php if($mes_id == 1){
                                    ?> selected <?php
                                    } ?> value="<?php echo $mes_id;?>">

                                        <?php echo utf8_encode($row["cl_descricao"]);?>
                                    </option>
                                    <?php } 
                                    ?>
                                </select>
                            </diiv>
                            <div id="filtro-1" class="filtro-group">
                                <select id="mes_fim" name="mes_fim">
                                    <option value="0">Não definido</option>
                                    <?php
                         
                                    while($row = mysqli_fetch_assoc($consulta_mes_fim)){
                                    $mes_id = utf8_encode($row['cl_id']);
                                    ?>
                                    <option <?php if($mes_id == 12){
                                    ?> selected <?php
                                    } ?> value="<?php echo $mes_id;?>">

                                        <?php echo utf8_encode($row["cl_descricao"]);?>
                                    </option>
                                    <?php } 
    ?>
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="filtro-2">
                        <div class="title">
                            <h4>Ano</h4>
                        </div>
                        <div class="bloco">
                            <diiv id="filtro-1" class="filtro-group">
                                <select id="ano" name="ano">
                                    <option value="0">Não definido</option>
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

                <!-- <div class=" result_consultar">
                        </div> -->
            </section>
            <div class="dados">
                <div class="bloco-left">

                </div>
                <div class="bloco-center">
                    <div class="bloco-center-top">

                    </div>
                    <div class="bloco-center-bottom">

                    </div>

                </div>

                <div class="bloco-right">
                    <div class="bloco-right-top">

                    </div>
                    <div class="bloco-right-bottom">

                    </div>
                    <div class="bloco-right-footer">

                    </div>
                </div>
            </div>
        </div>


    </main>
  

</body>
<script src="../../jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.1.1/chart.min.js"></script>

</html>


<script>
$(document).ready(function(e) {
    $('.bloco-principal .dados').css("display", "none")
})

var mes_ini = document.getElementById("mes_ini")
var mes_fim = document.getElementById("mes_fim")
var ano = document.getElementById("ano")
/*Despesa */
$("#btn_d").click(function(e) {
    e.preventDefault();

    $('.bloco-principal .dados').fadeIn(500)
    $('.bloco-principal .dados').slideDown(100)
    $('.bloco-principal .dados').css("display", "")
    $(".bloco-center-bottom").css("display","block")
    $(".bloco-center-top").css("height","250px")
    $('.bloco-right-top').css("display", "block")
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "despesa/bloco_left.php",
        success: function(result) {
            return $(".bloco-left").html(result);
        },
    });

    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "despesa/bloco_center_top.php",
        success: function(result) {
            return $(".bloco-center-top").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "despesa/bloco_right_top.php",
        success: function(result) {
            return $(".bloco-right-top").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "despesa/bloco_right_bottom.php",
        success: function(result) {
            return $(".bloco-right-bottom").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "despesa/bloco_right_footer.php",
        success: function(result) {
            return $(".bloco-right-footer").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "despesa/bloco_center_bottom.php",
        success: function(result) {
            return $(".bloco-center-bottom").html(result);
        },
    });

});
/*receita */
$("#btn_r").click(function(e) {
    $('.bloco-principal .dados').fadeIn(500)
    $('.bloco-principal .dados').slideDown(100)
    $('.bloco-principal .dados').css("display", "")
    $(".bloco-center-bottom").css("display","block")
    $(".bloco-center-top").css("height","250px")
    $('.bloco-right-top').css("display", "block")
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "receita/bloco_center_top.php",
        success: function(result) {
            return $(".bloco-center-top").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "receita/bloco_left.php",
        success: function(result) {
            return $(".bloco-left").html(result);
        },
    });

    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "receita/bloco_right_bottom.php",
        success: function(result) {
            return $(".bloco-right-bottom").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "receita/bloco_center_bottom.php",
        success: function(result) {
            return $(".bloco-center-bottom").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "receita/bloco_right_top.php",
        success: function(result) {
            return $(".bloco-right-top").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "receita/bloco_right_footer.php",
        success: function(result) {
            return $(".bloco-right-footer").html(result);
        },
    });
})


$("#btn_c").click(function(e) {
    e.preventDefault();

    $('.bloco-principal .dados').fadeIn(500)
    $('.bloco-principal .dados').slideDown(100)
    $('.bloco-principal .dados').css("display", "")
 
    $('.bloco-right-top').css("display", "none")
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "comparativo/bloco_center_top.php",
        success: function(result) {
            return $(".bloco-center-top").html(result);
        },
    });
    $(".bloco-center-top").css("height","490px")


    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "comparativo/bloco_left.php",
        success: function(result) {
            return $(".bloco-left").html(result);
        },
    });
    
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "comparativo/bloco_right_bottom.php",
        success: function(result) {
            return $(".bloco-right-bottom").html(result);
        },
    });

    $(".bloco-center-bottom").css("display","none")
})
</script>



<?php
    // Fechar conexao
    mysqli_close($conecta);
?>