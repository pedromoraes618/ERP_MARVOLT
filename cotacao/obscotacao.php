<?php
include("../conexao/sessao.php");
require_once("../conexao/conexao.php"); 
//inportar o alertar js
include('../alert/alert.php');
echo ",";

$hoje = date('Y-d-m');
if (isset($_GET["cotacaoCod"])){
    $cdcotacao=$_GET["cotacaoCod"];
}

   
if(isset($_POST['btnsalvar'])){

    //inlcuir as varias do input
    $observacao = ($_POST["obseracao"]);

   
   //query para alterar o produto da cotacao no banco de dados
   $update = "UPDATE cotacao set observacao = '$observacao' WHERE cod_cotacao = {$cdcotacao}  ";
     $update_cotacao_obs = mysqli_query($conecta, $update);
     if(!$update_cotacao_obs) {
         die("Erro na alteracao - banco de dados");   
     } else {  
        ?>
<script>
alertify.success("Dados alterados");
</script>
<?php
         //header("location:listagem.php"); 
          
     }
   
   }


//consultar a cotacao
$select = "SELECT * FROM cotacao WHERE cod_cotacao = '$cdcotacao' ";
$consultar_cotacao = mysqli_query($conecta, $select);
if(!$consultar_cotacao){
   die("Falha na consulta ao banco de dados");
}else{
   $linha = mysqli_fetch_assoc($consultar_cotacao);
   $observacao_b = ($linha['observacao']);

   
  
}




?>
<!doctype html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- estilo -->
    <link href="../_css/tela_cadastro_editar.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>
</head>

<body>


    <?php include_once("../_incluir/funcoes.php"); ?>


    <main>



        <form action="" method="post">
            <div style="margin:0 auto; width:1400px;">

                <table style="float: right;margin-bottom:20px">
                    <div id="titulo">
                        </p>Observação</p>
                    </div>
                    <div style="text-align:center;display:block" class="">
                        <div class="">
                            <textarea name="obseracao" id="observacao" rows="10"
                                cols="50"><?php echo $observacao_b; ?></textarea>
                        </div>
                        <div class="btn">
                            <input type="submit" id="salvar" name="btnsalvar" class="btn btn-success" value="salvar">
                            <button type="button" name="btnfechar" onclick="fechar();"
                                class="btn btn-secondary">Voltar</button>
                        </div>
                    </div>

            </div>

        </form>

    </main>
</body>

<?php include '../_incluir/funcaojavascript.jar'; ?>

<script>
function fechar() {
    window.close();
}
</script>
<script>
//abrir uma nova tela de cadastro
function abrepopupCadastroProduto() {

    var janela = "cadastro_produto.php";
    window.open(janela, 'popuppage',
        'width=1500,toolbar=0,resizable=1,scrollbars=yes,height=800,top=100,left=100');
}

function abrepopupEditarProduto() {

    var janela = "editar_produto.php?codigo=<?php echo $idProduto ?>";
    window.open(janela, 'popuppageEditarProduto',
        'width=1500,toolbar=0,resizable=1,scrollbars=yes,height=800,top=100,left=100');
}
</script>

<script>
function calculavalormargem() {
    var campoQuantidade = document.getElementById("campoQtdProduto").value;
    var campoPrecoCotado = document.getElementById("campoPrecoCotado").value;
    var campoPrecoVenda = document.getElementById("campoPrecoVenda").value;
    var campoMargem = document.getElementById("campoMargem");
    var calculoMargem;
    var calculoFinal;

    campoPrecoVenda = parseFloat(campoPrecoVenda);
    campoPrecoCotado = parseFloat(campoPrecoCotado);

    calculoMargem = (campoPrecoCotado / campoPrecoVenda).toFixed(2);
    calculoFinal = (1 - calculoMargem).toFixed(2);

    campoMargem.value = calculoFinal;


}
</script>

<script>
function calculavalorPrecoVenda() {
    var campoPrecoCotado = document.getElementById("campoPrecoCotado").value;
    var campoMargem = document.getElementById("campoMargem").value;
    var campoPrecoVenda = document.getElementById("campoPrecoVenda");
    var calculoPrecoVenda;

    campoMargem = parseFloat(campoMargem);
    campoPrecoCotado = parseFloat(campoPrecoCotado);

    calculoPrecoVenda = (campoPrecoCotado / (1 - (campoMargem))).toFixed(2);
    campoPrecoVenda.value = calculoPrecoVenda;

}
</script>


</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>