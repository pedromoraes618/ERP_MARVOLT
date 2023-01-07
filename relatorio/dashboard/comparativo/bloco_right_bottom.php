<?php 
include "../crud/comparativo.php";
include "../../../_incluir/funcoes.php";

?>

<div class="relatorio-right-bottom">
    <div class="title">
        <h4>Comparativo Despesa  </h4>
    </div>
    <div class="bloco">
        <div class="bloco-1">
            <div class="grafico" style="width:200;height:150px">
     
                <canvas width="90" height="80" id="grafico_piizza"></canvas>
                
            </div>
            <div <?php 
            if($valor_total_receita > 1000000){
                echo 'style="position:absolute;z-index: -1; right:80px;top: 155px;"';
            }else{
                echo 'style="position:absolute; right:95px;top: 155px;"';
            }
            ?>  class="">
                <p title="Receita total" style="font-size: 0.8em;"><?php echo real_format($valor_total_receita) ?></p>
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
            while($linha = mysqli_fetch_assoc($consulta_categoria_grupo_des)){ 
                $categoria = utf8_encode($linha['grupo']);
                $valor = $linha['totalPorGrupo'];
    
                echo    "'". $categoria ." ". real_format($valor) ."  /  %',"; 
                }
                ?>
            ];
            var myChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: dates,
                    datasets: [{
                        backgroundColor: [
                            <?php 
                            for($i = 0; $i<20; $i++){
                                echo    "'".random_color()."',";
                            }
                            ?>
                        ],

                        data: [
                            <?php
            while($linha = mysqli_fetch_assoc($consulta_somatorio_grupo_des)){ 
                $valor = $linha['totalPorGrupo'];

                $valorMultiplicado = 100 * $valor;
                $porcentagem = $valorMultiplicado / $valor_total_receita;
                $porcentagem = real_percent_grafico($porcentagem);
                echo "'".$porcentagem. "',";
                
                }?>
                        ],
                    }],

                },



                options: {

                    elements: {
                        line: {
                            tension: 0
                        }
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