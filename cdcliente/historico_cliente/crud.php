<?php 

include("../../conexao/conexao.php"); 
include("../../_incluir/funcoes.php"); 


if(isset($_GET['data_inicial']) and (isset($_GET['data_final'])) and isset($_GET['clienteID']) ){
$clienteID = $_GET['clienteID'];
$data_inicial = ($_GET['data_inicial']);
$data_final = ($_GET['data_final']);

if($data_inicial !=""){
$div1 = explode("/",$_GET['data_inicial']);
$data_inicial = $div1[2]."-".$div1[1]."-".$div1[0];
}

if($data_final !=""){
    $div2 = explode("/",$_GET['data_final']);
    $data_final = $div2[2]."-".$div2[1]."-".$div2[0];
}


/*pedido de compra */
$select = "SELECT clt.nome_fantasia,pdc.valor_total_compra,pdc.valor_total_margem,pdc.data_fechamento,pdc.numero_nf,pdc.entrega_realizada,pdc.valor_total 
from pedido_compra  as pdc inner join clientes as clt on clt.clienteID = pdc.clienteID
where pdc.data_fechamento BETWEEN '$data_inicial' and '$data_final' and pdc.clienteID = $clienteID order by data_fechamento desc";
$consulta_pedido_compra = mysqli_query($conecta,$select);

/*Nfe entrada */
$select  = "SELECT nfent.numero_nf,nfent.data_emissao,nfent.valor_total_produtos,nfent.valor_desconto ,nfent.valor_total_nota,clt.nome_fantasia from 
tb_nfe_entrada as nfent inner join clientes as clt on clt.cpfcnpj = nfent.cnpj_cpf WHERE nfent.data_emissao BETWEEN '$data_inicial' and '$data_final' and clt.clienteID = $clienteID order by nfent.data_emissao desc";
$consulta_nfe_entrada= mysqli_query($conecta,$select);

/*Lançamento financeiro */
$select ="SELECT lcf.data_a_pagar,lcf.valor,lcf.data_do_pagamento,lcf.status,frp.nome,clt.nome_fantasia ,DATEDIFF(lcf.data_do_pagamento,lcf.data_a_pagar) as atraso  from lancamento_financeiro as lcf 
inner join clientes as clt on clt.clienteID = lcf.clienteID inner join forma_pagamento as frp on frp.formapagamentoID = lcf.forma_pagamentoID where lcf.data_a_pagar  BETWEEN '$data_inicial' and '$data_final' 
and clt.clienteID = $clienteID order by lcf.data_a_pagar desc" ;
$consulta_financeiro = mysqli_query($conecta,$select);

/*Cotação*/
$select ="SELECT ctc.data_fechamento,ctc.status_proposta,ctc.data_lancamento,ctc.numero_orcamento,ctc.desconto,ctc.valorTotalComDesconto,ctc.margem  
from cotacao as ctc where ctc.data_lancamento BETWEEN '$data_inicial' and '$data_final' and ctc.clienteID = $clienteID order by ctc.data_lancamento desc ";
$consulta_cotacao = mysqli_query($conecta,$select);

}