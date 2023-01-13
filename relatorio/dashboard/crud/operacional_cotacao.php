<?php 
include("../../../conexao/conexao.php"); 

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
    $cont = 1;
    $soma_diferencia = 0;
    $soma_diferencia_compra = 0;
    $soma_diferencia_chegada_produto = 0;
//consultar valores total cotação
$select = "SELECT sum(ctc.valorTotalComDesconto) as total, clt.nome_fantasia,ctc.clienteID from cotacao as ctc
inner join clientes as clt on ctc.clienteID = clt.clienteID where ctc.data_envio BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'  group by ctc.clienteID";
$consulta_valores_cotacao = mysqli_query($conecta,$select);

//consultar valores cotacao ganho por cliente
function cocatao_ganhas_cliente($conecta,$ano,$mes_ini,$mes_fim,$clienteID){
include("../../../conexao/conexao.php"); 
$select = "SELECT sum(valorTotalComDesconto) as total from cotacao where data_envio BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31' and status_proposta = '3' and clienteID = '$clienteID'";
$consulta_valores_cotacao_ganho = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_valores_cotacao_ganho);
$valor_total_ganho = $linha['total'];
return $valor_total_ganho;
}

//consultar valores de todas as cotacoes
$select = "SELECT sum(valorTotalComDesconto) as total from cotacao where data_envio BETWEEN '$ano-$mes_ini-01' and '$ano-$mes_fim-31'";
$consulta_valores_cotacao_ganho = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_valores_cotacao_ganho);
$valor_total_cotacao = $linha['total'];

/*soma das categorias pedido de compra*/
$select = "SELECT sum(pditem.preco_venda_unitario * pditem.quantidade) as totalcategorapdc from pedido_compra as pdc inner join tb_pedido_item as pditem on pditem.pedidoID = pdc.codigo_pedido  
inner join categoria_produto as ctgp on ctgp.categoriaID = pditem.categoria_produto where pdc.data_fechamento between '$ano-$mes_ini-01' and '$ano-$mes_fim-31' ";
$consulta_total_por_categoria_pd = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_total_por_categoria_pd);
$valor_total_categoria = $linha['totalcategorapdc'];


/*soma das categorias pedido de compra*/
$select = "SELECT sum(pditem.preco_venda_unitario*pditem.quantidade) as somavenda, ctgp.nome_categoria as categoria from pedido_compra as pdc inner join tb_pedido_item as pditem on pditem.pedidoID = pdc.codigo_pedido  
inner join categoria_produto as ctgp on ctgp.categoriaID = pditem.categoria_produto where pdc.data_fechamento between '$ano-$mes_ini-01' and '$ano-$mes_fim-31' group by pditem.categoria_produto;";
$consulta_dados_categoria_pd = mysqli_query($conecta,$select);
$consulta_dados_cor_categoria_pd = mysqli_query($conecta,$select);
$consulta_dados_descricao_categoria_pd = mysqli_query($conecta,$select);

/*coletar a media entre data_de_envio e data de fechamento cotacao*/
$select = "SELECT DATEDIFF(data_fechamento,data_envio) as datapfechamento from cotacao WHERE DATA_FECHAMENTO !='0000-00-00' AND DATA_ENVIO !='0000-00-00' and data_envio between '$ano-$mes_ini-01' and '$ano-$mes_fim-31'";
$consulta_data_para_fechamento = mysqli_query($conecta,$select);
while($linha = mysqli_fetch_assoc($consulta_data_para_fechamento)){
    $cont = $cont + 1;
    $diferencia_para_fechamento = $linha['datapfechamento'];
    $soma_diferencia = $diferencia_para_fechamento + $soma_diferencia;
}

$dias_para_fechamento = $soma_diferencia / $cont; 

$cont = 1;
/*Media  dias para compra do produto*/
$select = "SELECT DATEDIFF(data_compra,data_fechamento) as datapcompra from pedido_compra WHERE data_fechamento !='0000-00-00' AND 
data_compra !='0000-00-00' and data_fechamento between '$ano-$mes_ini-01' and '$ano-$mes_fim-31'";
$consulta_data_para_compra = mysqli_query($conecta,$select);
while($linha = mysqli_fetch_assoc($consulta_data_para_compra)){
    $cont = $cont + 1;
    $diferencia_para_compra = $linha['datapcompra'];
    $soma_diferencia_compra = $diferencia_para_compra + $soma_diferencia_compra;
}


$dias_para_compra = $soma_diferencia_compra / $cont; 



$cont = 1;
/*Media  dias para compra do produto*/
$select = "SELECT DATEDIFF(data_chegada,data_compra) as datapchegada from pedido_compra WHERE data_compra !='0000-00-00' AND 
data_chegada !='0000-00-00' and data_fechamento between '$ano-$mes_ini-01' and '$ano-$mes_fim-31'";
$consulta_data_para_chegada_produto = mysqli_query($conecta,$select);
while($linha = mysqli_fetch_assoc($consulta_data_para_chegada_produto)){
    $cont = $cont + 1;
    $diferencia_para_chegada = $linha['datapchegada'];
    $soma_diferencia_chegada_produto= $diferencia_para_chegada + $soma_diferencia_chegada_produto;
}


$media_para_chegada_produto = $soma_diferencia_chegada_produto / $cont; 

}
?>