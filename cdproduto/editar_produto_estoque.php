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


//consultar tb_produto_estoque
if(isset($_GET['codigo'])){
    $codigo = $_GET['codigo'];
}
$select = "SELECT * from tb_produto_estoque where cl_id = $codigo";
$resultado = mysqli_query($conecta, $select);
if(!$resultado){
    die("Falha no banco de dados tb_produto_estoque ");
}else{
    $linha = mysqli_fetch_assoc($resultado);
    $b_descricao = $linha['cl_descricao'];
    $b_fabricante = $linha['cl_fabricante'];
    $b_categoria = $linha['cl_categoria'];
    $b_und = $linha['cl_und'];
    $b_estoque = $linha['cl_estoque'];
    $b_preco_custo = $linha['cl_preco_custo'];
    $b_observacao = $linha['cl_observacao'];
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

    <main>
        <form id="alterar_produto_estoque">

            <div style="margin:0 auto; width:1400px; ">


                <table style="float: right; margin-right:100px;">

                    <div id="titulo">
                        </p>Dadods do produto</p>
                    </div>

                </table>


                <div style="width: 900px;">

                    <table style="float:left; ">

                        <tr>
                            <td style="width: 120px;" align="left">Código:</td>
                            <td align=left><input readonly type="text" size="10" id="cammpoProdutoID"
                                    name="cammpoProdutoID" value="<?php echo $codigo; ?>"> </td>

                        </tr>
                    </table>
                    <!--finalizar hidden -->
                    <table style="float:left;">

                        <tr>
                            <td style="width: 120px;" align=left><b>Descrição:</b></td>
                            <td align=left><input type="text" size=60 name="campoNomeEditarProdutoEstoque"
                                    value="<?php echo $b_descricao; ?>">
                            </td>

                        </tr>
                        <tr>
                            <td style="width: 120px;" align=left><b>Fabricante:</b></td>
                            <td align=left><input type="text" size=20 name="campoFabricante"
                                    style="margin-bottom: 15px;" value="<?php echo $b_fabricante;?>">
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
                                     $categoria_principal = utf8_encode($linha_categoria["categoriaID"]);    
                                    if($b_categoria == $categoria_principal){
                                    
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
                        <tr>
                            <td align=left><b>Estoque:</b></td>
                            <td align=left><input type="text" size=10 onkeypress="return onlynumber();"
                                    name="campoEstoque" value="<?php echo $b_estoque; ?>" id="campoEstoque"></td>

                        </tr>
                        <tr>
                            <td align=left> <b>Und Medida:</b></td>
                            <td align=left> <input type="text" size="10" id="campoUnidadedeMedida"
                                    name="campoUnidadedeMedida" value="<?php echo $b_und ?>">
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 120px;"> <b>Preço Custo:</b></td>
                            <td style="width:100px;"><input type="text" onkeypress="return onlynumber();" size=10
                                    id="campoPrecoCusto" value="<?php  echo $b_preco_custo; ?>" name="campoPrecoCusto">
                            </td>

                        </tr>


                    </table>




                    <table style="float: left;">
                        <tr>
                            <td style="width: 120px;" align="left"><b>Observação:<b></td>
                            <td align="left"><textarea rows=4 cols=60 name="campoObservacao"
                                    id="observacao"><?php echo $b_observacao; ?></textarea>
                            </td>
                        </tr>

                    </table>


                    <table style="float: left;">
                        <tr>
                            <div id="botoes">
                                <input type="submit" name=enviar value="Alterar" class="btn btn-info btn-sm"></input>
                                </td>


                                <button type="button" name="btnfechar"
                                    onclick="window.opener.location.reload();fechar(); "
                                    class="btn btn-secondary">Voltar</button>

                                <button type="button" id="excluir" value="Remover" class="btn btn-danger btn-sm"
                                    onClick="return confirm('Deseja excluir o produto?');">Excluir</button></td>

                            </div>
                        </tr>
                    </table>
                </div>
            </div>


        </form>
    </main>

    <?php include "../_incluir/funcaojavascript.jar" ?>
    <script src="../jquery/jquery.js"></script>

</body>


<script>
var codigo = document.getElementById("cammpoProdutoID")
$("#alterar_produto_estoque").submit(function(e) {
    e.preventDefault();
    var formulario = $(this);
    var retorno = editar_ajuste_estoque(formulario)
})
//EXCLUIR
$('#excluir').click(function() {

    $.ajax({
        type: "POST",
        data: "codigo=" + codigo.value,
        url: "crud.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $sucesso = $.parseJSON(data)["sucesso"];
        if ($sucesso) {
            alertify.success("Produto removido com sucesso");
        } else {
            alertify.alert("Erro||contatar suporte || banco de dados");
        }
    }

    function falha() {
        console.log("erro");
    }

})

//ALTERAR
function editar_ajuste_estoque(dados) {
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "crud.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        console.log("ok");
        $mensagem = $.parseJSON(data)["mensagem"];
        $sucesso = $.parseJSON(data)["sucesso"];


        if ($sucesso) {
            alertify.success("Alteração realizado com sucesso")

        } else {
            alertify.alert($mensagem)
        }
    }

    function falha() {
        console.log("erro");
    }


}




function fechar() {
    window.close();
}
</script>

</html>

<?php 
mysqli_close($conecta);
?>