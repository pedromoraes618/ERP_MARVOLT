<?php 
include "../crud/despesa.php";
include "../../../_incluir/funcoes.php";

?>

<div class="relatorio-right-bottom">
    <div class="title">
        <h4>Depesa por Cliente </h4>
    </div>
    <div class="bloco">
        <div class="bloco-1">
            <div class="grafico" style="width:200;height:150px">
                <canvas width="120px" height="80px" id="grafico"></canvas>
            </div>
            <?php
            // $select = "SELECT sum(nf.valor_total_nota) as totalPorCliente,gl.cl_descricao as cliente, cl.grupo_cliente as grupo_cliente_despesa 
            // from tb_nfe_saida as nf inner join clientes as cl on cl.cpfcnpj = nf.cnpj_cpf inner join tb_grupo_cliente as gl on gl.cl_id = cl.grupo_cliente   where status_processamento = '1' and data_emissao 
            // BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by grupo_cliente_despesa order by totalPorCliente;";

            /*BUSCAR OS VALORES DE COMRPRA POR CLIENTE TABELA CONSULTA - PEDIDO DE COMPRA - CLIENTES - GRUPO_CLIENTE */
            $select = "SELECT cl.razaosocial, cl.cpfcnpj, gpcl.cl_descricao AS cliente,gpcl.cl_id, sum(valor_total_compra) as totalPorCliente 
            from pedido_compra as pdc inner join clientes as cl on cl.clienteID = pdc.clienteID inner join tb_grupo_cliente as gpcl on gpcl.cl_id = cl.grupo_cliente group by gpcl.cl_id";
            $consulta_valor_por_cliente = mysqli_query($conecta,$select);
            $consulta_valor_por_cliente_cliente = mysqli_query($conecta,$select);
            $consulta_valor_por_cliente_cliente_cor = mysqli_query($conecta,$select);

            ?>
            <script>
            var ctx = document.getElementById("grafico").getContext('2d');
            var dates = [
                <?php 
                           $santos_brasil = 0;
                        while( $linha = mysqli_fetch_assoc($consulta_valor_por_cliente_cliente)){
                            $cliente = utf8_encode($linha['cliente']);
                            $valor_por_cliente = $linha['totalPorCliente'];
                            echo    "'". $cliente ." ". real_format($valor_por_cliente) ."  /  %',"; 
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
                           while( $linha = mysqli_fetch_assoc($consulta_valor_por_cliente_cliente_cor)){
                            $valor_por_cliente_cor = $linha['totalPorCliente'];
                    
                                echo    "'".random_color()."',";
                                
                            }
                            ?>
                        ],



                        data: [

                            <?php
                 
                        while( $linha = mysqli_fetch_assoc($consulta_valor_por_cliente)){

                            $valor_por_cliente = $linha['totalPorCliente'];
                      

                     $valorMultiplicado = $valor_por_cliente;
                                    $porcentagem_anterior = $valorMultiplicado / 10000;
                                    $porcentagem_anterior = real_percent_grafico($porcentagem_anterior);
                                    
                            echo    "'".($porcentagem_anterior) ."',"; 

                        //verificar a quantidade de despesa paga por mes ano atual
            
              
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