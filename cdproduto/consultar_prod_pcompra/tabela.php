<?php 
include("../../conexao/conexao.php"); 
include("../../_incluir/funcoes.php");



$select = "SELECT * from categoria_produto";
$consultar_categoria_produto = mysqli_query($conecta, $select);
?>


<table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
    <tbody>
        <tr id="cabecalho_pesquisa_consulta">
            <td>
                <p>Categoria</p>
            </td>
            <td>
                <p>Produto</p>
            </td>

            <td>
                <p>Qtd.</p>
            </td>

            <td>
                <p>Preço Compra Unt.</p>
            </td>
            <td>
                <p>Preço Venda Unt.</p>
            </td>
            <td>
                <p>Preço Total Comprado</p>
            </td>
            <td>
                <p>Preço Total Vendido</p>
            </td>
            <td>
                <p>Margem</p>
            </td>
            <td>
                <p>Nº Pedido</p>
            </td>
            <td>

            </td>
        </tr>
        <?php 
         $total_categoria = array();
      while($linha = mysqli_fetch_assoc($consultar_categoria_produto)){
        $categoriaId =  $linha['categoriaID'];
        $titulo_categoria = utf8_encode($linha['nome_categoria']);
        ?>
        <tr class="sub_cabecalho">
            <td style="width: 300px;">
                <p><?php echo $titulo_categoria; ?></p>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>

        </tr>
        <?php
        $valor_total_venda = 0;
        $valor_total_compra = 0; 
        $select= "SELECT pdit.produto as produto,pdit.pedido_itemID as idproduto,pdit.quantidade as quantidade,pdit.margem as margem,pdit.preco_compra_unitario as preco_compra_unitario,pdit.preco_venda_unitario as preco_venda_unitario,
        ctprod.nome_categoria as categoria,pdc.numero_pedido_compra as numero_pedido from tb_pedido_item as pdit inner join categoria_produto as ctprod on ctprod.categoriaID = pdit.categoria_produto 
        inner join pedido_compra as pdc on pdc.codigo_pedido = pdit.pedidoID where pdit.categoria_produto = $categoriaId order by pdit.categoria_produto desc";
        $consultar_produtos_pedido_compra = mysqli_query($conecta, $select);
        while($linha = mysqli_fetch_assoc($consultar_produtos_pedido_compra)){
            $categoria =utf8_encode($linha['categoria']);
            $produto = utf8_encode($linha['produto']);
            $quantidade = $linha['quantidade'];
            $margem = $linha['margem'];
            $preco_compra_unitario = $linha['preco_compra_unitario'];
            $preco_venda_unitario = $linha['preco_venda_unitario'];
            $numero_pedido = $linha['numero_pedido'];
            $idProduto = $linha['idproduto'];
            $valor_total_venda = ($quantidade * $preco_venda_unitario) + $valor_total_venda;
            $valor_total_compra = ($quantidade * $preco_compra_unitario) + $valor_total_compra;
            ?>
        <tr id="linha_pesquisa">
            <td>
                <p> <?php echo $categoria; ?></p>
            </td>
            <td>
                <p> <?php echo $produto; ?></p>
            </td>
            <td>
                <p> <?php echo $quantidade; ?></p>
            </td>

            <td>
                <p> <?php echo real_format($preco_compra_unitario); ?></p>
            </td>
            <td>
                <p> <?php echo real_format($preco_venda_unitario); ?></p>
            </td>
            <td>
                <p> <?php echo real_format($quantidade * $preco_compra_unitario); ?></p>
            </td>
            <td>
                <p> <?php echo real_format($quantidade * $preco_venda_unitario); ?></p>
            </td>
            <td>
                <?php echo real_percent($margem); ?>
            </td>
            <td>
                <p> <?php echo ($numero_pedido); ?></p>
            </td>

            <td id="botaoEditar">
                <a
                    onclick="window.open('editar_ctg_produto.php?id=<?php echo $idProduto;?>', 
'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=700, HEIGHT=500');">

                    <button type="button" name="Editar">Editar Ctg</button>


                </a>


            </td>


        </tr>
        <?php 
        }
      
            if($valor_total_venda != 0){
            $valor_margem = ((($valor_total_venda-$valor_total_compra)/$valor_total_venda)*100);
            }else{
            $valor_margem = 0;
            }
            //array para guardar os valores de cada categoria
            array_push($total_categoria,(
                array("categoria"=>$titulo_categoria,"valor_venda"=>$valor_total_venda,"valor_compra"=>$valor_total_compra,"margem_total"=>$valor_margem)
            ));
           

         }
        ?>


    </tbody>
</table>
<div class="resumo_valores_categoria">
    <p>Resumo de valores</p>
</div>
<table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
    <tbody>
        <tr id="cabecalho_pesquisa_consulta">
            <td>
                <p>Categoria</p>
            </td>
            <td>
                <p>Valor de Compra</p>
            </td>
            <td>
                <p>Valor de Venda</p>
            </td>

            <td>
                <p>Margem</p>
            </td>
        </tr>
        <?php
        foreach($total_categoria as $catego){
        ?>
        <tr id="linha_pesquisa">
            <td>
                <p><?php echo $catego['categoria'] ?></p>
            </td>
            <td>
                <p><?php echo real_format($catego['valor_compra']) ?></p>
            </td>
            <td>
                <p><?php echo real_format($catego['valor_venda']) ?></p>
            </td>

            <td>
                <p><?php echo real_percent($catego['margem_total']) ?></p>
            </td>
            <?php
            }
            ?>
        </tr>

    </tbody>
</table>