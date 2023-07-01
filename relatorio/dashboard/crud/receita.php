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

/*consultar valores de dois grupos - emprestimo e investimmento - receita */
$select = "SELECT SUM(lcf.valor) as valor, srd.subgrupo  as grupo from lancamento_financeiro as lcf inner join tb_subgrupo_receita_despesa as srd on srd.subGrupoID = lcf.grupoID where 
lcf.receita_despesa = 'Receita' and status='Recebido' and lcf.data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'  group by lcf.grupoID";
$consulta_valor_por_grupo= mysqli_query($conecta,$select);
$consulta_valor_por_grupo_texto = mysqli_query($conecta,$select);
$consulta_valor_por_grupo_cor = mysqli_query($conecta,$select);

/*consultar somatorio de dois grupos - emprestimo e investimmento - receita */
$select = "SELECT SUM(lcf.VALOR) as valor, srd.subgrupo  as grupo from lancamento_financeiro as lcf inner join tb_subgrupo_receita_despesa as srd on srd.subGrupoID = lcf.grupoID where 
lcf.receita_despesa = 'Receita' and status='Recebido' and lcf.data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'";
$consulta_somatorio_grupo = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_somatorio_grupo);
$somatorio_grupo_receita = $linha['valor'];

/*consultar top 5 de clientes agrupados */
$select ="SELECT SUM(lcf.valor) as valor,lcf.clienteID,cl.nome_fantasia,gpcl.cl_id as id, gpcl.cl_descricao as grupo from lancamento_financeiro as lcf 
inner join clientes as cl on cl.clienteID = lcf.clienteID inner join tb_grupo_cliente as gpcl on gpcl.cl_id= cl.grupo_cliente  where 
lcf.receita_despesa = 'Receita' and lcf.status='Recebido' and lcf.data_do_pagamento 
BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by gpcl.cl_id order by valor desc limit 5";
$consulta_clientes_por_receita_agrupados = mysqli_query($conecta,$select);



$somtorio_receita_por_cliente = 0;
/*consultar top 5 de clientes agrupados por receita somatorio */
$select ="SELECT SUM(lcf.valor) as valor,lcf.clienteID,cl.nome_fantasia,gpcl.cl_id as id, gpcl.cl_descricao as grupo from lancamento_financeiro as lcf 
inner join clientes as cl on cl.clienteID = lcf.clienteID inner join tb_grupo_cliente as gpcl on gpcl.cl_id= cl.grupo_cliente  where 
lcf.receita_despesa = 'Receita' and lcf.status='Recebido' and gpcl.cl_id  != '7'  and gpcl.cl_id != '0' and lcf.data_do_pagamento 
BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by gpcl.cl_id order by valor desc limit 5";
$consulta_somatorio_cliente_receita = mysqli_query($conecta,$select);
while($linha = mysqli_fetch_assoc($consulta_somatorio_cliente_receita)){
    $valor = $linha['valor'];
    $somtorio_receita_por_cliente = $valor +  $somtorio_receita_por_cliente;
}



/*consultar receita detalhada */
$select = "SELECT SUM(lcf.valor) as valor,lcf.clienteID,cl.nome_fantasia as cliente, srd.subgrupo  as grupo from lancamento_financeiro as lcf inner join
 tb_subgrupo_receita_despesa as srd on srd.subGrupoID = lcf.grupoID inner join clientes as cl on cl.clienteID = lcf.clienteID where 
lcf.receita_despesa = 'Receita' and status='Recebido' and lcf.data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by lcf.clienteID order by valor desc";
$consulta_receita_detalhada = mysqli_query($conecta,$select);

/*consultar receita detalhada */
$select = "SELECT SUM(lcf.valor) as valor,lcf.clienteID,cl.nome_fantasia as cliente, srd.subgrupo  as grupo from lancamento_financeiro as lcf inner join tb_subgrupo_receita_despesa as srd on srd.subGrupoID = lcf.grupoID inner join clientes as cl on cl.clienteID = lcf.clienteID where 
lcf.receita_despesa = 'Receita' and status='Recebido' and lcf.data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'";
$consulta_somatorio_receita_detalhada = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_somatorio_receita_detalhada);
$somatorio_total_receita = $linha['valor'];

/*consultar nfs saida por operação estadual ou interestadual - ESTADUAL */
$select = "SELECT sum(nfs.vLiquido_servico) as somatorio_nota,clt.estadoID from tb_nfs as nfs  inner join clientes as clt  on 
clt.cpfcnpj = nfs.cnpj_tomador inner join tb_grupo_cliente as gpc on gpc.cl_id = clt.grupo_cliente and nfs.dt_emissao BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' and clt.estadoID = '10' ";
$consulta_somatorio_nfS_saida_estadual = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_somatorio_nfS_saida_estadual);
$somatorio_total_nfs_saida_estadual = $linha['somatorio_nota'];

/*consultar nfs saida por operação estadual ou interestadual - INTERSTADUAL */
$select = "SELECT sum(nfs.vLiquido_servico) as somatorio_nota,clt.estadoID from tb_nfs as nfs  inner join clientes as clt  on 
clt.cpfcnpj = nfs.cnpj_tomador inner join tb_grupo_cliente as gpc on gpc.cl_id = clt.grupo_cliente and nfs.dt_emissao BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'  and clt.estadoID != '10' ";
$consulta_somatorio_nfS_saida_interestadual = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_somatorio_nfS_saida_interestadual);
$somatorio_total_nfs_saida_interestadual = $linha['somatorio_nota'];

  
/*consultar nfs saida por operação estadual ou interestadual - SOMA TOTAL */
$select = "SELECT sum(nfs.vLiquido_servico) as somatorio_nota, COUNT(*) as qtd_nfs from tb_nfs as nfs  inner join clientes as clt  on 
clt.cpfcnpj = nfs.cnpj_tomador inner join tb_grupo_cliente as gpc on gpc.cl_id = clt.grupo_cliente and nfs.dt_emissao BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'  ";
$consulta_somatorio_nfS_saida_toal = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_somatorio_nfS_saida_toal);
$somatorio_total_nfs_saida = $linha['somatorio_nota'];
$qtd_nfs = $linha['qtd_nfs'];


/*consultar nfe saida por operação estadual ou interestadual - ESTADUAL */
$select = "SELECT sum(nfe.valor_total_nota) as somatorio_nota,clt.estadoID as estado  from tb_nfe_saida as nfe  inner join clientes as clt  on 
clt.clienteID = nfe.cliente_id inner join tb_grupo_cliente as gpc on gpc.cl_id = clt.grupo_cliente and nfe.data_emissao BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' and nfe.finalidade_id ='1' and clt.estadoID= '10'";
$consulta_somatorio_nfe_saida_estadual = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_somatorio_nfe_saida_estadual);
$somatorio_total_nfe_saida_estadual = $linha['somatorio_nota'];
$estadual = $linha['estado'];


/*consultar nfe saida por operação estadual ou interestadual - INTERESTADUAL */
$select = "SELECT sum(nfe.valor_total_nota) as somatorio_nota , clt.estadoID as estado from tb_nfe_saida as nfe  inner join clientes as clt  on 
clt.clienteID = nfe.cliente_id inner join tb_grupo_cliente as gpc on gpc.cl_id = clt.grupo_cliente and nfe.data_emissao BETWEEN '$ano-$mes_ini-01'
 and '$ano-$mes_fim-31' and nfe.finalidade_id ='1' and clt.estadoID != '10' ";
$consulta_somatorio_nfe_saida_interestadual = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_somatorio_nfe_saida_interestadual);
$somatorio_total_nfe_saida_inerestadual = $linha['somatorio_nota'];
$interestadual = $linha['estado'];

//consultar total valor de nota fiscal 
$select = "SELECT sum(nfe.valor_total_nota) as somatorio_nota,COUNT(*) as qtd_nfe  from tb_nfe_saida as nfe  inner join clientes as clt  on 
clt.clienteID = nfe.cliente_id inner join tb_grupo_cliente as gpc on gpc.cl_id = clt.grupo_cliente and nfe.data_emissao BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' and nfe.finalidade_id ='1'";
$consulta_somatorio_nfe_saida = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_somatorio_nfe_saida);
$somatorio_total_nfe_saida = $linha['somatorio_nota'];
$qtd_nfe = $linha['qtd_nfe'];

$soma_estaudal_nfe_nfs = $somatorio_total_nfe_saida_estadual + $somatorio_total_nfs_saida_estadual; 
$soma_interestadual_nfe_nfs = $somatorio_total_nfe_saida_inerestadual + $somatorio_total_nfs_saida_interestadual; 
$soma_total_nfe_nfs = $somatorio_total_nfe_saida + $somatorio_total_nfs_saida;

if(isset($_GET['id_grupo_cliente_bloco_left'])){

    $id_grupo_cliente = $_GET['id_grupo_cliente_bloco_left'];
    /*buscar os clientes que fazem parte do grupo de clientes */
    $select = "SELECT SUM(lcf.valor) as valor,lcf.clienteID,cl.nome_fantasia as cliente,gpcl.cl_id as id, gpcl.cl_descricao as grupo from
     lancamento_financeiro as lcf 
    inner join clientes as cl on cl.clienteID = lcf.clienteID inner join tb_grupo_cliente as gpcl on gpcl.cl_id= cl.grupo_cliente  where 
    lcf.receita_despesa = 'Receita' and status='Recebido' and lcf.data_do_pagamento 
    BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' and gpcl.cl_id = '$id_grupo_cliente' group by cl.clienteID ";
    $consulta_clientes_agrupado_por_cnpj = mysqli_query($conecta,$select);

    /*somar os valores do cliente por nota fiscal */
    $select = "SELECT SUM(lcf.valor) as somatorio,lcf.clienteID,cl.nome_fantasia as cliente,gpcl.cl_id as id, gpcl.cl_descricao as grupo from
     lancamento_financeiro as lcf 
    inner join clientes as cl on cl.clienteID = lcf.clienteID inner join tb_grupo_cliente as gpcl on gpcl.cl_id= cl.grupo_cliente  where 
    lcf.receita_despesa = 'Receita' and status='Recebido' and lcf.data_do_pagamento 
    BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' and gpcl.cl_id = '$id_grupo_cliente'";
    $consulta_soma_valor_clientes_agrupado_por_cnpj = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consulta_soma_valor_clientes_agrupado_por_cnpj);
    $consulta_clientes_agrupado_por_cnpj_somatorio = $linha['somatorio'];

    }

}