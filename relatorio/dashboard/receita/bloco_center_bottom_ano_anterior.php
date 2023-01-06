<?php 
include "../crud/receita.php";
include "../../../_incluir/funcoes.php";

if(isset($_GET['ano_filtro'])){
    $ano_filtro = $_GET['ano_filtro'];
};
?>


<div class="bloco">

    <div class="bloco-1">
        <div>
            <canvas width="750" height="170" id="myChart"></canvas>
        </div>

        <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var meses = ["Jan", "fev", "mar", "abr", "mai", "jun", 'jul', 'ago', 'set', 'out', 'nov', 'dez']
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: meses,
                datasets: [
                    <?php  
                            if($ano_filtro >= 2){
                            ?> {
                        label: 'R$',
                        data: [
                            <?php
                            $i = 0;
                            while($i<=11){
                            $i = $i+ 1;
                            //verificar a quantidade de receita por mes 
                            $select = "SELECT sum(lcf.valor) as receita, lcf.lancamentoFinanceiroID,cl.nome_fantasia,gpcl.cl_Id as grupo_cliente_id from lancamento_financeiro as lcf
                            inner join clientes as cl on cl.clienteID = lcf.clienteID inner join tb_grupo_cliente as gpcl on gpcl.cl_id = cl.grupo_cliente  where  lcf.receita_despesa = 'Receita' and status='Recebido'  
                            and gpcl.cl_id != 7 and lcf.data_do_pagamento BETWEEN '$ano-$i-01' and '$ano-$i-31'";
                            $consulta_valor_despesa_mes = mysqli_query($conecta,$select);
                            $linha = mysqli_fetch_assoc($consulta_valor_despesa_mes);
                            $valor_do_mes  =   ($linha['receita']);
                            $id  = $linha['lancamentoFinanceiroID'];
                            $valorMultiplicado = $valor_do_mes;
                            $porcentagem = $valorMultiplicado /3000;
                            $porcentagem = real_percent_relatorio($porcentagem);

                            echo       "'". $valor_do_mes ."',";
                            }
                            ?>

                        ],
                        borderColor: 'red',
                        borderWidth: 2,
                        backgroundColor: 'transparent',
                        fontColor: '#FFFFFF',

                    },

                    <?php $ano_anterior = $ano - 1; ?> {

                        label: 'R$',
                        data: [
                            <?php
                            
                                $i = 0;
                                while ($i <= 11) {
                                    $i = $i + 1;
                                    $select ="SELECT sum(lcf.valor) as receita, lcf.lancamentoFinanceiroID,cl.nome_fantasia,gpcl.cl_Id as grupo_cliente_id from lancamento_financeiro as lcf
                                    inner join clientes as cl on cl.clienteID = lcf.clienteID inner join tb_grupo_cliente as gpcl on gpcl.cl_id = cl.grupo_cliente  where  lcf.receita_despesa = 'Receita' and status='Recebido'  
                                   and gpcl.cl_id != 7 and lcf.data_do_pagamento BETWEEN '$ano_anterior-$i-01' and '$ano_anterior-$i-31'";
                                    $consulta_valor_despesa_mes_ano_anterior = mysqli_query($conecta, $select);
                                    $linha = mysqli_fetch_assoc(
                                    $consulta_valor_despesa_mes_ano_anterior);
                                    $valor_do_mes_anterior = $linha['receita'];
                                    $valorMultiplicado = $valor_do_mes_anterior;
                                    $porcentagem_anterior = $valorMultiplicado / 3000;
                                    $porcentagem_ano_anterior = real_percent_relatorio(
                                        $porcentagem_anterior);

                                    echo "'".$valor_do_mes_anterior."',";
                                } ?>
                        ],
                        borderColor: 'coral',
                        borderWidth: 2,
                        backgroundColor: 'transparent',
                        fontColor: '#FFFFFF',
                    },
                    <?php
                    };
            
        
                    if($ano_filtro >=  3){
                                

                        $ano_anterior_3 = $ano - 2; ?> {

                        label: 'R$',
                        data: [
                            <?php
                            $i = 0;
                            while ($i <= 11) {
                            $i = $i + 1;
                            $select ="SELECT sum(lcf.valor) as receita, lcf.lancamentoFinanceiroID,cl.nome_fantasia,gpcl.cl_Id as grupo_cliente_id from lancamento_financeiro as lcf
                            inner join clientes as cl on cl.clienteID = lcf.clienteID inner join tb_grupo_cliente as gpcl on gpcl.cl_id = cl.grupo_cliente  where  lcf.receita_despesa = 'Receita' and status='Recebido'  
                            and gpcl.cl_id != 7 and lcf.data_do_pagamento BETWEEN '$ano_anterior_3-$i-01' and '$ano_anterior_3-$i-31'";
                            $consulta_valor_despesa_mes_ano_anterior = mysqli_query($conecta, $select);
                            $linha = mysqli_fetch_assoc(
                            $consulta_valor_despesa_mes_ano_anterior);
                            $valor_do_mes_anterior = $linha['receita'];
                            $valorMultiplicado = $valor_do_mes_anterior;
                            $porcentagem_anterior = $valorMultiplicado / 3000;
                            $porcentagem_ano_anterior = real_percent_relatorio(
                            $porcentagem_anterior);

                            echo "'".$valor_do_mes_anterior."',";
                            } ?>
                        ],
                        borderColor: 'green',
                        borderWidth: 2,
                        backgroundColor: 'transparent',
                        fontColor: '#FFFFFF',
                    },
                    <?php 
                            };

                    ?>


                ]
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
        <?php if($ano_filtro >= 2){

        ?>
        <div class="leg-1">
            <div style="background-color:red ;" class="bloco-leg-1"></div>
            <p><?php echo $ano; ?></p>
        </div>
        <div class="leg-1">
            <div style="background-color:coral ;" class="bloco-leg-1"></div>
            <p><?php echo $ano_anterior; ?></p>
        </div>
        <?php 
           }  if($ano_filtro >= 3){  
        ?>
        <div class="leg-1">
            <div style="background-color:green ;" class="bloco-leg-1"></div>
            <p><?php echo $ano - 2; ?></p>
        </div>

        <?php
        }
        ?>


    </div>

</div>



<script>
// $(document).ready(function(e) {
//     $.ajax({
//         type: 'GET',
//         data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
//             .value,
//         url: "despesa/bloco_center_bottom2.php",
//         success: function(result) {
//             return $(".relatorio_center_bottom .bloco").html(result);
//         },
//     });
// })
// $("#rb1").click(function(e) {
//     e.preventDefault();
//     $.ajax({
//         type: 'GET',
//         data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
//             .value,
//         url: "despesa/bloco_center_bottom1.php",
//         success: function(result) {
//             return $(".relatorio_center_bottom .bloco").html(result);
//         },
//     });
// })

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
$('#ano_receita_meses').change(function() {
    var selectedValue = $(this).val();
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "receita/bloco_center_bottom2.php",
        success: function(result) {
            return $(".relatorio_center_bottom .bloco").html(result);
        },
    });
});
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