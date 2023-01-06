<?php 
include "crud.php";

?>
<div class="operacional">
    <div class="title">
        <p>Nfe Compra</p>
    </div>
    <table border="0" whidth="100%" cellspacing="0">

        <tbody class="top_tabela">
            <tr>
                <td style="width: 200px;">
                    <p>Emissão</p>
                </td>
                <td style="width: 400px;">
                    <p>Empresa</p>
                </td>
                <td>
                    <p>Nº Nfe</p>
                </td>
                <td>
                    <p>Valor Produtos</p>
                </td>
                <td>
                    <p>Valor Desconto</p>
                </td>
                <td>
                    <p>Valor Nota</p>
                </td>

            </tr>
        </tbody>
        <tbody class="corpo_tabela">
            <?php 
            $valor_total_nota = 0;
            $maior_valor_nota = 0;
            $menor_valor_nota = 0;
            $valor_total_produto = 0;
            $nPedidos = 0;
            while($linha = mysqli_fetch_assoc($consulta_nfe_entrada)){
                $valor_nota = $linha['valor_total_nota'];
                $data_emissao= formatDateB($linha['data_emissao']);
                $nome_fantasia = utf8_encode($linha['nome_fantasia']);
                $numero_nf = $linha['numero_nf'];
                $desconto = $linha['valor_desconto'];
                $vlr_produtos = $linha['valor_total_produtos'];
                $valor_total_nota = $valor_total_nota + $valor_nota;
                $valor_total_produto  = $valor_total_produto + $vlr_produtos;
                $nPedidos = $nPedidos + 1;
            
                if($maior_valor_nota < $valor_nota){
                    $maior_valor_nota = $valor_nota;
                }

                //pegar o menor valor vendido
                if($menor_valor_nota == 0){
                $menor_valor_nota = $valor_nota;
                }
                if($valor_nota < $menor_valor_nota){
                $menor_valor_nota = $valor_nota;
                }

            ?>

            <tr>
                <td>
                    <p><?php echo $data_emissao ?></p>
                </td>
                <td>
                    <p><?php echo $nome_fantasia; ?></p>
                </td>
                <td>
                    <p><?php echo ($numero_nf); ?></p>
                </td>
                <td>
                    <p><?php echo real_format($vlr_produtos); ?></p>
                </td>
                <td>
                    <p><?php echo real_format($desconto); ?></p>
                </td>
                <td>
                    <p><?php echo real_format($valor_nota); ?></p>
                </td>

            </tr>
            <?php } ?>
            <tr class="valor_total">
                <td>Total</td>
                <td></td>
                <td></td>
                <td><?php echo real_format($valor_total_produto); ?></td>
                <td></td>
                <td><?php echo real_format($valor_total_nota); ?></td>

            </tr>

        </tbody>
    </table>
    <div class="bloco-info-add">
        <div class="bloco-1">
            <p>Total de pedidos</p>
            <p><?php echo $nPedidos; ?></p>
        </div>
        <div class="bloco-1">
            <p>Maior Vlr. Nota</p>
            <p><?php echo real_format($maior_valor_nota);?></p>
        </div>
        <div class="bloco-1">
            <p>Menor Vlr. Mota</p>
            <p><?php echo real_format($menor_valor_nota); ?></p>
        </div>

    </div>
</div>