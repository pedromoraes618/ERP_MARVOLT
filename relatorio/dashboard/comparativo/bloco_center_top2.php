<?php 
include "../crud/comparativo.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio_center_top">
    <div class="title">
        <h4>Receita x Despesa x Lucro</h4>
    </div>
    <!-- <div class="bloco-tipo">
        <button id="rb1">R1</button>
        <button id="rb2">R2</button>
    </div> -->

    <div class="bloco">
        <div class="legenda">
            <div class="leg-1"><img src="../../images/receita_relatorio.png">
                <p>Receita</p>
            </div>
            <div class="leg-1"><img src="../../images/despesa_relatorio.png">
                <p>Despesa</p>
            </div>
            <div class="leg-1"><img src="../../images/lucro.png">
                <p>Lucro</p>
            </div>
        </div>

        <div class="bloco-1" >
            <div >
                <canvas width="750" height="200"  id="barchart"></canvas>
            </div>


            <script>
            var ctx = document.getElementById("barchart").getContext('2d');
            var meses = ["Jan", "fev", "mar", "abr", "mai", "jun", 'jul', 'ago', 'set', 'out', 'nov', 'dez'];

            var myChart = new Chart(ctx, {
                type: 'bar',

                data: {
                    labels: meses,
                    datasets: [{
                            type: 'line',
                            label: 'Lucro R$',
                            borderWidth: 3,
                            borderColor: 'rgba(45, 0, 255, 1)',
                            pointStyle: 'circle',
                            fill: false,

                            data: [
                                <?php
                            $i = 0;
                            while($i<=11){
                            $i = $i+ 1;
                            //verificar a quantidade de receita por mes 
                            echo       "'". (consular_receita_mes($i,$ano) - consular_despesa_mes($i,$ano))  ."',";
                        }
                            ?>
                            ],
                        },
                        {

                            label: 'Receita R$',
                            backgroundColor: 'rgba(20,148,71,1)',
                            data: [
                                <?php
                            $i = 0;
                            while($i<=11){
                            $i = $i+ 1;
                            //verificar a quantidade de receita por mes 
                            echo       "'". consular_receita_mes($i,$ano) ."',";
                            }
                            ?>
                            ],
                        },
                        {
                            label: 'Despesa R$',
                            backgroundColor: 'rgba(173,16,16,1)',
                            data: [
                                <?php
                            $i = 0;
                            while($i<=11){
                            $i = $i+ 1;
                            //verificar a quantidade de despesa por mes 
                            echo       "'". (consular_despesa_mes($i,$ano)) ."',";
                            }
                            ?>
                            ],
                          
                        },
                    ]
                },
                options: {
                    locale: 'pt-BR',
                    elements: {
                        line: {
                            tension: 0
                        }
                    },
                    legend: {
                        display: false,
                        fontColor: 'rgb(255, 99, 132)'
                    },
                    scales: {
                        yAxes: [{
                            locale: 'pt-BR',

                            ticks: {
                                callback: (value, index, values) => {
                                    return new Intl.NumberFormat('pt-br', {
                                        style: 'currency',
                                        currency: 'BRL',
                                    }).format(value);
                                },
                                beginAtZero: true,
                                fontColor: 'white' // aqui branco
                            },

                        }],
                        xAxes: [{
                            locale: 'pt-BR',
                            categoryPercentage: 0.7,
                            barPercentage: 1.2,
                            
                            ticks: {
                                beginAtZero: true,
                                fontColor: 'white' // aqui branco
                            },

                        }],
                    }
                }
            });
            </script>


        </div>



    </div>


</div>

