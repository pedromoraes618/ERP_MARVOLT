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

            $valor_total_produtos = verificar_total_valores_nf($conecta,"tb_nfe_saida_item","codigo_nf",$codigo_nf);
            $valor_total_nota = $valor_total_produtos + $outras_despesas - $desconto_nota;

            $update = "UPDATE `marvolt`.`tb_nfe_saida` SET `numero_pedido` = '$numero_pedido', `cfop` = '$cfop', `serie` = '1', 
            `cliente_id` = '$parceiro_id', `valor_frete` = '$vfrete', `tipo_frete` = '$frete', `outras_despesas` = '$outras_despesas', `transportadora_id` = '$transportadora_id',
             `placa` = '$placa', `uf_veiculo` = '$uf_veiculo', `quantidade_tra` = '$quantidade_trp', `especie_tra` = '$especie',  `peso_bruto` = '$peso_bruto',
              `peso_liquido` = '$peso_liquido', `valor_desconto` = '$desconto_nota', `valor_total_produtos` = '$valor_total_produtos', `valor_total_nota` = '$valor_total_nota', `finalidade_id` = '$finalidade',
             `forma_pagamento_id` = '$fpagamento', `observacao` = '$observacao' WHERE `tb_nfe_saida`.`nfe_saidaID` = $id_nf and codigo_nf ='$codigo_nf'";
             $operacao_update = mysqli_query($conecta,$update);
             if($operacao_update){
                $retornar["dados"] = array("sucesso" => true, "title" => "Nfe alterada com sucesso");
             }
        }
    }

    if ($acao == "show") {
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

        );



        $retornar["dados"] = array("sucesso" => true, "valores" => $informacao);
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
