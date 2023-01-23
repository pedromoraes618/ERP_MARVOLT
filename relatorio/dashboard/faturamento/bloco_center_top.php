<?php 
include "../crud/faturamento.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio_center_top">
    <div class="title">
        <h4>Faturamento em nota fiscal</h4>
    </div>
    <!-- <div class="bloco-tipo">
        <button id="rb1">R1</button>
        <button id="rb2">R2</button>
    </div> -->

    <div class="bloco">
   

        <div class="bloco-1">
        <div style="padding: 10px;padding-top: 30px;">
                <canvas   id="barchart_faturamento_top"></canvas>
            </div>
            <script>
            var ctx = document.getElementById("barchart_faturamento_top").getContext('2d');
            var meses = ["Jan", "fev", "mar", "abr", "mai", "jun", 'jul', 'ago', 'set', 'out', 'nov', 'dez'];

            var myChart = new Chart(ctx, {
                type: 'bar',

                data: {
                    labels: meses,
                    datasets: [{
                            type: 'line',
                            label: 'R$ ',
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
                            echo       "'". (consultar_faturamento_nfes($i,$ano)*0.001)  ."',";
                        }
                            ?>

                            ],

                        },
                        {

                            label: 'Quatidade ',
                            backgroundColor: 'rgba(20,148,71,1)',


                            data: [
                                <?php
                            $i = 0;
                            while($i<=11){
                            $i = $i+ 1;
                            //verificar a quantidade de receita por mes 
                            echo       "'". (consultar_quantidade_nfes($i,$ano))  ."',";
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
                    tooltips: {
                        backgroundColor: 'rgba(255, 255, 255, 1)',
                        bodyFontColor: 'rgba(0, 0, 0, 1)',
                        titleFontColor: 'rgba(0, 0, 0, 1)',
                        titleFontSize: 20,
                        caretPadding: 10,
                        xPadding: 5,
                        yPadding: 15,
                        caretSize: 10,
                        titleFontStyle: 'bold',
                    },

                    legend: {
                        display: false,
                        fontColor: 'rgb(255, 99, 132)'
                    },
                    scales: {
                        
                        yAxes: [{
                            display: true,
                     
                            ticks: {
                           
                                callback: (value, index, values) => {
                                   return "R$ "+ value + " K"
                                },
                                
                                fontColor: 'white' // aqui branco
                            },
                            min:20,
                            max:100,
                         
                           
                        }],
                        xAxes: [{
                            ticks: {
                                beginAtZero: true,
                                fontColor: 'white' // aqui branco
                            },

                        }],
                    },

                }
            });
            </script>


        </div>



    </div>


</div>