<?php 
include("../conexao/sessao.php");
require_once("../conexao/conexao.php");
include ("../_incluir/funcoes.php");

//consultar lancamento
$select = "SELECT receita_despesaID, nome from receita_despesa";
$lista_receita_despesa = mysqli_query($conecta,$select);
if(!$lista_receita_despesa){
    die("Falaha no banco de dados || falha de conexão");
}

$hoje = date('Y--m-d');

if($_GET){

    $pesquisaData = $_GET["CampoPesquisaData"];
    $pesquisaDataf = $_GET["CampoPesquisaDataf"];
    
    if($pesquisaData==""){
          
    }else{
        $div1 = explode("/",$_GET['CampoPesquisaData']);
        $pesquisaData = $div1[2]."-".$div1[1]."-".$div1[0];  
       
    }
    if($pesquisaDataf==""){
       
    }else{
    $div2 = explode("/",$_GET['CampoPesquisaDataf']);
    $pesquisaDataf = $div2[2]."-".$div2[1]."-".$div2[0];
    }
    
    $select = "SELECT  clientes.nome_fantasia, 
    lancamento_financeiro.data_do_pagamento, forma_pagamento.nome,lancamento_financeiro.grupoID,lancamento_financeiro.descricao,grupo_lancamento.nome  as grupo, 
    lancamento_financeiro.lancamentoFinanceiroID, tb_subgrupo_receita_despesa.subgrupo, tb_subgrupo_receita_despesa.subgrupo, lancamento_financeiro.data_movimento,  
    lancamento_financeiro.documento,lancamento_financeiro.lancamentoFinanceiroID,  lancamento_financeiro.data_a_pagar, 
    lancamento_financeiro.status,sum(valor) as somaI,lancamento_financeiro.documento,  
    lancamento_financeiro.receita_despesa from  clientes  inner join 
    lancamento_financeiro on lancamento_financeiro.clienteID = clientes.clienteID 
    inner join tb_subgrupo_receita_despesa on lancamento_financeiro.grupoID = 
    tb_subgrupo_receita_despesa.subGrupoID inner join forma_pagamento on 
    lancamento_financeiro.forma_pagamentoID = forma_pagamento.formapagamentoID inner join 
    grupo_lancamento on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID " ;
    //FATURAMENTO POR CLIENTE
    if(isset($_GET["pCliente"])){
        $select  .= " WHERE data_do_pagamento BETWEEN '$pesquisaData' and '$pesquisaDataf' and lancamento_financeiro.status = 'Recebido' 
        and clienteftID = '1' group by nome_fantasia order by valor desc";
    }

    //FATURAMENTO POR GRUPO
    if(isset($_GET["pGrupo"])){
        $select  .= " WHERE data_do_pagamento BETWEEN '$pesquisaData' and '$pesquisaDataf'  and lancamento_financeiro.status = 'Recebido'  and clienteftID = '1'  group by grupoID ";
    }
    
    $lista_pesquisa = mysqli_query($conecta,$select);
    if(!$lista_pesquisa){
        die("Falha no banco de dados || lancamento_financeiro");
    }

    $selectValorSoma  = "SELECT  clientes.nome_fantasia, forma_pagamento.nome,lancamento_financeiro.descricao, 
    grupo_lancamento.nome as grupo, lancamento_financeiro.lancamentoFinanceiroID, tb_subgrupo_receita_despesa.subgrupo, 
    lancamento_financeiro.data_movimento,  sum(valor) as soma, lancamento_financeiro.documento,lancamento_financeiro.lancamentoFinanceiroID, 
     lancamento_financeiro.data_a_pagar, lancamento_financeiro.status,lancamento_financeiro.valor,lancamento_financeiro.documento,  
     lancamento_financeiro.receita_despesa from  clientes  inner join lancamento_financeiro on lancamento_financeiro.clienteID = 
     clientes.clienteID inner join tb_subgrupo_receita_despesa on lancamento_financeiro.grupoID = tb_subgrupo_receita_despesa.subGrupoID 
     inner join forma_pagamento on lancamento_financeiro.forma_pagamentoID = forma_pagamento.formapagamentoID inner join grupo_lancamento 
     on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID " ;
    $selectValorSoma  .= " WHERE data_do_pagamento BETWEEN '$pesquisaData' and '$pesquisaDataf'  and lancamento_financeiro.status = 'Recebido'  and clienteftID = '1'  " ;
    $lista_Soma_Valor = mysqli_query($conecta,$selectValorSoma);
    if(!$lista_Soma_Valor){
        die("Falha no banco de dados || lancamento_financeiro (soma total)");
    }
    if(isset($_GET['pNfeSaida'])){
    $select = "SELECT * from tb_nfe_saida where status_processamento = '1'  and data_saida between '$pesquisaData' and '$pesquisaDataf' order by numero_nf";
    $lista_nfe_saida = mysqli_query($conecta,$select);

    $select = "SELECT sum(valor_total_nota) as soma from tb_nfe_saida where status_processamento = '1'  and data_saida between '$pesquisaData' and '$pesquisaDataf'";
    $lista_soma_nfe_saida = mysqli_query($conecta,$select);
    while($linha = mysqli_fetch_assoc($lista_soma_nfe_saida)){
        $soma_nfe_saida = $linha['soma'];
    }
    }


}

//recuperar valores via get
if (isset($_GET["CampoPesquisaData"])){
    $pesquisaData=$_GET["CampoPesquisaData"];
  }
  if (isset($_GET["CampoPesquisaDataf"])){
    $pesquisaDataf=$_GET["CampoPesquisaDataf"];
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
    <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>
    <a href="https://icons8.com/icon/59832/cardápio"></a>
</head>

<body>
    <?php include_once("../_incluir/topo.php"); ?>
    <?php include("../_incluir/body.php"); ?>
    <?php include_once("../_incluir/funcoes.php"); ?>



    <main>



        <div id="janela_pesquisa">
            <ul>
                <li>
                    <b style="margin-left:35px ;"> Data</b>
                </li>
            </ul>

            <form style="width:100%; " action="" method="get">
                <div id="BotaoLancar">
                    <input type="submit" style="width: 130px;" name="pCliente" id="lancar" value="Cliente">
                    <input type="submit" style="width: 130px;" name="pGrupo" id="lancar" value="Grupo">
                    <input type="submit" style="width: 130px;" name="pNfeSaida" id="lancar" value="Nfe Saida">
                </div>

                <tr>
                    <input style="width: 100px; " type="text" id="CampoPesquisaData" name="CampoPesquisaData"
                        placeholder="Data incial" onkeyup="mascaraData(this);" value="<?php if(!$_GET){ echo formatardataB(date('Y-m-01')); 
                        }elseif(isset($_GET["CampoPesquisaData"])){
                                 echo $pesquisaData;
                     }?>">

                    <input style=" width: 100px;" type="text" name="CampoPesquisaDataf" placeholder="Data final"
                        onkeyup="mascaraData(this);" value="<?php if(!$_GET){ echo date('d/m/Y');
                    }elseif(isset($_GET["CampoPesquisaDataf"])){ echo $pesquisaDataf;} ?>">
                </tr>


            </form>

        </div>

        <form action="consulta_financeiro.php" method="get">

            <?php 
             if((isset($_GET["pCliente"]))){
            include ("include_tabela/cliente.php");
             }

             if((isset($_GET["pGrupo"]))){
                include ("include_tabela/grupo.php");
            }
            if(isset($_GET['pNfeSaida'])){
                include ("include_tabela/nfe_saida.php");
            }
            ?>
        </form>

    </main>


</body>


<?php include '../_incluir/funcaojavascript.jar'; ?>

<script>
//abrir uma nova tela de cadastro

function abrepopupEditarEditarFinanceiro() {

    var janela = "editar_receita_despesa.php?codigo=<?php echo  $lancamentoID?>";
    window.open(janela, 'popuppage',
        'width=1500,toolbar=0,resizable=1,scrollbars=yes,height=800,top=100,left=100');
}
</script>

</html>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>