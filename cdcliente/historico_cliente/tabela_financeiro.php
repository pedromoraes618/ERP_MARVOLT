<?php 
include "crud.php";

?>
<div class="operacional">
    <div class="title">
        <p>Financeiro</p>
    </div>
    <table border="0" whidth="100%" cellspacing="0">

        <tbody class="top_tabela">
            <tr>
                <td style="width: 200px;">
                    <p>Vencimento</p>
                </td>
                <td style="width: 400px;">
                    <p>Pagamento</p>
                </td>

                <td>
                    <p>Status</p>
                </td>
                <td>
                    <p>Forma Pg.</p>
                </td>
                <td>
                    <p>Valor</p>
                </td>
                <td>
                    <p>Atraso</p>
                </td>
                <td></td>
            </tr>
        </tbody>
        <tbody class="corpo_tabela">
            <?php 
            $valor_total = 0;
            $total_pagos = 0;
            $total_a_pagar = 0;
            $cont_recebido = 0;
            $cont_pago = 0;
            $valor_total_pago = 0;
            $valor_total_recebido = 0;
            $duplicatas_atraso = 0;
            while($linha = mysqli_fetch_assoc($consulta_financeiro)){
                $valor = $linha['valor'];
                $data_a_pagar= formatDateB($linha['data_a_pagar']);
                $data_pagamento = formatDateB($linha['data_do_pagamento']);
                $nome_fantasia = utf8_encode($linha['nome_fantasia']);
                $forma_pagamento = utf8_encode($linha['nome']);
                $status = utf8_encode($linha['status']);
                $atraso = utf8_encode($linha['atraso']);
                $valor_total = $valor_total + $valor;
                if($status == "Recebido"){
                    $cont_recebido = $cont_recebido + 1;
                    $valor_total_recebido = $valor_total_recebido + $valor;
                } 
                if($status == "Pago"){
                    $cont_pago = $cont_pago + 1;
                    $valor_total_pago = $valor_total_pago + $valor;
                }
                if($atraso > 0){
                    $duplicatas_atraso = $duplicatas_atraso + 1;
                }
     
                //     //pegar o maior valor vendido
                // if($maior_valor_venda < $valor_venda){
                //     $maior_valor_venda = $valor_venda;
                // }

                // if($maior_valor_margem < $margem){
                //     $maior_valor_margem = $margem;
                // }
                // //pegar o menor valor vendido
                // if($menor_valor_venda == 0){
                // $menor_valor_venda = $valor_venda;
                // }
                // if($valor_venda < $menor_valor_venda){
                // $menor_valor_venda = $valor_venda;
                // }


            ?>
            <tr>
                <td>
                    <p><?php echo ($data_a_pagar) ?></p>
                </td>
                <td>
                    <p><?php echo ($data_pagamento) ?></p>
                </td>
                <td>
                    <p><?php echo $status; ?></p>
                </td>
                <td>
                    <p><?php echo ($forma_pagamento); ?></p>
                </td>
                <td>
                    <p><?php echo real_format($valor); ?></p>
                </td>
                <td style="width:50px ;">

                    <?php if($atraso > 0){ 
                    echo '<p style=color:red;text-align:center>'.$atraso.'</p>'; } ?>
                </td>

                <td style="width: 30px;">
                    <?php if($atraso > 0){ echo
                   '<img style="width:20px;" src=../../images/alerta.png>';
                }?>
                </td>
            </tr>
            <?php } ?>
            <tr class="valor_total">
                <td>Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <p><?php echo real_format($valor_total);?></p>
                </td>
                <td></td>
                <td></td>
            </tr>

        </tbody>
    </table>
    <div class="bloco-info-add">
        <div class="bloco-1">
            <p>Total Recebidos</p>
            <p><?php echo $cont_recebido; ?></p>
            <p><?php echo  real_format($valor_total_recebido); ?></p>
        </div>
        <div class="bloco-1">
            <p>Total Pago</p>
            <p><?php echo $total_pagos; ?></p>
            <p><?php echo  real_format($valor_total_pago); ?></p>

        </div>
        <div class="bloco-1">
            <p>Duplicatas em atraso</p>
            <p><?php echo $duplicatas_atraso; ?></p>

        </div>
       
    </div>
</div>