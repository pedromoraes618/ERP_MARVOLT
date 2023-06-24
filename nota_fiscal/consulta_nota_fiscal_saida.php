<?php
include("../conexao/sessao.php");
require_once("../conexao/conexao.php");
require_once("../_incluir/funcoes.php");


//consultar nota fiscal
if (isset($_GET["campoPesquisa"]) && ["campoPesquisaData"] && ["campoPesquisaDataf"]) {

    $pesquisaData = $_GET["campoPesquisaData"];
    $pesquisaDataf = $_GET["campoPesquisaDataf"];

    $pesquisaData =  formatarDataParaBancoDeDados($pesquisaData);
    $pesquisaDataf =  formatarDataParaBancoDeDados($pesquisaDataf);
    $pesquisa = $_GET["campoPesquisa"];
    $pesquisaNnfe = $_GET["CampoPesquisNnfe"];

    $select = " SELECT codigo_nf, nfe_saidaID,numero_nf,razao_social,finalidade_id,clt.nome_fantasia as nome_fantasia,clt.cpfcnpj as cnpj,
    cnpj_cpf,prot_autorizacao,data_entrada,data_emissao,valor_total_nota,valor_total_produtos,valor_desconto from tb_nfe_saida as nfes inner join 
    clientes as clt on clt.clienteID = nfes.cliente_id
     WHERE data_entrada BETWEEN '$pesquisaData' and '$pesquisaDataf' and  numero_nf  LIKE '%{$pesquisaNnfe}%' and  
     clt.nome_fantasia  LIKE '%{$pesquisa}%' ORDER BY numero_nf";
    $resultado = mysqli_query($conecta, $select);
}


//recuperar valores via get
if (isset($_GET["campoPesquisaData"])) {
    $pesquisaData = $_GET["campoPesquisaData"];
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
            <!-- <a onclick="window.open('importaXML/upload_nfe_saida.php', 
'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">
                <input type="submit" style="width:120px;" name="importar_xml" value="Importar_xml">
            </a> -->



            <form style="width:100%;" action="" method="get">

                <input style="width: 100px; " type="text" id="campoPesquisaData" name="campoPesquisaData" placeholder="Data incial" onkeyup="mascaraData(this);" value="<?php if (!isset($_GET["campoPesquisa"])) {
                                                                                                                                                                            echo formatardataB(date('Y-m-01'));
                                                                                                                                                                        }
                                                                                                                                                                        if (isset($_GET["campoPesquisaData"])) {
                                                                                                                                                                            echo $pesquisaData;
                                                                                                                                                                        } ?>">



                <input style=" width: 100px;" type="text" name="campoPesquisaDataf" placeholder="Data final" onkeyup="mascaraData(this);" value="<?php if (!isset($_GET["campoPesquisa"])) {
                                                                                                                                                        echo date('d/m/Y');
                                                                                                                                                    }
                                                                                                                                                    if (isset($_GET["campoPesquisaDataf"])) {
                                                                                                                                                        echo $pesquisaDataf;
                                                                                                                                                    } ?>">

                <input style="width: 100px; margin-left:50px" type="text" name="CampoPesquisNnfe" placeholder="N° Nfe" value="<?php if (isset($_GET['CampoPesquisNnfe'])) {
                                                                                                                                    echo $pesquisaNnfe;
                                                                                                                                } ?>">

                <input style="margin-left:150px;" type="text" name="campoPesquisa" value="<?php if (isset($_GET['campoPesquisa'])) {
                                                                                                echo $pesquisa;
                                                                                            } ?>" placeholder="Pesquisa / Empresa">
                <input type="image" name="pesquisa" src="https://img.icons8.com/ios/50/000000/search-more.png" />




            </form>


        </div>



        <table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
            <tbody>
                <tr id="cabecalho_pesquisa_consulta">

                    <td>
                        <p>Data</p>
                    </td>
                    <td>
                        <p>Nº NFE</p>
                    </td>


                    <td>
                        <p>Empresa</p>
                    </td>


                    <td>
                        <p>Data emissão</p>
                    </td>
                    <td>
                        <p>Vlr produtos</p>
                    </td>
                    <td>
                        <p>Desconto</p>
                    </td>

                    <td>
                        <p>Vlr Nota</p>
                    </td>

                    <td>
                        <p>Nº protocolo</p>
                    </td>

                    <td>
                        <p>Status</p>
                    </td>

                    <td>

                    </td>
                    <td>

                    </td>



                </tr>
            </tbody>
            <tbody>
                <?php
                if (isset($_GET["campoPesquisaData"])) {

                    $valor_total_nota = 0;
                    while ($linha = mysqli_fetch_assoc($resultado)) {

                        $nfeID = $linha["nfe_saidaID"];
                        $numeroNF = $linha["numero_nf"];
                        $nome_fantasia = $linha["nome_fantasia"];
                        $cnpj = $linha["cnpj"];
                        $protocolo = $linha["prot_autorizacao"];
                        $dataEntrada = $linha["data_entrada"];
                        $dataEmissao = $linha["data_emissao"];
                        $valorNota = $linha["valor_total_nota"];
                        $valorProduto = $linha["valor_total_produtos"];
                        $valorDesconto = $linha["valor_desconto"];
                        $status = $linha['finalidade_id'];
                        $codigo_nf = $linha['codigo_nf'];

                        if ($status == "1" and $protocolo == "") {
                            $status = "Em digitação";
                            //serie da nota fiscal - finalidade 1 - serie 0, demais finalidade serie 1
                            $update = "UPDATE tb_nfe_saida set serie = '0' WHERE nfe_saidaID = '$nfeID' ";
                            $operacao_update_serie = mysqli_query($conecta, $update);
                        } elseif ($status == "1" and $protocolo !== "") {
                            // $update = "UPDATE tb_nfe_saida set serie = '0' WHERE nfe_saidaID = '$nfeID' ";
                            // $operacao_update_serie = mysqli_query($conecta, $update);
                            $status = "Autorizada";
                        } elseif ($status == "2") {
                            $status = "Complementar";
                        } elseif ($status == "3") {
                            $status = "Ajuste";
                        } elseif ($status == "4") {
                            $status = "Devolução";
                        } elseif ($status == "5") {
                            $status = "Cancelado";
                        }

                        $valor_total_nota = $valorNota + $valor_total_nota;
                        // $select ="SELECT * FROM clientes where cpfcnpj = '$cnpj' ";
                        // $consultar_cliente = mysqli_query($conecta,$select);
                        // $linha = mysqli_fetch_assoc($consultar_cliente);
                        // $cliente_id = $linha['clienteID'];

                        // $update = "UPDATE tb_nfe_saida set cliente_id = '$cliente_id' WHERE cnpj_cpf = '$cnpj' ";
                        // $operacao_update_cnpj = mysqli_query($conecta,$update);


                        // $select ="SELECT * FROM tb_nfe_saida where nfe_saidaID = '$nfeID' ";
                        // $consulta_data_emissao = mysqli_query($conecta,$select);
                        // $linha = mysqli_fetch_assoc($consulta_data_emissao);
                        // $dt_emissao = $linha['data_emissao'];

                        // $update = "UPDATE tb_nfe_saida set data_entrada = '$dt_emissao' WHERE nfe_saidaID = '$nfeID' ";
                        // $operacao_update_dt_emissao = mysqli_query($conecta,$update);

  



                ?>


                        <tr id="linha_pesquisa">

                            <td>
                                <font size="2"> <?php echo formatDateB($dataEntrada) ?></font>
                            </td>
                            <td>
                                <p>
                                    <font size="3"><?php echo  $numeroNF; ?>
                                    </font>
                                </p>
                            </td>




                            <td>
                                <font size="2"><?php echo utf8_encode($nome_fantasia) ?></font>
                            </td>

                            <td>
                                <font size="2"> <?php echo formatardataB2($dataEmissao) ?></font>
                            </td>

                            <td>
                                <font size="2"> <?php echo real_format($valorProduto) ?></font>
                            </td>
                            <td>
                                <font size="2"> <?php echo real_format($valorDesconto) ?></font>
                            </td>


                            <td>
                                <font size="2"> <?php echo real_format($valorNota) ?></font>
                            </td>
                            <td>
                                <font size="2"> <?php echo ($protocolo) ?>
                                </font>
                            </td>

                            <td><?php echo $status; ?></td>


                            <td>
                                <a onclick="window.open('nfe_saida/nfe_tela.php?numero_nf=<?php echo $numeroNF; ?>&codigo_nf=<?php echo $codigo_nf; ?>&id=<?php echo $nfeID; ?>', 
'editar_nota_fiscal', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1700, HEIGHT=1000');">
                                    <button type="button" name="Editar">Editar</button>
                                </a>
                            </td>

                            <td>
                                <a onclick="window.open('nfe_saida/fiscal.php?numero_nf=<?php echo $numeroNF; ?>&codigo_nf=<?php echo $codigo_nf; ?>&id=<?php echo $nfeID; ?>', 
'operacao_Fiscal', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1600, HEIGHT=900');">
                                    <button style="background-color:black;color:white" type="button" name="Editar">Fiscal</button>
                                </a>
                            </td>
                        </tr>

                    <?php

                    }

                    ?>
            </tbody>

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
                <td>
                    <p></p>
                </td>
                <td>
                    <p></p>
                </td>


                <td>
                    <p></p>
                </td>
                <td>
                    <p><?php echo real_format($valor_total_nota); ?></p>
                </td>
                <td>
                    <p></p>
                </td>


                <td>
                    <p> </p>
                </td>


                <td>

                </td>

                <td>

                </td>

            </tr>

        <?php

                }
        ?>


        </table>



    </main>

</body>
<?php include '../_incluir/funcaojavascript.jar'; ?>

</html>

<?php
// Fechar conexao
mysqli_close($conecta);
?>