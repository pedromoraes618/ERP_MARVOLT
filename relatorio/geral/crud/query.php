<?php 
include("../../../conexao/conexao.php"); 

if(isset($_GET['filtroano_ini']) and (isset($_GET['filtroano_fim']))){
$ano_ini = $_GET['filtroano_ini'];
$ano_fim = $_GET['filtroano_fim'];
$dia_atual = date('d');



/*consultar grupos receita */
$select = "SELECT SUM(lcf.valor) as valor, srd.subgrupo  as grupo from lancamento_financeiro as lcf inner join tb_subgrupo_receita_despesa as srd on srd.subGrupoID = lcf.grupoID where 
lcf.receita_despesa = 'Receita' and status='Recebido' and lcf.data_do_pagamento BETWEEN '$ano_ini-01-01' and '$ano_fim-12-31'  group by lcf.grupoID order by valor desc";
$consulta_receita_por_grupo = mysqli_query($conecta,$select);


/*consultar grupos despesa pagas */
$select = "SELECT SUM(lcf.valor) as valor, srd.subgrupo  as grupo,glcm.nome as tipo from lancamento_financeiro as lcf inner join tb_subgrupo_receita_despesa as srd on srd.subGrupoID = lcf.grupoID inner join grupo_lancamento as glcm on glcm.grupo_lancamentoID = srd.grupo where 
lcf.receita_despesa = 'Despesa' and status='Pago' and lcf.data_do_pagamento  BETWEEN '$ano_ini-01-01' and '$ano_fim-12-31' group by lcf.grupoID order by glcm.nome , valor desc";
$consulta_despesa_por_grupo = mysqli_query($conecta,$select);


/*consultar grupos despesa a pagar*/
$select = "SELECT SUM(lcf.valor) as valor, srd.subgrupo  as grupo,glcm.nome as tipo from lancamento_financeiro as lcf inner join tb_subgrupo_receita_despesa as srd on srd.subGrupoID = lcf.grupoID inner join grupo_lancamento as glcm on glcm.grupo_lancamentoID = srd.grupo where 
lcf.receita_despesa = 'Despesa' and status='A Pagar' and lcf.grupoID != '23' and lcf.data_a_pagar  BETWEEN '2023-01-01' and '2030-12-31' group by lcf.grupoID order by glcm.nome , valor desc";
$consulta_despesa_a_pagar_por_grupo = mysqli_query($conecta,$select);

/*consultar grupos emprestimo a partir de  2023 */
$select = "SELECT sum(valor) as valor_total from lancamento_financeiro where grupoID =  23 and data_a_pagar   BETWEEN '2023-01-01' and '2023-12-31'";
$consulta_valor_imprestimo_a_partir_2023 = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_valor_imprestimo_a_partir_2023);
$valor_total_apartir_2023 = $linha['valor_total'];

/*consultar grupos emprestimo a partir de  2023 */
$select = "SELECT sum(valor) as valor_total from lancamento_financeiro where grupoID =  23 and data_a_pagar   BETWEEN '2024-01-01' and '2030-12-31'";
$consulta_valor_imprestimo_a_partir_2024 = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_valor_imprestimo_a_partir_2024);
$valor_total_apartir_2024 = $linha['valor_total'];

/*consultar total valo tabela produto_estoque */
$select = "SELECT sum(cl_total) AS valor_total from tb_produto_estoque";
$consulta_valor_total_produto_estoque = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_valor_total_produto_estoque);
$valor_total_estoque = $linha['valor_total'];

/*consultar valores de patrimonio e equipamentos tabelas - tb_patrimonio and lancamento_financeiro*/
$select = "SELECT sum(valor) as valor_total  from lancamento_financeiro where grupoID =  11 and data_do_pagamento   BETWEEN '2019-01-01' and '$ano_fim-12-31'";
$consulta_valor_total_patrimonio = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_valor_total_patrimonio);
$valor_total_patrimonio = $linha['valor_total'];

$select = "SELECT sum(total) as valor_total  from tb_patrimonio";
$consulta_valor_total_equipamentos = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_valor_total_equipamentos);
$valor_total_equipamentos = $linha['valor_total'];

$valor_total_patrimonio_equipamentos = $valor_total_patrimonio + $valor_total_equipamentos;



/*conultar valores total receita a liquidar de pedidos entregues e não entregues tabelas lancamento_financeiro and pedido_compra */
/*pedidos entregues */
$select = "SELECT sum(lcf.valor) as total, lcf.data_a_pagar, lcf.data_do_pagamento,lcf.valor,pdc.entrega_realizada,lcf.numeroPedido from lancamento_financeiro as lcf 
inner join pedido_compra as pdc on pdc.numero_pedido_compra = lcf.numeroPedido where numeroPedido != '' and pdc.entrega_realizada != '0000-00-00' and lcf.data_do_pagamento = '0000-00-00'";
$consulta_valor_pedidos_entregues_receita_a_liquidar = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_valor_pedidos_entregues_receita_a_liquidar);
$valor_total_receita_liquidar_entrega_realizada = $linha['total'];

/*pedidos não entregues */
$select = "SELECT sum(valor_total) as total from pedido_compra where entrega_realizada = '0000-00-00'";
$consulta_valor_pedidos_entregues_receita_a_liquidar = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_valor_pedidos_entregues_receita_a_liquidar);
$valor_total_receita_liquidar_entrega_nao_realizada = $linha['total'];


$valor_total_receita_a_liquidar = $valor_total_receita_liquidar_entrega_nao_realizada + $valor_total_receita_liquidar_entrega_realizada;



//consultar os dados da empresa pelo id 
$consulta = "SELECT * from empresa where empresaID = '1' ";
$dados_empresa= mysqli_query($conecta, $consulta);
while($row_empresa = mysqli_fetch_assoc($dados_empresa)){
    $razaoSocial = utf8_encode($row_empresa['razao_social']);
    $endereco = utf8_encode($row_empresa['endereco']);
    $cnpj = utf8_encode($row_empresa['cnpj']);
    $inscricaoEstadual = utf8_encode($row_empresa['inscricao_estadual']);
    $email = utf8_encode($row_empresa['email']);
    $telefone = utf8_encode($row_empresa['telefone']);
    $site = utf8_encode($row_empresa['site']);
}


}




?>