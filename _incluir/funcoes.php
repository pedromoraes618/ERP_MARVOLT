<?php
$mes = date('m');
    function real_format($valor) {
        $valor  = number_format($valor,2,",",".");
        return "R$ " . $valor;
    }

    function total_format($valor) {
      $valor  = number_format($valor,2,",",".");
      return  $valor;
  }

  function valor_total($valor) {
    $valor  = number_format($valor,2,".","");
    return  $valor;
}
function valor_k($valor) {
  $valor  = number_format($valor,4,".","");
  return  $valor;
}

function valor_qtd($valor) {
  $valor  = number_format($valor,0,"","");
  return  $valor;
}

    function real_percent($valor) {
      $valor  = number_format($valor,2,",",".");
      return  $valor . " %";
  }

  function real_percent_relatorio($valor) {
    $valor  = number_format($valor,2,".","");
    return  $valor . "%";
}
function real_percent_grafico($valor) {
  $valor  = number_format($valor,2,".","");
  return  $valor;
}

    function porcent_format($valor) {
      return $valor . " % ";
  }


    function dia_format($dias){
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


    function formatardata($value){
      $value = date("Y-m-d",strtotime($value));
      return $value;
    }

    function formatardataIncluir($value){
      $value = date("Y-d-m",strtotime($value));
      return $value;
    }

    function formatardataB($value){
      $value = date("d/m/Y",strtotime($value));
      return $value;
    
   }

   function formatardataB2($value){
    if($value == "0000-00-00"){
      return "";
    }elseif($value =="1970-01-01"){
      return "";
    }elseif($value =="01/01/1970"){
      return "";
    }else{
      $value = date("d/m/Y",strtotime($value));
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
   function random_color($start = 0x000000, $end = 0xFFFFFF) {
    return sprintf('#%06x', mt_rand($start, $end));
 }


 function saldo_inicial($conecta,$mes,$ano){
  if($mes == 01){
  $ano = $ano -1;
  $mes = 12;
  }else{
    $mes = $mes -1;
  }

  $select ="SELECT sum(valor) as valorreceita From lancamento_financeiro where Status='Recebido' and data_do_pagamento between '$ano-$mes-01' and '$ano-$mes-31' ";
  $consulta_valor_caixa_anterior = mysqli_query($conecta,$select);
  $linha = mysqli_fetch_assoc($consulta_valor_caixa_anterior);
  $valor_receita  = $linha['valorreceita'];

  $select ="SELECT sum(valor) as valordespesa From lancamento_financeiro where Status='Pago' and data_do_pagamento between '$ano-$mes-01' and '$ano-$mes-31' ";
  $consulta_valor_caixa_anterior = mysqli_query($conecta,$select);
  $linha = mysqli_fetch_assoc($consulta_valor_caixa_anterior);
  $valor_despesa  = $linha['valordespesa'];


  $saldo_inicial = $valor_receita - $valor_despesa;
  return $saldo_inicial;
 }
 function verifica_status_caixa($conecta,$mes,$ano){
  $select ="SELECT count(*) as qtd from tb_caixa where cl_mes = $mes and cl_ano = $ano";
  $consulta_caixa = mysqli_query($conecta,$select);
  $linha = mysqli_fetch_assoc($consulta_caixa);
  $qtd  = $linha['qtd'];
  return $qtd;
 }

 function verifica_caixa_descricao($conecta,$mes,$ano){
  $select ="SELECT * from tb_caixa where cl_mes = $mes and cl_ano = $ano";
  $consulta_caixa = mysqli_query($conecta,$select);
  $linha = mysqli_fetch_assoc($consulta_caixa);
  $descricao_b  = $linha['cl_descricao'];
  return $descricao_b;
 }



 function saldo_caixa($conecta,$mes,$ano){
  $select ="SELECT sum(valor) as valorreceita From lancamento_financeiro where Status='Recebido' and data_do_pagamento between '$ano-$mes-01' and '$ano-$mes-31' ";
  $consulta_valor_caixa = mysqli_query($conecta,$select);
  $linha = mysqli_fetch_assoc($consulta_valor_caixa);
  $valor_receita = $linha['valorreceita'];

  $select ="SELECT sum(valor) as valordespesa From lancamento_financeiro where Status='Pago' and data_do_pagamento between '$ano-$mes-01' and '$ano-$mes-31' ";
  $consulta_valor_caixa = mysqli_query($conecta,$select);
  $linha = mysqli_fetch_assoc($consulta_valor_caixa);
  $valor_despesa = $linha['valordespesa'];

  $saldo_caixa = $valor_receita - $valor_despesa;

  return $saldo_caixa;
 }


 function consulta_saldo_final($conecta,$mes,$ano){

  if($mes == 01){
    $ano = $ano -1;
    $mes = 12;
    }else{
      $mes = $mes -1;
    }

  $select ="SELECT * from tb_caixa where cl_mes = $mes and cl_ano = $ano";
  $consulta_caixa = mysqli_query($conecta,$select);
  $linha = mysqli_fetch_assoc($consulta_caixa);
  $saldo_fechamento  = $linha['cl_valor_fechamento'];
  return $saldo_fechamento;
 }

function registrar_log($conecta,$data,$user_id,$mensagem){
$inserir = "INSERT INTO tb_log ";
$inserir .= "(cl_data_modificacao,cl_usuario,cl_descricao)";
$inserir .= " VALUES ";
$inserir .= "('$data','$user_id','$mensagem' )";
$operacao_insert_log = mysqli_query($conecta, $inserir);
if($operacao_insert_log){
  return true;
}


//veriificar se o caix
 }
?>