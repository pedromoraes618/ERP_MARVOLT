<?php
include("../../conexao/sessao.php");
require_once("../../conexao/conexao.php");


$Select = "SELECT * from tb_conta_financeira ";
$consultar_contas_fi = mysqli_query($conecta, $Select);


// //consultar nota fiscal
if ($_GET) {
    //recuperar valores dos campos via $post
    $pesquisaData = $_GET["campoPesquisaData"];
    $pesquisaDataf = $_GET["campoPesquisaDataf"];
    $pesquisaDoc = $_GET["CampoPesquisaDoc"];
    $pesquisa = $_GET["campoPesquisa"];
    $instuicao = $_GET["instuicao"];
    $tipo = $_GET['tipo'];


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



    //select nas notas fiscais
    $select = " SELECT ext.cl_id,ext.cl_codigo,ext.cl_tipo,ext.cl_data,ext.cl_doc,ext.cl_descricao,ext.cl_valor,ctf.cl_banco as banco from tb_extrato_fiscal as ext inner join tb_conta_financeira as ctf on ctf.cl_id = ext.cl_conta_financeira
     WHERE ext.cl_data BETWEEN '$pesquisaData' and '$pesquisaDataf' and ext.cl_doc LIKE '%{$pesquisaDoc}%'  and ext.cl_descricao  LIKE '%{$pesquisa}%'  ";
    if ($instuicao != '0') {
        $select .= " and cl_conta_financeira = '$instuicao' ";
    }
    if ($tipo != '0') {
        $select .= " and ext.cl_tipo ='$tipo' ";
    }
    $select .= " ORDER BY ext.cl_data ";

    $consulta_tabela = mysqli_query($conecta, $select);
    if (!$consulta_tabela) {
        die("Falha na consulta ao banco de dados select");
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
    <link href="../../_css/estilo.css" rel="stylesheet">
    <link href="../../_css/pesquisa_tela.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <a href="https://icons8.com/icon/59832/cardápio"></a>
</head>

<body>
    <?php include_once("../../_incluir/topo.php"); ?>
    <?php include("../../_incluir/body.php"); ?>
    <?php include_once("../../_incluir/funcoes.php"); ?>


    <main>

        <div id="janela_pesquisa">
            <ul>
                <li>
                    <b> Data movimentação</b>
                </li>

            </ul>


            <form style="width:100%;" action="" method="get">


                <a onclick="window.open('upload_arquivo.php', 
'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">
                    <input type="submit" style="width: 120px;" value="Importar arquivo">
                </a>

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

                <input style="width: 100px; margin-left:50px" type="text" name="CampoPesquisaDoc" placeholder="N° doc" value="<?php if (isset($_GET['CampoPesquisaDoc'])) {
                                                                                                                                    echo $pesquisaDoc;
                                                                                                                                } ?>">

                <input style="margin-left:150px;" type="text" name="campoPesquisa" value="<?php if (isset($_GET['campoPesquisa'])) {
                                                                                                echo $pesquisa;
                                                                                            } ?>" placeholder="Pesquisa / Descrição">
                <input type="image" name="pesquisa" src="https://img.icons8.com/ios/50/000000/search-more.png" />


                <td>

                    <select style="width: 120px; float:right; margin-right:70px;" id="instuicao" name="instuicao">
                        <option value="0">Instituição..</option>
                        <?php
                        while ($linha = mysqli_fetch_assoc($consultar_contas_fi)) {
                            $id = $linha['cl_id'];
                            $banco = $linha['cl_banco'];

                            if (($_GET) and ($instuicao == $id)) {
                                echo "<option selected value='$id'>$banco</option>";
                            } else {
                                echo "<option value='$id'>$banco</option>";
                            }
                        }

                        ?>

                    </select>
                </td>

                <td>

                    <select style="width: 120px; float:right;;" id="tipo" name="tipo">
                        <option value="0">Tipo..</option>
                        <option <?php echo (($_GET) and ($tipo == "Entrada") ) ? 'selected':''; ?> value="Entrada">Entrada</option>
                        <option <?php echo (($_GET) and ($tipo == "Saida") ) ? 'selected':'';?> value="Saida">Saida</option>
                    </select>
                </td>

            </form>


        </div>
        <form action="consulta_financeiro.php" method="get">

            <table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
                <tbody>
                    <tr id="cabecalho_pesquisa_consulta">


                        <td>
                            <p>Código</p>
                        </td>

                        <td>
                            <p>Data Movimentação</p>
                        </td>
                        <td>
                            <p>Doc</p>
                        </td>
                        <td>
                            <p>Descrição</p>
                        </td>
                        <td>
                            <p>Instituição</p>
                        </td>
                        <td>
                            <p>Tipo</p>
                        </td>

                        <td>
                            <p>Valor</p>
                        </td>

                        <td>
                            <p></p>
                        </td>




                    </tr>

                </tbody>
                <tbody>

                    <?php
                    if ($_GET) {
                        $saldo_saida = 0;
                        $saldo_entrada = 0;
                        while ($linha = mysqli_fetch_assoc($consulta_tabela)) {
                            $id = $linha['cl_id'];
                            $codigo = $linha['cl_codigo'];
                            $data = $linha['cl_data'];
                            $doc = $linha['cl_doc'];
                            $descricao = $linha['cl_descricao'];
                            $valor = $linha['cl_valor'];
                            $tipo = $linha['cl_tipo'];
                            $banco = $linha['banco'];

                            if ($tipo == "Entrada") {
                                $saldo_entrada = $saldo_entrada + $valor;
                            } else {
                                $saldo_saida = $saldo_saida + $valor;
                            }
                    ?>
                            <tr id="linha_pesquisa">
                                <td>
                                    <p><?php echo $codigo ?></p>
                                </td>
                                <td><?php echo formatDateB($data) ?></td>
                                <td><?php echo $doc ?></td>
                                <td><?php echo $descricao ?></td>
                                <td><?PHP echo $banco; ?></td>
                                <td><?PHP echo $tipo; ?></td>

                                <td style='color:<?php echo ($tipo == "Entrada") ? "green" : "red" ?>'><?php echo real_format($valor) ?></td>
                                <td><button type="button" style="background-color:red" id="remover" id_extrato="<?php echo $id; ?>" class="btn btn-sm btn-danger remover">Remover</button></td>
                            </tr>
                        <?php } ?>

                        <tr id="cabecalho_pesquisa_consulta">
                            <td>
                                <p>Total</p>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <p> <?php echo real_format($saldo_entrada - $saldo_saida) ?></p>
                            </td>
                            <td></td>

                        </tr>



                    <?php
                    } ?>
                </tbody>

            </table>

        </form>

    </main>

</body>
<?php include '../../_incluir/funcaojavascript.jar'; ?>
<script src="../../jquery.js"></script>
<script>
    $(".remover").click(function() {
        var id = $(this).attr("id_extrato")
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja Remover esse doc",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                var elemento = $(this).parent().parent();
                $(elemento).fadeOut();
                var retorno = remover(id)
            }
        })
    })


    function remover(dados) {
        $.ajax({
            type: "POST",
            data: "id_doc=" + dados,
            url: "crud/gerenciar_arquivo.php",
            async: false
        }).then(sucesso, falha);

        function sucesso(data) {

            $dados = $.parseJSON(data)["dados"];

            if ($dados.sucesso == true) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: $dados.title,
                    showConfirmButton: false,
                    timer: 3500
                })

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Verifique!',
                    text: $dados.title,
                    timer: 7500,

                })
            }


        }

        function falha() {
            console.log("erro");
        }

    }
</script>

</html>

<?php
// Fechar conexao
mysqli_close($conecta);
?>