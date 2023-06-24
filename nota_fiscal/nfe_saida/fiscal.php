<?php
include "../../conexao/sessao.php";
include "../../conexao/conexao.php";
include "crud/gerenciar_nfe.php";

if ((isset($_GET['numero_nf'])) and (isset($_GET['codigo_nf']))) {
    $numero_nf = $_GET['numero_nf'];
    $codigo_nf = $_GET['codigo_nf'];
    $id = $_GET['id'];
} else {
    $numero_nf = "";
    $codigo_nf = "";
    $id = "";
}


// if (isset($_POST['enviar_nf'])) {
//     date_default_timezone_set('America/Fortaleza');
//     $data = date('Y/m/d H:i:s');

//     // echo $data;
//     $server = "https://homologacao.focusnfe.com.br";
//     // Substituir a variável, ref, pela sua identificação interna de nota.
//     $ref = "8";
//     $login = "2HSFkz0zl8MzSYnJSR0Zzi7Zu28htUVR";
//     $password = "";
//     $nfe = array(
//         "natureza_operacao" => "VENDA MERCADORIA",
//         "data_emissao" => "$data",
//         "data_entrada_saida" => "$data",
//         "tipo_documento" => "1",
//         "finalidade_emissao" => "1",
//         "cnpj_emitente" => "34226833000198",
//         "nome_emitente" => "MARVOLT SOLUÇÕES INDUSTRIAIS",
//         "nome_fantasia_emitente" => "Marvolt",
//         "logradouro_emitente" => "Estrada de Ribamar",
//         "numero_emitente" => "100",
//         "bairro_emitente" => "Ubatuba Laranjal",
//         "municipio_emitente" => "PACO DO LUMIAR",
//         "uf_emitente" => "MA",
//         "cep_emitente" => "65130000",
//         "inscricao_estadual_emitente" => "126093636",
//         "nome_destinatario" => "NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL",
//         "cpf_destinatario" => "51966818092",
//         "telefone_destinatario" => "1196185555",
//         "logradouro_destinatario" => "Rua S\u00e3o Janu\u00e1rio",
//         "numero_destinatario" => "99",
//         "bairro_destinatario" => "Crespo",
//         "municipio_destinatario" => "Manaus",
//         "uf_destinatario" => "AM",
//         "pais_destinatario" => "Brasil",
//         "cep_destinatario" => "69073178",
//         "valor_frete" => "0.0",
//         "valor_seguro" => "0",
//         "valor_total" => "47.23",
//         "valor_produtos" => "47.23",
//         "modalidade_frete" => "0",
//         "items" => array(
//             array(
//                 "numero_item" => "1",
//                 "codigo_produto" => "1232",
//                 "descricao" => "Cartu00f5es de Visita",
//                 "cfop" => "6923",
//                 "unidade_comercial" => "un",
//                 "quantidade_comercial" => "100",
//                 "valor_unitario_comercial" => "0.4723",
//                 "valor_unitario_tributavel" => "0.4723",
//                 "unidade_tributavel" => "un",
//                 "codigo_ncm" => "49111090",
//                 "quantidade_tributavel" => "100",
//                 "valor_bruto" => "47.23",
//                 "icms_situacao_tributaria" => "400",
//                 "icms_origem" => "0",
//                 "pis_situacao_tributaria" => "07",
//                 "cofins_situacao_tributaria" => "07"
//             )
//         ),
//     );

//     // Inicia o processo de envio das informações usando o cURL.

//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


//     curl_setopt($ch, CURLOPT_URL, $server . "/v2/nfe?ref=" . $ref);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($ch, CURLOPT_POST, 1);
//     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($nfe));
//     curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//     curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
//     $body = curl_exec($ch);
//     $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     print($http_code."\n");
//     print($body."\n\n");
//     print("");
//     curl_close($ch);


//     // echo $txtretorno;
// } elseif (isset($_POST['consultar_nf'])) {
//     $server = "https://homologacao.focusnfe.com.br";
//     // Substituir a variável, ref, pela sua identificação interna de nota.
//     $ref = "8";
//     $login = "2HSFkz0zl8MzSYnJSR0Zzi7Zu28htUVR";
//     $password = "";
//     // Inicia o processo de envio das informações usando o cURL.
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//     curl_setopt($ch, CURLOPT_URL, $server . "/v2/nfe/" . $ref);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($ch, CURLOPT_HTTPHEADER, array());
//     curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//     curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
//     $body = curl_exec($ch);
//     $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     // As próximas três linhas são um exemplo de como imprimir as informações de retorno da API.
//     print($http_code . "\n");
//     print($body . "\n\n");
//     echo $body;
//     curl_close($ch);
//     echo "https://homologacao.focusnfe.com.br/arquivos_development/34226833000197/202306/DANFEs/21230634226833000197550010000000011655237808.pdf";
// }
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <head>
        <link href="../../_css/tela_bootstrap.css" rel="stylesheet">
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
        <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- icons bootstrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
        <link rel="icon" type="img/icon.svg" href="img/icon.png">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>

</head>

<body>
    <div class="bloco_principal">
        <div class="row m-0 mb-3">
            <div class="col-md p-2  card p-2">
                <h5 class="fw-bold">Operações fiscais</h5>
            </div>

        </div>

        <div class="card">
            <form method="POST" class="form_principal" id="nota_fsical">

                <div class="col-md mb-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                        <button type="button" name="enviar_nf" id="enviar_nf" class="btn btn-sm btn-success">Enviar NF</button>
                        <button type="button" name="consultar_pdf_nf" id="consultar_pdf_nf" class="btn btn-sm btn-info">Consultar Pdf NF</button>
                        <button type="button" name="consultar_xml_nf" id="consultar_xml_nf" class="btn btn-sm btn-info">Consultar Xml NF</button>

                        <button type="button" id="cancelar_nf" class="btn btn-sm btn-danger">Cancelar NF</button>

                        <button type="button" class="btn btn-sm btn-secondary" onclick="window.opener.location.reload(); window.close();" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-2 mb-2">
                        <input type="hidden" id="codigo_nf" name="codigo_nf" value="<?php echo $codigo_nf ?>">
                        <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                        <label for="numero_nf" class="form-label">Nº NF</label>
                        <input type="text" readonly class="form-control" id="numero_nf" name="numero_nf" value="<?php echo $numero_nf; ?>">
                    </div>
                    <div class="col-md mb-2">
                        <label for="cliente" class="form-label">Cliente</label>
                        <input type="text" readonly class="form-control" id="cliente" name="cliente" value="">
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-md-2 mb-2">
                        <label for="data_emissao" class="form-label">Valor</label>
                        <input type="text" readonly class="form-control" id="valor" name="valor" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="data_emissao" class="form-label">Desconto</label>
                        <input type="text" readonly class="form-control" id="desconto" name="desconto" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="data_emissao" class="form-label">Valor total</label>
                        <input type="text" readonly class="form-control" id="valor_total" name="valor_total" value="">
                    </div>

                </div>
                <div class="row mb-2">

                    <div class="col-md mb-2">
                        <label for="chave_acesso" class="form-label">Chave de acesso</label>
                        <input type="text" readonly class="form-control" id="chave_acesso" name="chave_acesso" value="">
                    </div>
                    <div class="col-md mb-2">
                        <label for="nprotocolo" class="form-label">Nº protocolo</label>
                        <input type="text" readonly class="form-control" id="nprotocolo" name="nprotocolo" value="">
                    </div>

                </div>
            </form>


            <div class="tabela_externa"></div>
        </div>
        <div class="modal_externo"></div>
    </div>


    <script src="../../jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="js/gerenciar_fiscal.js"></script>
</body>

</html>