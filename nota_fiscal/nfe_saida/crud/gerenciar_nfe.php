<?php

if (isset($_GET['consultar_tabela_prod_nf'])) {
    include "../../../_incluir/funcoes.php";
    $codigo_nf = $_GET['codigo_nf'];
    $numero_nf = $_GET['numero_nf'];
    $select  = "SELECT * FROM tb_nfe_saida_item where numero_nf= '$numero_nf' and codigo_nf= '$codigo_nf'";
    $consulta_prod_nf = mysqli_query($conecta, $select);
}






if (isset($_POST['formulario_nota_fiscal'])) {
    include "../../../conexao/conexao.php";
    include "../../../_incluir/funcoes.php";
    $retornar = array();
    $acao = $_POST['acao'];
    if ($acao == "update") {
        $id_nf = $_POST['id'];
        $codigo_nf = $_POST['codigo_nf'];
        $finalidade = $_POST['finalidade'];
        $fpagamento = $_POST['fpagamento'];
        $cfop = $_POST['cfop'];
        $numero_pedido = $_POST['numero_pedido'];
        $frete = $_POST['frete'];
        $parceiro_id = $_POST['parceiro_id'];
        $transportadora_id = $_POST['transportadora_id'];
        $placa = $_POST['placa'];
        $uf_veiculo = $_POST['uf_veiculo'];
        $quantidade_trp = $_POST['quantidade_trp'];
        $especie = $_POST['especie'];
        $peso_bruto = $_POST['peso_bruto'];
        $peso_liquido = $_POST['peso_liquido'];
        $vfrete = $_POST['vfrete'];
        $outras_despesas = $_POST['outras_despesas'];

        $desconto_nota = $_POST['desconto_nota'];
        $observacao = $_POST['observacao'];

        if ($id_nf == "") {
            $retornar["dados"] = array("sucesso" => "false", "title" => "Nfe sem o id, verifique com o suporte");
        } elseif ($finalidade == "0") {
            $retornar["dados"] = array("sucesso" => "false", "title" => mensagem_alerta_cadastro("finalidade"));
        } elseif ($fpagamento == "0") {
            $retornar["dados"] = array("sucesso" => "false", "title" => mensagem_alerta_cadastro("forma de pagamento"));
        } elseif ($frete == "0") {
            $retornar["dados"] = array("sucesso" => "false", "title" => mensagem_alerta_cadastro("frete"));
        } elseif ($cfop == "0") {
            $retornar["dados"] = array("sucesso" => "false", "title" => mensagem_alerta_cadastro("natureza de operação"));
        } else {

            $valor_total_produtos = verificar_total_valores_nf($conecta, "tb_nfe_saida_item", "codigo_nf", $codigo_nf);
            $valor_total_nota = $valor_total_produtos + $outras_despesas - $desconto_nota;

            $update = "UPDATE `marvolt`.`tb_nfe_saida` SET `numero_pedido` = '$numero_pedido', `cfop` = '$cfop', `serie` = '1', 
            `cliente_id` = '$parceiro_id', `valor_frete` = '$vfrete', `tipo_frete` = '$frete', `outras_despesas` = '$outras_despesas', `transportadora_id` = '$transportadora_id',
             `placa` = '$placa', `uf_veiculo` = '$uf_veiculo', `quantidade_tra` = '$quantidade_trp', `especie_tra` = '$especie',  `peso_bruto` = '$peso_bruto',
              `peso_liquido` = '$peso_liquido', `valor_desconto` = '$desconto_nota', `valor_total_produtos` = '$valor_total_produtos', `valor_total_nota` = '$valor_total_nota', `finalidade_id` = '$finalidade',
             `forma_pagamento_id` = '$fpagamento', `observacao` = '$observacao' WHERE `tb_nfe_saida`.`nfe_saidaID` = $id_nf and codigo_nf ='$codigo_nf'";
            $operacao_update = mysqli_query($conecta, $update);
            if ($operacao_update) {
                desconto_rat($conecta, $codigo_nf, $desconto_nota); //rateio do desconto nos produtos
                $retornar["dados"] = array("sucesso" => true, "title" => "Nfe alterada com sucesso");
            }
        }
    }

    if ($acao == "show" or $acao == "resumo_nf") {
        $id_nf = $_POST['nf_id'];

        $select = "SELECT * from tb_nfe_saida where nfe_saidaID = $id_nf";
        $consultar_nf = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consultar_nf);
        $chave_acesso = ($linha['chave_acesso']);
        $data_emissao = ($linha['data_emissao']);
        $data_saida = ($linha['data_saida']);
        $parceiro_id = ($linha['cliente_id']);
        $finalidade_id = ($linha['finalidade_id']);
        $forma_pagamento = ($linha['forma_pagamento_id']);
        $cfop = ($linha['cfop']);
        $frete = ($linha['tipo_frete']);
        $protocolo = ($linha['prot_autorizacao']);
        $valor_total_produtos = $linha['valor_total_produtos'];
        $valor_total_produtos = $linha['valor_total_produtos'];
        $desconto_nota = $linha['valor_desconto'];
        $valor_total_nota = $linha['valor_total_nota'];
        $observacao = $linha['observacao'];
        $numero_pedido = $linha['numero_pedido'];

        /*transporadora */
        $placa = $linha['placa'];
        $uf_veiculo = $linha['uf_veiculo'];
        $quantidade_tra = $linha['quantidade_tra'];
        $especie_tra = $linha['especie_tra'];
        $quantidade_tra = $linha['quantidade_tra'];
        $peso_bruto = $linha['peso_bruto'];
        $peso_liquido = $linha['peso_liquido'];
        $outras_despesas = $linha['outras_despesas'];
        $valor_frete = $linha['valor_frete'];

        $parceiro_descricao =  verificar_valores($conecta, "clientes", "clienteID", $parceiro_id, "razaosocial");

        $transportadora_id = $linha['transportadora_id'];
        if ($transportadora_id != "") {
            $transportadora_descricao =  verificar_valores($conecta, "clientes", "clienteID", $transportadora_id, "razaosocial");
        } else {
            $transportadora_descricao = "";
        }

        $informacao = array(
            "chave_acesso" => $chave_acesso,
            "data_emissao" => formatDateB($data_emissao),
            "data_saida" => formatDateB($data_saida),
            "finalidade" => $finalidade_id,
            "fpagamento" => $forma_pagamento,
            "cfop" => $cfop,
            "frete" => $frete,
            "protocolo" => $protocolo,
            "parceiro_descricao" => $parceiro_descricao,
            "parceiro_id" => $parceiro_id,
            "placa" => $placa,
            "uf_veiculo" => $uf_veiculo,
            "quantidade_trp" => $quantidade_tra,
            "especie" => $especie_tra,
            "peso_bruto" => $peso_bruto,
            "peso_liquido" => $peso_liquido,
            "outras_despesas" => $outras_despesas,
            "vlr_total_produtos" => $valor_total_produtos,
            "desconto_nota" => $desconto_nota,
            "vlr_total_nota" => $valor_total_nota,
            "observacao" => $observacao,
            "transportadora_descricao" => $transportadora_descricao,
            "transportadora_id" => $transportadora_id,
            "vfrete" => $valor_frete,
            "npedido" => $numero_pedido,

        );



        $retornar["dados"] = array("sucesso" => true, "valores" => $informacao);
    }
    if (isset($_POST['nfe'])) {
        $ambiente = verficar_paramentro($conecta, "tb_parametros", "parametroID", "15"); //1- homologação 2 - produção

        date_default_timezone_set('America/Fortaleza');
        $data = date('Y/m/d H:i:s');

        if ($ambiente == "1") {
            $server = "https://homologacao.focusnfe.com.br";
            $login = "2HSFkz0zl8MzSYnJSR0Zzi7Zu28htUVR";
        } elseif ($ambiente == "2") {
            $server = "https://api.focusnfe.com.br";
            $login = "RCfEkn8VWRThB4MjmfrJ6AO8aMoFGqVG";
        } else {
            $server = "";
            $login = "";
        }
        $password = "";

        $id_nf = $_POST['id_nf'];
        $select = "SELECT * from tb_nfe_saida where nfe_saidaID = $id_nf";
        $consultar_nf = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consultar_nf);
        $numero_nf = ($linha['numero_nf']);
        $chave_acesso = ($linha['chave_acesso']);
        $data_emissao = ($linha['data_emissao']);
        $data_saida = ($linha['data_saida']);

        $finalidade_id = ($linha['finalidade_id']);
        $forma_pagamento = ($linha['forma_pagamento_id']);
        $cfop = ($linha['cfop']);
        $frete = ($linha['tipo_frete']);
        $protocolo = ($linha['prot_autorizacao']);
        $valor_total_produtos = $linha['valor_total_produtos'];
        $valor_total_produtos = $linha['valor_total_produtos'];
        $desconto_nota = $linha['valor_desconto'];
        $valor_total_nota = $linha['valor_total_nota'];
        $observacao = $linha['observacao'];
        $numero_pedido = $linha['numero_pedido'];

        /*transporadora */
        $placa = $linha['placa'];
        $uf_veiculo = $linha['uf_veiculo'];
        $quantidade_tra = $linha['quantidade_tra'];
        $especie_tra = $linha['especie_tra'];
        $quantidade_tra = $linha['quantidade_tra'];
        $peso_bruto = $linha['peso_bruto'];
        $peso_liquido = $linha['peso_liquido'];
        $outras_despesas = $linha['outras_despesas'];
        $valor_frete = $linha['valor_frete'];




        /*transportadora*/
        $transportadora_id = $linha['transportadora_id'];
        if ($transportadora_id != "") {
            $transportadora_descricao =  verificar_valores($conecta, "clientes", "clienteID", $transportadora_id, "razaosocial");
        } else {
            $transportadora_descricao = "";
        }


        /*cliente obrigatorio */
        $parceiro_id = ($linha['cliente_id']);
        /*emitente*/
        $select = "SELECT * FROM clientes where clienteID = $parceiro_id ";
        $consultar_emitente = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consultar_emitente);
        $parceiro_descricao =  verificar_valores($conecta, "clientes", "clienteID", $parceiro_id, "razaosocial");



        /*emitente*/
        $select = "SELECT * FROM empresa where empresaID = '1' ";
        $consultar_emitente = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consultar_emitente);
        $razao_social_emit = utf8_encode($linha['razao_social']);
        $nome_fantasia_emit = utf8_encode($linha['nome_fantasia']);
        $inscricao_estadual_emit = ($linha['inscricao_estadual']);
        $cnpj_emit = ($linha['cnpj']);
        $endereco_emit = utf8_encode($linha['endereco']);
        $bairro_emit = utf8_encode($linha['bairro']);
        $codigo_municipio_emit = ($linha['codigo_municipio']); //codigo
        $cidade_emit = utf8_encode($linha['cidade']);
        $estado_emit = utf8_encode($linha['estado']); //descricao
        $numero_emit = ($linha['numero']); //descricao
        $cep_emit = ($linha['cep']); //descricao
        $email_emit = ($linha['email']);
        $telefone_emit = ($linha['telefone']);
        $site_emit = utf8_encode($linha['site']);

        $ref = $numero_nf; //numero da nf
        if ($acao == "enviar_nf") {
            // Substituir a variável, ref, pela sua identificação interna de razao_social_emit.

            $nfe = array(
                "natureza_operacao" => "VENDA MERCADORIA",
                "data_emissao" => "$data",
                "data_entrada_saida" => "$data",
                "tipo_documento" => "1",
                "finalidade_emissao" => "1",
                "serie" => "1",
                "numero" => $ref,
                "cnpj_emitente" => "$cnpj_emit",
                "nome_emitente" => "$razao_social_emit",
                "nome_fantasia_emitente" => "$nome_fantasia_emit",
                "logradouro_emitente" => "$endereco_emit",
                "numero_emitente" => "$numero_emit",
                "bairro_emitente" => "$bairro_emit",
                "municipio_emitente" => "$cidade_emit",
                "uf_emitente" => "$estado_emit",
                "cep_emitente" => "$cep_emit",
                "inscricao_estadual_emitente" => "$inscricao_estadual_emit",
                "nome_destinatario" => "NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL",
                "cpf_destinatario" => "51966818092",
                "telefone_destinatario" => "1196185555",
                "logradouro_destinatario" => "Rua S\u00e3o Janu\u00e1rio",
                "numero_destinatario" => "99",
                "bairro_destinatario" => "Crespo",
                "municipio_destinatario" => "Manaus",
                "uf_destinatario" => "AM",
                "pais_destinatario" => "Brasil",
                "cep_destinatario" => "69073178",
                "valor_frete" => "0.0",
                "valor_seguro" => "0",
                "valor_total" => "47.23",
                "valor_produtos" => "47.23",
                "modalidade_frete" => "0",
                "items" => array(
                    array(
                        "numero_item" => "1",
                        "codigo_produto" => "1232",
                        "descricao" => "Cartu00f5es de Visita",
                        "cfop" => "6923",
                        "unidade_comercial" => "un",
                        "quantidade_comercial" => "100",
                        "valor_unitario_comercial" => "0.4723",
                        "valor_unitario_tributavel" => "0.4723",
                        "unidade_tributavel" => "un",
                        "codigo_ncm" => "49111090",
                        "quantidade_tributavel" => "100",
                        "valor_bruto" => "47.23",
                        "icms_situacao_tributaria" => "400",
                        "icms_origem" => "0",
                        "pis_situacao_tributaria" => "07",
                        "cofins_situacao_tributaria" => "07"
                    )
                ),
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, $server . "/v2/nfe?ref=" . $ref);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($nfe));
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $body = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            // As próximas três linhas são um exemplo de como imprimir as informações de retorno da API.
            $txtretorno = $http_code . $body;
            $retornar["dados"] = array("sucesso" => true, "valores" => $txtretorno, "http_code" => $http_code);
            curl_close($ch);
        }

        if ($acao == "consultar_nf") {
            // Inicia o processo de envio das informações usando o cURL.

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, $server . "/v2/nfe/" . $ref . "?completa=1");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array());
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
            $body = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // Verificar se a requisição foi bem-sucedida
            if ($http_code == 200) {
                $txtretorno = $http_code . $body;
                $response = json_decode($body, true);
                $chaveAcesso = $response['chave_nfe'];
                $chaveAcesso = substr($chaveAcesso, 3);
                $nprotocolo = $response['protocolo'];
                $caminho_xml_nota_fiscal = $response['caminho_xml_nota_fiscal'];
                $caminho_danfe = $response['caminho_danfe'];


                $requisicao = $response['requisicao_nota_fiscal'];
                $data_emissao = $requisicao['data_emissao'];
                $data_saida = $requisicao['data_entrada_saida'];


                $data_emissao = DateTime::createFromFormat("Y-m-d\TH:i:sP", $data_emissao)->format("Y-m-d");
                $data_saida = DateTime::createFromFormat("Y-m-d\TH:i:sP", $data_saida)->format("Y-m-d");

                update_info_nf($conecta, $id_nf, $data_emissao, $data_saida, $chaveAcesso, $nprotocolo, $caminho_danfe, $caminho_xml_nota_fiscal);
                $retornar["dados"] = array("sucesso" => true, "valores" => $txtretorno, "chave_acesso" => $chaveAcesso, "nprotocolo" => $nprotocolo,"opem_danfe_nf"=>"$server$caminho_danfe","opem_xml"=>"$server$caminho_xml_nota_fiscal");
            } else {
                $retornar["dados"] = array("sucesso" => true, "valores" => "Requisição invalida!");
            }


            curl_close($ch);
        }
    }
    if ($acao == "showProduto") {
        $id_produto = $_POST['id_produto'];
        $select  = "SELECT * FROM tb_nfe_saida_item where nfe_iten_saidaID= $id_produto ";
        $consulta_item_nf = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consulta_item_nf);
        $item = $linha['item'];
        $descricao = utf8_encode($linha['descricao']);
        $und = utf8_encode($linha['und']);
        $quantidade = ($linha['quantidade']);
        $valor_unitario = ($linha['valor_unitario']);
        $valor_produto = ($linha['valor_produto']);
        $ncm = ($linha['ncm']);
        $cest = ($linha['ncm']);
        $cfop = ($linha['cfop']);
        $cst = ($linha['cst_icms']);
        $bc_icms = ($linha['bc_icms']);
        $aliq_icms = ($linha['aliq_icms']);
        $valor_icms = ($linha['valor_icms']);
        $base_icms_sub = ($linha['base_icms_sub']);
        $icms_sub = ($linha['icms_sub']);
        $desconto = ($linha['desconto']);
        $aliq_ipi = ($linha['aliq_ipi']);
        $valor_ipi = ($linha['valor_ipi']);
        $ipi_devolvido = ($linha['ipi_devolvido']);
        $base_pis = ($linha['base_pis']);
        $valor_pis = ($linha['valor_pis']);
        $cst_pis = ($linha['cst_pis']);
        $base_cofins = ($linha['base_cofins']);
        $valor_cofins = ($linha['valor_cofins']);
        $cst_cofins = ($linha['cst_cofins']);
        $base_iss = ($linha['base_iss']);
        $valor_iss = ($linha['valor_iss']);
        $gtin = $linha['gtin'];


        $informacao = array(
            "item" => $item,
            "descricao" => $descricao,
            "und" => $und,
            "quantidade" => $quantidade,
            "valor_unitario" => $valor_unitario,
            "valor_produto" => $valor_produto,
            "cfop" => $cfop,
            "ncm" => $ncm,
            "cest" => $cest,
            "cst" => $cst,
            "bc_icms" => $bc_icms,
            "aliq_icms" => $aliq_icms,
            "valor_icms" => $valor_icms,
            "base_icms_sub" => $base_icms_sub,
            "icms_sub" => $icms_sub,
            "desconto" => $desconto,
            "aliq_ipi" => $aliq_ipi,
            "valor_ipi" => $valor_ipi,
            "ipi_devolvido" => $ipi_devolvido,
            "base_pis" => $base_pis,
            "valor_pis" => $valor_pis,
            "cst_pis" => $cst_pis,
            "base_cofins" => $base_cofins,
            "valor_cofins" => $valor_cofins,
            "cst_cofins" => $cst_cofins,
            "base_iss" => $base_iss,
            "valor_iss" => $valor_iss,
            "gtin" => $gtin,

        );



        $retornar["dados"] = array("sucesso" => true, "valores" => $informacao);
    }
    if ($acao == "updateProduto") {
        $itensJSON = $_POST['itens']; //array de produtos
        $itens = json_decode($itensJSON, true); //recuperar valor do array javascript decodificando o json

        $id_produto = $itens['id_produto'];
        $numero_nf = $itens['numero_nf'];
        $codigo_nf = $itens['codigo_nf'];
        $descricao = $itens['descricao'];
        $und = $itens['und'];
        $qtd = $itens['qtd'];
        $vlr_unitario = $itens['vlr_unitario'];
        $cfop = $itens['cfop'];
        $ncm = $itens['ncm'];
        $cest = $itens['cest'];
        $cst = $itens['cst'];
        $base_icms = $itens['base_icms'];
        $aliq_icms = $itens['aliq_icms'];
        $vlr_icms = $itens['vlr_icms'];
        $base_icms_sub = $itens['base_icms_sub'];
        $icms_sub = $itens['icms_sub'];
        $desconto = $itens['desconto'];
        $aliq_ipi = $itens['aliq_ipi'];
        $ipi = $itens['ipi'];
        $ipi_devolvido = $itens['ipi_devolvido'];
        $base_pis = $itens['base_pis'];
        $pis = $itens['pis'];
        $cst_pis = $itens['cst_pis'];
        $base_cofins = $itens['base_cofins'];
        $cofins = $itens['cofins'];
        $cst_cofins = $itens['cst_cofins'];
        $base_iss = $itens['base_iss'];
        $iss = $itens['iss'];
        $gtin = $itens['gtin'];

        if ($cfop == '0') {
            $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("cfop"));
        } elseif ($ncm == "") {
            $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("ncm"));
        } elseif ($gtin == "") {
            $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("gtin"));
        } elseif ($cst == "") {
            $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("cst"));
        } elseif ($qtd == "") {
            $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("quantidade"));
        } else {

            $valor_total = $vlr_unitario * $qtd;
            //   $retornar["dados"] = array("sucesso" => "false", "title" => $id_produto);
            $update = "UPDATE `marvolt`.`tb_nfe_saida_item` SET `descricao` = '$descricao', `ncm` = '$ncm', 
        `cfop` = '$cfop', `und` = '$und', `quantidade` = '$qtd', `valor_unitario` = '$vlr_unitario', `valor_produto` = '$valor_total', 
        `bc_icms` = '$base_icms', `valor_icms` = '$vlr_icms', `aliq_icms` = '$aliq_icms', `base_icms_sub` = '$base_icms_sub', `icms_sub` = '$icms_sub', 
        `aliq_ipi` = '$aliq_ipi', `valor_ipi` = '$ipi', `ipi_devolvido` = '$ipi_devolvido', `base_pis` = '$base_pis', `valor_pis` = '$pis', 
        `cst_pis` = '$cst_pis', `base_cofins` = '$base_cofins', `valor_cofins` = '$cofins', `cst_cofins` = '$cst_cofins', `base_iss` = '$base_iss', 
        `valor_iss` = '$iss', `origem` = '0',  `cst_icms` = '$cst',  `gtin` = '$gtin' WHERE `tb_nfe_saida_item`.`nfe_iten_saidaID` = $id_produto";
            $operacao_update = mysqli_query($conecta, $update);
            if ($operacao_update) {
                $retornar["dados"] = array("sucesso" => true, "title" => "Item alterado com sucesso!");
                recalcular_nf($conecta, $codigo_nf);
            } else {
                $retornar["dados"] = array("sucesso" => false, "title" => "Erro, Favor verifique com o suporte");
            }
        }
    }


    echo json_encode($retornar);
}


/*finalidade */
$select = "SELECT * FROM finalidade_nf";
$consulta_finalidade = mysqli_query($conecta, $select);

/*forma de pagamento */
$select = "SELECT * FROM forma_pagamento";
$consulta_forma_pagamento = mysqli_query($conecta, $select);


/*cfop */
$select = "SELECT * FROM tb_cfop";
$consulta_cfop = mysqli_query($conecta, $select);
$consulta_cfop2 = mysqli_query($conecta, $select);


/*frete */
$select = "SELECT * FROM frete";
$consulta_frete = mysqli_query($conecta, $select);

/*cst icms */
$select = "SELECT * FROM tb_icms";
$consulta_icms = mysqli_query($conecta, $select);


/*cst cest */
$select = "SELECT * FROM tb_cest";
$consulta_cest = mysqli_query($conecta, $select);
$consulta_ncm = mysqli_query($conecta, $select);

/*cst  */
$select = "SELECT * FROM tb_cst";
$consulta_cst_pis = mysqli_query($conecta, $select);
$consulta_cst_cofins = mysqli_query($conecta, $select);
