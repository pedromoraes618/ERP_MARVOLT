<?php 
include "../crud/operacional_cotacao.php";
include "../../../_incluir/funcoes.php";

?>

<div class="relatorio-right-bottom">
    <div class="title">
        <h4> Valores por categoria Pdc</h4>
    </div>
    <div class="bloco">
        <div class="bloco-1">
            <div class="grafico" style="width:200;height:150px">
                <canvas width="120px" height="80px" id="grafico"></canvas>
            </div>
            <?php
       
            ?>
            <script>
            var bar_ctx = document.getElementById('grafico');
            var ctx = document.getElementById("grafico").getContext('2d');
            var dates = [
                <?php 
                           $santos_brasil = 0;
                        while( $linha = mysqli_fetch_assoc($consulta_dados_descricao_categoria_pd)){
                            $categoria = utf8_encode($linha['categoria']);
                            $valor_venda = utf8_encode($linha['somavenda']);
                         
                            echo    "'". $categoria ." ". real_format($valor_venda) ."  /  %',"; 
                            }
                            
                        ?>
            ];
            var myChart = new Chart(ctx, {
                type: 'pie',

                data: {
                    labels: dates,

                    datasets: [{

                        backgroundColor: [
                            <?php 
                           while( $linha = mysqli_fetch_assoc($consulta_dados_cor_categoria_pd)){
                      
                    
                                echo    "'".random_color()."',";
                                
                            }
                            ?>
                        ],
                        data: [

                            <?php

                        while($linha = mysqli_fetch_assoc($consulta_dados_categoria_pd)){

                        $valor_venda_por_categoria = $linha['somavenda'];
                        $porcentagem_valor_categoria= ($valor_venda_por_categoria*100)/$valor_total_categoria;
                        $porcentagem_valor_categoria= real_percent_grafico($porcentagem_valor_categoria);

                        echo    "'".($porcentagem_valor_categoria) ."',"; 

                        }
                        ?>
                        ],
                    }],

                },

                options: {
                    elements: {
                        line: {
                            tension: 0,
                         
                        }
                        
                    },

                    tooltips: {
                        backgroundColor:'rgba(255, 255, 255, 1)',
                        bodyFontColor:'rgba(0, 0, 0, 1)',
                        titleFontColor:'rgba(0, 0, 0, 1)',
                        titleFontSize:20,
                        caretPadding:10,
                        xPadding:5,
                        yPadding:15,
                         mode: 'index',
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
               
                    scaleShowLabels: false,
                    legend: {
                        display: false,
                        fontColor: 'rgb(245, 40, 145)',
                    },

                }
            });
            </script>
        </div>

    </div>

</div>
<script>
$(".relatorio-right-top .bloco-dados .info").mouseover(function(e) {
    e.preventDefault();
    let id_tipo = $(this).attr("id_tipo")

    $(".relatorio-right-top .bloco-dados  #" + id_tipo).css("display", "block")
})
$(".relatorio-right-top .bloco-dados  .info").mouseout(function(e) {
    let id_tipo = $(this).attr("id_tipo")
    $(".relatorio-right-top .bloco-dados  #" + id_tipo).css("display", "none")
})
</script>