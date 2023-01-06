<?php 
include("../../conexao/sessao.php");
include("../../conexao/conexao.php"); 
if(isset($_GET['nfantasia'])){
    $nome_fantasia = $_GET['nfantasia'];
    $cliente_id = $_GET['codigo'];
}
$ano_inicial = (date('Y')-2);
$date_inicial = date('01/01/'.$ano_inicial);
$date_atual = date('d/m/Y');


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
    <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>
</head>

<body class="rla_operacional">
    <main>
        <div class="bloco-principal">
            <section id="topo">
                <div class="title">
                    <h3>Histórico Empresa</h3>

                </div>

                <div class="topo-1">
                    <div class="filtro_date">
                        <div class="titulo">
                            <p>Periodo</p>
                        </div>
                        <div class="input">
                            <input style="width: 100px; " type="text" id="data_inicial" placeholder=""
                                onkeyup="mascaraData(this);" value="<?php echo $date_inicial;?>">
                            <input style="width: 100px;" type="text" id="data_final" onkeyup="mascaraData(this);"
                                value="<?php echo $date_atual; ?>">
                        </div>
                    </div>

                    <div class="btn_operacional">
                        <input type="hidden" id="idcliente" value="<?php echo $cliente_id; ?>">
                        <button id="btn_pdcompra" class="button">Pedido de compra</button>
                        <button id="btn_nfe_ntrada" class="button">Nfe Entrada</button>
                        <button id="btn_financeiro" class="button">Financeiro</button>
                        <button id="btn_cotacao" class="button">Cotação</button>
                        <button id="btn_voltar" onclick="fechar()" style="background-color:darkkhaki;" class="button">Voltar</button>

                    </div>

                    <div class="topo-2">
                        <img src="../../images/furo.png">
                        <p><?php echo $nome_fantasia;?></p>
                        <img src="../../images/furo.png">
                    </div>
                </div>
            </section>
            <hr>
            <section class="operacional">
                <div class="dados-1">

                </div>

            </section>
        </div>
    </main>
</body>
<?php include '../../_incluir/funcaojavascript.jar'; ?>

</html>


<script src="../../jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
</body>

</html>

<script>
var id_cliente = document.getElementById("idcliente")
var data_inicial = document.getElementById("data_inicial")
var data_final = document.getElementById("data_final")


$(document).ready(function(e) {

    $('.bloco-principal .operacional').css("display", "none")


})


$("#btn_pdcompra").click(function(e) {
    $('.bloco-principal .operacional').fadeIn(500)
    $('.bloco-principal .operacional').slideDown(100)
    $('.bloco-principal .operacional').css("display", "")
    $.ajax({
        type: 'GET',
        data: "clienteID=" + id_cliente.value + "&data_inicial=" + data_inicial.value + "&data_final=" + data_final.value,
        url: "tabela_pdcompra.php",
        success: function(result) {
            return $(".operacional .dados-1").html(result);
        },
    });
})

$("#btn_nfe_ntrada").click(function(e) {
    $('.bloco-principal .operacional').fadeIn(500)
    $('.bloco-principal .operacional').slideDown(100)
    $('.bloco-principal .operacional').css("display", "")
    $.ajax({
        type: 'GET',
        data: "clienteID=" + id_cliente.value + "&data_inicial=" + data_inicial.value + "&data_final=" + data_final.value,
        url: "tabela_nfe_entrada.php",
        success: function(result) {
            return $(".operacional .dados-1").html(result);
        },
    });
})
$("#btn_financeiro").click(function(e) {
    $('.bloco-principal .operacional').fadeIn(500)
    $('.bloco-principal .operacional').slideDown(100)
    $('.bloco-principal .operacional').css("display", "")
    $.ajax({
        type: 'GET',
        data: "clienteID=" + id_cliente.value + "&data_inicial=" + data_inicial.value + "&data_final=" + data_final.value,
        url: "tabela_financeiro.php",
        success: function(result) {
            return $(".operacional .dados-1").html(result);
        },
    });
})
$("#btn_cotacao").click(function(e) {
    $('.bloco-principal .operacional').fadeIn(500)
    $('.bloco-principal .operacional').slideDown(100)
    $('.bloco-principal .operacional').css("display", "")
    $.ajax({
        type: 'GET',
        data: "clienteID=" + id_cliente.value + "&data_inicial=" + data_inicial.value + "&data_final=" + data_final.value,
        url: "tabela_cotacao.php",
        success: function(result) {
            return $(".operacional .dados-1").html(result);
        },
    });
})

function fechar() {
window.close()
window.opener.location.reload()
}
</script>