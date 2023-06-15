<?php

$mes = date('m');

function real_format($valor)
{
  $valor  = number_format($valor, 2, ",", ".");
  return "R$ " . $valor;
}

function total_format($valor)
{
  $valor  = number_format($valor, 2, ",", ".");
  return  $valor;
}

function valor_total($valor)
{
  $valor  = number_format($valor, 2, ".", "");
  return  $valor;
}
function valor_k($valor)
{
  $valor  = number_format($valor, 4, ".", "");
  return  $valor;
}

function valor_qtd($valor)
{
  $valor  = number_format($valor, 0, "", "");
  return  $valor;
}

function real_percent($valor)
{
  $valor  = number_format($valor, 2, ",", ".");
  return  $valor . " %";
}

function real_percent_relatorio($valor)
{
  $valor  = number_format($valor, 2, ".", "");
  return  $valor . "%";
}
function real_percent_grafico($valor)
{
  $valor  = number_format($valor, 2, ".", "");
  return  $valor;
}

function porcent_format($valor)
{
  return $valor . " % ";
}


function dia_format($dias)
{
  return $dias . " dias";
}

function formatCnpjCpf($value)
{
  $cnpj_cpf = preg_replace("/\D/", '', $value);

  if (strlen($cnpj_cpf) === 11) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  }

  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function formatInscricaoEstadual($value)

{
  $inscricaoEstadual = preg_replace("/\D/", '', $value);
  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{1})/", "\$1.\$2.\$3-\$4", $inscricaoEstadual);
}


function formatardata($value)
{
  $value = date("Y-m-d", strtotime($value));
  return $value;
}

function formatardataIncluir($value)
{
  $value = date("Y-d-m", strtotime($value));
  return $value;
}

function formatardataB($value)
{
  $value = date("d/m/Y", strtotime($value));
  return $value;
}

function formatardataB2($value)
{
  if ($value == "0000-00-00") {
    return "";
  } elseif ($value == "1970-01-01") {
    return "";
  } elseif ($value == "01/01/1970") {
    return "";
  } elseif ($value == "") {
    return "";
  } else {
    $value = date("d/m/Y", strtotime($value));
    return $value;
  }
}

function formatDateB($value)
{
  if (($value != "") and ($value != "0000-00-00")) {
    $value = date("d/m/Y", strtotime($value));
    return $value;
  }
}
$hoje = date('Y-m-d');
//gerar cor automatico
function random_color($start = 0x000000, $end = 0xFFFFFF)
{
  return sprintf('#%06x', mt_rand($start, $end));
}


function saldo_inicial($conecta, $mes, $ano)
{
  if ($mes == 01) {
    $ano = $ano - 1;
    $mes = 12;
  } else {
    $mes = $mes - 1;
  }

  $select = "SELECT sum(valor) as valorreceita From lancamento_financeiro where Status='Recebido' and data_do_pagamento between '$ano-$mes-01' and '$ano-$mes-31' ";
  $consulta_valor_caixa_anterior = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consulta_valor_caixa_anterior);
  $valor_receita  = $linha['valorreceita'];

  $select = "SELECT sum(valor) as valordespesa From lancamento_financeiro where Status='Pago' and data_do_pagamento between '$ano-$mes-01' and '$ano-$mes-31' ";
  $consulta_valor_caixa_anterior = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consulta_valor_caixa_anterior);
  $valor_despesa  = $linha['valordespesa'];


  $saldo_inicial = $valor_receita - $valor_despesa;
  return $saldo_inicial;
}
function verifica_status_caixa($conecta, $mes, $ano)
{
  $select = "SELECT count(*) as qtd from tb_caixa where cl_mes = $mes and cl_ano = $ano and cl_banco='CAIXA'";
  $consulta_caixa = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consulta_caixa);
  $qtd  = $linha['qtd'];
  return $qtd;
}

function verifica_status_conta_financeira($conecta, $mes, $ano, $banco)
{
  $select = "SELECT count(*) as qtd from tb_caixa where cl_mes = $mes and cl_ano = $ano and cl_banco='$banco'";
  $consulta_caixa = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consulta_caixa);
  $qtd  = $linha['qtd'];
  return $qtd;
}


function verifica_caixa_descricao($conecta, $mes, $ano)
{
  $select = "SELECT * from tb_caixa where cl_mes = $mes and cl_ano = $ano";
  $consulta_caixa = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consulta_caixa);
  $descricao_b  = $linha['cl_descricao'];
  return $descricao_b;
}



function saldo_caixa($conecta, $mes, $ano)
{
  $select = "SELECT sum(valor) as valorreceita From lancamento_financeiro where Status='Recebido' and data_do_pagamento between '$ano-$mes-01' and '$ano-$mes-31' ";
  $consulta_valor_caixa = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consulta_valor_caixa);
  $valor_receita = $linha['valorreceita'];

  $select = "SELECT sum(valor) as valordespesa From lancamento_financeiro where Status='Pago' and data_do_pagamento between '$ano-$mes-01' and '$ano-$mes-31' ";
  $consulta_valor_caixa = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consulta_valor_caixa);
  $valor_despesa = $linha['valordespesa'];

  $saldo_caixa = $valor_receita - $valor_despesa;

  return $saldo_caixa;
}

function saldo_caixa_conta_financeira($conecta, $mes, $ano, $banco)
{
  $select = "SELECT sum(fn.valor) as valorreceita From lancamento_financeiro as fn inner join tb_conta_financeira as ctf on ctf.cl_id =fn.cl_conta_financeira_id
   where Status='Recebido' and fn.data_do_pagamento between '$ano-$mes-01' and '$ano-$mes-31' and ctf.cl_banco ='$banco' ";
  $consulta_valor_caixa = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consulta_valor_caixa);
  $valor_receita = $linha['valorreceita'];

  $select = "SELECT sum(fn.valor) as valordespesa From lancamento_financeiro as fn inner join tb_conta_financeira as ctf on ctf.cl_id =fn.cl_conta_financeira_id
   where Status='Pago' and fn.data_do_pagamento between '$ano-$mes-01' and '$ano-$mes-31' and ctf.cl_banco ='$banco' ";
  $consulta_valor_caixa = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consulta_valor_caixa);
  $valor_despesa = $linha['valordespesa'];

  $saldo_caixa = $valor_receita - $valor_despesa;

  return $saldo_caixa;
}


function consulta_saldo_final_caixa($conecta, $mes, $ano)
{

  if ($mes == 01) {
    $ano = $ano - 1;
    $mes = 12;
  } else {
    $mes = $mes - 1;
  }

  $select = "SELECT * from tb_caixa where cl_mes = $mes and cl_ano = $ano and cl_banco='CAIXA'";
  $consulta_caixa = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consulta_caixa);
  $saldo_fechamento  = $linha['cl_valor_fechamento'];
  return $saldo_fechamento;
}

function consulta_saldo_final_conta_financeira($conecta, $mes, $ano, $banco)
{

  if ($mes == 01) {
    $ano = $ano - 1;
    $mes = 12;
  } else {
    $mes = $mes - 1;
  }

  $select = "SELECT * from tb_caixa where cl_mes = $mes and cl_ano = $ano and cl_banco='$banco' ";
  $consulta_caixa = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consulta_caixa);
  $saldo_fechamento  = $linha['cl_valor_fechamento'];
  return $saldo_fechamento;
}

function registrar_log($conecta, $data, $user_id, $mensagem)
{
  $inserir = "INSERT INTO tb_log ";
  $inserir .= "(cl_data_modificacao,cl_usuario,cl_descricao)";
  $inserir .= " VALUES ";
  $inserir .= "('$data','$user_id','$mensagem' )";
  $operacao_insert_log = mysqli_query($conecta, $inserir);
  if ($operacao_insert_log) {
    return true;
  }


  //veriificar se o caix
}

function verficar_paramentro($conecta, $tabela, $filtro, $valor)
{
  $select = "SELECT * from $tabela where $filtro = $valor";
  $consultar_parametros = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consultar_parametros);
  $valor_parametro = $linha['valor'];
  return $valor_parametro;
}

function verificar_valores($conecta, $tabela, $filtro, $valor_filtro, $valor_resultado)
{
  $select = "SELECT * from $tabela where $filtro = $valor_filtro";
  $consultar_valor = mysqli_query($conecta, $select);
  $linha = mysqli_fetch_assoc($consultar_valor);
  $valor = $linha["$valor_resultado"];
  return $valor;
}
function verificar_total_valores($conecta, $tabela, $filtro, $valor_filtro)
{
  $valor_total = 0;
  $select = "SELECT * from $tabela where $filtro = '$valor_filtro'";
  $consultar_valor = mysqli_query($conecta, $select);
  while ($linha = mysqli_fetch_assoc($consultar_valor)) {
    $preco_venda_unitario = $linha['preco_venda_unitario'];
    $quantidade = $linha['quantidade'];
    $valor_venda = $preco_venda_unitario * $quantidade;

    $valor_total = $valor_venda + $valor_total;
  }

  return $valor_total;
}
//mensagem de alerta cadastro
function mensagem_alerta_cadastro($campo)
{
  return "Campo $campo não foi informado, favor verifique!";
}


function formatarDataParaBancoDeDados($data)
{
  // Cria um objeto DateTime a partir da string da data no formato 'dd/mm/aaaa'
  $dataObj = DateTime::createFromFormat('d/m/Y', $data);

  // Retorna a data formatada no formato 'aaaa-mm-dd'
  return $dataObj->format('Y-m-d');
}

function verficar_duplicidade_nfe($conecta, $tabela, $valor)
{
  $select = "SELECT * FROM $tabela where numero_nf = '$valor'";
  $consulta_duplicidade = mysqli_query($conecta, $select);
  if (mysqli_num_rows($consulta_duplicidade) > 0) {
    return true;
  } else {
    return false;
  }
}



function insert_nfe_item($conecta, $codigo_pedido, $cst, $desconto, $cfop, $numero_nf, $cst_pis, $cst_cofins)
{
  $select = "SELECT * FROM tb_pedido_item where pedidoID = '$codigo_pedido'";
  $consulta_item_pedido = mysqli_query($conecta, $select);
  $qtd_item = mysqli_num_rows($consulta_item_pedido);

  $item = 0;
  while ($linha = mysqli_fetch_assoc($consulta_item_pedido)) {
    $codigo = $linha['cod_produto'];
    $produto = $linha['produto'];
    $unidade = $linha['unidade'];
    $quantidade = $linha['quantidade'];
    $preco_venda = $linha['preco_venda_unitario'];

    $valor_total_prod = $quantidade * $preco_venda;
    $desc_rat = $desconto / $qtd_item;
    $item = $item + 1;

    $insert = "INSERT INTO `marvolt`.`tb_nfe_saida_item` (`item`,`numero_nf`, `codigo`, `descricao`, `cfop`, `und`, `quantidade`, 
    `valor_unitario`, `valor_produto`, `bc_icms`, `valor_icms`, `aliq_icms`, 
    `base_icms_sub`, `icms_sub`, `aliq_ipi`, `valor_ipi`, `ipi_devolvido`, 
    `base pis`, `valor_pis`, `cst_pis`, `base_cofins`, `valor_cofins`, `cst_cofins`,
     `base_iss`, `valor_iss`, `origem`, `desconto`,`cst`) VALUES ('$item','$numero_nf', '$codigo', '$produto',
      '$cfop', '$unidade', '$quantidade', '$preco_venda', '$valor_total_prod', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '$cst_pis',
       '0', '0', '$cst_cofins', '0', '0', '0', '$desc_rat','$cst')";
    $operacao_insert = mysqli_query($conecta, $insert);
  }
}

function atulizar_vl_parametro($conecta, $valor_filtro, $valor)
{

  $update = "UPDATE tb_parametros set valor = '$valor' where parametroID = '$valor_filtro'";
  $operacao_update = mysqli_query($conecta, $update);
  if ($operacao_update) {
    return true;
  } else {
    return false;
  }
}
