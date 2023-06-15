<?php


if (isset($_GET['consultar_chamado'])) {
    include("../../conexao/conexao.php");
    include("../../_incluir/funcoes.php");
    $clienteID = $_GET['clienteID'];
    $pesquisar_conteudo = $_GET['pesquisar_conteudo'];
    $data_inicial = $_GET['dt_inicial'];
    $data_final = $_GET['dt_final'];
    $comprador_id = $_GET['comprador'];
    $data_inicial = formatarDataParaBancoDeDados($data_inicial);
    $data_final = formatarDataParaBancoDeDados($data_final);


    $select = "SELECT cont.cl_data_limite,cont.cl_comprador_id, cont.cl_id,cont.cl_data_lancamento,cont.cl_descricao,cont.cl_status, cmp.comprador
from tb_contato cont inner join comprador as cmp on cmp.id_comprador = cont.cl_comprador_id where 
cont.cl_data_lancamento between '$data_inicial' and '$data_final' and cl_descricao LIKE '%$pesquisar_conteudo%' and cont.cl_empresa_id ='$clienteID' ";
    if ($comprador_id != 0) {
        $select .= " and cont.cl_comprador_id = '$comprador_id' ";
    }
    $consulta_contato = mysqli_query($conecta, $select);
}

if (isset($_POST['formulario_contato'])) {
    include("../../conexao/conexao.php");
    include("../../_incluir/funcoes.php");
    $acao = $_POST['acao'];
    $retornar = array();



    $comprador_padrao = verficar_paramentro($conecta, "tb_parametros", "parametroID", "8");

    if ($acao == "create") {
        $data_a_fazer = $_POST['data_fazer'];
        $descricao = $_POST['descricao'];
        $empresa_id = $_POST['empresa_id'];
        $comprador_id = $_POST['comprador_id'];
        if (isset($_POST['status'])) {
            $status = "2";
        } else {
            $status = "1";
        }
        if ($descricao == "") {
            $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("descrição"));
        } elseif ($status == '2' and $data_a_fazer == "") {
            $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro('data a fazer'));
        } else {
            if ($data_a_fazer != "") {
                $data_a_fazer = formatarDataParaBancoDeDados($data_a_fazer);
            }

            if ($comprador_id == "0") {
                $comprador_id = $comprador_padrao;
            }

            $insert = "INSERT INTO `marvolt`.`tb_contato` (`cl_data_lancamento`, `cl_empresa_id`, `cl_comprador_id`, `cl_descricao`, `cl_status`, `cl_data_limite`) 
            VALUES ( '$hoje', '$empresa_id', '$comprador_id', '$descricao', '$status', '$data_a_fazer')";
            $operacao_insert = mysqli_query($conecta, $insert);
            if ($operacao_insert) {
                $retornar["dados"] = array("sucesso" => true, "title" => "Contato lançado com sucesso!");
            } else {
                $retornar["dados"] = array("sucesso" => false, "title" => "Erro favor informe o suporte do sistema");
            }
        }
    } elseif ($acao == "update") {
        $id = $_POST['id'];
        $data_a_fazer = $_POST['data_fazer'];
        $descricao = $_POST['descricao'];
        $empresa_id = $_POST['empresa_id'];
        $comprador_id = $_POST['comprador_id'];
        if (isset($_POST['status'])) {
            $status = "2";
        } else {
            $status = "1";
        }
        if ($descricao == "") {
            $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro("descrição"));
        } elseif ($status == '2' and $data_a_fazer == "") {
            $retornar["dados"] = array("sucesso" => false, "title" => mensagem_alerta_cadastro('data a fazer'));
        } else {
            if ($data_a_fazer != "") {
                $data_a_fazer = formatarDataParaBancoDeDados($data_a_fazer);
            }

            if ($comprador_id == "0") {
                $comprador_id = $comprador_padrao;
            }

            $insert = "UPDATE `marvolt`.`tb_contato` SET  `cl_comprador_id` = '$comprador_id',
             `cl_descricao` = '$descricao', `cl_status` = '$status', `cl_data_limite` = '$data_a_fazer' WHERE `tb_contato`.`cl_id` = $id";
            $operacao_update= mysqli_query($conecta, $insert);
            if ($operacao_update) {
                $retornar["dados"] = array("sucesso" => true, "title" => "Contato alterado com sucesso!");
            } else {
                $retornar["dados"] = array("sucesso" => false, "title" => "Erro favor informe o suporte do sistema");
            }
        }
    } elseif ($acao == "show") {
        $contato_id = $_POST['contato_id'];
        $select = "SELECT * from tb_contato where cl_id ='$contato_id' ";
        $consulta_contato = mysqli_query($conecta, $select);
        $linha = mysqli_fetch_assoc($consulta_contato);
        $data_lancamento =  ($linha['cl_data_lancamento']);
        $empresa_id =  ($linha['cl_empresa_id']);
        $comprador_id =  ($linha['cl_comprador_id']);
        $descricao =  ($linha['cl_descricao']);
        $status =  ($linha['cl_status']);
        $data_limite =  ($linha['cl_data_limite']);

        $informacao = array(
            "data_lancamento" => formatDateB($data_lancamento),
            "empresa_id" => $empresa_id,
            "comprador" => $comprador_id,
            "descricao" => $descricao,
            "status" => $status,
            "data_limite" => formatDateB($data_limite),

        );

        $retornar["dados"] = array("sucesso" => true, "valores" => $informacao);
    }
    echo json_encode($retornar);
}


$select = "SELECT clt.nome_fantasia,id_comprador,comprador  FROM comprador as comp inner join clientes as clt 
on clt.clienteID =  comp.id_cliente";
$consulta_comprador = mysqli_query($conecta, $select);
