<?php 
include "../crud/despesa.php";
include "../../_incluir/funcoes.php";
?>


  
        <?php
        $i = 0;
        while($i<=11){
        $i = $i+ 1;
        //verificar a quantidade de despesa paga por mes ano atual
        $select = "SELECT sum(valor) as despesa,lancamentoFinanceiroID from lancamento_financeiro where  receita_despesa = 'Despesa' and status='Pago'  
        and data_do_pagamento between '$ano-$i-01' and '$ano-$i-31'";
        $consulta_valor_despesa_mes = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consulta_valor_despesa_mes);
        $valor_do_mes  = $linha['despesa'];
        $id  = $linha['lancamentoFinanceiroID'];
        $valorMultiplicado = $valor_do_mes;
        $porcentagem = $valorMultiplicado /3000;
        $porcentagem = real_percent_relatorio($porcentagem);
   
        if($i == 1){
            $mes = "Jan";
        }elseif($i==2){
            $mes = "Fev";
        }elseif($i == 3){
            $mes = "Mar";
        }elseif($i == 4){
            $mes = "Abr";
        }elseif($i == 5){
            $mes = "Maio";
        }elseif($i == 6){
            $mes = "Jun";
        }elseif($i == 7){
            $mes = "Jul";
        }elseif($i == 8){
            $mes = "Ago";
        }elseif($i == 9){
            $mes = "Set";
        }elseif($i == 10){
            $mes = "Out";
        }elseif($i == 11){
            $mes = "Nov";
        }
        elseif($i == 12){
            $mes = "Dez";
        }
        
        //verificar a quantidade de despesa paga por mes ano anterior
        $ano_anterior = $ano -1;
        

        $select = "SELECT sum(valor) as despesa from lancamento_financeiro where  receita_despesa = 'Despesa' and status='Pago'  
        and data_do_pagamento between '$ano_anterior-$i-01' and '$ano_anterior-$i-31'";
        $consulta_valor_despesa_mes_ano_anterior = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consulta_valor_despesa_mes_ano_anterior);
        $valor_do_mes_anterior  = $linha['despesa'];
        $valorMultiplicado = $valor_do_mes_anterior;
        $porcentagem_anterior = $valorMultiplicado / 3000;
        $porcentagem_ano_anterior = real_percent_relatorio($porcentagem_anterior);

        ?>
        <div class="bloco-1">
            <div id_mes="<?php echo $id; ?>" class="grafico">
                <div class="info">
                    <div style="height:<?php echo $porcentagem;?>;background-color:red" class="barra"></div>
                </div>

                <div class="info">
                    <div style="height:<?php echo $porcentagem_ano_anterior;?>;background-color:blue"
                        class="barra"></div>
                </div>

                <div class="bloco-sub-dados id<?php echo $id;  ?>">
                    <div class="title">
                        <p><?php echo $mes; ?></p>
                    </div>
                    <div class="sub-dados-group">

                        <div class="bloco-1">
                            <div class="title">
                                <p><?php echo $ano; ?></p>
                            </div>
                            <hr>
                            <p><?php echo $porcentagem; ?></p>

                            <p><?php echo real_format($valor_do_mes); ?></p>
                        </div>
                        <hr>
                        <div class="bloco-1">
                            <div class="title">
                                <p><?php echo $ano_anterior; ?></p>
                            </div>
                            <hr>
                            <p><?php echo $porcentagem_ano_anterior; ?></p>

                            <p><?php echo real_format($valor_do_mes_anterior); ?></p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="title">
                <p><?php echo $mes; ?></p>
            </div>

        </div>

        <?php 
        
    }
        ?>


        <div class="legenda">
            <div class="leg-1">
                <div style="background-color:red ;" class="bloco-leg-1"></div>
                <p><?php echo $ano; ?></p>
            </div>
            <div class="leg-1">
                <div style="background-color:blue ;" class="bloco-leg-1"></div>
                <p><?php echo $ano_anterior; ?></p>
            </div>
        </div>
  
<script>
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