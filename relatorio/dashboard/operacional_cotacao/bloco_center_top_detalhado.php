<?php 
include "../crud/operacional_cotacao.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio_center_top">
    <div class="title">
        <h4>Volume de cotação - <?php echo $cliente; ?></h4>
   
    </div>
    <!-- <div class="bloco-tipo">
        <button id="rb1">R1</button>
        <button id="rb2">R2</button>
    </div> -->

    <div class="bloco">
        <div class="legenda">
            <div class="leg-1"><img src="../../images/total_cotacao.png">
                <p>Total</p>
            </div>
            <div class="leg-1"><img src="../../images/receita_relatorio.png">
                <p>Ganha</p>
            </div>
            <div class="leg-1"><img src="../../images/cotacao_parcial.png">
                <p>Ganha Parcial</p>
            </div>
        </div>

        <div class="bloco-1">
            <div>
                <canvas width="750" height="150" id="barchart"></canvas>
            </div>


            <script>
            var ctx = document.getElementById("barchart").getContext('2d');
            var meses = ["Jan", "fev", "mar", "abr", "mai", "jun", 'jul', 'ago', 'set', 'out', 'nov', 'dez'];

            var myChart = new Chart(ctx, {
                type: 'bar',

                data: {
                    labels: meses,
                    datasets: [{

                            label: 'Total Cotação ',
                            backgroundColor: 'rgba( 95, 158, 160, 1 )',
                            data: [
                                <?php
                            $i = 0;
                            while($i<=11){
                            $i = $i+ 1;
                            //verificar a quantidade de receita por mes 
                            echo       "'". consultar_count_cotacao_cliente($i,$ano,$clienteID) ."',";
                            }
                            ?>
                            ],
                        },
                        {
                            label: 'Cotação Ganha ',
                            backgroundColor: 'rgba(20,148,71,1)',
                            data: [
                                <?php
                            $i = 0;
                            while($i<=11){
                            $i = $i+ 1;
                            //verificar a quantidade de despesa por mes 
                            echo       "'". (consultar_count_cotacao_ganha_cliente($i,$ano,$clienteID)) ."',";
                            }
                            ?>
                            ],

                        },
                        {
                            label: 'Cotação Ganha Parcial:',
                            backgroundColor: 'rgba( 184, 134, 11, 1 )',
                            data: [
                                <?php
                            $i = 0;
                            while($i<=11){
                            $i = $i+ 1;
                            //verificar a quantidade de despesa por mes 
                            echo       "'". (consultar_count_cotacao_ganha_parcial_cliente($i,$ano,$clienteID)) ."',";
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
                    }, tooltips: {
                        backgroundColor:'rgba(255, 255, 255, 1)',
                        bodyFontColor:'rgba(0, 0, 0, 1)',
                        titleFontColor:'rgba(0, 0, 0, 1)',
                        titleFontSize:20,
                        caretPadding:10,
                        xPadding:5,
                        yPadding:15,
                       
                         caretSize:10,
                         titleFontStyle:'bold',
                       
                        
                        // callbacks: {
                        // title:function(chart){
                        //     console.log(chart[0])
                        // },
                        //  afterBody:function(context){
                        
                        //  },
                          
                        // }
                    },
                    legend: {
                        display: false,
                        fontColor: 'rgb(255, 99, 132)'
                    },
                    scales: {
                        yAxes: [{
                            locale: 'pt-BR',

                            ticks: {
                              
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