<?php

include("../../conexao/sessao.php");
require_once("../../conexao/conexao.php");
include('../../alert/alert.php');

        
//update
if(isset($_GET['id'])){
$idProduto = $_GET['id'];
//consulta produto pedido_compra
$select = "SELECT * from tb_pedido_item where pedido_itemID = '$idProduto'";
$lista_categoria = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($lista_categoria);
$b_categoria = $linha['categoria_produto'];
$b_produto = $linha['produto'];

}

//consulta categoria
$select = "SELECT categoriaID, nome_categoria from categoria_produto";
$lista_categoria = mysqli_query($conecta,$select);





?>
<!doctype html>

<html>



<head>
    <meta charset="UTF-8">
    <!-- estilo -->

    <link href="../../_css/tela_cadastro_editar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <main>

        <div style="padding: 50px;">
            <form id="alterar_categoria" autocomplete="off">

                <div style="text-align: center;" id="titulo">
                    </p>Categoria Produto</p>
                </div>

                <table>

                    <tr>
                        <input type="hidden" size=50 name="campoId" id="campoId" value="<?php echo $idProduto; ?>">


                        <td style="width: 90px;" align=left><b>Descrição:</b></td>

                        <td align=left><input type="text" size=50 name="campoDescricao" id="campoDescricao"
                                value="<?php echo utf8_encode($b_produto);  ?>">
                        </td>

                    </tr>
                    </tr>
                    <td style="width: 90px;" align=left><b>Categoria:</b></td>
                    <td>
                        <select style="width: 390px;" id="campoCategoria" name="campoCategoria">
                            <option value="0">Selecione</option>
                            <?php 
        
                                while($linha_categoria = mysqli_fetch_assoc($lista_categoria)){
                                $categoria_principal  =  utf8_encode($linha_categoria["categoriaID"]);
                                if($b_categoria==$categoria_principal){

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
                    <tr>
                </table>
                <table>
                    <tr>
                        <div style="margin-left:95px;" id="botoes">
                            <input type="submit" name=enviar value="Alterar" class="btn btn-info btn-sm"></input>


                            <button type="button" name="btnfechar" onclick="window.opener.location.reload();fechar();"
                                class="btn btn-secondary">Voltar</button>


                        </div>
                </table>



            </form>
        </div>




    </main>
</body>
<script src="../../jquery/jquery.js"></script>


<script>
$('#alterar_categoria').submit(function(e) {

    var descricao = document.getElementById('campoDescricao');
    var categoria = document.getElementById('campoCategoria')
    var id = document.getElementById('campoId')
    
    e.preventDefault();
    var formulario = $(this);
    var retorno = alterar_categoria(formulario);

});

function alterar_categoria(dados) {
    $.ajax({
        type: "POST",
        data: dados.serialize(),
        url: "crud.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $mensagem = $.parseJSON(data)["mensagem"];
        $sucesso = $.parseJSON(data)["sucesso"];

        if ($sucesso) {
            alertify.success("Categoria alterada com sucesso")
        
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