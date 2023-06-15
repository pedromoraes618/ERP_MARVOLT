<?php
include("../conexao/sessao.php");
require_once("../conexao/conexao.php");
include("../alert/alert.php");

echo "."; 
//consultar categoria do produto
$select = "SELECT categoriaID, nome_categoria from categoria_produto";
$lista_categoria = mysqli_query($conecta,$select);
if(!$lista_categoria){
    die("Falaha no banco de dados  Linha 89");
}

//consultar Situação ativo
$selectativo = "SELECT ativoID, nome_ativo from ativo";
$lista_ativo = mysqli_query($conecta, $selectativo);
if(!$lista_ativo){
    die("Falaha no banco de dados  Linha 96 ");
}

//variaveis 
if(isset($_POST["enviar"])){
    $hoje = date('Y-m-d'); 
    $produtoID = utf8_decode($_POST["cammpoProdutoID"]);
    $nome_produto = utf8_decode($_POST["campoNomeProduto"]);
    $preco_venda = utf8_decode($_POST["campoPrecoVenda"]);
    $preco_compra = utf8_decode($_POST["campoPrecoCompra"]);
    $estoque = utf8_decode($_POST["campoEstoque"]);
    $unidade_medida = utf8_decode($_POST["campoUnidadedeMedida"]);
    $categoria = utf8_decode($_POST["campoCategoria"]);
    $ativo = utf8_decode($_POST["campoAtivo"]);
    $observacao = utf8_decode($_POST["campoObservacao"]);
    $fabricante =  utf8_decode($_POST["campoFabricante"]);
    $ncm =  utf8_decode($_POST["campoNcm"]);
   

  if(isset($_POST['enviar']))
  {
    if($categoria=="0"){
     
      ?>
<script>
alertify.alert("Favor informar a categoria do produto");
</script>

<?php 
    }elseif($nome_produto==""){
      ?>
<script>
alertify.alert("Favor informe a descrição do produto");
</script>

<?php 
    }else{
       

//inserindo as informações no banco de dados
  $inserir = "INSERT INTO produtos ";
  $inserir .= "( data_cadastro,nomeproduto,precovenda,precocompra,estoque,unidade_medida,observacao,nome_categoria,nome_ativo,fabricante,ncm )";
  $inserir .= " VALUES ";
  $inserir .= "( '$hoje','$nome_produto','$preco_venda',' $preco_compra',' $estoque','$unidade_medida','$observacao','$categoria','$ativo','$fabricante','$ncm')";

   
  $operacao_inserir = mysqli_query($conecta, $inserir);
  if(!$operacao_inserir){
      die("Erro no banco de dados Linha 63 inserir_no_banco_de_dados");
      
  }else{
    $nome_produto = "";
    $preco_venda = "";
    $preco_compra = "";
    $estoque = "";
    $unidade_medida = "";
    $categoria = "1";
    $ativo = "";
    $observacao = "";
    $fabricante = "";
    $ncm = "";
    ?>
<script>
alertify.success("Produto cadastrado com sucesso");
</script>

<?php
  }

}

}

}

?>

<!doctype html>

<html>



<head>
    <meta charset="UTF-8">
    <!-- estilo -->

    <link href="../_css/tela_cadastro_editar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="tab" style="width: 1500px;">
        <button class="tablinks" onclick="openCity(event, 'p1')" id="defaultOpen">Dados básicos</button>
        <button class="tablinks" onclick="openCity(event, 'p2')">Informação fiscal</button>

    </div>
    <main>

        <div style="margin:0 auto; width:1400px; ">




            <table style="float: right; margin-right:100px;">
                <form action="" method="post">
                    <div id="titulo">
                        </p>Dadods do produto</p>
                    </div>

            </table>

            <div id="p1" class="tabcontent">
                <div style="width: 900px;">

                    <table style="float:left; ">

                        <tr>
                            <td style="width: 120px;" align="left">Código:</td>
                            <td align=left><input readonly type="text" size="10" id="cammpoProdutoID"
                                    name="cammpoProdutoID" value=""> </td>

                        </tr>
                    </table>
                    <!--finalizar hidden -->
                    <table style="float:left;">

                        <tr>
                            <td style="width: 120px;" align=left><b>Descrição:</b></td>
                            <td align=left><input type="text" size=60 name="campoNomeProduto"
                                    value="<?php if(isset($_POST['enviar'])){ echo utf8_encode($nome_produto);}?>">
                            </td>

                        </tr>
                        <tr>
                            <td style="width: 120px;" align=left><b>Fabricante:</b></td>
                            <td align=left><input type="text" size=20 name="campoFabricante"
                                    style="margin-bottom: 15px;"
                                    value="<?php if(isset($_POST['enviar'])){ echo utf8_encode($fabricante);}?>">
                            </td>

                        </tr>
                        <tr>
                            <td align=left><b>Categoria:</b></td>
                            <td>
                                <select style="width: 390px; margin-bottom: 5px;" id="campoCategoria"
                                    name="campoCategoria">
                                    <option value="0">Selecione</option>
                                    <?php 
                                    

                                    while($linha_categoria  = mysqli_fetch_assoc($lista_categoria)){
                                        $categoriaPrincipal = utf8_encode($linha_categoria["categoriaID"]);
                                    if(!isset($categoria)){
                                    
                                    ?>
                                    <option value="<?php echo ($linha_categoria["categoriaID"]);?>">
                                        <?php echo ($linha_categoria["nome_categoria"]);?>
                                    </option>
                                    <?php
   
                                    }else{

                                        if($categoria==$categoriaPrincipal){
                                        ?> <option value="<?php echo ($linha_categoria["categoriaID"]);?>"
                                        selected>
                                        <?php echo ($linha_categoria["nome_categoria"]);?>
                                    </option>

                                    <?php
                                            }else{
                                    
                                ?>
                                    <option value="<?php echo ($linha_categoria["categoriaID"]);?>">
                                        <?php echo ($linha_categoria["nome_categoria"]);?>
                                    </option>
                                    <?php

                                    }

                                    }

                                    
                                    }
                   
     ?>

                                </select>

                            </td>

                        </tr>
                    </table>
                    <table style="float: left;">

                        <tr>
                            <td style="width: 120px;"> <b>Preço Compra:</b></td>
                            <td style="width:100px;"><input type="text" size=10 id="campoPrecoCompra"
                                    name="campoPrecoCompra"
                                    value="<?php if(isset($_POST['enviar'])){ echo utf8_encode($preco_compra);}?>"></td>
                            <td><b>Preço Venda:</b></td>
                            <td style="width: 50px;"><input type="text" size=10 name="campoPrecoVenda"
                                    id="campoPrecoVenda" value="<?php if(isset($_POST['enviar']))
                    { echo utf8_encode($preco_venda);}?>"></td>


                            <td> <b>Ativo:</b></td>
                            <td> <select id="campoAtivo" name="campoAtivo">
                                    <?php 

                                
                                while($linha_ativo  = mysqli_fetch_assoc($lista_ativo)){
                                    $ativoPrincipal = utf8_encode($linha_ativo["ativoID"]);
                                if(!isset($ativo)){
                                
                                ?>
                                    <option value="<?php echo utf8_encode($linha_ativo["ativoID"]);?>">
                                        <?php echo utf8_encode($linha_ativo["nome_ativo"]);?>
                                    </option>
                                    <?php
   
                                        }else{

                                            if($ativo==$ativoPrincipal){
                                            ?> <option value="<?php echo utf8_encode($linha_ativo["ativoID"]);?>"
                                        selected>
                                        <?php echo utf8_encode($linha_ativo["nome_ativo"]);?>
                                    </option>

                                    <?php
                                            }else{
                                    
                                ?>
                                    <option value="<?php echo utf8_encode($linha_ativo["ativoID"]);?>">
                                        <?php echo utf8_encode($linha_ativo["nome_ativo"]);?>
                                    </option>
                                    <?php

                                        }

                                        }

                                        
                                        }

?>
                                </select>
                            </td>
                        </tr>

                    </table>


                    <table style="float: left;">
                        <tr>
                            <td style="width: 120px;" align=left><b>Estoque:</b></td>
                            <td align=left><input type="text" size=10 name="campoEstoque" id="campoEstoque"
                                    value="<?php if(isset($_POST['enviar'])){ echo utf8_encode($estoque);}?>"></td>

                            <td align=left> <b>Und Medida:</b></td>
                            <td align=left> <input style="margin-left: 5px;" type="text" size="10"
                                    id="campoUnidadedeMedida" name="campoUnidadedeMedida"
                                    value="<?php if(isset($_POST['enviar'])){ echo utf8_encode($unidade_medida);}?>">
                            </td>

                        </tr>


                        <table style="float: left;">
                            <tr>
                                <td style="width: 120px;" align="left"><b>Observação:<b></td>
                                <td align="left"><textarea rows=4 cols=60 name="campoObservacao" id="observacao"
                                        value=""><?php if(isset($_POST['enviar'])){ echo utf8_encode($observacao);}?></textarea>
                                </td>
                            </tr>

                        </table>
                    </table>

                    <table style="float: left;">
                        <tr>
                            <div id="botoes">
                                <input type="submit" name=enviar value="Incluir" class="btn btn-info btn-sm"
                                    onClick="return confirm('Confirma o cadastro do produto?');"></input></td>


                                <button type="button" name="btnfechar"
                                    onclick="window.opener.location.reload();fechar(); "
                                    class="btn btn-secondary">Voltar</button>

                            </div>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div id="p2" class="tabcontent">
            <table style="float:left;">
                <tr>
                    <td style="width: 120px;"><b>Ncm:</b></td>
                    <td align=left> <input type="text" size="10" id="campoNcm" name="campoNcm"
                            value="<?php if(isset($_POST['enviar'])){ echo utf8_encode($ncm);}?>">
                    </td>

                </tr>
            </table>
        </div>



        </form>



    </main>

    <script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    document.getElementById("defaultOpen").click();
    </script>
</body>


<script>
function fechar() {
    window.close();
}
</script>

</html>

<?php 
mysqli_close($conecta);
?>