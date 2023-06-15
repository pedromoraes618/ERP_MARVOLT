<?php
include("../conexao/sessao.php");
require_once("../conexao/conexao.php");
include_once("../_incluir/funcoes.php"); 
//inportar o alertar js
include('../alert/alert.php');

echo",";

//consultar forma de pagamento
$select = "SELECT formapagamentoID, nome, statuspagamento from forma_pagamento";
$lista_formapagamemto = mysqli_query($conecta,$select);
if(!$lista_formapagamemto){
    die("Falaha no banco de dados || select formapagma");
}


//consultar cliente
$select = "SELECT clienteID, razaosocial,nome_fantasia from clientes";
$lista_clientes = mysqli_query($conecta,$select);
if(!$lista_clientes){
    die("Falaha no banco de dados || select clientes");
}

//consultar status do pedido
$select = "SELECT statuspedidoID, nome from status_pedido";
$lista_statuspedido = mysqli_query($conecta,$select);
if(!$lista_statuspedido){
    die("Falaha no banco de dados || select statuspedido");
}

//consultar status da compra
$select = "SELECT statuscompraID, nome from status_compra";
$lista_statuscompra = mysqli_query($conecta,$select);
if(!$lista_statuscompra){
    die("Falaha no banco de dados || select statuscompra");
}

$select = "SELECT statuscompraID, nome from status_compra";
$lista_statuscompra = mysqli_query($conecta,$select);
if(!$lista_statuscompra){
    die("Falaha no banco de dados || select statuscompra");
}



//consultar grupo Lançamento
$select = "SELECT subGrupoID, subgrupo,nome as grupo,lancamento from tb_subgrupo_receita_despesa inner join grupo_lancamento on grupo_lancamento.grupo_lancamentoID = tb_subgrupo_receita_despesa.grupo where lancamento = 'Despesa' or grupo = 1";
$lista_grupoLancamento = mysqli_query($conecta,$select);
if(!$lista_grupoLancamento){
    die("Falaha no banco de dados
    || falha de conexão de red
    select tb_subgrupo_receita_despesa");
}



//consultar conta_financeira
$select = "SELECT * from tb_conta_financeira";
$consulta_conta_financeira = mysqli_query($conecta,$select);
if(!$consulta_conta_financeira){
    die("Falha no banco de dados || select ");
}


//remover todos os lancamentos
if(isset($_POST['btnremover'])){
    $numeroRecorrente = utf8_decode($_POST["numeroRecorrente"]);
    $formaPagamento = utf8_decode($_POST["txtFormaPagamento"]);
    $cliente = utf8_decode($_POST["txtCliente"]);
    $dataApagar = utf8_decode($_POST["txtaPagar"]);
    $documento = utf8_decode($_POST["txtNumeroDocumento"]);
    $valor = utf8_decode($_POST["valorDocumento"]);
    $nParcela = utf8_decode($_POST["numeroParcela"]);
    $subGrupo = utf8_decode($_POST["subGrupo"]);
    excluirLcmt($numeroRecorrente);
};



//salvar os lancamentos
if(isset($_POST['salvar'])){
    $hoje = date('Y-m-d'); 
    $numeroRecorrente = utf8_decode($_POST["numeroRecorrente"]);
    $formaPagamento = utf8_decode($_POST["txtFormaPagamento"]);
    $cliente = utf8_decode($_POST["txtCliente"]);
    $dataApagar = utf8_decode($_POST["txtaPagar"]);
    $documento = utf8_decode($_POST["txtNumeroDocumento"]);
    $valor = utf8_decode($_POST["valorDocumento"]);
    $nParcela = utf8_decode($_POST["numeroParcela"]);
    $subGrupo = utf8_decode($_POST["subGrupo"]);
    $conta_financeira = $_POST['campoContaFinanceira'];


    //não deixa duplicar o post
if( $_SERVER['REQUEST_METHOD']=='POST' )
{
    $request = md5( implode( $_POST ) );
    if( isset( $_SESSION['last_request'] ) && $_SESSION['last_request']== $request )
    {
        $documento ="";
        $nParcela = "";
        $dataApagar = "";
        $valor = "";
        $subGrupo = "0";
        $formaPagamento = "0";
        $conta_financeira = 0;
    }
    else
    {
        
    $_SESSION['last_request']  = $request;

        if($cliente == "0"){
                    ?>
<script>
alertify.alert("Favor selecionar a Empresa");
</script>
<?php
                }elseif($documento==""){
                    ?>
<script>
alertify.alert("Favor preencher o campo Documento");
</script>
<?php   
                }elseif($dataApagar==""){
                    ?>
<script>
alertify.alert("Favor preencher o campo Data 1º Pagamentor");
</script>
<?php   
                }
                elseif($nParcela==""){
                    ?>
<script>
alertify.alert("Favor preencher o campo N parcela");
</script>
<?php   
                } elseif($subGrupo=="0"){
                    ?>
<script>
alertify.alert("Favor preencher o campo SubGrupo");
</script>
<?php   
                }elseif($formaPagamento=="0"){
                    ?>
<script>
alertify.alert("Favor preencher o campo forma do pagamento");
</script>
<?php   
                }elseif($valor==""){
                    ?>
<script>
alertify.alert("Favor preencher o campo Vlr Total");
</script>
<?php   
                }elseif($conta_financeira=="0"){
      
                    ?>
                
                <script>
                alertify.alert("Favor informe a conta financeira");
                </script>
                <?php
                
                }
                else{
                    $cont = 0;
                    //variavel para controlar o while
                    $controle = 1;
                    //soma total das parcelas
                    $soma_valor_parc =0;
                    $valor_total = $valor;
                    $quantidade_par = $nParcela;
                    $data_atual = new DateTime();

                    $valor_par = $valor_total / $quantidade_par;

                     
                    while($controle <= $quantidade_par){
                        $cont = $cont +1;
                            //acessa o if quando é ultima parcela para corrigir o valor da compra
                        $data_parcela = $data_atual ->format('y-m-').$dataApagar;
                        $menagem = utf8_decode("Lançamento financeiro recorrente Parcela "."$documento"."/"."$cont");
                        $data_atual->add(new DateInterval("P1M"));
                        if($controle == $quantidade_par){
                            //utilizar a soma das parcelas já impressa e subtrair do valor total da compra para obter o valor a ultima parcela e corrigir a diferença

                            $valor_ultima_par = $valor_total -$soma_valor_parc;
                            //somar o valor das parcelas
                         //  $soma_valor_parc += number_format($valor_ultima_par,2,'.','');
                         $inserir = "INSERT INTO lancamento_financeiro ";
                         $inserir .= "(data_movimento,data_a_pagar,receita_despesa,status,forma_pagamentoID,clienteID,descricao,documento,grupoID,valor,numeroRecorrente,cl_conta_financeira_id)";
                         $inserir .= " VALUES ";
                         $inserir .= "('$hoje','$data_parcela','Despesa','A Pagar','$formaPagamento','$cliente','$menagem','$documento/$cont','$subGrupo','$valor_ultima_par','$numeroRecorrente','$conta_financeira' )";
         
                         //verificando se está havendo conexão com o banco de dados
                         $operacao_inserir = mysqli_query($conecta, $inserir);
                         if(!$operacao_inserir){
                       
                             die("Erro no banco de dados inserir_no_banco_de_dados");
                         }

                        }else{
                        // echo "Valor da parcela 2". real_format($valor_par)."<br>";
                         //somar o valor das parcelas
                        $soma_valor_parc += number_format($valor_par,2,'.','');

                        $inserir = "INSERT INTO lancamento_financeiro ";
                        $inserir .= "(data_movimento,data_a_pagar,receita_despesa,status,forma_pagamentoID,clienteID,descricao,documento,grupoID,valor,numeroRecorrente,cl_conta_financeira_id)";
                        $inserir .= " VALUES ";
                        $inserir .= "('$hoje','$data_parcela','Despesa','A Pagar','$formaPagamento','$cliente','$menagem','$documento/$cont','$subGrupo','$valor_par','$numeroRecorrente','$conta_financeira'  )";
                          //verificando se está havendo conexão com o banco de dados
                          $operacao_inserir = mysqli_query($conecta, $inserir);
                          if(!$operacao_inserir){
                        
                              die("Erro no banco de dados inserir_no_banco_de_dados");
                          }    
                    }

                        //incrementar a variavel apos imprimir a parcela
                        $controle++;

                  


        
                }
                    
            }
        }
    }



}

//select lancamento financeiro
if($_POST){
    $numeroRecorrente = utf8_decode($_POST["numeroRecorrente"]);
    $select = "SELECT  clientes.nome_fantasia, 
    forma_pagamento.nome,ctfn.cl_banco as banco,lancamento_financeiro.descricao,grupo_lancamento.nome  as grupo,
     lancamento_financeiro.lancamentoFinanceiroID, tb_subgrupo_receita_despesa.subgrupo,
      tb_subgrupo_receita_despesa.subgrupo, lancamento_financeiro.data_movimento, 
       lancamento_financeiro.documento,lancamento_financeiro.lancamentoFinanceiroID,lancamento_financeiro.numeroRecorrente,
        lancamento_financeiro.data_a_pagar,
         lancamento_financeiro.status,lancamento_financeiro.valor,
           lancamento_financeiro.receita_despesa from  clientes  inner join lancamento_financeiro 
           on lancamento_financeiro.clienteID = clientes.clienteID inner join tb_subgrupo_receita_despesa 
           on lancamento_financeiro.grupoID = tb_subgrupo_receita_despesa.subGrupoID inner join forma_pagamento
            on lancamento_financeiro.forma_pagamentoID = forma_pagamento.formapagamentoID inner join grupo_lancamento
             on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID  inner join tb_conta_financeira as ctfn on ctfn.cl_id =lancamento_financeiro.cl_conta_financeira_id WHERE numeroRecorrente = '$numeroRecorrente' order by data_a_pagar ";
             $lista_pesquisa_lancamento = mysqli_query($conecta,$select);
            if(!$lista_pesquisa_lancamento){
                die("Falha no banco de dados");
            }
    
            $select = "SELECT sum(valor) as totalPedido from lancamento_financeiro WHERE numeroRecorrente = '$numeroRecorrente'";
            $lista_total_financeiro = mysqli_query($conecta,$select);
            if(!$lista_total_financeiro){
                die("Falha no banco de dados || select somatorio financeiro");
            }else{
                $row = mysqli_fetch_assoc($lista_total_financeiro);
                $totalPedido = $row['totalPedido'];
            }
    }

//funcão excluir lancamento
function excluirLcmt($anexoID){
    include("../conexao/conexao.php");
    $remover = "DELETE FROM lancamento_financeiro  where numeroRecorrente = '{$anexoID}' ";
    $operacao_remover = mysqli_query($conecta, $remover);
    if(!$operacao_remover){
        die("Erro no banco de dados ");
    }else{
        ?>
<script>
alertify.error("Lançamentos removidos com sucesso");
</script>
<?php
    }
}

//gerar id recorrente
$recorrenteID = rand(100,50000);     

?>
<!doctype html>

<html>



<head>
    <meta charset="UTF-8">
    <!-- estilo -->

    <link href="../_css/tela_cadastro_editar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <?php 
    include("../classes/select2/select2_link.php")
    ?>
    <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>

</head>

<body>
    <div id="titulo">
        </p>Lançamento recorrente</p>
    </div>

    <form action="" autocomplete="off" method="post">
        <main>
            <div style="margin:0 auto; width:1400px; ">
                <table style="float:left; width:1400px; margin-bottom: 10px; border:1px solid;">
                    <button type="button" style="float:right" name="btnfechar"
                        onclick="window.opener.location.reload();fechar();" class="btn btn-secondary">Voltar</button>

                </table>

                <table style="float:left; width:1400px; margin-bottom: 10px;">
                    <tr>
                        <td>
                            <input readonly type="hidden" size=10 id="numeroRecorrente" name="numeroRecorrente" value="<?php 
                            if($_POST){
                                echo $numeroRecorrente;
                            }else{
                               echo $recorrenteID;
                            }
                                    ?>">


                        </td>
                    </tr>



                </table>


                <table
                    style="float:left; width:1400px; border-bottom:1px solid #ddd; padding-bottom:50px;  margin-bottom:20px">

                    <tr>
                        <td>
                            <label for="txtCliente" style="width:100px;"> <b>Empresa:</b></label>
                            <select id="txtCliente" name="txtCliente">
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
                </table>
                <table style="float:left; width:1400px; margin-bottom: 0px; ">
                    <tr>
                        <td>
                            <label for="txtNumeroDocumento" style="width:148px;"> <b>Documento</b></label>


                            <label for="numeroParcela" style="width:148px;"> <b>Nº parcela</b></label>

                            <label for="txtaPagar" style="width:148px;"> <b>Dia. 1º pgt </b></label>

                            <label for="valorDocumento" style="width:148px;"> <b>Vlr Total</b></label>

                            <label for="valorDocumento" style="width:150px;"> <b>SubGrupo</b></label>

                            <label for="txtFormaPagamento" style="width:240px;" ><b>Forma do pagamento:</b></label>

                            <label for="txtFormaPagamento" ><b>Conta Finaneceira</b></label>

                        </td>
                    </tr>
                </table>

                <table style="float:left; width:1400px; margin-top:-5px ">
                    <tr>
                        <td>

                            <input type="text" size=10 id="txtNumeroDocumento" name="txtNumeroDocumento" value="<?php
                                        if($_POST){
                                            echo $documento;
                                        }?>">
                            <input type="text" size=10 id="numeroParcela" name="numeroParcela"
                                value="<?php if($_POST){echo $nParcela;}?>">

                            <input type="text" size=10 id="txtaPagar" name="txtaPagar" value="<?php
                                      if($_POST){
                                        echo $dataApagar;
                                    }
                                    ?>" maxlength="10" autocomplete="off">


                            <input type="text" size=10 id="valorDocumento" name="valorDocumento" value="<?php 
                                   if($_POST){
                                    echo $valor;
                                }
                                    ?>">

                            <select style="margin-right:20px; width:150px" id="subGrupo" name="subGrupo">
                                <option value="0">Selecione</option>
                                <?php 
                           
                           while($linha_grupoLancamento  = mysqli_fetch_assoc($lista_grupoLancamento)){
                            $GrupoLancamentoPrincipal = utf8_encode($linha_grupoLancamento["subGrupoID"]);

                            

                           if(!isset($subGrupo)){
                           
                           ?>
                                <option value="<?php echo utf8_encode($linha_grupoLancamento["subGrupoID"]);?>">
                                    <?php echo utf8_encode($linha_grupoLancamento["subgrupo"] ." - ". $linha_grupoLancamento['grupo']);?>
                                </option>
                                <?php
                           

                           }else{

                            if($subGrupo==$GrupoLancamentoPrincipal){
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


                            <select style="width: 212px; margin-right:27px" id="txtFormaPagamento"
                                name="txtFormaPagamento">
                                <option value="0">Selecione</option>

                                <?php 

                             while($linha_formapagamento  = mysqli_fetch_assoc($lista_formapagamemto)){
                             $formaPagmaentoPrincipal = utf8_encode($linha_formapagamento["formapagamentoID"]);
                            if(!isset($formaPagamento)){
                            
                            ?>
                                <option value="<?php echo utf8_encode($linha_formapagamento["formapagamentoID"]);?>">
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
                                <option value="<?php echo utf8_encode($linha_formapagamento["formapagamentoID"]);?>">
                                    <?php echo utf8_encode($linha_formapagamento["nome"]);?>
                                </option>
                                <?php

                                            }
                                            
                                        }

                                                            
                                    }
                                                            
                                         ?>

                            </select>
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

                            <input type="submit" id="salvar" name="salvar" class="btn btn-success" value="Adicionar">
                            <input id="remover" type="submit" name="btnremover" value="Remover" class="btn btn-danger"
                                onClick="return confirm('Deseja remover esses lançamentos?');"></input>

                        </td>
                    </tr>
                </table>
                <table border="0" cellspacing="0" width="1400px;" class="tabela_pesquisa" style="margin-top:10px;">
                    <?php if($_POST){?>
                    <tbody>
                        <tr id="cabecalho_pesquisa_consulta">
                            <td>
                                <p style="margin-left:10px;">Parcela</p>
                            </td>
                            <td>
                                <p>Vencimento</p>
                            </td>

                            <td>
                                <p>Documento</p>
                            </td>
                            <td>
                                <p>SubGrupo</p>
                            </td>
                            <td>
                                <p>Conta financeira</p>
                            </td>
                            <td>
                                <p>Status</p>
                            </td>
                            <td >
                                <p>Valor</p>
                            </td>
                            <td>
                                <p></p>
                            </td>
                            <td>
                                <p></p>
                            </td>





                        </tr>
                        <?php


$linhas = 0;
while($linha = mysqli_fetch_assoc($lista_pesquisa_lancamento)){
    $lancamentoID = utf8_encode($linha['lancamentoFinanceiroID']);
    $dataLancamento= utf8_encode($linha['data_movimento']);
    $dataApagarB = utf8_encode($linha['data_a_pagar']);
    $documentoB = utf8_encode($linha['documento']);
    $valorB = $linha['valor'];
    $statusB = $linha['status'];
    $subGrupo = utf8_encode($linha['subgrupo']);
    
    $recorrenteID = $linha['numeroRecorrente'];
    $banco = $linha['banco'];

?>
                        <tr id="linha_pesquisa">

                            <td style="width: 100px; ">
                                <p style="margin-left: 15px; margin-top:10px;">
                                    <font size="3"><?php echo $linhas = $linhas +1;?></font>
                                </p>
                            </td>

                            <td style="width: 150px;">

                                <font size="2"><?php echo formatardataB($dataApagarB);?> </font>

                            </td>

                            <td style="width: 150px;">

                                <font size="2"><?php echo ($documentoB);?> </font>

                            </td>

                            <td style="width: 150px;">

                                <font size="2"><?php echo $subGrupo;?> </font>

                            </td>

                        
                            <td style="width: 150px;">

                                <font size="2"><?php echo $banco;?> </font>

                            </td>
                            <td style="width: 150px;">

                                <font size="2"><?php echo $statusB;?> </font>

                            </td>

                            <td style="width: 150px;">
                                <font size="2"><?php echo real_format($valorB);?> </font>
                            </td>



                            <td style="width:100px ;" id="botaoEditar">

                                <a
                                    onclick="window.open('editar_despesa.php?codigo=<?PHP echo $lancamentoID; ?>', 
'editar_despesa', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">

                                    <button type="button" class="btn btn-warning" name="editar">Editar</button>
                                </a>

                            </td>

                            <td style="width: 100px;">
                                <a href="" style="color: red;" class="excluir"
                                    title="<?php echo $lancamentoID ?>"><button type="button"
                                        class="btn btn-danger">Excluir</button></a>
                            </td>
                        </tr>

                        <?php }
                        ?>

                        <tr id="cabecalho_pesquisa_consulta">
                            <td >
                                <p>Total</p>
                            </td>


                            <td>

                            </td>

                            <td>

                            </td>
                            <td>

                            </td>
                            <td>

</td>
                            <td>

                            </td>
             
                            <td>
                                <font size="2"><?php echo real_format($totalPedido);?> </font>
                            </td>
                            <td>

                            </td>
                            <td>

                            </td>





                        </tr>
                    </tbody>
                    <?php 
                }?>
                </table>




    </form>
    </div>
    </main>
    <?php include '../_incluir/funcaojavascript.jar'; ?>
    <?php include '../classes/select2/select2_java.php'; ?>
    <script>
    function fechar() {
        window.close();
    }

    $('a.excluir').click(function(e) {
        e.preventDefault();
        var id = $(this).attr("title");
        alertify.confirm("Deseja remover essa parcela?.",
            function() {
                var elemento = $(this).parent().parent();
                $(elemento).fadeOut();
                alertify.success('Parcela removida');
                $.ajax({
                    type: "GET",
                    data: "codigo=" + id,
                    url: "remover_recorrente.php",
                    async: false
                }).done(function(data) {

                })

                setTimeout(function() {
                    location.reload();
                }, 1000);



            },
            function() {

            });



    });
    </script>

</body>

</html>

<?php
mysqli_close($conecta);
?>