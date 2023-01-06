<?php 
include "../crud/receita.php";
include "../../../_incluir/funcoes.php";

?>

<div class="relatorio-right-bottom">
    <div class="title">
        <h4> Receita por Tipo</h4>
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
                        while( $linha = mysqli_fetch_assoc($consulta_valor_por_grupo_texto)){
                            $grupo = utf8_encode($linha['grupo']);
                            $valor_por_grupo = $linha['valor'];
                            echo    "'". $grupo ." ". real_format($valor_por_grupo) ."  /  %',"; 
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
                           while( $linha = mysqli_fetch_assoc($consulta_valor_por_grupo_cor)){
                      
                    
                                echo    "'".random_color()."',";
                                
                            }
                            ?>
                        ],
                        data: [

                            <?php

                        while( $linha = mysqli_fetch_assoc($consulta_valor_por_grupo)){

                        $valor_por_grupo = $linha['valor'];
                        $porcentagem_valor_grupo = ($valor_por_grupo / $somatorio_grupo_receita)*100;
                        $porcentagem_valor_grupo = real_percent_grafico($porcentagem_valor_grupo);

                        echo    "'".($porcentagem_valor_grupo) ."',"; 

                        }
                        ?>
                        ],
                    }],

                },

                options: {
                    elements: {
                        line: {
                            tension: 0
                        }
                    },
                    scaleShowLabels: false,
                    legend: {
                        display: false,
                        fontColor: 'rgb(255, 99, 132)'
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