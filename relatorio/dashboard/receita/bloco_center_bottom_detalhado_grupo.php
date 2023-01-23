<?php 
include "../crud/receita.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio_center_bottom">

    <div class="title">
        <h4>
            <?php 
            if(isset($_GET['grupocliente'])){
                $desc_grupo = $_GET['grupocliente'];
                echo  "Análise de variação de receita - $desc_grupo ";
            }
            
          ?>

        </h4>
    </div>
    <!-- <div class="bloco-tipo">
        <button id="rb1">R1</button>
        <button id="rb2">R2</button>
    </div> -->

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
                    datasets: [{
                            label: 'R$',
                            data: [
                                <?php
                            $i = 0;
                            while($i<=11){
                            $i = $i+ 1;
                            //verificar a quantidade de receita por mes 
                            if(isset($_GET['id_grupo_cliente_bloco_center_bottom'])){
                                $grupoID = $_GET['id_grupo_cliente_bloco_center_bottom'];
                            }
                            // lcf.grupoID != 22  grupo de investimento de socio não entra na receita do dashboard
                            $select = "SELECT sum(lcf.valor) as receita, grpc.cl_descricao from lancamento_financeiro as lcf inner join clientes as cl on cl.clienteID = lcf.clienteID inner join tb_grupo_cliente as grpc
                            on grpc.cl_id = cl.grupo_cliente where lcf.grupoID != 22 and  lcf.receita_despesa = 'Receita' and lcf.status='Recebido' and lcf.data_do_pagamento between '$ano-$i-01' and '$ano-$i-31' and grpc.cl_id = '$grupoID' "; // GRUPO NOTA FISCAL RECEITA
                            $consulta_valor_despesa_mes = mysqli_query($conecta,$select);
                            $linha = mysqli_fetch_assoc($consulta_valor_despesa_mes);
                            $valor_do_mes  =   ($linha['receita']);
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
                                    $select ="SELECT sum(lcf.valor) as receita, grpc.cl_descricao from lancamento_financeiro as lcf inner join clientes as cl on cl.clienteID = lcf.clienteID inner join tb_grupo_cliente as grpc
                                    on grpc.cl_id = cl.grupo_cliente where  lcf.receita_despesa = 'Receita' and lcf.status='Recebido' and lcf.data_do_pagamento between '$ano_anterior-$i-01' and '$ano_anterior-$i-31' and grpc.cl_id ='$grupoID'";
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
                    ]
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

                    scales: {
                        yAxes: [{
                            display: true,

                            display: true,

                            ticks: {
                                callback:(value,index,values)=>{
                                    return new Intl.NumberFormat('pt-br',{
                                        style:'currency',
                                        currency:'BRL',
                                    }).format(value);},
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
            <div class="leg-1">
                <div style="background-color:red ;" class="bloco-leg-1"></div>
                <p><?php echo $ano; ?></p>
            </div>
            <div class="leg-1">
                <div style="background-color:coral ;" class="bloco-leg-1"></div>
                <p><?php echo $ano_anterior; ?></p>
            </div>
        </div>

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