<?php 
include("../conexao/sessao.php");
require_once("../conexao/conexao.php"); 

//consultar situacao ativo
$selectativo = "SELECT ativoID, nome_ativo from ativo";
$lista_ativo = mysqli_query($conecta, $selectativo);
if(!$lista_ativo){
die("Falaha no banco de dados  Linha 31 inserir_transportadora");
}

//consultar categoria
$selectcategoria = "SELECT categoriaID, nome_categoria from categoria_produto";
$lista_categoria = mysqli_query($conecta, $selectcategoria);
if(!$lista_categoria){
die("Falaha no banco de dados  Linha 31 inserir_transportadora");
}

//consultar clientes
$produtos = " SELECT produtos.produtoID, produtos.fabricante, produtos.nomeproduto, produtos.precovenda,produtos.precocompra,produtos.estoque, categoria_produto.nome_categoria as categoria_nome, ativo.nome_ativo as ativo_nome, produtos.unidade_medida from ativo  inner join  produtos on produtos.nome_ativo = ativo.ativoID INNER Join categoria_produto on produtos.nome_categoria = categoria_produto.categoriaID " ;
if(isset($_GET["produto"])){
    $nome_produto = $_GET["produto"];
    $produtos .= " WHERE produtos.nomeproduto LIKE '%{$nome_produto}%' or categoria_produto.nome_categoria LIKE '%{$nome_produto}%'  or produtos.produtoID LIKE '%{$nome_produto}%' ";
}

$resultado = mysqli_query($conecta, $produtos);
if(!$resultado){
    die("Falha na consulta ao banco de dados");
    
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
                onclick="window.open('cadastro_produto.php', 
'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">
                <input type="submit" style="width:140px" name="cadastrar_produto" value="Adicionar Produto">
            </a>


            <form action="consulta_produto.php" method="get">

                <input type="text" name="produto" placeholder="Pesquisa / Produto / Código / Categoria" value="<?php if(isset($_GET['produto'])){
                    echo $nome_produto;
                }?>">
                <input type="image" name="pesquisa" src="https://img.icons8.com/ios/50/000000/search-more.png" />


            </form>


        </div>

        <form action="consulta_produto.php" method="get">

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
                            <p>Preço venda</p>
                        </td>
                        <td>
                            <p>Preço compra</p>
                        </td>
                        <td>
                            <p>Estoque</p>
                        </td>


                        <td>
                            <p>Categoria</p>
                        </td>
                        <td>
                            <p>Fabricante</p>
                        </td>
                        <td>
                            <p>UND</p>
                        </td>

                        <td>
                            <p></p>
                        </td>

                    </tr>

                    <?php


if(isset($_GET["produto"])){
      while($linha = mysqli_fetch_assoc($resultado)){
        $idProduto = $linha["produtoID"]?>


                    <tr id="linha_pesquisa">



                        <td style="width: 70px;">
                            <font size="3"><?php echo utf8_encode($linha["produtoID"])?> </font>
                        </td>

                        <td style="width: 500px;">
                            <p>
                                <font size="2"><?php echo utf8_encode($linha["nomeproduto"])?> </font>
                            </p>
                        </td>
                        <td style="width: 150px;">
                            <font size="2"><?php echo real_format($linha["precovenda"])?></font>
                        </td>
                        <td style="width: 150px;">
                            <font size="2"><?php echo real_format($linha["precocompra"])?> </font>
                        </td>

                        <td style="width: 100px;">
                            <font size="2"><?php echo utf8_encode($linha["estoque"])?> </font>
                        </td>

                        <td style="width: 100px;">
                            <font size="2"> <?php echo utf8_encode($linha["categoria_nome"])?></font>
                        </td>

                        <td style="width: 100px;">
                            <font size="2"><?php echo utf8_encode($linha["fabricante"])?> </font>
                        </td>
                        <td>
                            <font size="2"><?php echo utf8_encode($linha["unidade_medida"])?> </font>
                        </td>

                        <td id="botaoEditar">


                            <a
                                onclick="window.open('editar_produto.php?codigo=<?php echo $linha['produtoID']?>', 
'editar_produto', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">

                                <button type="button" name="editar">Editar</button>
                            </a>

                        </td>


                    </tr>



                    <?php
             }
            }
            ?>
                </tbody>
            </table>

        </form>

    </main>
</body>


</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>