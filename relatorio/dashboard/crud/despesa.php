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
/*coletar os valores do dos grupos depesa */
$select = "SELECT  tb_subgrupo_receita_despesa.subgrupo as grupo,sum(lancamento_financeiro.valor) as totalPorGrupo
from  lancamento_financeiro   inner join tb_subgrupo_receita_despesa
on lancamento_financeiro.grupoID = tb_subgrupo_receita_despesa.subGrupoID
inner join grupo_lancamento on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID
 where lancamento_financeiro.status = 'Pago'  and lancamento_financeiro.data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by tb_subgrupo_receita_despesa.subgrupo,grupo order by totalPorGrupo desc";
$consulta_somatorio_grupo_des = mysqli_query($conecta,$select);


$select = "SELECT sum(lancamento_financeiro.valor) as total
from  lancamento_financeiro   inner join tb_subgrupo_receita_despesa
on lancamento_financeiro.grupoID = tb_subgrupo_receita_despesa.subGrupoID
inner join grupo_lancamento on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID 
where lancamento_financeiro.status = 'Pago'  and lancamento_financeiro.data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' ";
$consulta_valor_total = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_valor_total);
$somatorio = $linha['total'];
$somatorio_top_seis = $linha['total'];



//pegar apenas as 6 mnaior categorias de despesas com mais valor
$select = "SELECT  tb_subgrupo_receita_despesa.subgrupo as grupo,tb_subgrupo_receita_despesa.subGrupoID as cl_id,sum(lancamento_financeiro.valor) as totalPorGrupo
from  lancamento_financeiro   inner join tb_subgrupo_receita_despesa
on lancamento_financeiro.grupoID = tb_subgrupo_receita_despesa.subGrupoID
inner join grupo_lancamento on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID
 where lancamento_financeiro.status = 'Pago' and lancamento_financeiro.data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by tb_subgrupo_receita_despesa.subgrupo,grupo  order by totalPorGrupo desc limit 5";
$consulta_top_seis_despesa = mysqli_query($conecta,$select);



//somar os valores retornado de cada categoria para obter a porcentagem
$select = "SELECT  tb_subgrupo_receita_despesa.subgrupo as grupo,sum(lancamento_financeiro.valor) as totalPorGrupo
from  lancamento_financeiro   inner join tb_subgrupo_receita_despesa
on lancamento_financeiro.grupoID = tb_subgrupo_receita_despesa.subGrupoID
inner join grupo_lancamento on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID
 where lancamento_financeiro.status = 'Pago'  and lancamento_financeiro.data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by tb_subgrupo_receita_despesa.subgrupo,grupo  order by totalPorGrupo desc limit 5";
$consulta_top_seis_despesa_while = mysqli_query($conecta,$select);
while($linha = mysqli_fetch_assoc($consulta_top_seis_despesa_while)){
$soma_total_grupo  = $soma_total_grupo + $linha['totalPorGrupo'];
}


function despesa_mes_ano_atual(){
    include("../../conexao/conexao.php"); 
    $select = "SELECT sum(valor) as despesa from lancamento_financeiro where  receita_despesa = 'Despesa' and status='Pago'  
    and data_do_pagamento between '2022-01-01' and '2022-01-31'";
    $consulta_valor_despesa_mes = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consulta_valor_despesa_mes);
    $valor_do_mes  = $linha['despesa'];
    return $valor_do_mes;
    
}





/*quantidade de nota fiscais parceladas e nota fiscal a vista - NFE */
$avista_nfe = 0;
$parcelado_nfe = 0;
$soma_total_parcelado_nfe = 0;
$soma_total_avista_nfe = 0;
$select = " SELECT count(*) as qtd, sum(lc.valor) as valor, lc.numeroNotaFiscal,nf.data_emissao from lancamento_financeiro as lc inner join tb_nfe_entrada as nf on nf.numero_nf = lc.numeroNotaFiscal where lc.numeroNotaFiscal != '' and 
lc.modalidade = 'NFE_ENTRADA' and nf.data_emissao BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'  group by lc.numeroNotaFiscal";
$consulta_qtd_nota_fiscal = mysqli_query($conecta,$select);
while($linha =  mysqli_fetch_assoc($consulta_qtd_nota_fiscal)){
    $qtd_nota_fiscal = $linha['qtd'];
    $valor = $linha['valor'];
    
    if($qtd_nota_fiscal == 1){
        
        $avista_nfe = 1 + $avista_nfe;
        $soma_total_avista_nfe = $soma_total_avista_nfe + $valor;
        
    }elseif($qtd_nota_fiscal > 1){

        $parcelado_nfe = 1 + $parcelado_nfe;
        $soma_total_parcelado_nfe = $soma_total_parcelado_nfe + $valor;

    }

}


/*quantidade de nota fiscais parceladas e nota fiscal a vista - NFS */
$avista_nfs = 0;
$parcelado_nfs = 0;
$soma_total_parcelado_nfs = 0;
$soma_total_avista_nfs = 0;
$select = " SELECT count(*) as qtd, sum(lc.valor) as valor, lc.numeroNotaFiscal,nfs.dt_emissao from lancamento_financeiro as lc inner join tb_nfs_entrada as nfs on nfs.numero_nf = lc.numeroNotaFiscal where lc.numeroNotaFiscal != '' and 
lc.modalidade = 'NFS_ENTRADA' and nfs.dt_emissao BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'  group by lc.numeroNotaFiscal";
$consulta_qtd_nota_fiscal = mysqli_query($conecta,$select);
while($linha =  mysqli_fetch_assoc($consulta_qtd_nota_fiscal)){
    $qtd_nota_fiscal = $linha['qtd'];
    $valor = $linha['valor'];

    if($qtd_nota_fiscal == 1){

        $avista_nfs = 1 + $avista_nfs;
        $soma_total_avista_nfs = $soma_total_avista_nfs + $valor;

    }elseif($qtd_nota_fiscal > 1){

        $parcelado_nfs = 1 + $parcelado_nfs;
        $soma_total_parcelado_nfs = $soma_total_parcelado_nfs + $valor;

    }
}


if(isset($_GET['id_cliente_bloco_left'])){
    $id_cliente = $_GET['id_cliente_bloco_left'];
    $select = "SELECT  tb_subgrupo_receita_despesa.subGrupoID,clientes.nome_fantasia as cliente,sum(lancamento_financeiro.valor) as totalPorCliente
    from  lancamento_financeiro   inner join tb_subgrupo_receita_despesa
    on lancamento_financeiro.grupoID = tb_subgrupo_receita_despesa.subGrupoID 
    inner join grupo_lancamento on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID
     inner join clientes on clientes.clienteID = lancamento_financeiro.clienteID
    where lancamento_financeiro.status = 'Pago' and lancamento_financeiro.data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'  and  lancamento_financeiro.grupoID = '$id_cliente' group by clientes.nome_fantasia order by totalPorCliente desc ";
    $consulta_despesa_detalhe_cliente = mysqli_query($conecta,$select);
    
    //pegar o somatorio dos valores agrupados por cliente 
    $id_cliente = $_GET['id_cliente_bloco_left'];
    $select = "SELECT  tb_subgrupo_receita_despesa.subGrupoID,clientes.nome_fantasia as cliente,sum(lancamento_financeiro.valor) as totalPorCliente
    from  lancamento_financeiro   inner join tb_subgrupo_receita_despesa
    on lancamento_financeiro.grupoID = tb_subgrupo_receita_despesa.subGrupoID 
    inner join grupo_lancamento on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID
     inner join clientes on clientes.clienteID = lancamento_financeiro.clienteID
    where lancamento_financeiro.status = 'Pago' and lancamento_financeiro.data_do_pagamento BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'   and lancamento_financeiro.grupoID = '$id_cliente' group by clientes.nome_fantasia order by totalPorCliente desc ";
    $total_despesa_detalhe_cliente = mysqli_query($conecta,$select);
    while($linha = mysqli_fetch_assoc($total_despesa_detalhe_cliente)){
        $soma_total_cliente  = $soma_total_cliente + $linha['totalPorCliente'];
    }
    }


    /*bloco-right-top */
    //pegar o valor de despesa por tipo // despesa fixa ou variaveis
    $select = "SELECT sum(f.valor) as somatorio,gl.nome as tipo,gl.grupo_lancamentoID as id from lancamento_financeiro  as f inner join tb_subgrupo_receita_despesa as subg on f.grupoID = subg.subGrupoID 
    inner join grupo_lancamento as gl on gl.grupo_lancamentoID = subg.grupo  where f.receita_despesa = 'Despesa'
     and f.status = 'Pago' and f.data_do_pagamento
     BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'  group by gl.nome";
     $total_valor_despesa_por_tipo = mysqli_query($conecta,$select);
}