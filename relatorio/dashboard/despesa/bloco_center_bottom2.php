<?php 
include "../crud/despesa.php";
include "../../_incluir/funcoes.php";
?>


<div class="bloco-1">
    <div>
        <canvas width="700" height="170" id="myChart"></canvas>
    </div>


    <script>
    var ctx = document.getElementById("myChart").getContext('2d');
    var meses = ["Jan", "fev", "mar", "abr", "mai", "jun", 'jul', 'ago', 'set', 'out', 'nov', 'dez']
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: meses,
            datasets: [{

                    label: 'Valor referente ao ano <?php echo $ano; ?>',
                    data: [
                        <?php
                            $i = 0;
                            while($i<=11){
                            $i = $i+ 1;
                            //verificar a quantidade de despesa paga por mes ano atual
                            $select = "SELECT sum(valor) as despesa,lancamentoFinanceiroID from lancamento_financeiro where  receita_despesa = 'Despesa' and status='Pago'  
                            and data_do_pagamento between '$ano-$i-01' and '$ano-$i-31'";
                            $consulta_valor_despesa_mes = mysqli_query($conecta,$select);
                            $linha = mysqli_fetch_assoc($consulta_valor_despesa_mes);
                            $valor_do_mes  = ($linha['despesa']);
                            $id  = $linha['lancamentoFinanceiroID'];
                            $valorMultiplicado = $valor_do_mes;
                            $porcentagem = $valorMultiplicado /3000;
                            $porcentagem = real_percent_relatorio($porcentagem);

                            echo       "'". $valor_do_mes ."',";
                            }
                            ?>

                    ],
                    borderColor: 'red',
                    borderWidth: 4,



                },
                {
                    <?php    $ano_anterior = $ano - 1; ?>
                    label: 'Valor referente ao ano <?php echo $ano_anterior; ?>',
                    data: [
                        <?php
                                 

                                $i = 0;
                                while ($i <= 11) {
                                    $i = $i + 1;
                                    

                                    $select =
                                        "SELECT sum(valor) as despesa from lancamento_financeiro where  receita_despesa = 'Despesa' and status='Pago'  
                                    and data_do_pagamento between '$ano_anterior-$i-01'
                                    and '$ano_anterior-$i-31'
                                    ";
                                    $consulta_valor_despesa_mes_ano_anterior = mysqli_query($conecta,
                                        $select);
                                    $linha = mysqli_fetch_assoc(
                                        $consulta_valor_despesa_mes_ano_anterior);
                                    $valor_do_mes_anterior = $linha['despesa'];
                                    $valorMultiplicado = $valor_do_mes_anterior;
                                    $porcentagem_anterior = $valorMultiplicado / 3000;
                                    $porcentagem_ano_anterior = real_percent_relatorio(
                                        $porcentagem_anterior);

                                    echo "'".$valor_do_mes_anterior."',";
                                } ?>
                    ],
                    borderColor: 'blue',
                    borderWidth: 4,

                },
            ]
        },

        options: {
            elements: {
                line: {
                    tension: 0
                }
            },

            legend: {
                display: false
            },
        
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
    });
    </script>


</div>


<script>
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