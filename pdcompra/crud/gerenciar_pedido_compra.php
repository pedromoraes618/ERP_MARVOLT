<?php
if (isset($_POST['gerar_nfe'])) {
    include("../../conexao/conexao.php");
    include("../../_incluir/funcoes.php");
    $acao = $_POST['acao'];
    $user_id = $_POST['user_id'];
    $retornar = array();
    if ($acao == "create") {
        $codigo_pedido = $_POST['codigo_pedido'];
        $nfe_prox =  verficar_paramentro($conecta, "tb_parametros", "parametroID", "9") + 1;
        $cfop_interno =  verficar_paramentro($conecta, "tb_parametros", "parametroID", "10");
        $cfop_externo =  verficar_paramentro($conecta, "tb_parametros", "parametroID", "11");
        $crt_nfe =  verficar_paramentro($conecta, "tb_parametros", "parametroID", "12");
        $crt_3 =  verficar_paramentro($conecta, "tb_parametros", "parametroID", "13");

        if ($codigo_pedido == "") {
            $retornar["dados"] = array("sucesso" => true, "title" => "Não é possivel realizar a ação, o pedido está sem o código, Favor verifique");
        } else {

            $desconto = verificar_valores($conecta, "pedido_compra", "codigo_pedido", $codigo_pedido, "desconto_geral_reais");
            $cliente_id = verificar_valores($conecta, "pedido_compra", "codigo_pedido", $codigo_pedido, "clienteID");
            $valor_total_nota = verificar_valores($conecta, "pedido_compra", "codigo_pedido", $codigo_pedido, "valor_total");
            $forma_pagamento_id = verificar_valores($conecta, "pedido_compra", "codigo_pedido", $codigo_pedido, "forma_pagamento");
            $valor_total_produtos = verificar_total_valores($conecta, "tb_pedido_item", "pedidoID", $codigo_pedido);

            $cliente_uf = verificar_valores($conecta, "clientes", "clienteID", $cliente_id, "estadoID");

            if($cliente_uf =="10"){//estado maranhão 
                $cfop = $cfop_interno;
            }else{
                $cfop = $cfop_externo;
            }

            $insert = "INSERT INTO `marvolt`.`tb_nfe_saida` ( `data_entrada`, `numero_nf`, `serie`, `cliente_id`,  `tipo_frete`,  `valor_desconto`, 
            `valor_total_produtos`, `valor_total_nota`, `finalidade_id`, `forma_pagamento_id`,`cfop`) VALUES ('$hoje', '$nfe_prox', '1',
            '$cliente_id', '1', '$desconto','$valor_total_produtos','$valor_total_nota','1','$forma_pagamento_id','$cfop')";
            $operacao_insert = mysqli_query($conecta, $insert);
            if ($operacao_insert) {
                $retornar["dados"] = array("sucesso" => true, "title" => "NFE $nfe_prox gerado com sucesso");
                if($crt_nfe=="1"){//simples naccional
                    insert_nfe_item($conecta,$codigo_pedido,"102",$desconto,$cfop,$nfe_prox,"07","07");
                    atulizar_vl_parametro($conecta,"9",$nfe_prox);

                    registrar_log($conecta,$hoje,$user_id,"Gerou a NFE $nfe_prox do pedido de compra codigo $codigo_pedido ");
                }else{
                    insert_nfe_item($conecta,$codigo_pedido,$crt_3,$desconto,$cfop,$nfe_prox,"01","01");
                }
               
            } else {
                $retornar["dados"] = array("sucesso" => false, "title" => "Erro favor informe o suporte do sistema");
            }
    
        }


  
    }

    echo json_encode($retornar);
}
