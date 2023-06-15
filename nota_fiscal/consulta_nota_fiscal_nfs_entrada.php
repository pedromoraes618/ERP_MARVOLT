<?php require_once("../conexao/conexao.php"); ?>
<?php

include("../conexao/sessao.php");

$select_finalidade = " SELECT * from finalidade_nf ";
$consulta_finalidade = mysqli_query($conecta, $select_finalidade);
if (!$consulta_finalidade) {
    die("Falha na consulta ao banco de dados");
} else {
    $linha = mysqli_fetch_assoc($consulta_finalidade);
    $finalidadeID = $linha['finalidadeID'];
    $descricao = $linha['descricao'];
}

//consultar nota fiscal
if (isset($_GET["campoPesquisa"]) && ["campoPesquisaData"] && ["campoPesquisaDataf"]) {

    $pesquisaData = $_GET["campoPesquisaData"];
    $pesquisaDataf = $_GET["campoPesquisaDataf"];


    if ($pesquisaData == "") {
    } else {
        $div1 = explode("/", $_GET['campoPesquisaData']);
        $pesquisaData = $div1[2] . "-" . $div1[1] . "-" . $div1[0];
    }
    if ($pesquisaDataf == "") {
    } else {
        $div2 = explode("/", $_GET['campoPesquisaDataf']);
        $pesquisaDataf = $div2[2] . "-" . $div2[1] . "-" . $div2[0];
    }



    $select = " SELECT cl_id,dt_emissao,numero_nf,id_referencia,razao_social_tomador,razao_social_prestador,vTotal_servico,codigo_autenticacao from tb_nfs_entrada";
    $pesquisa = $_GET["campoPesquisa"];
    $pesquisaNnfe = $_GET["CampoPesquisNnfe"];
    $select .= " WHERE dt_emissao BETWEEN '$pesquisaData' and '$pesquisaDataf' and  numero_nf  LIKE '%{$pesquisaNnfe}%' and  razao_social_tomador  LIKE '%{$pesquisa}%' ORDER BY numero_nf";
    $resultado = mysqli_query($conecta, $select);
    if (!$resultado) {
        die("Falha na consulta ao banco de dados tb_nfs");
    }
}


//consultar nota fiscal
if (isset($_GET["campoPesquisa"]) && ["campoPesquisaData"] && ["campoPesquisaDataf"]) {

    $pesquisaData = $_GET["campoPesquisaData"];
    $pesquisaDataf = $_GET["campoPesquisaDataf"];


    if ($pesquisaData == "") {
    } else {
        $div1 = explode("/", $_GET['campoPesquisaData']);
        $pesquisaData = $div1[2] . "-" . $div1[1] . "-" . $div1[0];
    }
    if ($pesquisaDataf == "") {
    } else {
        $div2 = explode("/", $_GET['campoPesquisaDataf']);
        $pesquisaDataf = $div2[2] . "-" . $div2[1] . "-" . $div2[0];
    }



    $selectsoma = " SELECT cl_id,dt_emissao,numero_nf,id_referencia,razao_social_tomador,razao_social_prestador,codigo_autenticacao, sum(vTotal_servico) as soma from tb_nfs_entrada";
    $pesquisa = $_GET["campoPesquisa"];
    $pesquisaNnfe = $_GET["CampoPesquisNnfe"];
    $selectsoma .= " WHERE dt_emissao BETWEEN '$pesquisaData' and '$pesquisaDataf' and  numero_nf  LIKE '%{$pesquisaNnfe}%' and  razao_social_tomador  LIKE '%{$pesquisa}%'   ORDER BY numero_nf  ";
    $lista_Soma_Valor = mysqli_query($conecta, $selectsoma);
    if (!$lista_Soma_Valor) {
        die("Falha na consulta ao banco de dados");
    } else {
    }
}


//recuperar valores via get
if (isset($_GET["campoPesquisaData"])) {
    $pesquisaData = $_GET["campoPesquisaData"];
}
if (isset($_GET["campoPesquisaDataf"])) {
    $pesquisaDataf = $_GET["campoPesquisaDataf"];
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
            <ul>
                <li>
                    <b> Data emissão</b>
                </li>

            </ul>

            <a
                onclick="window.open('importaXML/upload_nfs_entrada.php', 
'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">
                <input type="submit" style="width:120px;" name="importar_xml" value="Importar_xml_nfs">
            </a>


            <form style="width:100%;" action="" method="get">

                <input style="width: 100px; " type="text" id="campoPesquisaData" name="campoPesquisaData"
                    placeholder="Data incial" onkeyup="mascaraData(this);" value="<?php if (!isset($_GET["campoPesquisa"])) {
            echo formatardataB(date('Y-m-01'));
            }
            if (isset($_GET["campoPesquisaData"])) {
            echo $pesquisaData;
            } ?>">

                <input style=" width: 100px;" type="text" name="campoPesquisaDataf" placeholder="Data final"
                    onkeyup="mascaraData(this);" value="<?php if (!isset($_GET["campoPesquisa"])) {
            echo date('d/m/Y');
            }
            if (isset($_GET["campoPesquisaDataf"])) {
            echo $pesquisaDataf;
            } ?>">

                <input style="width: 100px; margin-left:50px" type="text" name="CampoPesquisNnfe" placeholder="N° Nfs"
                    value="<?php if (isset($_GET['CampoPesquisNnfe'])) {
            echo $pesquisaNnfe;
            } ?>">

                <input style="margin-left:150px;" type="text" name="campoPesquisa" value="<?php if (isset($_GET['campoPesquisa'])) {
            echo $pesquisa;
            } ?>" placeholder="Pesquisa / Empresa">
                <input type="image" name="pesquisa" src="https://img.icons8.com/ios/50/000000/search-more.png" />




            </form>


        </div>

        <form action="" method="get">

            <table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
                <tbody>
                    <tr id="cabecalho_pesquisa_consulta">

                        <td >
                            <p>Nº NFE</p>
                        </td>

                        <td>
                            <p>Data Emissão</p>
                        </td>
                        <td>
                            <p>Empresa</p>
                        </td>

                        <td>
                            <p>Vlr Total</p>
                        </td>


                        <td>
                            <p>Autenticação</p>
                        </td>

                        <td >
                            <p>Provisionamento</p>
                        </td>
                        <td>

                        </td>



                    </tr>
                    <?php
                    if (isset($_GET["campoPesquisaData"])) {
                        while ($linha = mysqli_fetch_assoc($resultado)) {
                            $nfsID = $linha["cl_id"];
                            $id_referencia = $linha["id_referencia"];
                            $numeroNF = $linha["numero_nf"];
                            $autenticacao = $linha["codigo_autenticacao"];
                            $razaoSocial = $linha["razao_social_prestador"];
                            $dataEmissao = $linha["dt_emissao"];
                            $valorTotal = $linha["vTotal_servico"];


                    ?>
                    <tr id="linha_pesquisa">


                        <td >
                            <p>
                                <font size="3"><?php echo  $numeroNF; ?>
                                </font>
                            </p>
                        </td>

                        <td>
                            <font size="2"> <?php echo formatardataB($dataEmissao) ?></font>
                        </td>



                        <td style="width:400px;">
                            <font size="2"><?php echo utf8_encode($razaoSocial) ?></font>
                        </td>
                        <td >
                            <font size="2"> <?php echo real_format($valorTotal) ?></font>
                        </td>
                        <td >
                            <font size="2"> <?php echo utf8_encode($autenticacao) ?>
                            </font>
                        </td>


                        <?php
                                $select = "SELECT sum(valor) as soma_valor_nota from lancamento_financeiro  WHERE numeroNotaFiscal = '$numeroNF' and id_referencia = '$id_referencia'";
                                $opSelect = mysqli_query($conecta, $select);
                                if (!$opSelect) {
                                    die("Falha na consulta ao banco de dados");
                                } else {
                                    $row = mysqli_fetch_assoc($opSelect);
                                    $somma_valor = $row['soma_valor_nota'];
                                }

                                ?>
                        <td >
                            <a style="cursor:pointer;"
                                onclick="window.open('provisionamento_nfs_entrada.php?codigo=<?php echo $numeroNF; ?>&referencia=<?php echo $id_referencia; ?>', 
'editar_nota_fiscal', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1600, HEIGHT=900');">
                                <?php
                                        if (($somma_valor > 0) && ($somma_valor != $valorTotal)) {

                                        ?>
                                <p style="color:darkgoldenrod">Provisionada parcial</p>

                                <?php

                                        } elseif ($somma_valor == $valorTotal) {
                                        ?>
                                <p style="color:green">Provisionada</p>

                                <?php

                                        } else {
                                        ?>
                                <p style="color:blue">A provisionar</p>
                                <?php
                                        } ?>

                            </a>
                        </td>

                        <td id="botaoEditar">



                            <a
                                onclick="window.open('visualizar_nfs_entrada.php?numero_nf=<?php echo $numeroNF; ?>', 
'editar_nota_fiscal', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1600, HEIGHT=900');">

                                <button type="button" name="editar">Visualizar</button>

                            </a>


                        </td>
                    </tr>



                    <?php

                        }


                        while ($linha_Soma_Valor = mysqli_fetch_assoc($lista_Soma_Valor)) {
                            $soma = $linha_Soma_Valor['soma'];


                        ?>

                    <tr id="cabecalho_pesquisa_consulta">
                        <td>
                            <p>Total</p>
                        </td>
                        <td>
                            <p></p>
                        </td>

                        <td>
                            <p></p>
                        </td>
                        <td style="width: 140px;">
                            <p><?php echo real_format($soma); ?></p>
                        </td>
                        <td>
                            <p></p>
                        </td>
                        <td>
                            <p></p>
                        </td>

                        <td>

                        </td>

                    </tr>

                    <?php
//   $update = "UPDATE lancamento_financeiro set modalidade = 'NFS_ENTRADA' where numeroNotaFiscal = '$numeroNF' and grupoID = 17";
//   $realizar_update = mysqli_query($conecta,$update);

                        }
                    }
                    ?>

                </tbody>
            </table>

        </form>

    </main>

</body>
<?php include '../_incluir/funcaojavascript.jar'; ?>

<script>
//abrir uma nova tela de cadastro
function abrepopupcliente() {

    var janela = "cadastro_cliente.php";
    window.open(janela, 'popuppageCadastrar',
        'width=1500,toolbar=0,resizable=1,scrollbars=yes,height=800,top=100,left=100');
}

function abrepopupEditarCliente() {

    var janela = "editar_cliente.php?codigo=<?php
                                                if (isset($_GET["cliente"])) {
                                                    while ($linha = mysqli_fetch_assoc($resultado)) {
                                                        $Idcliente = $linha["clienteID"];
                                                    }
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