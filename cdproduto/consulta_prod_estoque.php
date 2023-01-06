<?php 
include("../conexao/sessao.php");
require_once("../conexao/conexao.php"); 

if(isset($_GET["produto"])){
$select = " SELECT prod_est.cl_id as id_produto,prod_est.cl_descricao, prod_est.cl_und as unidade,
 prod_est.cl_estoque as estoque,ct_produto.nome_categoria as categoria, prod_est.cl_preco_custo as preco_custo,
 prod_est.cl_observacao as obs,prod_est.cl_fabricante as fabricante  from tb_produto_estoque 
as prod_est  inner join categoria_produto as ct_produto on
prod_est.cl_categoria = ct_produto.categoriaID" ;
$pesquisa = $_GET["produto"];
$select .= " WHERE prod_est.cl_descricao LIKE '%{$pesquisa}%' or prod_est.cl_id  LIKE '%{$pesquisa}%' ";
$resultado_pesquisa = mysqli_query($conecta, $select);
if(!$resultado_pesquisa){
    die("Falha na consulta ao banco de dados");
}

//VALOR TOTAL CONTABIL E QTD ESTOQUE
$select = $select = "SELECT  sum(cl_total) as soma, sum(cl_estoque) as total_estoque FROM tb_produto_estoque
 WHERE cl_descricao LIKE '%{$pesquisa}%' or cl_id  LIKE '%{$pesquisa}%' ";
$operacao_soma_total = mysqli_query($conecta,$select);
if(!$operacao_soma_total){
    die("Falaha no banco de dados || select valor");
}else{
    $linha = mysqli_fetch_assoc($operacao_soma_total);
    $soma = $linha['soma'];
    $total_qtd_estoque = $linha['total_estoque'];
}


}



?>
<!doctype html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- estilo -->
    <link href="../_css/estilo.css" rel="stylesheet">
    <link href="../_css/pesquisa_tela.css" rel="stylesheet">

    <a href="https://icons8.com/icon/59832/cardápio"></a>
</head>

<body>

    <?php include_once("../_incluir/topo.php"); ?>
    <?php include("../_incluir/body.php"); ?>
    <?php include_once("../_incluir/funcoes.php"); ?>


    <main>

        <div id="janela_pesquisa">

            <a
                onclick="window.open('cadastro_produto_estoque.php', 
'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">
                <input type="submit" style="width:140px" name="cadastrar_produto" value="Adicionar Produto">
            </a>



            <form method="get">

                <input type="text" name="produto" placeholder="Pesquisa / Produto / Código " value="<?php if(isset($_GET['produto'])){
                    echo $pesquisa;
                }?>">
                <input type="image" name="pesquisa" src="https://img.icons8.com/ios/50/000000/search-more.png" />


            </form>


        </div>



        <table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
            <tbody>
                <tr id="cabecalho_pesquisa_consulta">
                    <td>
                        <p>Código</p>
                    </td>

                    <td>
                        <p>Descrição</p>
                    </td>
                    <td>
                        <p>Fabricante</p>
                    </td>
                    <td>
                        <p>Categoria</p>
                    </td>

                    <td>
                        <p>UND</p>
                    </td>

                    <td>
                        <p>Estoque</p>
                    </td>

                    <td>
                        <p>Preço Custo</p>
                    </td>
                    <td>

                    </td>


                </tr>

                <?php


if(isset($_GET["produto"])){
      while($linha = mysqli_fetch_assoc($resultado_pesquisa)){
        $idProduto = $linha["id_produto"];
        $descricao = $linha["cl_descricao"];
        $fabricante = $linha["fabricante"];
        $categoria = $linha["categoria"];
        $unidade = $linha["unidade"];
        $estoque = $linha["estoque"];
        $preco_custo = $linha["preco_custo"];
        $observacao = $linha["obs"];
        
        ?>

                <tr id="linha_pesquisa">
                    <td style="width: 70px;">
                        <font size="3"><?php echo $idProduto;?> </font>
                    </td>

                    <td style="width: 500px;">
                        <p>
                            <font size="2"><?php echo utf8_encode($descricao)?> </font>
                        </p>
                    </td>


                    <td style="width: 120px;">
                        <font size="2"> <?php echo utf8_encode($fabricante)?></font>
                    </td>

                    <td style="width: 120px;">
                        <font size="2"><?php echo utf8_encode($categoria)?> </font>
                    </td>
                    <td style="width: 120px;">
                        <font size="2"><?php echo utf8_encode($unidade)?> </font>
                    </td>

                    <td style="width: 120px;">
                        <font size="2"><?php echo utf8_encode($estoque)?> </font>
                    </td>
                    <td style="width: 120px;">
                        <font size="2"><?php echo real_format($preco_custo)?> </font>
                    </td>


                    <td id="botaoEditar">


                        <a
                            onclick="window.open('editar_produto_estoque.php?codigo=<?php echo $idProduto;?>', 
'editar_produto', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">

                            <button type="button" name="editar">Editar</button>
                        </a>

                    </td>


                </tr>



                <?php
             }
     
                     ?>

                <tr id="cabecalho_pesquisa_consulta">
                    <td>
                        <p>Total</p>
                    </td>
                    <td>
                        <p></p>
                    </td>

                    <td>

                    </td>

                    <td>

                    </td>


                    <td>

                    </td>

                    <td>
                        <p><?php  echo ($total_qtd_estoque);?> </p>
                    </td>
                    <td>
                        <p><?php  echo real_format($soma);?> </p>
                    </td>

                    <td>

                    </td>




                </tr>

                <?php

        

            }
            ?>
            </tbody>
        </table>



    </main>
</body>


</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>