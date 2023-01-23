<?php
include("../../../conexao/conexao.php"); 

$soma_total_grupo = 0;
$soma_total_cliente = 0;
if(isset($_GET['filtroano']) and (isset($_GET['filtromesini'])and (isset($_GET['filtromesfim'])))){
    
$ano = $_GET['filtroano'];
$ano_anterior = $_GET['filtroano'] - 1;
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


        /*consultar valopres e dados nota fiscal saida por cliente bloco-left*/
    $select = "SELECT clt.nome_fantasia as cliente,clt.clienteID as clienteid,sum(nfes.valor_total_nota) as valor_total_nfe,clt.cpfcnpj as cnpj from tb_nfe_saida as nfes 
    inner join clientes as clt on clt.cpfcnpj = nfes.cnpj_cpf where nfes.status_processamento = '1' and  nfes.data_emissao between '$ano-$mes_ini-01' and '$ano-$mes_fim-31' 
    group by clt.clienteID order by valor_total_nfe  desc ";
    $consultar_nfe_saida_agrupado = mysqli_query($conecta,$select);

    //valor total nfe saida ano anterior
    $select = "SELECT sum(valor_total_nota) as valor_total_nfe_saida from tb_nfe_saida where status_processamento = '1' and data_emissao between '$ano_anterior-01-01' and '$ano_anterior-12-31' ";
    $consultar_valor_total_nfe_saida_ano_anterior = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_valor_total_nfe_saida_ano_anterior);
    $valor_total_nfe_saida_ano_anterior = $linha['valor_total_nfe_saida'];

     //valor total nfe saida ano atual
     $select = "SELECT sum(valor_total_nota) as valor_total_nfe_saida from tb_nfe_saida where status_processamento = '1' and data_emissao between '$ano-01-01' and '$ano-12-31' ";
     $consultar_valor_total_nfe_saida_ano_atual = mysqli_query($conecta,$select);
     $linha = mysqli_fetch_assoc($consultar_valor_total_nfe_saida_ano_atual);
     $valor_total_nfe_saida_ano_atual = $linha['valor_total_nfe_saida'];
     
     $txcrescimento = ((($valor_total_nfe_saida_ano_atual - $valor_total_nfe_saida_ano_anterior)/$valor_total_nfe_saida_ano_anterior)*100);

         
    //valor total nfs saida
    $select = "SELECT sum(vLiquido_servico) AS valor_total, count(*) as qtdnfss from tb_nfs where dt_emissao between '$ano-$mes_ini-01' and '$ano-$mes_fim-31' ";
    $consultar_valor_total_nfs_saida = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_valor_total_nfs_saida);
    $valor_total_nfs_saida= $linha['valor_total'];
    $quantidade_nfs_saida = $linha['qtdnfss'];

   

    //valor total nfe saida
    $select = "SELECT sum(valor_total_nota) as valor_total_nfe_saida,count(*) as qtdnfes  from tb_nfe_saida where status_processamento = '1' and data_emissao between '$ano-$mes_ini-01' and '$ano-$mes_fim-31' ";
    $consultar_valor_total_nfe_saida = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_valor_total_nfe_saida);
    $valor_total_nfe_saida = $linha['valor_total_nfe_saida'];
    $quantidade_nfe_saida = $linha['qtdnfes'];

    $valor_soma_media_faturamento = $valor_total_nfe_saida + $valor_total_nfs_saida;
    $media_faturamento = $valor_soma_media_faturamento / 12;
    $quantidade_nfs_nfe = $quantidade_nfs_saida + $quantidade_nfe_saida;

    //sabe o ticket medio por data
    $ticket_medio = $valor_soma_media_faturamento/$quantidade_nfs_nfe;

    
//valor total nfe entrada
    $select = "SELECT sum(valor_total_nota) as valor_total_nfe_entrada from tb_nfe_entrada where data_emissao between '$ano-$mes_ini-01' and '$ano-$mes_fim-31' ";
    $consultar_valor_total_nfe_entrada = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_valor_total_nfe_entrada);
    $valor_total_nfe_entrada = $linha['valor_total_nfe_entrada'];

        //estoque 
    $select ="SELECT sum(cl_total) as valor_total FROM `tb_produto_estoque`";
    $consulta_valor_estoque = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consulta_valor_estoque);
    $valor_estoque = $linha['valor_total'];

    //margem 
    $select ="SELECT sum(nfes.valor_total_nota) as valorVenda, sum(pdc.valor_total_compra) as valorCompra from tb_nfe_saida as nfes inner join pedido_compra as pdc 
    on pdc.numero_nf = nfes.numero_nf where nfes.status_processamento = '1' and nfes.data_emissao between '$ano-$mes_ini-01' and '$ano-$mes_fim-31'";
    $consulta_valor_margem = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consulta_valor_margem);
    $valor_total_venda = $linha['valorVenda'];
    $valor_total_compra= $linha['valorCompra'];
    
    $margem_total = ((($valor_total_venda - $valor_total_compra)/$valor_total_venda)*100);

    //calulcar a media de desconto orcamento
        //valor total nfs saida
        $select = "SELECT sum(valorTotal-valorTotalComDesconto) as valorDesconto,count(*) as qtdOrcamento from cotacao where data_fechamento between '$ano-$mes_ini-01' and '$ano-$mes_fim-31' ";
        $consultar_valor_total_nfs_saida = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consultar_valor_total_nfs_saida);
        $valor_desconto_total= $linha['valorDesconto'];
        $quantidade_orcamento = $linha['qtdOrcamento'];
        
        $media_desconto_orcado = $valor_desconto_total / $quantidade_orcamento;


    function consultar_faturamento_nfes($i,$ano){
        include("../../../conexao/conexao.php"); 
        $select = "SELECT sum(valor_total_nota) as valor_total,count(*) as qtdnfes from  
        tb_nfe_saida where status_processamento = '1' and data_emissao between '$ano-$i-01' and '$ano-$i-31'";
        $consultar_valor_total_nfe_saida = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consultar_valor_total_nfe_saida);
        $valor_total_nfe_saida = $linha['valor_total'];

             
    //valor total nfs saida
    $select = "SELECT sum(vLiquido_servico) AS valor_total, count(*) as qtdnfss from tb_nfs where dt_emissao between '$ano-$i-01' and '$ano-$i-31' ";
    $consultar_valor_total_nfs_saida = mysqli_query($conecta,$select);
    $linha = mysqli_fetch_assoc($consultar_valor_total_nfs_saida);
    $valor_total_nfs_saida= $linha['valor_total'];
    $valor_total_nota_fiscal = $valor_total_nfe_saida + $valor_total_nfs_saida;

    return $valor_total_nota_fiscal;
    }
    
    function consultar_quantidade_nfes($i,$ano){
        include("../../../conexao/conexao.php"); 
        $select = "SELECT count(*) as qtdnfes from  
        tb_nfe_saida where status_processamento = '1' and data_emissao between '$ano-$i-01' and '$ano-$i-31'";
        $consultar_quantidade_nfe_saida = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consultar_quantidade_nfe_saida);
        $quantidade_nfe_saida = $linha['qtdnfes'];

        //valor total nfs saida
        $select = "SELECT count(*) as qtdnfss from tb_nfs where dt_emissao between '$ano-$i-01' and '$ano-$i-31' ";
        $consultar_valor_total_nfs_saida = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consultar_valor_total_nfs_saida);
        $quantidade_nota_nfs_saida = $linha['qtdnfss'];
        $quantidade_nota_fiscal_saida = $quantidade_nfe_saida + $quantidade_nota_nfs_saida;
        return $quantidade_nota_fiscal_saida;

        
    }


    if(isset($_GET['cliente_id'])){
        $clienteid = $_GET['cliente_id'];
        $select = "SELECT * from clientes where clienteID = '$clienteid'";
        $consultar_cliente = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consultar_cliente);
        $cliente_nome = utf8_encode($linha['nome_fantasia']);
         //nota fiscal entrada    
    function consultar_faturamento_nfes_cliente($i,$ano,$clienteid){
        include("../../../conexao/conexao.php"); 
        $select = "SELECT sum(nfes.valor_total_nota) as valor_total from  
        tb_nfe_saida as nfes inner join  clientes as clt on clt.cpfcnpj = nfes.cnpj_cpf where  nfes.data_emissao between '$ano-$i-01' and '$ano-$i-31' and clt.clienteID= $clienteid;";
        $consultar_valor_total_nfe_entrada = mysqli_query($conecta,$select);
        $linha = mysqli_fetch_assoc($consultar_valor_total_nfe_entrada);
        $valor_total_nfe_saida_cliente = $linha['valor_total'];
        return $valor_total_nfe_saida_cliente;
    }

        
    }

    if(isset($_GET['cliente_cnpj'])){
        $clientecnpj = $_GET['cliente_cnpj'];
        //nota fiscal entrada    
        function consultar_faturamento_nfee($i,$ano,$clientecnpj){
            include("../../../conexao/conexao.php"); 
            $select = "SELECT sum(valor_total_nota) as valor_total from  
            tb_nfe_entrada where  data_emissao between '$ano-$i-01' and '$ano-$i-31' and cnpj_cpf = '$clientecnpj'";
            $consultar_valor_total_nfe_entrada = mysqli_query($conecta,$select);
            $linha = mysqli_fetch_assoc($consultar_valor_total_nfe_entrada);
            $valor_total_nfe_entrada = $linha['valor_total'];
            return $valor_total_nfe_entrada;
            }
    
    
            function consultar_quantidade_nfee($i,$ano,$clientecnpj){
            include("../../../conexao/conexao.php"); 
            $select = "SELECT count(*) as qtdnfes from  
            tb_nfe_entrada where  data_emissao between '$ano-$i-01' and '$ano-$i-31' and cnpj_cpf = '$clientecnpj'";
            $consultar_quantidade_nfe_entrada = mysqli_query($conecta,$select);
            $linha = mysqli_fetch_assoc($consultar_quantidade_nfe_entrada);
            $quantidade_nfe_entrada = $linha['qtdnfes'];
            return $quantidade_nfe_entrada;
        }
    }


}