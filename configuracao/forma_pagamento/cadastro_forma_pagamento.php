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

$Select = "SELECT * from tb_conta_financeira ";
$consultar_contas_fi = mysqli_query($conecta, $Select);

if (isset($_POST['enviar'])) {
    $descricao = utf8_decode($_POST['txtFormaPagamento']);
    $banco = utf8_decode($_POST['txtBanco']);
    $tipo = utf8_decode($_POST['tipo']);


    if ($descricao == "") {
?>
        <script>
            alertify.alert("Favor informe a descrição");
        </script>
    <?php
    } elseif (!isset($_POST['status'])) {
    ?>
        <script>
            alertify.alert("Favor informar o status");
        </script>
        <?php
    } elseif ($tipo =="0") {
        ?>
            <script>
                alertify.alert("Favor informar o tipo");
            </script>
            <?php
        } else {
        $status = ($_POST['status']);
        //inserindo as informações no banco de dados
        $inserir = "INSERT INTO forma_pagamento ";
        $inserir .= "(nome,banco,statuspagamento,tipo)";
        $inserir .= " VALUES ";
        $inserir .= "('$descricao','$banco','$status','$tipo' )";

        $operacao_inserir = mysqli_query($conecta, $inserir);
        if (!$operacao_inserir) {
            die("Erro no banco de dados || inserir na tabela forma_pagamento ");
        } else {
            $descricao = "";
            $banco = 0;
        ?>
            <script>
                alertify.success("Forma de pagamento lançado com sucesso");
            </script>
<?php
        }
    }
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
                                <input readonly type="text" size=10 id="txtCodigo" name="txtCodigo" disabled value="">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label for="txtFormaPagamento" style="width:115px;"> <b>Descrição:</b></label>
                                <input type="text" size=50 name="txtFormaPagamento" id="txtFormaPagamento" value="<?php if (isset($_POST['enviar'])) {
                                                                                                                        echo utf8_encode($descricao);
                                                                                                                    } ?>">

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtBanco" style="width:115px; "> <b>Banco:</b></label>
                                <select style="width: 150px;margin-bottom: 11px" id="txtBanco" name="txtBanco">
                                    <option value="0">Selecione</option>
                                    <?php
                                    while ($linha = mysqli_fetch_assoc($consultar_contas_fi)) {
                                        $id = $linha['cl_id'];
                                        $banco = $linha['cl_banco'];

                                            echo "<option  value='$id'>$banco</option>";
                                        
                                    }

                                    ?>

                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtBanco" style="width:115px;"> <b>Tipo:</b></label>
                                <select style="width: 300px;margin-bottom: 11px" id="tipo" name="tipo">
                                    <option value="0">Selecione</option>
                                    <option value="1">Dinheiro</option>
                                    <option value="2">Cheque</option>
                                    <option value="3">Cartão de Crédito</option>
                                    <option value="4">Cartão de Débito</option>
                                    <option value="15">Boleto Bancário</option>
                                    <option value="17">Pagamento Instantâneo (PIX)</option>
                                    <option value="18">Transferência bancária, Carteira Digital</option>
                                    <option value="99">Outros</option>
                                 
                                
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="txtStatus" style="width:115px;"> <b>Status:</b></label>
                                <input type="radio" name="status" value="A RECEBER"> A Receber
                                <input type="radio" name="status" value="RECEBIDO"> Recebido


                            </td>
                        </tr>
                    </div>
                    <tr>

                        <td>
                            <div style="margin-left: 120px;margin-top:10px">
                                <input type="submit" name=enviar value="Incluir" class="btn btn-info btn-sm" onClick="return confirm('Confirmar o cadastro da Forma de pagamento?');"></input>

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