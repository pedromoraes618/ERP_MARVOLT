<?php

include("../conexao/sessao.php");
require_once("../conexao/conexao.php");
//inportar o alertar js
include('../alert/alert.php');

        
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

        <div style="margin:0 auto; width:1100px; ">
            <form id="ajustar_estoque" autocomplete="off">
                <table style="float: right; margin-right:100px;">
                    <div id="titulo">
                        </p>Ajuste de estoque</p>
                    </div>
                </table>


                <div style="width: 600px;">
                    <!--finalizar hidden -->
                    <table style="float:left;">

                        <tr>
                            <td style="width: 95px;" align=left><b>Código:</b></td>
                            <td align=left><input type="text" readonly size=10 name="campo_codigo"
                                    value="<?php echo $BprodutoID; ?>" id="campo_codigo">
                            </td>
                        </tr>
                    </table>
                    <table style="float:left;">

                        <tr>
                            <td style="width: 90px;" align=left><b>Descrição:</b></td>
                            <td align=left><input type="text" readonly size=80 value="<?php echo $Bnome_produdo; ?>"
                                    name="campoDescricao" id="campoDescricao" value="">
                            </td>
                        </tr>

                        <tr>
                            <td style="width: 90px;" align=left><b>Und:</b></td>
                            <td align=left><input type="text" readonly size=10 value="<?php echo $Bunidade_medida; ?>"
                                    name="campoUnidade" id="campoUnidade" value="">
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 120px;" align=left><b>Qtd Disponivel:</b></td>
                            <td align=left><input type="text" readonly size=10 value="<?php echo $Bestoque ?>"
                                    name="campoQtdDisponivel" id="campoQtdDisponivel" value="">
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 90px;padding-top:10px;" align=left><b>Tipo:</b></td>
                            <td align=left style="padding-top:10px">
                                <select name="tipo">
                                    <option name="tipo" value="0">Selecione ...</option>
                                    <option name="tipo" value="1">Entrada</option>
                                    <option name="tipo" value="2">Saida</option>
                                </select>
                            </td>
                        </tr>

                        <tr>

                            <td style="width: 90px;padding-top:10px;" align=left><b>Quantidade:</b></td>
                            <td style="width: 90px;padding-top:10px;"><input type="text" size=10 name="campoQuantidade"
                                    id="campoQuantidade" value="">
                            </td>
                        </tr>
                    </table>


                    <table style="float: left;">
                        <tr>
                            <div style="margin-left:90px;" id="botoes">
                                <input type="submit" value="Alterar" class="btn btn-info btn-sm"></input>


                                <button type="button" name="btnfechar"
                                    onclick="window.opener.location.reload();fechar();"
                                    class="btn btn-secondary">Voltar</button>



                            </div>
                    </table>



                </div>
            </form>
        </div>




    </main>
</body>
<script src="../jquery/jquery.js"></script>


<script>
var qtd_disponivel = document.getElementById("campoQtdDisponivel");
var quantidade = document.getElementById("campoQuantidade");

$("#ajustar_estoque").submit(function(e) {
    e.preventDefault();

    var formulario = $(this);
    var retorno = ajuste_estoque(formulario)


})



function ajuste_estoque(dados) {
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
        $nova_quantidade = $.parseJSON(data)["qtd"];



        if ($sucesso) {
            alertify.success("Ajuste realizado com sucesso")
            qtd_disponivel.value = $nova_quantidade
            quantidade.value = "";
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