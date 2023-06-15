<?php
require_once("../conexao/sessao.php");
require_once("../conexao/conexao.php");


//consultar cliente/forncedor/transportador
$selectcft = "SELECT clienteftID, nome from forclietrans";
$lista_cft = mysqli_query($conecta, $selectcft);
if (!$lista_cft) {
    die("Falaha no banco de dados  Linha 31 inserir_transportadora");
}
//consultar ramo cliente
$select = "SELECT categoriaID, nome_categoria from categoria_produto";
$lista_categoria = mysqli_query($conecta, $select);
if (!$lista_categoria) {
    die("Falaha no banco de dados  Linha 89");
}

if (isset($_GET['cliente'])) {

    $tipo = $_GET['campoTipoEmpresa'];
    $nome_cliente = $_GET["cliente"];
    $ramo = $_GET["ramo"];


    //consultar clientes
    $select = "SELECT clt.nome_fantasia,clt.clienteftID,clt.cpfcnpj,clt.cidade,clt.bairro,clt.clienteftID,clt.clienteID,clt.telefone,ramo.nome_categoria FROM clientes as clt inner join categoria_produto as ramo on ramo.categoriaID = clt.ramo ";
    $select .= " WHERE  clt.nome_fantasia LIKE  '%{$nome_cliente}%'  ";

    if ($tipo != "0") {
        $select .= " and  clt.clienteftID = '{$tipo}' ";
    }

    if ($ramo != "0") {
        $select .= "  and clt.ramo = '{$ramo}'  ";
    }
    $select .= " order by nome_fantasia ";

    $resultado = mysqli_query($conecta, $select);
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
    <a href="https://icons8.com/icon/59832/cardápio"></a>
</head>

<body>
    <?php include_once("../_incluir/topo.php"); ?>
    <?php include("../_incluir/body.php"); ?>
    <?php include_once("../_incluir/funcoes.php"); ?>


    <main>



        <div id="janela_pesquisa">


            <div id="BotaoLancar">
                <a onclick="window.open('cadastro_cliente.php', 
'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">
                    <input type="submit" name="cadastar_cliente" value="Adicionar">
                </a>
            </div>



            <form style="width:100%;" action="consulta_cliente.php" method="get">

                <tr>

                    <td>
                        <input type="text" name="cliente" style="margin-left: 500px;" placeholder="Pesquisa / Empresa / Cnpj" value="<?php if (isset($_GET['cliente'])) {
                                                                                                                                            echo $nome_cliente;
                                                                                                                                        } ?>">

                        <input type="image" name="pesquisa" src="https://img.icons8.com/ios/50/000000/search-more.png" />
                    </td>
                    <td>
                        <select style="width: 150px; float:right; margin-right:50px" id="ramo" name="ramo">
                            <option value="0">Ramo</option>
                            <?php


                            while ($linha  = mysqli_fetch_assoc($lista_categoria)) {
                                $ramo_principal = ($linha["categoriaID"]);
                                if (!isset($ramo)) {

                            ?>

                                    <option value="<?php echo ($linha["categoriaID"]); ?>">
                                        <?php echo ($linha["nome_categoria"]); ?>
                                    </option>
                                    <?php

                                } else {

                                    if ($ramo == $ramo_principal) {
                                    ?> <option value="<?php echo ($linha["categoriaID"]); ?>" selected>
                                            <?php echo ($linha["nome_categoria"]); ?>
                                        </option>

                                    <?php
                                    } else {

                                    ?>
                                        <option value="<?php echo ($linha["categoriaID"]); ?>">
                                            <?php echo ($linha["nome_categoria"]); ?>
                                        </option>
                            <?php

                                    }
                                }
                            }

                            ?>


                        </select>
                    </td>
                    <td>
                        <select style="width: 170px; float:right; margin-right:20px; " id="campoTipoEmpresa" name="campoTipoEmpresa">
                            <option value="0">Tipo de Empresa</option>
                            <?php


                            while ($linha_consulta_tipo  = mysqli_fetch_assoc($lista_cft)) {
                                $tipo_principal = utf8_encode($linha_consulta_tipo["clienteftID"]);
                                if (!isset($tipo)) {

                            ?>

                                    <option value="<?php echo utf8_encode($linha_consulta_tipo["clienteftID"]); ?>">
                                        <?php echo utf8_encode($linha_consulta_tipo["nome"]); ?>
                                    </option>
                                    <?php

                                } else {

                                    if ($tipo == $tipo_principal) {
                                    ?> <option value="<?php echo utf8_encode($linha_consulta_tipo["clienteftID"]); ?>" selected>
                                            <?php echo utf8_encode($linha_consulta_tipo["nome"]); ?>
                                        </option>

                                    <?php
                                    } else {

                                    ?>
                                        <option value="<?php echo utf8_encode($linha_consulta_tipo["clienteftID"]); ?>">
                                            <?php echo utf8_encode($linha_consulta_tipo["nome"]); ?>
                                        </option>
                            <?php

                                    }
                                }
                            }

                            ?>


                        </select>
                    </td>


                </tr>


            </form>

        </div>

        <form action="consulta_pdcompra.php" method="get">

            <table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
                <tbody>
                    <tr id="cabecalho_pesquisa_consulta">


                        <td>
                            <p>Código</p>
                        </td>
                        <td>
                            <p> Empresa</p>
                        </td>
                        <td>
                            <p>Cpf/Cnpj</p>
                        </td>
                        <td>
                            <p>Cidade</p>
                        </td>
                        <td>
                            <p>Bairro</p>
                        </td>


                        <td>
                            <p>Fornecedor\Cliente</p>
                        </td>
                        <td>
                            <p>Ramo</p>
                        </td>

                        <td>
                            <p>Telefone</p>
                        </td>

                        <td>
                          
                        </td>
                        <td>
                         
                        </td>
                        <td>
                          
                        </td>

                    </tr>

                    <?php
                    if (isset($_GET["cliente"])) {
                        while ($linha = mysqli_fetch_assoc($resultado)) {
                            $Idcliente = $linha["clienteID"];
                            $nome_fantasia = utf8_encode($linha["nome_fantasia"]);


                            $select = "SELECT data_fechamento from pedido_compra where clienteID = $Idcliente and data_fechamento = 
            (select max(data_fechamento) from pedido_compra where clienteID = $Idcliente)";
                            $resultado_ultimo_pedido_compra_cliente = mysqli_query($conecta, $select);
                            $linha_ultimo_pedido = mysqli_fetch_assoc($resultado_ultimo_pedido_compra_cliente);
                            $ultimo_pd_fechamento = $linha_ultimo_pedido['data_fechamento'];

                    ?>



                            <tr id="linha_pesquisa">



                                <td style="width:80px">
                                    <p>
                                        <font size="2" style="margin-left: 20px;"><?php echo utf8_encode($linha["clienteID"]) ?>
                                        </font>
                                    </p>
                                </td>

                                <td style="width:450px;">
                                    <p>
                                        <font size="2"><?php echo $nome_fantasia ?>
                                        </font>
                                    </p>
                                </td>

                                <td style="width:140px;">
                                    <font size="2"><?php echo formatCnpjCpf($linha["cpfcnpj"]) ?></font>
                                </td>
                                <td style="width:120px;">
                                    <font size="2"> <?php echo utf8_encode($linha["cidade"]) ?>
                                    </font>
                                </td>

                                <td style="width:120px;">
                                    <font size="2"> <?php echo utf8_encode($linha["bairro"]) ?></font>
                                </td>

                                <td style="width:160px;">
                                    <font size="2"><?php if ($linha["clienteftID"] == 1) {
                                                        echo  "CLIENTE";
                                                    }
                                                    if ($linha["clienteftID"] == 2) {
                                                        echo  "FORNECEDOR";
                                                    }

                                                    if ($linha["clienteftID"] == 3) {
                                                        echo "TRANSPORTADOR";
                                                    }
                                                    if ($linha["clienteftID"] == 5) {
                                                        echo "BANCO";
                                                    }
                                                    ?> </font>
                                </td>

                                <td style="width:120px;">
                                    <font size="2"> <?php echo ($linha["nome_categoria"]) ?></font>
                                </td>

                                <td style="width:120px;">
                                    <font size="2"> <?php echo utf8_encode($linha["telefone"]) ?></font>
                                </td>

                                <td id="botaoEditar">
                                    <a onclick="window.open('contatos/consultar_contato.php?codigo=<?php echo $Idcliente; ?>&nfantasia=<?php echo $nome_fantasia ?>', 
'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">

                                        <button type="button" style="margin-right:10px;" name="contato">Contato</button>


                                    </a>


                                </td>
                                <td id="botaoEditar">
                                    <a onclick="window.open('editar_cliente.php?codigo=<?php echo $Idcliente; ?>', 
'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">

                                        <button style="margin-right:10px;" type="button" name="Editar">Editar</button>


                                    </a>


                                </td>
                                <td id="botaoEditar">
                                    <a onclick="window.open('historico_cliente/consultar_hst.php?codigo=<?php echo $Idcliente; ?>&nfantasia=<?php echo $nome_fantasia ?>', 
'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">

                                        <button type="button" style="margin-right:10px;" name="Editar">Historico</button>


                                    </a>


                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

        </form>

    </main>

</body>

<script>
    //abrir uma nova tela de cadastro
    function abrepopupcliente() {

        var janela = "cadastro_cliente.php";
        window.open(janela, 'popuppageCadastrar',
            'width=1500,toolbar=0,resizable=1,scrollbars=yes,height=800,top=100,left=100');
    }

    function abrepopupEditarCliente() {

        var janela = "editar_cliente.php?codigo=<?php

                                                while ($linha = mysqli_fetch_assoc($resultado)) {
                                                    $Idcliente = $linha["clienteID"];
                                                }

                                                ?>";
        window.open(janela, 'popuppageEditar',
            'width=1500,toolbar=0,resizable=1,scrollbars=yes,height=800,top=100,left=100');
    }
</script>

</html>

<?php
// Fechar conexao
mysqli_close($conecta);
?>