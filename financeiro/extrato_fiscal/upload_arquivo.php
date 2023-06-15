<?php
include("../../conexao/conexao.php");
include("../../_incluir/funcoes.php");

$Select = "SELECT * from tb_conta_financeira ";
$consultar_contas_fi = mysqli_query($conecta, $Select);


?>





<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- estilo -->
    <link href="../../_css/tela_cadastro_editar.css" rel="stylesheet">
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>
</head>

<body>

    <main>
        <div style="margin:0 auto;width:1000px">
            <form method="post" action="entrada_arquivo.php" method="post" enctype="multipart/form-data">
                <table>
                    <div id="titulo">
                        </p>Importar arquivo Ofx</p>
                        <tr>
                            <td>

                                <input type="file" name="arquivo" id="file">
                                <button type="submit" name="upload" class="btn btn-primary">upload Arquivo ofx</button>

                            </td>
                            <td align=left> <button type="button" name="btnfechar" onclick="window.opener.location.reload();fechar();" class="btn btn-secondary">Voltar</button>
                            </td>
                        </tr>
                    </div>
                </table>
                <hr>
                <div class="bloco-input">

                    <div class="group-input">
                        <select id="campoBanco" name="campoBanco">
                            <option value="0">Selecione o Banco</option>
                            <?php
                            while ($linha = mysqli_fetch_assoc($consultar_contas_fi)) {
                                $id = $linha['cl_id'];
                                $banco = $linha['cl_banco'];

                                echo "<option value='$id'>$banco</option>";
                            }

                            ?>
                        </select>
                    </div>




                </div>
            </form>


        </div>
    </main>
</body>

</html>
<script>
    function fechar() {
        window.close();
    }
</script>