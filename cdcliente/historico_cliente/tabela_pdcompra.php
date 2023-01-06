<?php 
include "crud.php";

?>
<div class="operacional">
    <div class="title">
        <p>Pedido de compra</p>
    </div>
    <table border="0" whidth="100%" cellspacing="0">

        <tbody class="top_tabela">
            <tr>
                <td style="width: 200px;">
                    <p>Fechamento</p>
                </td>
                <td style="width: 400px;">
                    <p>Cliente</p>
                </td>

                <td>
                    <p>Compra</p>
                </td>
                <td>
                    <p>Venda</p>
                </td>
                <td>
                    <p>Margem</p>
                </td>
            </tr>
        </tbody>
        <tbody class="corpo_tabela">
            <?php 
            $valor_total_venda = 0;
            $valor_total_compra = 0;
            $nPedidos = 0;
            $maior_valor_venda = 0;
            $maior_valor_margem = 0;
            $menor_valor_venda = 0;
            while($linha = mysqli_fetch_assoc($consulta_pedido_compra)){
                $valor_venda = $linha['valor_total'];
                $data_fechamento= formatDateB($linha['data_fechamento']);
                $valor_compra = $linha['valor_total_compra'];
                $nome_fantasia = utf8_encode($linha['nome_fantasia']);
                $numero_nf = $linha['numero_nf'];
                $margem = $linha['valor_total_margem'];
                $valor_total_venda = $valor_total_venda +$valor_venda;
                $valor_total_compra = $valor_total_compra +$valor_compra;
                $nPedidos = $nPedidos + 1;
                 //pegar o maior valor vendido
                if($maior_valor_venda < $valor_venda){
                    $maior_valor_venda = $valor_venda;
                }

                if($maior_valor_margem < $margem){
                    $maior_valor_margem = $margem;
                }
                //pegar o menor valor vendido
                if($menor_valor_venda == 0){
                $menor_valor_venda = $valor_venda;
                }
                if($valor_venda < $menor_valor_venda){
                $menor_valor_venda = $valor_venda;
                }


            ?>
            <tr>
                <td>
                    <p><?php echo $data_fechamento ?></p>
                </td>
                <td>
                    <p><?php echo $nome_fantasia; ?></p>
                </td>
                <td>
                    <p><?php echo real_format($valor_compra); ?></p>
                </td>
                <td>
                    <p><?php echo real_format($valor_venda); ?></p>
                </td>

                <td>
                    <p><?php echo real_percent($margem); ?></p>
                </td>
            </tr>
            <?php } ?>
            <tr class="valor_total">
                <td>Total</td>
                <td></td>
                <td><?php echo real_format($valor_total_compra); ?></td>
                <td><?php echo real_format($valor_total_venda); ?></td>

                <td><?php 
                if($valor_total_venda != 0){
                $valor_margem = ((($valor_total_venda-$valor_total_compra)/$valor_total_venda)*100);
                }else{
                $valor_margem = 0;
                }
                echo real_percent($valor_margem); ?></td>
            </tr>

        </tbody>
    </table>
    <div class="bloco-info-add">
        <div class="bloco-1">
            <p>Total de pedidos</p>
            <p><?php echo $nPedidos; ?></p>
        </div>
        <div class="bloco-1">
            <p>Maior Vlr. Vendido</p>
            <p><?php echo real_format($maior_valor_venda);?></p>
        </div>
        <div class="bloco-1">
            <p>Menor Vlr. Vendido</p>
            <p><?php echo real_format($menor_valor_venda); ?></p>
        </div>
        <div class="bloco-1">
            <p>Maior margem %</p>
            <p><?php echo real_percent($maior_valor_margem); ?></p>
        </div>
    </div>
</div>