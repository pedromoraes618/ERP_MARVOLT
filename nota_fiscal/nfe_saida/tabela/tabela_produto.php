<?php
include "../../../conexao/conexao.php";
include "../crud/gerenciar_nfe.php";
?>

<div class="table-responsive border-0 border-top shadow mb-0 mb-2">
    <table class="table table-hover">
        <thead>
            <th>Item</th>
            <th>Descrição</th>
            <th>Und</th>
            <th>Qtd</th>
            <th>Vlr Unitario</th>
            <th>Vlr total
            <th>Ncm
            <th>Cfop
            <th>Cst
            <th>
        </thead>
        <tbody>
            <?php
            $total_prod = 0;
            while ($linha = mysqli_fetch_assoc($consulta_prod_nf)) {
                $nfe_iten_saidaID = $linha['nfe_iten_saidaID'];
                $item = $linha['item'];
                $descricao = utf8_encode($linha['descricao']);
                $und = utf8_encode($linha['und']);
                $quantidade = ($linha['quantidade']);
                $valor_unitario = ($linha['valor_unitario']);
                $valor_produto = ($linha['valor_produto']);
                $ncm = ($linha['ncm']);
                $cfop = ($linha['cfop']);
                $cst = ($linha['cst_icms']);

                $total_prod = $valor_produto + $total_prod;

                //     $codigo_produto_b = $linha['cl_codigo'];
                //     $descricao_b = utf8_encode($linha['descricao']);
                //     $referencia_b = utf8_encode($linha['cl_referencia']);
                //     $estoque_minimo_b = utf8_encode($linha['cl_estoque_minimo']);
                //     $estoque_maximo_b = utf8_encode($linha['cl_estoque_maximo']);
                //     $subgrupo_b = utf8_encode($linha['subgrupo']);
                //     $und_b = utf8_encode($linha['und']);
                //     $fabricante_b = utf8_encode($linha['fabricante']);
                //     $estoque_b = $linha['cl_estoque'];
                //     $preco_venda_b = real_format($linha['cl_preco_venda']);
                //     $ativo = ($linha['ativo']);
            ?>
                <tr>
                    <td><?php echo $item ?></td>
                    <td><?php echo $descricao ?></td>
                    <td><?php echo $und ?></td>
                    <td><?php echo $quantidade ?></td>
                    <td><?php echo real_format($valor_unitario) ?></td>
                    <td><?php echo real_format($valor_produto); ?></td>
                    <td><?php echo $ncm ?></td>
                    <td><?php echo $cfop ?></td>
                    <td><?php echo $cst ?></td>
                    <td><button type="button" id_prod=<?php echo $nfe_iten_saidaID; ?>  class="btn btn-sm btn-info editar_prod">Editar </button></td>
                </tr>

            <?php } ?>
        </tbody>
        <tfoot>
            <th>Total</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th><?php echo real_format($total_prod) ?></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
        </tfoot>
    </table>
</div>

<script src="js/tabela/editar_prod.js"></script>