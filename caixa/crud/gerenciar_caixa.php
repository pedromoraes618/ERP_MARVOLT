<?php

//a brir o caixa
if(isset($_POST['abertura_caixa'])){
    include("../../conexao/conexao.php"); 
    include("../../_incluir/funcoes.php"); 
    $retornar = array();
    $ano_caixa = $_POST['ano_caixa'];
    $mes_caixa = $_POST['mes_caixa'];
    $usuario_id = $_POST['usuario_id'];
    
    $user = $_POST['user'];
    //referente ao log
    $mensagem = "Usúario $user realizou a abertura do caixa do mes $mes_caixa ano $ano_caixa";
    $mensagem_reaberto = "Usúario $user realizou a reabertura do caixa do mes $mes_caixa ano $ano_caixa";


    $data_abertura = ("$ano_caixa-$mes_caixa-01");
    $saldo_inicial = consulta_saldo_final($conecta,$mes_caixa,$ano_caixa); // verificar o saldo do caixa anterior
    
    
    $caixa = verifica_status_caixa($conecta,$mes_caixa,$ano_caixa); // veriricar se o caixa já foi aberto se sim apenas reaberir o caixa
    if($caixa > 0){
    $update = "UPDATE tb_caixa SET cl_valor_abertura = '$saldo_inicial',cl_descricao='reaberto',cl_usuario_abertura='$usuario_id' WHERE cl_mes = '$mes_caixa' and cl_ano = '$ano_caixa'";
    $operacao_update = mysqli_query($conecta, $update);
    if($operacao_update){
    $retornar["dados"] = array("sucesso"=>true,"title"=>"Caixa reaberto com sucesso");
    registrar_log($conecta,$hoje,$usuario_id,$mensagem_reaberto);
    }
    }else{
        $inset = "INSERT INTO tb_caixa (cl_data_abertura,cl_valor_abertura,cl_descricao,cl_usuario_abertura,cl_mes,cl_ano)
        VALUES ('$data_abertura','$saldo_inicial','aberto','$usuario_id','$mes_caixa','$ano_caixa')";
       $operacao_inserir = mysqli_query($conecta, $inset);
       if($operacao_inserir){
           $retornar["dados"] = array("sucesso"=>true,"title"=>"Caixa aberto com sucesso");
           registrar_log($conecta,$hoje,$usuario_id,$mensagem);
       }
    }
   


    echo json_encode($retornar);
}


//fechar o caixa
if(isset($_POST['fechar_caixa'])){
    include("../../conexao/conexao.php"); 
    include("../../_incluir/funcoes.php"); 
    $retornar = array();
    $ano_caixa = $_POST['ano_caixa'];
    $mes_caixa = $_POST['mes_caixa'];
    $user = $_POST['user'];
    $usuario_id = $_POST['usuario_id'];

    //referente ao log
    $mensagem = "Usúario $user realizou o fechamento do caixa do mes $mes_caixa ano $ano_caixa";
    $mensagem_imposivel = "Tentativa de fechamento de caixa do usúario $user  mes $mes_caixa ano $ano_caixa, não foi possivel pois o caixa ainda não foi aberto";

  
    $ultimo_dia_mes = date("t", strtotime(date("$ano_caixa-$mes_caixa-d")));
    $data_fechamento = "$ano_caixa-$mes_caixa-$ultimo_dia_mes";

    
    $saldo_inicial = saldo_inicial($conecta,$mes_caixa,$ano_caixa); // verificar o saldo do caixa anterior
    $saldo_caixa = saldo_caixa($conecta,$mes_caixa,$ano_caixa); // verificar o saldo do caixa anterior

    $saldo_real = (consulta_saldo_final($conecta,$mes_caixa,$ano_caixa) + $saldo_caixa);

    
    $caixa = verifica_status_caixa($conecta,$mes_caixa,$ano_caixa); // veriricar se o caixa já foi aberto se sim apenas reaberir o caixa

    if($caixa > 0){
    $update = "UPDATE tb_caixa SET cl_valor_fechamento = '$saldo_real',cl_data_fechamento='$data_fechamento',cl_descricao='fechado',cl_usuario_fechamento='$usuario_id' WHERE cl_mes = '$mes_caixa' and cl_ano = '$ano_caixa'";
    $operacao_update = mysqli_query($conecta, $update);
    if($operacao_update){
    $retornar["dados"] = array("sucesso"=>true,"title"=>"Caixa Fechado com sucesso");

    registrar_log($conecta,$hoje,$usuario_id,$mensagem);

    }
    }else{

        $retornar["dados"] = array("sucesso"=>false,"title"=>"Não é possivel fechar o caixa pois o caixa ainda não foi aberto");
        registrar_log($conecta,$hoje,$usuario_id,$mensagem_imposivel);
    }
   
    
    // if($mes_caixa == "1"){
    //     $ano_caixa = $ano_caixa-1; // se for mes um, ele vai verificar o caixa do ano anterior
    //     $mes_caixa = 12;
    //     $caixa_anterior = verifica_status_caixa($conecta,$mes_caixa,$ano_caixa); // veriricar se existe caixa anterior registrado no bd
    // }else{
    //     $data_fechamento = ("$ano_caixa-$mes_caixa-31");
    //     $mes_caixa = $mes_caixa-1;
    //     $caixa_anterior = verifica_status_caixa($conecta,$mes_caixa,$ano_caixa); // veriricar se existe caixa anterior registrado no bd
    // }
    
    // $ultimo_dia_mes = date("t", strtotime(date("$ano_caixa-$mes_caixa-d"))); // Desconbrir o ultimo dia do mes

    // $data_fechamento = ("$ano_caixa-$mes_caixa-$ultimo_dia_mes");
    // $saldo_caixa = saldo_caixa($conecta,$mes_caixa,$ano_caixa); // verificar o saldo do caixa anterior
    // if($caixa_anterior > 0){//verificar se a registro do caixa do mes anteior se sim, ele vai recalcular o valor o fechamento desse mes anterior
    // $update = "UPDATE tb_caixa SET cl_valor_fechamento = '$saldo_caixa',cl_data_fechamento='$data_fechamento',cl_descricao='fechado' WHERE cl_mes = '$mes_caixa' and cl_ano = '$ano_caixa'";
    // $operacao_update = mysqli_query($conecta, $update);
   
    // }


    echo json_encode($retornar);
}


if(isset($_GET['status_caixa'])){
    $mes_caixa = $_GET['mes_caixa'];
    $ano_caixa = $_GET['ano_caixa'];
    
    $status = verifica_caixa_descricao($conecta,$mes_caixa,$ano_caixa);
}