<?php
include("../conexao/sessao.php");
require_once("../conexao/conexao.php");
include ("../_incluir/funcoes.php");
//inportar o alertar js
include('../alert/alert.php');

//usuario logado
$user= $_SESSION["user_portal"];


//importar tabelas
include('select_financeiro_despesaSQL.php');

$select = "SELECT MAX(lancamentoFinanceiroID) as ultimoID FROM lancamento_financeiro;";
$lista_Max_ID = mysqli_query($conecta,$select);
if(!$lista_Max_ID){
    die("Falaha no banco de dados || select statuscompra");
}else{
    $idMax = mysqli_fetch_assoc($lista_Max_ID);
    $ultimoID = $idMax['ultimoID'];

}



echo ",";
//iniciar a tela com o campo preenchido

//variaveis 
if(isset($_POST["enviar"])){
    $hoje = date('Y-m-d'); 
   $lancamentoID = utf8_decode($_POST["cammpoLancamentoID"]);
   $dataLancamento = utf8_decode($_POST["campoDataLancamento"]);
   $dataapagar = utf8_decode($_POST["campoDataPagar"]);
   $dataPagamento = utf8_decode($_POST["campoDataPagamento"]);
   $cliente = utf8_decode($_POST["campoCliente"]);
   $formaPagamento = utf8_decode($_POST["campoFormaPagamento"]);
   $statusLancamento = utf8_decode($_POST["campoStatusLancamento"]);
   $descricao = utf8_decode($_POST["campoDescricao"]);
   $documento = utf8_decode($_POST["campoDocumento"]);
   $grupoLancamento = utf8_decode($_POST["CampoGrupoLancamento"]);
   $valor = utf8_decode($_POST["campoValor"]); 
   $observacao = utf8_decode($_POST["observacao"]);
   $nPedido = utf8_decode($_POST["numeroPedido"]);
   $nNotaFiscal = utf8_decode($_POST["numeroNotaFiscal"]);
   $conta_financeira = $_POST['campoContaFinanceira'];
  

//formatar a data para o banco de dados(Y-m-d)
  if(isset($_POST['enviar']))
{

if($dataLancamento==""){
    
      ?>
<script>
alertify.alert("Favor informe a data de lançamento");
</script>

<?php
  }elseif($cliente=="0"){
      ?>

<script>
alertify.alert("Favor informe o cliente");
</script>

<?php

  }elseif($statusLancamento=="0"){
      
      ?>

<script>
alertify.alert("Favor informe o status do lançamento");
</script>
<?php

}elseif($grupoLancamento=="0"){
      
    ?>

<script>
alertify.alert("Favor informe o subGrupo");
</script>
<?php

}elseif($formaPagamento=="0"){
      
    ?>

<script>
alertify.alert("Favor informe a forma de pagamento");
</script>
<?php

}elseif($conta_financeira=="0"){
      
    ?>

<script>
alertify.alert("Favor informe a conta financeira");
</script>
<?php

}else{

      

//condição obrigatorio 
    if(!$dataLancamento == ""){

        if($dataLancamento==""){
          
        }else{
            $div1 = explode("/",$_POST['campoDataLancamento']);
            $dataLancamento = $div1[2]."-".$div1[1]."-".$div1[0];  
           
        }
        if($dataapagar==""){
           
        }else{
            $div2 = explode("/",$_POST['campoDataPagar']);
        $dataapagar = $div2[2]."-".$div2[1]."-".$div2[0];
        }


        if($dataPagamento==""){
            $ano_caixa = "2000";
            $mes_caixa = "01";
        }else{
            
        $div3 = explode("/",$_POST['campoDataPagamento']);
        $dataPagamento = $div3[2]."-".$div3[1]."-".$div3[0];
        //verifificar se o caixa está aberto
        
        $ano_caixa = $div3[2];
        $mes_caixa = $div3[1];
        }
        

        if($dataapagar==""){
          $dataapagar=$dataLancamento;
       }

      if(($statusLancamento =="Pago") and (verifica_caixa_descricao($conecta,$mes_caixa,$ano_caixa) == "fechado")){
        //reformatar data
        $dataLancamento = formatDateB($dataLancamento);
        $dataapagar = formatDateB($dataapagar);
        $dataPagamento = formatDateB($dataPagamento);
             
  ?>
<script>
alertify.alert("Não é possivel adicionar esse lançamento, o caixa desse periodo já foi fechado, favor verifique");
</script>
<?php
      
      }else{

//inserindo as informações no banco de dados
  $inserir = "INSERT INTO lancamento_financeiro ";
  $inserir .= "( data_movimento,data_a_pagar,data_do_pagamento,receita_despesa,status,forma_pagamentoID,clienteID,descricao,documento,grupoID,valor,observacao,numeroPedido,numeroNotaFiscal,cl_conta_financeira_id )";
  $inserir .= " VALUES ";
  $inserir .= "( '$dataLancamento','$dataapagar','$dataPagamento','Despesa','$statusLancamento','$formaPagamento','$cliente','$descricao','$documento','$grupoLancamento','$valor','$observacao','$nPedido','$nNotaFiscal','$conta_financeira' )";

  
  //verificando se está havendo conexão com o banco de dados
  $operacao_inserir = mysqli_query($conecta, $inserir);
  if(!$operacao_inserir){
    print_r($_POST);
      die("Erro no banco de dados inserir_no_banco_de_dados");
   
  }else{
         $hoje = date('Y-m-d'); 
        //adicionar ao log
        $mensagem = "Usuario lançou o lancamento financeiro tipo: Despesa doc Nº $documento, valor R$ $valor ";
        $inserir = "INSERT INTO tb_log";
        $inserir .= "(cl_data_modificacao,cl_usuario,cl_descricao)";
        $inserir .= " VALUES ";
        $inserir .= "('$hoje','$user','$mensagem' )";
        $operacao_insert_log = mysqli_query($conecta, $inserir);
           

    $dataLancamento = "";
  $dataapagar ="";
  $dataPagamento = "";
  $formaPagamento = "";
  $cliente = 1;
  $formaPagamento = 1;
  $statusLancamento=1;
  $grupoLancamento=1;
  $descricao = "";
  $documento ="";
  $valor = "";
  $observacao = "";
  $nPedido = "";
  $nNotaFiscal = "";
  $conta_financeira = 0;

         //vai retornar o ultimo id
     
  ?>
<script>
alertify.success("Lançamento <?php echo ($ultimoID + 1)?> Realizado com sucesso");
</script>
<?php
    
  }

      }
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
    <?php 
    include("../classes/select2/select2_link.php")
    ?>
    <link rel="shortcut icon" type="imagex/png" href="img/marvolt.ico">
    <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <form action="" autocomplete="off" method="post">
        <div id="titulo">
            </p>Lançamento de Despesa</p>
        </div>

        <main>
            <div style="margin:0 auto; width:1400px; ">
                <form action="" method="post">
                    <table style="float:left; width:1400px; margin-bottom: 10px; border:1px solid;">



                        <table style="float:left; width:1400px; margin-bottom: 10px;border-bottom:1px solid #ddd; ; ">


                            <tr>
                                <td>
                                    <label for="cammpoLancamentoID" style="width: 100px;"> <b>Código:</b></label>
                                    <input readonly type="text" size="10" id="cammpoLancamentoID"
                                        name="cammpoLancamentoID" value="">
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <label for="txtNumeroOrcamento" style="width: 100px;"> <b>Data Lnct</b></label>
                                    <input type="text" size=10 name="campoDataLancamento" id="campoDataLancamento"
                                        OnKeyUp="mascaraData(this);" maxlength="10" autocomplete="off" value="<?php
                    
                            
                            if(isset($_POST['enviar'])){ 
                             
                                if($dataLancamento){
                              
                                    echo  $dataLancamento;
                                }else{
                                        echo "";
                                    
                                }}
                                  
                           ?>">
                                    <label for="txtUnidade" style="width:140px;"> <b>Data Vencimento:</b></label>
                                    <input type="text" size=10 id="campoDataPagar" name="campoDataPagar"
                                        OnKeyUp="mascaraData(this);" maxlength="10" autocomplete="off" value="<?php if(isset($_POST['enviar'])){ 
                                
                                if($dataapagar){
                              
                                    echo ($dataapagar);
                                }else{
                                        echo "";
                                    
                                }}
                            ?>">

                                    <label for="txtNumeroOrcamento" style="width: 140px;"> <b>Data
                                            Pagamento:</b></label>
                                    <input type="text" size=10 id="campoDataPagamento" name="campoDataPagamento"
                                        OnKeyUp="mascaraData(this);" maxlength="10" value="<?php if(isset($_POST['enviar'])){ 
                                
                                if($dataPagamento){
                              
                                    echo ($dataPagamento);
                                }else{
                                        echo "";
                                    
                                }}

                               ?>">


                                </td>

                            </tr>
                        </table>
                        <table style="float:left; width:650px; margin-bottom:30px; ">
                            <tr>
                                <td>
                                    <label for="campoCliente" style="width: 100px;"> <b>Empresa:</b></label>
                                    <select id="campoCliente" name="campoCliente">
                                        <option value="0">Selecione</option>
                                        <?php 

                            while($linha_clientes = mysqli_fetch_assoc($lista_clientes)){
                            $formaClientePrincipal = utf8_encode($linha_clientes["clienteID"]);
                            if(!isset($cliente)){
                            
                            ?>
                                        <option value="<?php echo utf8_encode($linha_clientes["clienteID"]);?>">
                                            <?php echo utf8_encode($linha_clientes["nome_fantasia"]);?>
                                        </option>
                                        <?php
                            

                            }else{
                            if($cliente ==$formaClientePrincipal){
                             ?> <option value="<?php echo utf8_encode($linha_clientes["clienteID"]);?>" selected>
                                            <?php echo utf8_encode($linha_clientes["nome_fantasia"]);?>
                                        </option>

                                        <?php
                            }else{
                             
                            ?>
                                        <option value="<?php echo utf8_encode($linha_clientes["clienteID"]);?>">
                                            <?php echo utf8_encode($linha_clientes["nome_fantasia"]);?>
                                        </option>
                                        <?php

                                        }
                                        
                                    }

                                                        
                                }


                                ?>


                                    </select>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="campoDescricao" style="width:100px;"> <b>Descrição:</b></label>
                                    <input type="text" size=56 name="campoDescricao" id="campoDescricao"
                                        value="<?php if(isset($_POST['enviar'])){ echo utf8_encode($descricao );}?>">
                            </tr>
                            <tr>
                                <td>
                                    <label for="CampoGrupoLancamento" style="width:100px;"> <b>SubGrupo:</b></label>
                                    <select style="margin-left:0px; width:300px" id="CampoGrupoLancamento"
                                        name="CampoGrupoLancamento">
                                        <option value="0">Selecione</option>
                                        <?php 
                           
                           while($linha_grupoLancamento  = mysqli_fetch_assoc($lista_grupoLancamento)){
                            $GrupoLancamentoPrincipal = utf8_encode($linha_grupoLancamento["subGrupoID"]);
                           if(!isset($grupoLancamento)){
                           
                           ?>
                                        <option value="<?php echo utf8_encode($linha_grupoLancamento["subGrupoID"]);?>">
                                            <?php echo utf8_encode($linha_grupoLancamento["subgrupo"] ." - ". $linha_grupoLancamento['grupo']);?>
                                        </option>
                                        <?php
                           

                           }else{

                            if($grupoLancamento==$GrupoLancamentoPrincipal){
                            ?> <option value="<?php echo utf8_encode($linha_grupoLancamento["subGrupoID"]);?>"
                                            selected>
                                            <?php echo utf8_encode($linha_grupoLancamento["subgrupo"] ." - ".   $linha_grupoLancamento['grupo']);?>
                                        </option>

                                        <?php
                                     }else{
                            
                           ?>
                                        <option value="<?php echo utf8_encode($linha_grupoLancamento["subGrupoID"]);?>">
                                            <?php echo utf8_encode($linha_grupoLancamento["subgrupo"] ." - ". $linha_grupoLancamento['grupo']);?>
                                        </option>
                                        <?php

                                        }
                                        
                                    }

                                                            
                                    }
                                                            
                                                            ?>

                                    </select>

                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="campoValor" style="width:100px;"> <b>Valor:</b></label>
                                    <input type="text" size=15 name="campoValor" id="campoValor"
                                        onkeypress="return onlynumber();"
                                        value="<?php if(isset($_POST['enviar'])){ echo utf8_encode($valor);}?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="observacao" style="width: 100px;"> <b>Observação:</b></label>
                                    <textarea rows=4 cols=60 name="observacao"
                                        id="observacao"><?php if(isset($_POST['enviar'])){ echo utf8_encode($observacao);}?></textarea>
                                </td>
                            </tr>


                        </table>


                        <table style="float:right; width:730px; margin-bottom:30px;">
                            <tr>
                                <td>
                                    <label for="campoFormaPagamento" style="width:180px;"> <b>Forma do
                                            pagamento:</b></label>
                                    <select style="width: 212px; margin-right:27px;" id="campoFormaPagamento"
                                        name="campoFormaPagamento">
                                        <option value="0">Selecione</option>

                                        <?php 

                             while($linha_formapagamento  = mysqli_fetch_assoc($lista_formapagamemto)){
                             $formaPagmaentoPrincipal = utf8_encode($linha_formapagamento["formapagamentoID"]);
                            if(!isset($formaPagamento)){
                            
                            ?>
                                        <option
                                            value="<?php echo utf8_encode($linha_formapagamento["formapagamentoID"]);?>">
                                            <?php echo utf8_encode($linha_formapagamento["nome"]);?>
                                        </option>
                                        <?php
                            

                            }else{

                             if($formaPagamento==$formaPagmaentoPrincipal){
                             ?> <option value="<?php echo utf8_encode($linha_formapagamento["formapagamentoID"]);?>"
                                            selected>
                                            <?php echo utf8_encode($linha_formapagamento["nome"]);?>
                                        </option>

                                        <?php
                                      }else{
                             
                            ?>
                                        <option
                                            value="<?php echo utf8_encode($linha_formapagamento["formapagamentoID"]);?>">
                                            <?php echo utf8_encode($linha_formapagamento["nome"]);?>
                                        </option>
                                        <?php

                                            }
                                            
                                        }

                                                            
                                    }
                                                            
                                         ?>

                                    </select>
                                    <label for="campoContaFinanceira" style="width:80px;"> <b>Conta fin:</b></label>
                                    <select style="width:170px" id="campoContaFinanceira" name="campoContaFinanceira">
                                        <option value="0">Selecione</option>
                                        <?php 
                            while($linha  = mysqli_fetch_assoc($consulta_conta_financeira)){
                                $conta_financeira_principal = utf8_encode($linha["cl_id"]);
                               if(!isset($conta_financeira)){
                               
                               ?>
                                        <option <?php if($conta_financeira_principal =="4"){echo "selected"; } ?> value="<?php echo utf8_encode($linha["cl_id"]);?>">
                                            <?php echo utf8_encode($linha["cl_banco"]);?>
                                        </option>
                                        <?php
                               
   
                               }else{
   
                                if($conta_financeira==$conta_financeira_principal){
                                ?> <option value="<?php echo utf8_encode($linha["cl_id"]);?>" selected>
                                            <?php echo utf8_encode($linha["cl_banco"]);?>
                                        </option>

                                        <?php
                                         }else{
                                
                               ?>
                                        <option value="<?php echo utf8_encode($linha["cl_id"]);?>">
                                            <?php echo utf8_encode($linha["cl_banco"]);?>
                                        </option>
                                        <?php
   
                                        }
                                        
                                    }
                                
                                                            
                                }
                                                        
                                                        ?>
                                    </select>

                                </td>
                            </tr>

                            <tr>
                                <td><label for="campoDocumento" style="width:180px;"> <b>N°
                                            Documento:</b></label>
                                    <input type="text" style="width: 212px;margin-right:26px" size=20 name="campoDocumento"
                                        id="campoDocumento"
                                        value="<?php if(isset($_POST['enviar'])){ echo utf8_encode($documento);}?>">
                              
                                        <label for="campoStatusLancamento" style="width:80px;"> <b>Status:</b></label>
                                    <select style="width:170px" id="campoStatusLancamento" name="campoStatusLancamento">
                                        <option value="0">Selecione</option>
                                        <?php 
                            while($linha_statusLacamento  = mysqli_fetch_assoc($lista_statusLancamento)){
                                $statusPrincipal = utf8_encode($linha_statusLacamento["nome"]);
                               if(!isset($statusLancamento)){
                               
                               ?>
                                        <option value="<?php echo utf8_encode($linha_statusLacamento["nome"]);?>">
                                            <?php echo utf8_encode($linha_statusLacamento["nome"]);?>
                                        </option>
                                        <?php
                               
   
                               }else{
   
                                if($statusLancamento==$statusPrincipal){
                                ?> <option value="<?php echo utf8_encode($linha_statusLacamento["nome"]);?>" selected>
                                            <?php echo utf8_encode($linha_statusLacamento["nome"]);?>
                                        </option>

                                        <?php
                                         }else{
                                
                               ?>
                                        <option value="<?php echo utf8_encode($linha_statusLacamento["nome"]);?>">
                                            <?php echo utf8_encode($linha_statusLacamento["nome"]);?>
                                        </option>
                                        <?php
   
                                        }
                                        
                                    }
                                
                                                            
                                }
                                                        
                                                        ?>
                                    </select>

                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label for="numeroPedido" style="width:180px;"> <b>N°
                                            Pedido:</b></label>
                                    <input style="width: 212px; margin-right:27px" type="text" size=20 name="numeroPedido" id="numeroPedido"
                                        value="<?php if(isset($_POST['enviar'])){ echo utf8_encode($nPedido);}?>">

                                        
                                        <label for="numeroNotaFiscal" style="width:80px;"> <b>N°
                                            NFE:</b></label>
                                    <input type="text" size=16 name="numeroNotaFiscal" id="numeroNotaFiscal"
                                        value="<?php if(isset($_POST['enviar'])){ echo utf8_encode($nNotaFiscal);}?>">


                               
                                </td>


                                </td>

                            </tr>
                        </table>
                        <table style="float:left; width:800px;">
                            <tr>

                                <td>
                                    <div style="margin-left:100px;">

                                        <input type="submit" style="height:37px" name=enviar value="Incluir"
                                            onClick="return confirm('Deseja realizar o lançamento?');"
                                            class="btn btn-info btn-sm"></input>
                                        <button type="button" name="btnfechar"
                                            onclick="window.opener.location.reload();fechar();"
                                            class="btn btn-secondary">Voltar</button>
                                        <a href="recorrente.php">
                                            <button type="button" class="btn btn-warning"
                                                name="editar">Recorrente</button>

                                        </a>
                                    </div>
                                </td>

                            </tr>

                        </table>

                    </table>

                </form>
            </div>
        </main>
</body>

<?php include '../_incluir/funcaojavascript.jar'; ?>
<?php include '../classes/select2/select2_java.php'; ?>

<script src="../jquery/jquery.js"></script>
<script>
function abrepopupcliente() {

    var janela = "../buscar_cliente/consulta_cliente.php";
    window.open(janela, 'popuppage',
        'width=1500,toolbar=0,resizable=1,scrollbars=yes,height=800,top=100,left=100');
}

function fechar() {
    window.close();
}
</script>


</html>

<?php 
mysqli_close($conecta);

?>