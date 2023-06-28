<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->

<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css" />
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css" />
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css" />
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css" />

<?php
require_once("../../conexao/conexao.php");

include("../../conexao/sessao.php");

$hoje = date('Y-d-m');
echo ".";

if (isset($_GET['codigo'])) {
    $codigoID = ($_GET['codigo']);
}


$Select = "SELECT * from tb_conta_financeira ";
$consultar_contas_fi = mysqli_query($conecta, $Select);

if (isset($_POST['enviar'])) {
    $descricao = utf8_decode($_POST['txtFormaPagamento']);
    $banco = utf8_decode($_POST['txtBanco']);
    $tipo = ($_POST['tipo']);


    if ($descricao == "") {
?>
        <script>
            alertify.alert("Favor informe a descrição");
        </script>
    <?php
    } elseif (!isset($_POST['status'])) {
    ?>
        <script>
            alertify.alert("Favor informe o status");
        </script>
    <?php
    } elseif ($tipo == "0") {
    ?>
        <script>
            alertify.alert("Favor informe o tipo");
        </script>
        <?php
    } else {
        $status = utf8_decode($_POST['status']);
        //inserindo as informações no banco de dados
        $update = "UPDATE forma_pagamento set nome = '{$descricao}', banco = '{$banco}', statuspagamento = '{$status}', tipo='$tipo'  where formapagamentoID = '{$codigoID}'  ";
        $operacao_update = mysqli_query($conecta, $update);
        if (!$operacao_update) {
            die("Erro no banco de dados || update na tabela forma_pagamento ");
        } else {
        ?>
            <script>
                alertify.success("Dados alterado com sucesso");
            </script>
<?php
        }
    }
}


$select = "SELECT * FROM forma_pagamento where formapagamentoID = '$codigoID'";
$operacao_select = mysqli_query($conecta, $select);
if ($operacao_select) {
    $linha = mysqli_fetch_assoc($operacao_select);
    $fomaPagamentoID = $linha['formapagamentoID'];
    $formaPagamentoB = utf8_encode($linha['nome']);
    $bancoB = utf8_encode($linha['banco']);
    $statusB = $linha['statuspagamento'];
    $tipo_b = $linha['tipo'];
} else {
    die("Erro no banco de dados");
}



?>
<!doctype html>

<html>



<head>
    <meta charset="UTF-8">
    <!-- estilo -->

    <link href="../../_css/tela_cadastro_editar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>

<body>
    <div id="titulo">
        </p>Forma de Pagamento</p>
    </div>
    <main>
        <div style="margin:0 auto; width:700px; float:left ">
            <form action="" method="post">

                <table style="float:left; width:700px;">
                    <div style="width: 700px; ">

                        <tr>
                            <td>
                                <label for="txtCodigo" style="width:115px;"> <b>Código:</b></label>
                                <input readonly type="text" size=10 id="txtCodigo" name="txtCodigo" value="<?php echo $codigoID; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="txtFormaPagamento" style="width:115px;"> <b>Descrição;</b></label>
                                <input type="text" size=50 name="txtFormaPagamento" id="txtFormaPagamento" value="<?php echo $formaPagamentoB; ?>">

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtBanco" style="width:115px; "> <b>Banco:</b></label>
                                <select style="width: 150px;margin-bottom: 9px" id="txtBanco" name="txtBanco">
                                    <option value="0">Selecione</option>
                                    <?php
                                    while ($linha = mysqli_fetch_assoc($consultar_contas_fi)) {
                                        $id = $linha['cl_id'];
                                        $banco = $linha['cl_banco'];

                                        if (($bancoB == $id)) {
                                            echo "<option selected value='$id'>$banco</option>";
                                        } else {
                                            echo "<option value='$id'>$banco</option>";
                                        }
                                    }

                                    ?>

                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtStatus" style="width:115px;"> <b>Status:</b></label>
                                <input type="radio" name="status" value="A RECEBER" <?php if ($statusB == "A RECEBER") {
                                                                                    ?> checked <?php
                                                                                            } ?>> A Receber
                                <input type="radio" name="status" value="RECEBIDO" <?php if ($statusB == "RECEBIDO") {
                                                                                    ?> checked <?php
                                                                                            } ?>> Recebido


                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtBanco" style="width:115px;"> <b>Tipo:</b></label>
                                <select style="width: 300px;margin-bottom: 11px" id="tipo" name="tipo">
                                    <option value="0">Selecione</option>
                                    <option <?php if ($tipo_b == "01") {
                                                echo 'selected';
                                            } ?> value="01">Dinheiro</option>
                                    <option <?php if ($tipo_b == "02") {
                                                echo 'selected';
                                            } ?> value="02">Cheque</option>
                                    <option <?php if ($tipo_b == "03") {
                                                echo 'selected';
                                            } ?> value="03">Cartão de Crédito</option>
                                    <option <?php if ($tipo_b == "04") {
                                                echo 'selected';
                                            } ?> value="04">Cartão de Débito</option>
                                    <option <?php if ($tipo_b == "15") {
                                                echo 'selected';
                                            } ?> value="15">Boleto Bancário</option>
                                    <option <?php if ($tipo_b == "17") {
                                                echo 'selected';
                                            } ?> value="17">Pagamento Instantâneo (PIX)</option>
                                    <option <?php if ($tipo_b == "18") {
                                                echo 'selected';
                                            } ?> value="18">Transferência bancária, Carteira Digital</option>
                                    <option <?php if ($tipo_b == "99") {
                                                echo 'selected';
                                            } ?> value="99">Outros</option>


                                </select>

                            </td>
                        </tr>
                    </div>
                    <tr>

                        <td>
                            <div style="margin-left: 120px;margin-top:10px">
                                <input type="submit" name=enviar value="Alterar" class="btn btn-info btn-sm"></input>

                                <button type="button" onclick="window.opener.location.reload();fechar();" class="btn btn-secondary">Voltar</button>
                            </div>

                        </td>

                </table>
    </main>
    <script>
        function fechar() {
            window.close();
        }
    </script>


</body>

</html>