<?php 
include "../crud/comparativo.php";
include "../../../_incluir/funcoes.php";

?>

<div class="relatorio-right-bottom">
    <div class="title">
        <h4>Comparativo Despesa</h4>
    </div>
    <div class="bloco">
        <div class="bloco-1">

        
            <div class="grafico" style="width:200;height:150px">

                <canvas width="90" height="80" id="grafico_piizza"></canvas>

            </div>
            <div title="Receita total" <?php  
        
            if($valor_total_receita > 1000000){
                echo 'style="position:absolute;z-index: -1; right:80px;top: 155px;"';
            }else{
                echo 'style="position:absolute;z-index: -1; right:95px;top: 155px;"';
            }
            ?> class="">
                <p style="font-size: 0.8em;"><?php echo real_format($valor_total_receita) ?></p>
            </div>
            <?php
            // $select = "SELECT sum(nf.valor_total_nota) as totalPorCliente,gl.cl_descricao as cliente, cl.grupo_cliente as grupo_cliente_despesa 
            // from tb_nfe_saida as nf inner join clientes as cl on cl.cpfcnpj = nf.cnpj_cpf inner join tb_grupo_cliente as gl on gl.cl_id = cl.grupo_cliente   where status_processamento = '1' and data_emissao 
            // BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by grupo_cliente_despesa order by totalPorCliente;";

            /*BUSCAR OS VALORES DE COMRPRA POR CLIENTE TABELA CONSULTA - PEDIDO DE COMPRA - CLIENTES - GRUPO_CLIENTE */
       
            ?>
            <script>
            var ctx = document.getElementById("grafico_piizza").getContext('2d');
            var dates = [
                <?php
                    foreach($array_dados_despesa_top_5 as $linha){
                    $categoria = $linha['categoria'];
                    $valor = $linha['valor'];
                     echo    "'". $categoria ." ". real_format($valor) ."  /  %',"; 
                }   echo    "'Outros ". real_format($valor_outras_despesas)." /  %',"; echo    "'Lucro ". real_format($lucratividade_real)." /  %',";  
                ?>
            ];
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: dates,
                    datasets: [{
                        backgroundColor: [
                            <?php 
                            for($i = 0; $i<5; $i++){
                                echo    "'".random_color()."',";
                            }echo    "'#FFFF00',"."'#0000CD'";
                            ?>
                        ],

                        data: [
                            <?php
                $cont = 0;
                foreach($array_dados_despesa_top_5 as $linha){
                $cont = $cont + 1;
                $categoria = $linha['categoria'];
                $valor = $linha['valor'];

                $valorMultiplicado_top_5 = 100 * $valor;
                $porcentagem_top_5 = $valorMultiplicado_top_5 / $valor_total_receita;
                $porcentagem_top_5 = real_percent_grafico($porcentagem_top_5);

                $valorMultiplicado_lucro = 100 * $lucratividade_real;
                $porcentagem_lucro = $valorMultiplicado_lucro / $valor_total_receita;
                $porcentagem_lucro = real_percent_grafico($porcentagem_lucro);

                $valorMultiplicado_outros = 100 * $valor_outras_despesas;
                $porcentagem_outros = $valorMultiplicado_outros / $valor_total_receita;
                $porcentagem_outros = real_percent_grafico($porcentagem_outros);


                echo "'".$porcentagem_top_5. "',";
                }echo "'".real_percent_grafico($porcentagem_outros). "',"."'".real_percent_grafico($porcentagem_lucro)."'";

                
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
                    tooltips: {
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