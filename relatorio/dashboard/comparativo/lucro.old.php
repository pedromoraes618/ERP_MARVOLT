<?php 
include "../crud/despesa.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio_center_bottom">

    <div class="title">
        <h4>Comparação de gastos entre meses</h4>
    </div>
    <!-- <div class="bloco-tipo">
        <button id="rb1">R1</button>
        <button id="rb2">R2</button>
    </div> -->

    <div class="bloco">

        <div class="bloco-1">
            <div>
                <canvas width="750" height="170" id="myChart"></canvas>
            </div>


            <script>
            var ctx = document.getElementById("myChart").getContext('2d');
            var meses = ["Jan", "fev", "mar", "abr", "mai", "jun", 'jul', 'ago', 'set', 'out', 'nov', 'dez']

            var stackedBar = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: [{
                        type: 'bar',
                        label: 'Dataset 1',
                        backgroundColor: 'rgba(255, 0, 0, 0.16)',
                        borderColor: 'coral',
                        borderWidth: 2,
                        data: [15, 59, 80, 81, 56, 55, 40]
                    }, {
                        type: 'bar',
                        label: 'Dataset 2',
                        backgroundColor: 'rgba(0, 255, 34, 0.16)',
                        data: [25, 59, 80, 81, 56, 55, 40]
                    }, {
                        type: 'line',
                        label: 'Dataset 3',
                        borderWidth: 3,
                        borderColor: 'rgba(45, 0, 255, 1)',
                        fill: false,
                        data: [5, 10, 15, 81, 56, 55, 40],
                    }]
                },
                options: {
                    elements: {
                        line: {
                            tension: 0
                        }
                    },
                    scales: {
                        yAxes: [{
                            display: true,

                            ticks: {
                                fontColor: 'white' // aqui branco
                            }

                        }],
                        xAxes: [{
                            display: true,

                            ticks: {
                                fontColor: 'white' // aqui branco
                            }

                        }]
                    }
                }
            });
            </script>


        </div>
        <div class="legenda">
            <div class="leg-1">
                <div style="background-color:red ;" class="bloco-leg-1"></div>
                <p><?php echo $ano; ?></p>
            </div>
            <div class="leg-1">
                <div style="background-color:coral ;" class="bloco-leg-1"></div>
                <p><?php echo $ano; ?></p>
            </div>
        </div>

    </div>


</div>

<script>
$("#rb2").click(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "despesa/bloco_center_bottom2.php",
        success: function(result) {
            return $(".relatorio_center_bottom .bloco").html(result);
        },
    });
})


$(".relatorio_center_bottom .bloco .bloco-1 .grafico").mouseover(function(e) {
    e.preventDefault();
    let id_mes = $(this).attr("id_mes")
    $(".relatorio_center_bottom .bloco .bloco-1  .id" + id_mes).css("display", "block")
})
$(".relatorio_center_bottom .bloco .bloco-1 .grafico").mouseout(function(e) {
    let id_mes = $(this).attr("id_mes")
    $(".relatorio_center_bottom .bloco .bloco-1  .id" + id_mes).css("display", "none")
})
</script>