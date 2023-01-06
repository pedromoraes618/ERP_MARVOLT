<?php

include("../conexao/sessao.php");
require_once("../conexao/conexao.php");
include("../alert/alert.php");

 echo "."; 
if($_POST){

//inlcuir as varias do input

$produtoID = utf8_decode($_POST["cammpoProdutoID"]);
$nome_produdo = utf8_decode($_POST["campoNomeProduto"]);
$preco_venda = utf8_decode($_POST["campoPrecoVenda"]);
$preco_compra = utf8_decode($_POST["campoPrecoCompra"]);
$estoque = utf8_decode($_POST["campoEstoque"]);
$unidade_medida = utf8_decode($_POST["campoUnidadedeMedida"]);
$categoria = utf8_decode($_POST["campoCategoria"]);
$ativo = utf8_decode($_POST["campoAtivo"]);
$observacao = utf8_decode($_POST["campoObservacao"]);
$fabricante =  utf8_decode($_POST["campoFabricante"]);
$ncm =  utf8_decode($_POST["campoNcm"]);

if(isset($_POST['btnsalvar'])){

if($categoria=="0"){
     
    ?>
<script>
alertify.alert("Favor informar a categoria do produto");
</script>

<?php 
  }elseif($nome_produdo==""){
    ?>
<script>
alertify.alert("Favor informe a descrição do produto");
</script>

<?php 
  }else{
     
//query para alterar o cliente no banco de dados
$alterar = "UPDATE produtos set nomeproduto = '{$nome_produdo}', precovenda = '{$preco_venda}', precocompra = '{$preco_compra}',  estoque = '{$estoque}', ncm = '{$ncm}', ";
$alterar .= " unidade_medida = '{$unidade_medida}', categoriaID = '{$categoria}', ativoID = '{$ativo}', observacao = '{$observacao}', nome_categoria = '{$categoria}', nome_ativo = '{$ativo}',fabricante = '{$fabricante}' WHERE produtoID = {$produtoID} ";

 $operacao_alterar = mysqli_query($conecta, $alterar);
 if(!$operacao_alterar) {
     die("Erro banco de dados || upate no banco de dados || tabela produtos");   
 } else { ?>
<script>
alertify.success("Dados alterados");
</script>

<?php
     //header("location:listagem.php"); 
    }
      
 }

}
}

?>

<?php
if(isset($_POST['btnremover'])){

//query para remover o produto no banco de dados
$remover = "DELETE FROM produtos WHERE produtoID = {$produtoID}";

 $operacao_remover = mysqli_query($conecta, $remover);

 if(!$operacao_remover) {
     die("Erro linha 44");   
 } else {    ?>
<script>
alertify.error("Produto removido com sucesso");
</script>

<?php
     //header("location:listagem.php"); 
      
 }

}

?>

<?php


//variaveis
$campo_obrigatorio_RazacaoS ="Razao Social deve ser informada";
$msgcadastrado = "Cliente cadastrado com sucesso";


$select = "SELECT estadoID, nome from estados";
$lista_estados = mysqli_query($conecta,$select);
if(!$lista_estados){
die("Falaha no banco de dados  Linha 49 cadastro_cliente");
}


$consulta = "SELECT * FROM produtos ";
if (isset($_GET["codigo"])){
$produtoID=$_GET["codigo"];
$consulta .= " WHERE produtoID = {$produtoID} ";
}else{
$consulta .= " WHERE produtoID = 1 ";

}
//consulta ao banco de dados
$detalhe = mysqli_query($conecta, $consulta);
if(!$detalhe){
die("Falha na consulta ao banco de dados");
}else{

$dados_detalhe = mysqli_fetch_assoc($detalhe);
$BprodutoID=  utf8_encode($dados_detalhe['produtoID']);
$Bnome_produdo =  utf8_encode($dados_detalhe["nomeproduto"]);
$Bpreco_venda = utf8_encode($dados_detalhe["precovenda"]);
$Bpreco_compra = utf8_encode($dados_detalhe["precocompra"]);
$Bestoque = utf8_encode($dados_detalhe["estoque"]);
$Bunidade_medida = $dados_detalhe["unidade_medida"];
$Bcategoria = utf8_encode($dados_detalhe["nome_categoria"]);
$Bativo = utf8_encode($dados_detalhe["nome_ativo"]);
$Bobservacao = utf8_encode($dados_detalhe["observacao"]);
$Bfabricante = utf8_encode($dados_detalhe["fabricante"]);
$Bncm = utf8_encode($dados_detalhe["ncm"]);

}

//consulta categoria
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


?>


<!doctype html>

<html>



<head>
    <meta charset="UTF-8">
    <!-- estilo -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="../_css/tela_cadastro_editar.css" rel="stylesheet">

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
                        </p>Dados do Produto</p>
                    </div>
            </table>
            <div id="p1" class="tabcontent">

                <div style="width: 900px;">

                    <table style="float:left; ">
                        <tr>
                            <td style="width: 120px;">Código:</td>
                            <td align=left><input readonly type="text" size="10" id="cammpoProdutoID"
                                    name="cammpoProdutoID" value="<?php echo $BprodutoID;?>"> </td>
                        </tr>

                        <tr>
                            <td style="width: 120px;"><b>Descrição:</b></td>
                            <td align=left><input type="text" size=60 name="campoNomeProduto"
                                    value="<?php echo $Bnome_produdo ?>">
                            </td>

                        </tr>
                        <tr>
                            <td style="width: 120px;" align=left><b>Fabricante:</b></td>
                            <td align=left><input type="text" size=20 name="campoFabricante"
                                    value="<?php echo $Bfabricante;?>">
                            </td>

                        </tr>
                        <tr>
                            <td align=left><b>Categoria:</b></td>
                            <td>
                                <select style="width: 390px;" id="campoCategoria" name="campoCategoria">
                                    <option value="0">Selecione</option>
                                    <?php 
                        $meucategoria =  $Bcategoria ;
                        while($linha_categoria = mysqli_fetch_assoc($lista_categoria)){
                        $categoria_principal  =  utf8_encode($linha_categoria["categoriaID"]);
                        if($meucategoria==$categoria_principal){
                            
                        ?>
                                    <option value="<?php echo utf8_encode($linha_categoria["categoriaID"]);?>" selected>
                                        <?php echo utf8_encode($linha_categoria["nome_categoria"]);?>
                                    </option>



                                    <?php
     }else{
     ?>
                                    <option value="<?php echo utf8_encode($linha_categoria["categoriaID"]);?>">
                                        <?php echo utf8_encode($linha_categoria["nome_categoria"]);?>
                                    </option>
                                    <?php
     }}
     ?>

                                </select>

                            </td>
                        </tr>
                    </table>
                    <table style="float: left;">

                        <tr>
                            <td style="width: 120px;"><b>Preço Compra:</b></td>
                            <td><input type="text" size=10 id="campoPrecoCompra" name="campoPrecoCompra"
                                    value="<?php echo $Bpreco_compra ?>">

                            <td align=left> <b>Preço Venda:</b></td>
                            <td align=left> <input type="text" size=10 name="campoPrecoVenda" id="campoPrecoVenda"
                                    value="<?php echo $Bpreco_venda ?>"></td>

                            <td align=left> <b>Ativo:</b></td>


                            <td align=left> <select id="campoAtivo" name="campoAtivo">
                                    <?php 
                        $meuativo = $Bativo;
                        while($linha_ativo = mysqli_fetch_assoc($lista_ativo)){
                        $ativo_principal  = utf8_encode($linha_ativo["ativoID"]);
                        if($meuativo==$ativo_principal){

?>
                                    <option value="<?php echo utf8_encode($linha_ativo["ativoID"]);?>" selected>
                                        <?php echo utf8_encode($linha_ativo["nome_ativo"]);?>
                                    </option>

                                    <?php
                                }else{
 ?>
                                    <option value="<?php echo utf8_encode($linha_ativo["ativoID"]);?>">
                                        <?php echo utf8_encode($linha_ativo["nome_ativo"]);?>
                                    </option>
                                    <?php

 }}
 
 ?>

                                </select>
                            </td>

                        </tr>
                    </table>
                    <table style="float: left;">
                        <tr>
                            <td style="width: 120px;"><b>Estoque:</b></td>
                            <td align=left><input type="text" size=10 name="campoEstoque" id="campoEstoque"
                                    value="<?php echo $Bestoque ?>">


                            <td align=left> <b>Und Medida:</b></td>
                            <td align=left> <input type="text" style="margin-left: 5px; " size=10
                                    id="campoUnidadedeMedida" name="campoUnidadedeMedida"
                                    value="<?php echo $Bunidade_medida ?>">

                            </td>


                        </tr>


                        </tr>

                    </table>
                    <table style="float: left;">

                        <tr>
                            <td style="width: 120px;"><b>Observação:<b></td>
                            <td><textarea rows=4 cols=60 name="campoObservacao"
                                    id="observacao"><?php echo $Bobservacao?></textarea>
                            </td>
                        </tr>

                    </table>
                    <table width=100%>
                        <tr>
                            <div id="botoes">

                                <input type="submit" name="btnsalvar" value="Alterar"
                                    class="btn btn-info btn-sm"></input>



                                <button type="button" onclick="return fechar();"
                                    class="btn btn-secondary">Voltar</button>



                                <input id="remover" type="submit" name="btnremover" value="Remover"
                                    class="btn btn-danger"
                                    onClick="return confirm('Deseja remover esse produto? Verifique se o produto tem movimentação');"></input>



                            </div>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
        </div>
        <div id="p2" class="tabcontent">
            <table style="float:left ;">
                <tr>
                    <td style="width: 120px;"><b>Ncm:</b></td>
                    <td align=left> <input type="text" size="10" id="campoNcm" name="campoNcm"
                            value="<?php echo $Bncm?>">
                    </td>

            </table>

        </div>

        </form>

        </table>




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


</html>


<script>
function fechar() {
    window.opener.location.reload();
    window.close();
}
</script>
</script>

<?php 
mysqli_close($conecta);
?>