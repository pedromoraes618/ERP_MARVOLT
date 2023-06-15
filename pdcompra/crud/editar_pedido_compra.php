<?php 

//consultar forma de pagamento
$select = "SELECT formapagamentoID, nome, statuspagamento from forma_pagamento";
$lista_formapagamemto = mysqli_query($conecta, $select);
if (!$lista_formapagamemto) {
    die("Falaha no banco de dados || select formapagma");
}


//pegar o nivel do usuario
include "../nivel_usuariosql.php";

//consultar cliente
$select = "SELECT clienteID, razaosocial,nome_fantasia from clientes where clienteFtID = 1 order by nome_fantasia ";
$lista_clientes = mysqli_query($conecta, $select);
if (!$lista_clientes) {
    die("Falaha no banco de dados || select clientes");
}

//consultar status do pedido
$select = "SELECT statuspedidoID, nome from status_pedido";
$lista_statuspedido = mysqli_query($conecta, $select);
if (!$lista_statuspedido) {
    die("Falaha no banco de dados || select statuspedido");
}

//consultar status da compra
$select = "SELECT statuscompraID, nome from status_compra";
$lista_statuscompra = mysqli_query($conecta, $select);
if (!$lista_statuscompra) {
    die("Falaha no banco de dados || select statuscompra");
}

//consultar categoria do produto
$select = "SELECT categoriaID, nome_categoria from categoria_produto";
$lista_categoria = mysqli_query($conecta, $select);
if (!$lista_categoria) {
    die("Falaha no banco de dados  Linha 89");
}


if ($_POST) {

    $hoje = date('Y-m-d');
    $codPedido = utf8_decode($_POST["txtcodigo"]);

    $numeroPedidoCompra = utf8_decode($_POST["txtNumeroPedido"]);
    $numeroOrcamento = utf8_decode($_POST["txtNumeroOrcamento"]);
    $numeroNfe = utf8_decode($_POST["txtNumeroNfe"]);
    $formaPagamento = utf8_decode($_POST["campoFormaPagamento"]);
    $cliente = utf8_decode($_POST["txtCliente"]);
    $produto = utf8_decode($_POST["txtProduto"]);
    $statusCompra = utf8_decode($_POST["txtStatusCompra"]);
    $precoVenda = utf8_decode($_POST["txtprecoUnitarioVenda"]);
    $precoCompra = utf8_decode($_POST["txtprecoUnitarioCompra"]);
    $unidade = utf8_decode($_POST["txtUnidade"]);
    $quantidade = utf8_decode($_POST["txtQuantidade"]);
    $margem = utf8_decode($_POST["txtMargem"]);
    $desconto = utf8_decode($_POST["txtDesconto"]);
    $entregaPrevista = utf8_decode($_POST["txtEntregaPrevista"]);
    $dataCompra = utf8_decode($_POST["txtDataDaCompra"]);
    $entregaRealizada = utf8_decode($_POST["txtEntregaRealizada"]);
    $dataChegada = utf8_decode($_POST["txtDataChegada"]);
    $dataChegadaPrevista = utf8_decode($_POST["txtDataChegadaPrevista"]);
    $entregaPrevistaPost = utf8_decode($_POST["txtEntregaPrevista"]);
    $dataCompraPost = utf8_decode($_POST["txtDataDaCompra"]);
    $entregaRealizadaPost = utf8_decode($_POST["txtEntregaRealizada"]);
    $dataChegadaPost = utf8_decode($_POST["txtDataChegada"]);
    $dataChegadaPrevistaPost = utf8_decode($_POST["txtDataChegadaPrevista"]);
    $dataFechamentoPost = utf8_decode($_POST["txtDataFechamento"]);
    $valorTototalVenda = utf8_decode($_POST["txtValorTotal"]);
    $descontoGeral = utf8_decode($_POST["txtDescontoGeral"]);
    $valorComDesconto = utf8_decode($_POST["txtValorTotalComDesconto"]);
    $valorTotalMargem = utf8_decode($_POST["txtValorMargem"]);
    $valorTotalCompra = utf8_decode($_POST["txtValorTotalCompra"]);
    $dataFechamento = utf8_decode($_POST["txtDataFechamento"]);
    $descontoGeralReais = utf8_decode($_POST["txtDescontoGeralReais"]);
    $categoria_produto = $_POST['campoCategoriaProd'];
}


if (isset($_GET["codigo"])) {
    $pedidoID =  $_GET["codigo"];
    $codigo_pedido =  $_GET["codigoPedido"];
}

//salvando o pedido de compra no banco de dados
if (isset($_POST['salvar'])) {
    if ($codPedido == "") {
?>
        <script>
            alertify.alert("Pedido de compra não iniciado");
        </script>
    <?php
    } elseif ($numeroPedidoCompra == "") {
    ?>
        <script>
            alertify.alert("Numero do pedido não informado");
        </script>
    <?php
    } elseif ($cliente == "0") {
    ?>
        <script>
            alertify.alert("Favor selecione o cliente");
        </script>
    <?php
    } elseif ($statusCompra == "0") {
    ?>
        <script>
            alertify.alert("Não foi definido o status da compra");
        </script>
    <?php

    } elseif ($formaPagamento == "0") {
    ?>
        <script>
            alertify.alert("Não foi definido a forma de pagamento");
        </script>
    <?php

    } elseif ($dataFechamento == "") {
    ?>
        <script>
            alertify.alert("Data do fechamento não informada || Campo D.Fch");
        </script>
        <?php

    } else {


        if ($entregaPrevista == "") {
        } else {
            $div1 = explode("/", $_POST['txtEntregaPrevista']);
            $entregaPrevista = $div1[2] . "-" . $div1[1] . "-" . $div1[0];
        }
        if ($dataChegadaPrevista == "") {
        } else {
            $div2 = explode("/", $_POST['txtDataChegadaPrevista']);
            $dataChegadaPrevista = $div2[2] . "-" . $div2[1] . "-" . $div2[0];
        }


        if ($dataCompra == "") {
        } else {

            $div3 = explode("/", $_POST['txtDataDaCompra']);
            $dataCompra = $div3[2] . "-" . $div3[1] . "-" . $div3[0];
        }


        if ($entregaRealizada == "") {
        } else {

            $div4 = explode("/", $_POST['txtEntregaRealizada']);
            $entregaRealizada = $div4[2] . "-" . $div4[1] . "-" . $div4[0];
        }

        if ($dataChegada == "") {
        } else {

            $div5 = explode("/", $_POST['txtDataChegada']);
            $dataChegada = $div5[2] . "-" . $div5[1] . "-" . $div5[0];
        }

        if ($dataFechamento == "") {
        } else {

            $div7 = explode("/", $_POST['txtDataFechamento']);
            $dataFechamento = $div7[2] . "-" . $div7[1] . "-" . $div7[0];
        }




        //query para alterar o cliente no banco de dados
        $alterar = "UPDATE pedido_compra set data_fechamento = '{$dataFechamento}', numero_pedido_compra = '{$numeroPedidoCompra}',
   desconto_geral_reais = '{$descontoGeralReais}', numero_orcamento  = '{$numeroOrcamento}', 
   numero_nf = '{$numeroNfe}',  forma_pagamento = '{$formaPagamento}', 
   valor_total_compra = '{$valorTotalCompra}', 
   clienteID = '{$cliente}', status_da_compra = '{$statusCompra}',  
   entrega_prevista = '{$entregaPrevista}', data_compra = '{$dataCompra}', 
   entrega_realizada = '{$entregaRealizada}', data_chegada= '{$dataChegada}', 
   data_chegada_prevista = '{$dataChegadaPrevista}',desconto_geral = '{$descontoGeral}',
   valor_total = '{$valorComDesconto}',valor_total_margem = '{$valorTotalMargem}' WHERE pedidoID = {$pedidoID} and codigo_pedido = {$codigo_pedido} ";

        $operacao_alterar = mysqli_query($conecta, $alterar);
        if (!$operacao_alterar) {
            die("Erro o no update banco de dados");
        } else {
        ?>

            <script>
                alertify.success('Dados alterados');
            </script>
        <?php
            //inserindo as informações no banco de dados
            $hoje = date('y-m-d');
            $mensagem = "Usuario editou o pedido de compra Nº $numeroPedidoCompra";
            $inserir = "INSERT INTO tb_log ";
            $inserir .= "(cl_data_modificacao,cl_usuario,cl_descricao)";
            $inserir .= " VALUES ";
            $inserir .= "('$hoje','$user','$mensagem' )";
            $operacao_insert_log = mysqli_query($conecta, $inserir);
        }
    }

    if ($descontoGeral != "") {
        $update = "UPDATE tb_pedido_item set desconto = '{$descontoGeral}' where pedidoID = '{$codigo_pedido}'";

        $operacao_update = mysqli_query($conecta, $update);
        if (!$operacao_update) {
            die("Erro no update banco de dados || Desconto no item");
        }
    }
}


//Consultar os dados do pedido banco de dados
$consulta = "SELECT * FROM pedido_compra ";
if (isset($_GET["codigo"])) {
    $pedidoID =  $_GET["codigo"];
    $codigo_pedido =  $_GET["codigoPedido"];
    $consulta .= " WHERE codigo_pedido = {$codigo_pedido} and pedidoID = {$pedidoID}";
}
$dados_pedido = mysqli_query($conecta, $consulta);
if (!$dados_pedido) {
    die("Falaha no banco de dados");
} else {
    $linha = mysqli_fetch_assoc($dados_pedido);
    $numeroPedidoCompraB =  utf8_encode($linha['numero_pedido_compra']);
    $numeroOrcamentoB = utf8_encode($linha['numero_orcamento']);
    $numeroNfeB = utf8_encode($linha['numero_nf']);
    $formaPagamentoB = utf8_encode($linha['forma_pagamento']);
    $clienteB = utf8_encode($linha['clienteID']);
    $statusCompraB = utf8_encode($linha['status_da_compra']);
    $statusPedidoB = utf8_encode($linha['status_do_pedido']);
    $dataCompraB = utf8_encode($linha['data_compra']);
    $dataChegadaPrevistaB = utf8_encode($linha['data_chegada_prevista']);
    $dataChegadaB = utf8_encode($linha['data_chegada']);
    $entregaPrevistaB = utf8_encode($linha['entrega_prevista']);
    $entregaRealizadaB = utf8_encode($linha['entrega_realizada']);
    $valorComDescontoB  = utf8_encode($linha['valor_total']);
    $descontoGeralB  = utf8_encode($linha['desconto_geral']);
    $valorTotalMargemB  = utf8_encode($linha['valor_total_margem']);
    $valorTotalCompraB  = utf8_encode($linha['valor_total_compra']);
    $dataFechamentoB  = utf8_encode($linha['data_fechamento']);
    $descontoGeralReaisB  = utf8_encode($linha['desconto_geral_reais']);
}



//salvando o produto no banco de dados
if (isset($_POST['adicionar'])) {
    if ($codPedido == "") {
        ?>
        <script>
            alertify.alert("Pedido de compra não iniciado");
        </script>
        <?php
    } else {
        if ($produto == "") {
        ?>
            <script>
                alertify.alert("Favor preencher o campo Produto");
            </script>
        <?php
        } elseif ($unidade == "") {
        ?>
            <script>
                alertify.alert("Favor preencher o campo unidade");
            </script>
        <?php
        } elseif ($precoCompra == "") {
        ?>
            <script>
                alertify.alert("Favor preencher o campo preço compra");
            </script>
        <?php
        } elseif ($precoVenda == "") {
        ?>
            <script>
                alertify.alert("Favor preencher o campo preço venda");
            </script>
        <?php
        } elseif ($quantidade == "") {
        ?>
            <script>
                alertify.alert("Favor preencher o campo quantidade");
            </script>
        <?php
        } else {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $request = md5(implode($_POST));

                if (isset($_SESSION['last_request']) && $_SESSION['last_request'] == $request) {
                    $produto = "";
                    $unidade = "";
                    $quantidade = "";
                    $precoCompra = "";
                    $precoVenda = "";
                    $margem = "";
                } else {
                    $_SESSION['last_request']  = $request;
                    $_POST;
                    $inserir = "INSERT INTO tb_pedido_item ";
                    $inserir .= "( data_lancamento,pedidoID,produto,unidade,quantidade,preco_compra_unitario,preco_venda_unitario,margem,desconto,status_compra,categoria_produto )";
                    $inserir .= " VALUES ";
                    $inserir .= "( '$hoje','$codPedido','$produto','$unidade','$quantidade','$precoCompra','$precoVenda','$margem','$desconto','2','$categoria_produto' )";
                    $operacao_inserir = mysqli_query($conecta, $inserir);
                    if (!$operacao_inserir) {
                        print_r($_POST);
                        die("Erro no banco de dados || adicionar o produto no banco de dados");
                    }

                    $produto = "";
                    $unidade = "";
                    $quantidade = "";
                    $precoCompra = "";
                    $precoVenda = "";
                    $margem = "";
                    $desconto = "";
                }
            }
        }
    }
}

//remover pedido de compra
if (isset($_POST['remover'])) {
    $delete = "DELETE from pedido_compra where codigo_pedido = '$codigo_pedido' ";
    $operacao_delete = mysqli_query($conecta, $delete);
    if (!$operacao_delete) {
        die("Falaha no banco de dados || delete pedido_compra ");
    } else {
        $delete = "DELETE from tb_pedido_item where pedidoID = '$codigo_pedido' ";
        $operacao_delete = mysqli_query($conecta, $delete);
        if (!$operacao_delete) {
            die("Falaha no banco de dados || delete produto_pedido_compra ");
        } else {
        ?>
            <script>
                alertify.success("Pedido de compra removido com sucesso!");
            </script>
<?php

            //inserindo as informações no banco de dados log
            $hoje = date('y-m-d');
            $mensagem = "Usuario removeu o pedido de compra Nº $numeroPedidoCompraB";
            $inserir = "INSERT INTO tb_log ";
            $inserir .= "(cl_data_modificacao,cl_usuario,cl_descricao)";
            $inserir .= " VALUES ";
            $inserir .= "('$hoje','$user','$mensagem' )";
            $operacao_insert_log = mysqli_query($conecta, $inserir);
        }
    }
}



//consultar os produtos do pedido de compra!
if ((isset($_POST['adicionar'])) or (isset($_POST['fecharPesquisa']))  or (isset($_POST['salvar'])) or (!isset($_GET['pesquisar']))) {

    $selectProduto =  " SELECT produto ,cod_produto, pedidoID ,pedido_itemID, unidade, quantidade,preco_compra_unitario,preco_venda_unitario,margem,desconto,status_compra from tb_pedido_item where pedidoID = '$codigo_pedido'";
    $lista_Produto = mysqli_query($conecta, $selectProduto);
    if (!$lista_Produto) {
        die("Falaha no banco de dados || pesquisar produto ");
    }
}

if ((isset($_POST['adicionar'])) or (isset($_POST['fecharPesquisa'])) or  (isset($_POST['salvar'])) or (!isset($_POST['pesquisar']))) {

    $selectProdutoSoma =  " SELECT  sum(preco_venda_unitario*quantidade) as somaVenda, sum(preco_compra_unitario*quantidade) as somaCompra from tb_pedido_item where pedidoID = '$codigo_pedido'";
    $lista_Produto_Soma = mysqli_query($conecta, $selectProdutoSoma);
    if (!$lista_Produto_Soma) {
        die("Falaha no banco de dados || pesquisar produto ");
    } else {
        $linha_soma = mysqli_fetch_assoc($lista_Produto_Soma);
        $somaVenda = $linha_soma['somaVenda'];
        $somaCompra = $linha_soma['somaCompra'];
    }
}



if (isset($_POST['pesquisar'])) {
    $select = "SELECT * from produto_cotacao  where numero_orcamento = '$numeroOrcamento'";
    $lista_produto_cotacao = mysqli_query($conecta, $select);
    if (!$lista_produto_cotacao) {
        die("Falaha no banco de dados || select produto_cotacao");
    }
}
