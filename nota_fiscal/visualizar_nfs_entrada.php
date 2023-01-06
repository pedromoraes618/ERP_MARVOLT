<?php 
session_start();

?>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css" />
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css" />
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css" />
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css" />

<?php

require_once("../conexao/conexao.php");
include ("../_incluir/funcoes.php");
echo ".";

if($_GET['numero_nf']){
    $nNF = $_GET['numero_nf'];
}

$select ="SELECT * FROM tb_nfs_entrada where numero_nf = $nNF";
$operacao_select = mysqli_query($conecta,$select);
if(!$operacao_select){
    die("falha no banco de dados || tb_nfs");
}else{
    $linha = mysqli_fetch_assoc($operacao_select);
    $simples_nacional = $linha['simples_nacional'];
    $tipo_natureza = $linha['natureza_operacao'];
    $codigo_autenticacao = $linha['codigo_autenticacao'];
    $serieNf = $linha['serie'];
    $dt_emissao = $linha['dt_emissao'];
    $dt_saida = $linha['dt_saida'];
    $prest_CNPJ = $linha['cnpj_prestador'];
    $prest_xNome = $linha['razao_social_prestador'];
    $tomador_CNPJ = $linha['cnpj_tomador'];
    $tomador_xNome = $linha['razao_social_tomador'];
    $vDeducoes = $linha['vDeducoes'];
    $vPis = $linha['vPis'];
    $vCofins = $linha['vCofins'];
    $vInss = $linha['vInss'];
    $vIr = $linha['vIR'];
    $vCsll = $linha['vCsll'];
    $vIss_repetido = $linha['vIss_repetido'];
    $vTotalServico = $linha['vTotal_servico'];
    $vLiquidoServico = $linha['vLiquido_servico'];
    $OutrasRetencoes =$linha['vOutras_retencoes'];
    $bCalculo = $linha['vBase_calculo'];
    $aliquota = $linha['vAliquota'];
    $descCondicionado = $linha['vDesconto_condicionado'];
    $descIncondicionado = $linha['vDesconto_incondicionado'];
    $vIss = $linha['vIss'];
    $OutrasInformacoes = utf8_encode($linha['outras_informacoes']);
}
 
	
$select ="SELECT * FROM tb_nfs_item_entrada where numero_nf = $nNF";
$operacao_select_item = mysqli_query($conecta,$select);
if(!$operacao_select_item){
    die("falha no banco de dados || tb_nfs");
}
?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html;">
    <meta charset="UTF-8">
    <LINK rel="stylesheet" href="importaXML/estilo.css" TYPE="text/css">
    <title>Nfs</title>
</head>

<body>
    <center>
        <h3>Nota fiscal NFs</h3>
        <submit type="submit" onclick="window.opener.location.reload();fechar();" value="Voltar">
    </center>



    <form method="post">
        <?php  

if($simples_nacional == 1){
	$simples_nacional = "SIM";
}else{
	$simples_nacional = "NÃO";
}

if($tipo_natureza == 1){
	$tipo_natureza =  "Tributação no município";
}elseif($tipo_natureza == 2){
	$tipo_natureza =  "Tributação fora do município";
}elseif($tipo_natureza == 3){
	$tipo_natureza =  "Isenção";
}elseif($tipo_natureza == 4){
	$tipo_natureza =  "Imune";
}elseif($tipo_natureza == 5){
	$tipo_natureza = "Exigibilidade suspensa por decisão judicial";
}elseif($tipo_natureza == 6){
	$tipo_natureza = "Exigibilidade suspensa por procedimento administrativo";
 }

?>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="cor0">
                <td align="center" width="0%">GERAL</td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="cor0">
                <td align="center">Codigo de Autenticação</td>
                <td align="center">Numero Nota</td>
                <td align="center">Serie</td>
                <td align="center">Data Emissao</td>
                <td align="center">Data Saida</td>
                <td align="center">Natureza de operação(Tipo)</td>
                <td align="center">Simples Nacional</td>
            </tr>
            <tr class="cor1">
                <td align="left" width="10%"><input type="text" style="text-align:center;" name="codigo_autenticacao"
                        size="50" class="cor1" value="<?php echo $codigo_autenticacao; ?>" />
                </td>
                <td align="center" width="0%"><input type="text" name="nNF" size="10" class="cor1"
                        value="<?php echo $nNF; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="serie" size="3" class="cor1"
                        value="<?php echo $serieNf;?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="dt_emissao" size="6" class="cor1"
                        value="<?php  echo formatardataB($dt_emissao); ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="dt_saida" size="6" class="cor1"
                        value="<?php echo formatardataB($dt_saida); ?>" readonly="readonly" /></td>
                <td align="center" width="5%"><input type="text" style="text-align:center;" name="natureza_operacao"
                        size="60" class="cor1" value="<?php echo $tipo_natureza; ?>" readonly="readonly" /></td>
                <td align="center" width="10%"><input type="text" name="simples_nacional" size="6" class="cor1"
                        value="<?php echo $simples_nacional;  ?>" readonly="readonly" /></td>
            </tr>

        </table>
        <?php

	
?>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="cor0">
                <td align="center" width="0%">DADOS DO PRESTADOR</td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="header-fixa">
                <td width="43%" align="center">Nome / Razao Social</td>
                <td width="37%" align="center">CNPJ / CPF</td>
                <td width="20%" align="center">Inscricao Estadual</td>
            </tr>
            <tr class="cor1">
                <td align="center"><input type="text" name="razao_social_prestador" size="60"
                        value="<?php echo utf8_encode($prest_xNome);  ?>" readonly="readonly" class="cor1" /></td>
                <td align="center"><input class="cor1" type="text" id="cnpj_prestador" name="cnpj_prestador" size="15"
                        value="<?php echo $prest_CNPJ; ?>" readonly="readonly" /></td>
                <td align="center"><input type="text" class="cor1" name="IE_prestador" size="15" value="<?php ?>"
                        readonly="readonly" /></td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="cor0">
                <td align="center" width="0%">DADOS DO TOMADOR</td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="header-fixa">
                <td width="43%" align="center">Nome / Razao Social</td>
                <td width="37%" align="center">CNPJ / CPF</td>
                <td width="20%" align="center">Inscricao Estadual</td>
            </tr>
            <tr class="cor1">
                <td align="center"><input type="text" name="razao_social_tomador" size="60"
                        value="<?php echo utf8_encode($tomador_xNome);  ?>" readonly="readonly" class="cor1" /></td>
                <td align="center"><input class="cor1" type="text" id="cnpj_tomador" name="cnpj_tomador" size="15"
                        value="<?php echo $tomador_CNPJ;?>" readonly="readonly" /></td>
                <td align="center"><input type="text" class="cor1" name="ie_tomador" size="15" value="<?php ?>"
                        readonly="readonly" /></td>
            </tr>
        </table>
        <?php

?>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="cor100">
                <td align="center" width="0%">TOTAL</td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="header-fixa">

                <td align="center">Deduções</td>
                <td align="center">Pis</td>
                <td align="center">Cofins</td>
                <td align="center">Inss</td>
                <td align="center">Ir</td>
                <td align="center">Csll</td>
                <td align="center">Iss Repetido</td>
                <td align="center">Valor Total Serviço</td>

            </tr>
            <tr class="cor1">
                <td align="center" width="0%"><input type="text" name="vDeducoes" size="15" class="cor1"
                        value="<?php echo $vDeducoes; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="vPis" size="15" class="cor1"
                        value="<?php echo $vPis; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="vCofins" class="cor1"
                        value="<?php echo $vCofins; ?>">
                <td align="center" width="0%"><input type="text" name="vInss" size="15" class="cor1"
                        value="<?php echo $vInss; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="vIR" size="15" class="cor1"
                        value="<?php echo $vIr; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="vCsll" size="15" class="cor1"
                        value="<?php echo $vCsll; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="vIss_repetido" size="15" class="cor1"
                        value="<?php echo $vIss_repetido; ?>" readonly="readonly" /></td>

                <td align="center" width="0%"><input type="text" name="vTotalServico" size="15" class="cor1"
                        value="<?php echo ($vTotalServico); ?>" readonly="readonly" /></td>

            </tr>

        </table>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="header-fixa">
                <td align="center">Outras Retençoes</td>
                <td align="center">Base de Calculo</td>
                <td align="center">Aliquota</td>
                <td align="center">Desconto Condicionado</td>
                <td align="center">Iss</td>
                <td align="center">Desconto Incondicionado </td>
                <td align="center">Valor Liquido </td>
            </tr>
            <tr class="cor1">
                <td align="center" width="0%"><input type="text" name="vOutrasRetencoes" size="15" class="cor1"
                        value="<?php echo $OutrasRetencoes; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="vBaseCalculo" size="15" class="cor1"
                        value="<?php echo $bCalculo; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="vAliquota" size="15" class="cor1"
                        value="<?php echo $aliquota; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="vDescontoCondicionado" size="15" class="cor1"
                        value="<?php echo $descCondicionado;  ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="vIss" size="15" class="cor1"
                        value="<?php echo $vIss; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="vDescontoIncondicionado" size="15" class="cor1"
                        value="<?php echo $descIncondicionado; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="valorQuido" size="15" class="cor1"
                        value="<?php echo $vLiquidoServico; ?>" readonly="readonly" /></td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="cor100">
                <td align="center" width="100%">Itens da NFs</td>
            </tr>
        </table>
        <?php
//===============================================================================================================================================			
//Dados dos itens

?>
        <table width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="header-fixa">
                <td width="5%" align="center">Seq</td>
                <td width="5%" align="center">C&oacute;digo</td>
                <td width="35%" align="center">Descri&ccedil;&atilde;o dos Servi&ccedil;o(s)</td>

            </tr>
            <?php
	$seq = 0;
    while($linha = mysqli_fetch_assoc($operacao_select_item)){
    $ItemListaServico = $linha['item_lista_servico'];
    $discriminacao = $linha['discriminacao'];
?>


            <tr <?php 

$class = "class='cor1'";
echo $class ?>>
                <td align="center"><?php echo $seq = $seq + 1; ?></td>
                <td align="center"> <input type="text" name="codigo[]" size="8" <?php echo $class ?>
                        value="<?php echo $ItemListaServico; ?>" readonly="readonly" /></td>
                <td align="left"><input type="text" style="text-align:left;" name="descriminacaoServico"
                        <?php echo $class ?> size="200" value="<?php echo $discriminacao; ?>" readonly="readonly" />
                </td>

            </tr>

            <?php
			 }

		 ?>
        </table>
        <table style="margin-top:50px ;" width="100%" border="0" cellpadding="1" cellspacing="1">
            <tr class="cor100">
                <td align="center" width="0%">Informações</td>
            </tr>
            <tr <?php 

$class = "class='cor1'";
echo $class ?>>

                <td align="left"><input type="text" style="text-align:left;" name="descriminacaoServico"
                        <?php echo $class ?> size="200" value="<?php echo $OutrasInformacoes; ?>" readonly="readonly" />
                </td>


            </tr>
        </table>
        <?php

?>


    </form>
    <script>
    function fechar() {
        window.close();
    }
    </script>
</body>

</html>
<?php



?>