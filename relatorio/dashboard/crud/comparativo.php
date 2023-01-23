<?php
include("../../../conexao/conexao.php"); 

$soma_total_grupo = 0;
$soma_total_cliente = 0;
if(isset($_GET['filtroano']) and (isset($_GET['filtromesini'])and (isset($_GET['filtromesfim'])))){
    
$ano = $_GET['filtroano'];
$mes_ini = $_GET['filtromesini'];
$mes_fim = $_GET['filtromesfim'];
    if($ano == "0"){
    $ano = date('Y');
    }
    if($mes_ini == 0){
        $mes_ini = '01';
    }

    if($mes_fim == 0){
        $mes_fim = '12';
    }
}




if(($_GET)){
    $array_valores_pd_compra = array();
    $array_dados_despesa_top_5 = array();
    $cont = 0;
    $valor_outras_despesas = 0;
    /*funcao para retornar o valor por mes de despesa*/
    function consular_despesa_mes($i,$ano){
        include("../../../conexao/conexao.php"); 
        $select = "SELECT sum(valor) as despesa from lancamento_financeiro where status = 'Pago' and receita_despesa = 'Despesa' and data_do_pagamento BETWEEN '$ano-$i-01' and '$ano-$i-31'";
        $consulta_valor_despesa_mes = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consulta_valor_despesa_mes);
        $total_valor_do_mes_despesa  = $linha['despesa'];
        return $total_valor_do_mes_despesa;
    }

    /*funcao para retornar o valor por mes de receita*/
    function consular_receita_mes($i,$ano){
        include("../../../conexao/conexao.php"); 
        $select = "SELECT sum(valor) as receita from lancamento_financeiro where status = 'Recebido' and receita_despesa = 'Receita' and data_do_pagamento BETWEEN '$ano-$i-01' and '$ano-$i-31'";
        $consulta_valor_despesa_mes = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consulta_valor_despesa_mes);
        $total_valor_do_mes_receita  = $linha['receita'];
        return $total_valor_do_mes_receita;
    }

    /*consultar valores de compra e venda de pededidos de compra com limite */
    $select = "SELECT clt.nome_fantasia, SUM(pdc.valor_total_compra) AS valor_total_compra,clt.clienteID as id_cliente,SUM(pdc.valor_total) as valor_total_venda from pedido_compra as
     pdc inner join clientes as clt on clt.clienteID = pdc.clienteID where pdc.data_fechamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by pdc.clienteID order by valor_total_venda desc limit 8";
    $consulta_valor_receita_despesa_pd_compra= mysqli_query($conecta,$select);
    while($linha = mysqli_fetch_assoc($consulta_valor_receita_despesa_pd_compra)){
    $cliente = utf8_encode($linha['nome_fantasia']);
    $cliente_id = utf8_encode($linha['id_cliente']);
    $valor_total_venda = $linha['valor_total_venda'];
    $valor_total_compra = $linha['valor_total_compra'];
    array_push($array_valores_pd_compra,(
    array("cliente"=>$cliente,"valor_venda"=>$valor_total_venda,"valor_compra"=>$valor_total_compra,"cliente_id"=>$cliente_id)
    ));
}
   /*consultar valores de compra e venda de pededidos de compra sem limete  */
    $select = "SELECT clt.nome_fantasia, SUM(pdc.valor_total_compra) AS valor_total_compra,clt.clienteID as id_cliente,SUM(pdc.valor_total) as valor_total_venda from pedido_compra as
    pdc inner join clientes as clt on clt.clienteID = pdc.clienteID where pdc.data_fechamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by pdc.clienteID order by valor_total_venda desc";
    $consulta_valor_receita_despesa_pd_compra_2= mysqli_query($conecta,$select);

    /*coletar os valores do dos grupos depesa */
    $select = "SELECT  tb_subgrupo_receita_despesa.subgrupo as grupo,sum(lancamento_financeiro.valor) as totalPorGrupo
    from  lancamento_financeiro   inner join tb_subgrupo_receita_despesa
    on lancamento_financeiro.grupoID = tb_subgrupo_receita_despesa.subGrupoID
    inner join grupo_lancamento on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID
    where lancamento_financeiro.status = 'Pago'  and lancamento_financeiro.data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by tb_subgrupo_receita_despesa.subgrupo,grupo order by totalPorGrupo desc ";
    $consulta_dados_grupo_des = mysqli_query($conecta,$select);
    while($linha = mysqli_fetch_assoc($consulta_dados_grupo_des)){ 
        $categoria = utf8_encode($linha['grupo']);
        $valor = $linha['totalPorGrupo'];
        if($cont <= 4){
            array_push($array_dados_despesa_top_5,(
            array("categoria"=>$categoria,"valor"=>$valor)
            ));
        }else{
            $valor_outras_despesas = $valor + $valor_outras_despesas;
        }
        $cont ++;
    }





    /*valor total receita */
    $select = "SELECT sum(valor) as valor_total_receita from lancamento_financeiro where status = 'Recebido' and  data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'";
    $consultar_valor_total_receita =  mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_valor_total_receita);
    $valor_total_receita = $linha['valor_total_receita'];

    
    
//despesas dos ultimos 12 meses
$select =" SELECT sum(valor) as valor_despesa from lancamento_financeiro where  status = 'Pago' and data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'"; 
$consulta_despesa = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_despesa);
$valor_despesa = $linha['valor_despesa'];

//receita dos ultimos 12 meses
$select =" SELECT sum(valor) as valor_receita from lancamento_financeiro where status = 'Recebido' and data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'";
$consulta_receita = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_receita);
$valor_receita = $linha['valor_receita'];



//receita total
$select =" SELECT sum(valor) as receita_total  from lancamento_financeiro  where status = 'Recebido'";
$consulta_despesa = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_despesa);
$receita_total = $linha['receita_total'];

$saldo = $valor_receita - $valor_despesa;
$lucratividade = ($saldo / $receita_total) *100;
$lucratividade_real = ($saldo);



    if(isset($_GET['cliente_id'])){
        $clienteID = $_GET['cliente_id'];
        $cliente_nome = $_GET['cliente_nome'];
         /*funcao para retornar o valor por mes de despesa*/
     function consular_despesa_mes_detalhado_pdc($i,$ano,$clienteID){
        include("../../../conexao/conexao.php"); 
        $select = "SELECT  SUM(pdc.valor_total_compra) AS valor_total_compra from pedido_compra as pdc where pdc.clienteID = $clienteID and pdc.data_fechamento BETWEEN '$ano-$i-01' and '$ano-$i-31'  ";
        $consulta_valor_despesa_mes_pdc = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consulta_valor_despesa_mes_pdc);
        $total_valor_do_mes_despesa_pdc  = $linha['valor_total_compra'];
        return $total_valor_do_mes_despesa_pdc;
    }
    /*funcao para retornar o valor por mes de receita*/
    function consular_receita_mes_detalhado_pdc($i,$ano,$clienteID){
        include("../../../conexao/conexao.php"); 
        $select = "SELECT  SUM(pdc.valor_total) AS valor_total_venda from pedido_compra as pdc where  pdc.clienteID = $clienteID and pdc.data_fechamento BETWEEN '$ano-$i-01' and '$ano-$i-31'; ";        
        $consulta_valor_receita_mes_pdc = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consulta_valor_receita_mes_pdc);
        $total_valor_do_mes_receita_pdc  = $linha['valor_total_venda'];
        return $total_valor_do_mes_receita_pdc;
    }
    }
    
    
}
    