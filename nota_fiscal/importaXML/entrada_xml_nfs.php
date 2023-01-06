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

require_once("../../conexao/conexao.php");
include("../../_incluir/funcoes.php");
echo ".";


$formatosPermitidos = array("xml");
$extensao = pathinfo($_FILES['xml_nfs']['name'], PATHINFO_EXTENSION);
$chave = ($_FILES['xml_nfs']['name']);
if (in_array($extensao, $formatosPermitidos)) {
    $DestinoXML = "arquivos/";
    $temporario = $_FILES['xml_nfs']['tmp_name'];
    if (move_uploaded_file($temporario, $DestinoXML . $chave)) {
    } else {
        echo "Erro, não foi possivel fazer o upload";
    }
} else {
    echo "Formato inválido";
}





//Primeiro Envio o XML para o Servidor
$hoje = date('Y-m-d');



?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html;">
    <meta charset="UTF-8">
    <LINK rel="stylesheet" HREF="estilo.css" TYPE="text/css">
    <title>Entrada de NFs por XML</title>
</head>

<body>
    <center>
        <h3>Dados Importados do XML</h3>
        <submit type="submit" onclick="window.opener.location.reload();fechar();" value="Voltar">
    </center>



    <form method="post" action="entrada_xml.php ">

        <?php

        if ($chave) {
            if ($chave == '') {
                echo "<h4>Informe a chave de acesso!</h4>";
                exit;
            }
            $arquivo = "arquivos/" . $chave;
            if (file_exists($arquivo)) {
                $arquivo = $arquivo;
                $xml = simplexml_load_file($arquivo);
                // imprime os atributos do objeto criado

                if (empty($xml->ListaNfse->ComplNfse->Nfse->InfNfse->CodigoVerificacao)) {
                    echo "<h4>Arquivo sem dados de autoriza��o!</h4>";
                    exit;
                }

                $codigo_autenticacao = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->CodigoVerificacao;
                $nNF = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Numero;
                $serieNf = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->IdentificacaoRps->Serie;
                $dt_emissao = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->DataEmissao;
                $dt_saida = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->DataEmissao;
                $tipo_natureza = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->NaturezaOperacao;
                $tipo_natureza_b = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->NaturezaOperacao;
                $simples_nacional_b = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->OptanteSimplesNacional; // 1 para sim e 2 para não,
                $simples_nacional = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->OptanteSimplesNacional; // 1 para sim e 2 para não,

                if ($simples_nacional == 1) {
                    $simples_nacional = "SIM";
                } else {
                    $simples_nacional = "NÃO";
                }

                if ($tipo_natureza == 1) {
                    $tipo_natureza =  "Tributação no município";
                } elseif ($tipo_natureza == 2) {
                    $tipo_natureza =  "Tributação fora do município";
                } elseif ($tipo_natureza == 3) {
                    $tipo_natureza =  "Isenção";
                } elseif ($tipo_natureza == 4) {
                    $tipo_natureza =  "Imune";
                } elseif ($tipo_natureza == 5) {
                    $tipo_natureza = "Exigibilidade suspensa por decisão judicial";
                } elseif ($tipo_natureza == 6) {
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
                        value="<?php echo $serieNf; ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="dt_emissao" size="6" class="cor1"
                        value="<?php echo formatardataB($dt_emissao); ?>" readonly="readonly" /></td>
                <td align="center" width="0%"><input type="text" name="dt_saida" size="6" class="cor1"
                        value="<?php echo formatardataB($dt_saida); ?>" readonly="readonly" /></td>
                <td align="center" width="5%"><input type="text" style="text-align:center;" name="natureza_operacao"
                        size="60" class="cor1" value="<?php echo $tipo_natureza; ?>" readonly="readonly" /></td>
                <td align="center" width="10%"><input type="text" name="simples_nacional" size="6" class="cor1"
                        value="<?php echo $simples_nacional;  ?>" readonly="readonly" /></td>
            </tr>

        </table>
        <?php
                //===============================================================================================================================================	
                // <emit> Emitente
                // 	$emit_CPF = $xml->NFe->infNFe->emit->CPF;
                // 	$emit_CNPJ = $xml->NFe->infNFe->emit->CNPJ;  				
                // 	$emit_xNome = $xml->NFe->infNFe->emit->xNome; 				
                // 	$emit_xFant = $xml->NFe->infNFe->emit->xFant;     			
                // //<enderEmit>
                // 	$emit_xLgr = $xml->NFe->infNFe->emit->enderEmit->xLgr;		
                // 	$emit_nro= $xml->NFe->infNFe->emit->enderEmit->nro; 			
                // 	$emit_xBairro = $xml->NFe->infNFe->emit->enderEmit->xBairro;
                // 	$emit_cMun = $xml->NFe->infNFe->emit->enderEmit->cMun; 		
                // 	$emit_xMun = $xml->NFe->infNFe->emit->enderEmit->xMun; 		
                // 	$emit_UF = $xml->NFe->infNFe->emit->enderEmit->UF; 			
                // 	$emit_CEP = $xml->NFe->infNFe->emit->enderEmit->CEP; 		
                // 	$emit_cPais = $xml->NFe->infNFe->emit->enderEmit->cPais; 	
                // 	$emit_xPais = $xml->NFe->infNFe->emit->enderEmit->xPais; 	
                // 	$emit_fone = $xml->NFe->infNFe->emit->enderEmit->fone; 		
                // //</enderEmit>
                // 	$emit_IE = $xml->NFe->infNFe->emit->IE; 				 
                // 	$emit_IM = $xml->NFe->infNFe->emit->IM; 				  
                // 	$emit_CNAE = $xml->NFe->infNFe->emit->CNAE; 			 
                // 	$emit_CRT = $xml->NFe->infNFe->emit->CRT; 
                // //</emit>
                // //===============================================================================================================================================		
                // //<dest>
                // $dest_cnpj =  $xml->NFe->infNFe->dest->CNPJ;       		        //<CNPJ>01153928000179</CNPJ>
                // //<CPF></CPF>
                // $dest_xNome = $xml->NFe->infNFe->dest->xNome;       		      //<xNome>AGROVENETO S.A.- INDUSTRIA DE ALIMENTOS  -002825</xNome>

                // //***********************************************************************************************************************************************	


                // //<enderDest>
                // $dest_xLgr = $xml->NFe->infNFe->dest->enderDest->xLgr;            //<xLgr>ALFREDO PESSI, 2.000</xLgr>
                // $dest_nro =  $xml->NFe->infNFe->dest->enderDest->nro;     		  //<nro>.</nro>
                // $dest_xBairro = $xml->NFe->infNFe->dest->enderDest->xBairro;      //<xBairro>PARQUE INDUSTRIAL</xBairro>
                // $dest_cMun = $xml->NFe->infNFe->dest->enderDest->cMun;            //<cMun>4211603</cMun>
                // $dest_xMun = $xml->NFe->infNFe->dest->enderDest->xMun;            //<xMun>NOVA VENEZA</xMun>
                // $dest_UF = $xml->NFe->infNFe->dest->enderDest->UF;                //<UF>SC</UF>
                // $dest_CEP = $xml->NFe->infNFe->dest->enderDest->CEP;              //<CEP>88865000</CEP>
                // $dest_cPais = $xml->NFe->infNFe->dest->enderDest->cPais;          //<cPais>1058</cPais>
                // $dest_xPais = $xml->NFe->infNFe->dest->enderDest->xPais;          //<xPais>BRASIL</xPais>
                // //</enderDest>
                // $dest_IE = $xml->NFe->infNFe->dest->IE;                           //<IE>253323029</IE>
                // //</dest>
                //===============================================================================================================================================	



                $prest_CNPJ = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->PrestadorServico->IdentificacaoPrestador->Cnpj;
                $prest_xNome =  $xml->ListaNfse->ComplNfse->Nfse->InfNfse->PrestadorServico->RazaoSocial;
                $prest_xNome_b =  $xml->ListaNfse->ComplNfse->Nfse->InfNfse->PrestadorServico->RazaoSocial;
                $prest_xNome_b = utf8_decode($prest_xNome_b);

                $tomador_CNPJ = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->TomadorServico->IdentificacaoTomador->CpfCnpj->Cnpj;
                $tomador_xNome =  $xml->ListaNfse->ComplNfse->Nfse->InfNfse->TomadorServico->RazaoSocial;
                $tomador_xNome_b =  $xml->ListaNfse->ComplNfse->Nfse->InfNfse->TomadorServico->RazaoSocial;
                $tomador_xNome_b = utf8_decode($tomador_xNome_b);
                // 	$emit_xFant = $xml->NFe->infNFe->emit->xFant;     			
                // //<enderEmit>
                // 	$prest_xLgr = $xml->NFe->infNFe->emit->enderEmit->xLgr;		
                // 	$prest_nro= $xml->NFe->infNFe->emit->enderEmit->nro; 			
                // 	$prest_xBairro = $xml->NFe->infNFe->emit->enderEmit->xBairro;
                //	$prest_cMun = $xml->NFe->infNFe->emit->enderEmit->cMun; 		
                // 	$prest_xMun = $xml->NFe->infNFe->emit->enderEmit->xMun; 		
                // 	$prest_UF = $xml->NFe->infNFe->emit->enderEmit->UF; 			
                // 	$prest_CEP = $xml->NFe->infNFe->emit->enderEmit->CEP; 		
                // 	$prest_cPais = $xml->NFe->infNFe->emit->enderEmit->cPais; 	
                // 	$prest_xPais = $xml->NFe->infNFe->emit->enderEmit->xPais; 	
                // 	$prest_fone = $xml->NFe->infNFe->emit->enderEmit->fone; 		
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
                        value="<?php echo $prest_xNome;  ?>" readonly="readonly" class="cor1" /></td>
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
                        value="<?php echo $tomador_xNome;  ?>" readonly="readonly" class="cor1" /></td>
                <td align="center"><input class="cor1" type="text" id="cnpj_tomador" name="cnpj_tomador" size="15"
                        value="<?php echo $tomador_CNPJ; ?>" readonly="readonly" /></td>
                <td align="center"><input type="text" class="cor1" name="ie_tomador" size="15" value="<?php ?>"
                        readonly="readonly" /></td>
            </tr>
        </table>
        <?php

                //Totais
                /*
  <total>
        <ICMSTot>
          <vBC>0.00</vBC>
          <vICMS>0.00</vICMS>
          <vBCST>0.00</vBCST>
          <vST>0.00</vST>
          <vProd>555.00</vProd>
          <vFrete>0.00</vFrete>
          <vSeg>0.00</vSeg>
          <vDesc>0.00</vDesc>
          <vII>0.00</vII>
          <vIPI>0.00</vIPI>
          <vPIS>3.62</vPIS>
          <vCOFINS>16.66</vCOFINS>
          <vOutro>0.00</vOutro>
          <vNF>555.00</vNF>
        </ICMSTot>
      </total>
*/

                // $vBC = $xml->NFe->infNFe->total->ICMSTot->vBC;
                // $vBC = number_format((double) $vBC, 2, ".", "");
                // $vICMS = $xml->NFe->infNFe->total->ICMSTot->vICMS;
                // $vICMS = number_format((double) $vICMS, 2, ".", "");
                // $vBCST = $xml->NFe->infNFe->total->ICMSTot->vBCST;
                // $vBCST = number_format((double) $vBCST, 2, ".", "");
                // $vST = $xml->NFe->infNFe->total->ICMSTot->vST;
                // $vST = number_format((double) $vST, 2, ".", "");
                // $vProdTotal = $xml->NFe->infNFe->total->ICMSTot->vProd;
                // $vProdProduto = number_format((double) $vProdTotal, 2, ".", ""); 
                // $vNF = $xml->NFe->infNFe->total->ICMSTot->vNF;
                // $vNF = number_format((double) $vNF, 2, ".", "");
                // $vFrete = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vFrete, 2, ".", "");
                // $vSeg = number_format((double)   $xml->NFe->infNFe->total->ICMSTot->vSeg, 2, ".", "");
                // $vDesc = number_format((double) $xml->NFe->infNFe->total->ICMSTot->vDesc, 2, ".", "");
                // $vIPI = number_format((double) $xml->NFe->infNFe->total->ICMSTot->	vIPI, 2, ".", "");	
                $vTotalServico = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->ValorServicos;
                $vDeducoes = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->ValorDeducoes;
                $vPis = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->ValorPis;
                $vCofins = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->ValorCofins;
                $vInss = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->ValorInss;
                $vIr = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->ValorIr;
                $vCsll = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->ValorCsll;
                $issRepetido = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->IssRetido;
                $vIss = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->ValorIss;
                $OutrasRetencoes = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->OutrasRetencoes;
                $bCalculo = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->BaseCalculo;
                $aliquota = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->Aliquota;
                $vLiquidoServico = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->ValorLiquidoNfse;
                $descCondicionado = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->DescontoCondicionado;
                $descIncondicionado = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Valores->DescontoIncondicionado;
                $OutrasInformacoes = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->OutrasInformacoes;
                $OutrasInformacoes_b = utf8_decode($OutrasInformacoes);
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
                <td align="center" width="0%"><input type="text" name="vIss" size="15" class="cor1"
                        value="<?php echo $issRepetido; ?>" readonly="readonly" /></td>
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
                    // 	foreach($xml->NFe->infNFe->det as $item) 
                    // 	{
                    // 		$seq++;
                    // 		$codigo = $item->prod->cProd;
                    // 		$xProd = $item->prod->xProd;
                    // 		$NCM = $item->prod->NCM;
                    // 		$CFOP = $item->prod->CFOP;
                    // 		$uCom = $item->prod->uCom;
                    // 		$qCom = $item->prod->qCom;
                    // 		$qCom = number_format((double) $qCom, 2, ".", "");
                    // 		$vUnCom = $item->prod->vUnCom;
                    // 		$vUnCom = number_format((double) $vUnCom, 2, ".", ".");
                    // 		$vProd = $item->prod->vProd;
                    // 		$vProdItem = number_format((double) $vProd, 2, ".", "");	
                    // 		$vBC_item = $item->imposto->ICMS->ICMS00->vBC;
                    // 		$icms00 = $item->imposto->ICMS->ICMS00;
                    // 		$icms10 = $item->imposto->ICMS->ICMS10;
                    // 		$icms20 = $item->imposto->ICMS->ICMS20;
                    // 		$icms30 = $item->imposto->ICMS->ICMS30;
                    // 		$icms40 = $item->imposto->ICMS->ICMS40;
                    // 		$icms50 = $item->imposto->ICMS->ICMS50;
                    // 		$icms51 = $item->imposto->ICMS->ICMS51;
                    // 		$icms60 = $item->imposto->ICMS->ICMS60;
                    // 		$ICMSSN102 = $item->imposto->ICMS->ICMSSN102; 
                    // 		if(!empty($ICMSSN102)) 
                    // 			{
                    // 				$bc_icms = "0.00";	
                    // 				$pICMS = "0	";
                    // 				$vlr_icms = "0.00";
                    // 			}		


                    // 		if (!empty($icms00))
                    // 		{
                    // 			$bc_icms = $item->imposto->ICMS->ICMS00->vBC;
                    // 			$bc_icms = number_format((double) $bc_icms, 2, ".", "");
                    // 			$pICMS = $item->imposto->ICMS->ICMS00->pICMS;
                    // 			$pICMS = round($pICMS,0);
                    // 			$vlr_icms = $item->imposto->ICMS->ICMS00->vICMS;
                    // 			$vlr_icms = number_format((double) $vlr_icms, 2, ".", "");
                    // 		}
                    // 		if (!empty($icms20))
                    // 		{
                    // 			$bc_icms = $item->imposto->ICMS->ICMS20->vBC;
                    // 			$bc_icms = number_format((double) $bc_icms, 2, ".", "");
                    // 			$pICMS = $item->imposto->ICMS->ICMS20->pICMS;
                    // 			$pICMS = round($pICMS,0);
                    // 			$vlr_icms = $item->imposto->ICMS->ICMS20->vICMS;
                    // 			$vlr_icms = number_format((double) $vlr_icms, 2, ".", "");
                    // 		}
                    // 			if(!empty($icms30)) 
                    // 			{
                    // 				$bc_icms = "0.00";	
                    // 				$pICMS = "0	";
                    // 				$vlr_icms = "0.00";
                    // 			}
                    // 			if(!empty($icms40)) 
                    // 			{
                    // 				$bc_icms = "0.00";	
                    // 				$pICMS = "0	";
                    // 				$vlr_icms = "0.00";
                    // 			}
                    // 			if(!empty($icms50)) 
                    // 			{
                    // 				$bc_icms = "0.00";	
                    // 				$pICMS = "0	";
                    // 				$vlr_icms = "0.00";
                    // 			}
                    // 			if(!empty($icms51)) 
                    // 			{
                    // 				$bc_icms = $item->imposto->ICMS->ICMS51->vBC;
                    // 				$pICMS = $item->imposto->ICMS->ICMS51->pICMS;
                    // 				$pICMS = round($pICMS,0);
                    // 				$vlr_icms = $item->imposto->ICMS->ICMS51->vICMS;
                    // 			}
                    // 		if(!empty($icms60)) 
                    // 		{
                    // 			$bc_icms = "0,00";	
                    // 			$pICMS = "0	";
                    // 			$vlr_icms = "0,00";
                    // 		}
                    // 		$IPITrib = $item->imposto->IPI->IPITrib;
                    // 		if (!empty($IPITrib))
                    // 		{
                    // 			$bc_ipi =$item->imposto->IPI->IPITrib->vBC;
                    // 			$bc_ipi = number_format((double) $bc_ipi, 2, ".", "");
                    // 			$perc_ipi =  $item->imposto->IPI->IPITrib->pIPI;
                    // 			$perc_ipi = round($perc_ipi,0);
                    // 			$vlr_ipi = $item->imposto->IPI->IPITrib->vIPI;
                    // 			$vlr_ipi = number_format((double) $vlr_ipi, 2, ".", "");
                    // 		}
                    // 		$IPINT = $item->imposto->IPI->IPINT;
                    // 		{
                    // 			$bc_ipi = "0,00";
                    // 			$perc_ipi =  "0";
                    // 			$vlr_ipi = "0,00";
                    // 		}	
                    // 		if($seq % 2 == 0)
                    // 			$class = "class='cor2'";
                    // 		else
                    // 			$class = "class='cor1'";

                    // 

                    $id_referencia = rand(200, 50000);
                    if ($codigo_autenticacao != "") {
                        $select = " SELECT * from tb_nfs where codigo_autenticacao = '$codigo_autenticacao' ";
                        $consulta = mysqli_query($conecta, $select);
                        if (!$consulta) {
                            die("Falha na consulta ao banco de dados Usuraio");
                        } else {
                            $row_banco = mysqli_fetch_assoc($consulta);
                            $b_autenticacao = $row_banco['codigo_autenticacao'];
                        }

                        if ($codigo_autenticacao == $b_autenticacao) {
                    ?>
            <script>
            alertify.alert("Nota de Serviço já importada || Operação cancelada");
            </script>
            <?php
                        } else {
                            if ($tomador_CNPJ != "") {
                                $select = " SELECT * from clientes where cpfcnpj = '$tomador_CNPJ' ";
                                $consulta_cliente = mysqli_query($conecta, $select);
                                if (!$consulta_cliente) {
                                    die("Falha na consulta ao banco de dados cliente");
                                } else {
                                    $row_banco_cliente = mysqli_fetch_assoc($consulta_cliente);
                                    $cnpj = $row_banco_cliente['cpfcnpj'];
                                }

                                if ($cnpj != $tomador_CNPJ) {
                            ?> <?php

                                } else {

                                    $insert = "INSERT INTO tb_nfs ";
                                    $insert .= "(codigo_autenticacao,data_entrada,dt_emissao,dt_saida,numero_nf,natureza_operacao,serie,simples_nacional,razao_social_prestador,cnpj_prestador,
razao_social_tomador,cnpj_tomador,vDeducoes,vPis,vCofins,vInss,vIR,vCsll,vIss,vTotal_servico,vOutras_retencoes,vBase_calculo,vAliquota,vDesconto_condicionado,
vDesconto_incondicionado,vLiquido_servico,outras_informacoes,id_referencia,vIss_repetido)";
                                    $insert .= " VALUES ";
                                    $insert .= "( '$codigo_autenticacao','$hoje','$dt_emissao','$dt_saida','$nNF','$tipo_natureza_b','$serieNf','$simples_nacional_b', '$prest_xNome_b','$prest_CNPJ',
'$tomador_xNome_b','$tomador_CNPJ','$vDeducoes','$vPis','$vCofins','$vInss','$vIr','$vCsll','$vIss','$vTotalServico','$OutrasRetencoes','$bCalculo','$aliquota','$descCondicionado',
'$descIncondicionado','$vLiquidoServico','$OutrasInformacoes_b','$id_referencia','$issRepetido')";

                                    $operacao_inserir = mysqli_query($conecta, $insert);
                                    if (!$operacao_inserir) {
                                        die("Erro no banco de dados || tabela tb_nfs");
                                    } else {
                                ?>
            <script>
            alertify.success("Nota de Serviço importada com sucesso!");
            </script>
            <?php
                                    }
                                }
                            }
                        }
                    }



                    $ItemListaServico = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->ItemListaServico;
                    $discriminacao = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Discriminacao;
                    $discriminacao_b = $xml->ListaNfse->ComplNfse->Nfse->InfNfse->Servico->Discriminacao;

                    ?>

            <tr <?php

                        $class = "class='cor1'";
                        echo $class ?>>
                <td align="center"><?php echo $seq ?></td>
                <td align="center"> <input type="text" name="codigo[]" size="8" <?php echo $class ?>
                        value="<?php echo $ItemListaServico; ?>" readonly="readonly" /></td>
                <td align="left"><input type="text" style="text-align:left;" name="descriminacaoServico"
                        <?php echo $class ?> size="200" value="<?php echo $discriminacao; ?>" readonly="readonly" />
                </td>


            </tr>
            <?php
                    if ($codigo_autenticacao != "") {
                        $select = " SELECT * from tb_nfs_item where codigo_autenticacao = '$codigo_autenticacao' ";
                        $consulta = mysqli_query($conecta, $select);
                        if (!$consulta) {
                            die("Falha na consulta ao banco de dados Usuraio");
                        } else {
                            $row_banco = mysqli_fetch_assoc($consulta);
                            $b_autenticacao = $row_banco['codigo_autenticacao'];
                        }

                        if ($codigo_autenticacao == $b_autenticacao) {
                        } else {
                            if ($tomador_CNPJ != "") {
                                $select = " SELECT * from clientes where cpfcnpj = '$tomador_CNPJ' ";
                                $consulta_cliente = mysqli_query($conecta, $select);
                                if (!$consulta_cliente) {
                                    die("Falha na consulta ao banco de dados cliente");
                                } else {
                                    $row_banco_cliente = mysqli_fetch_assoc($consulta_cliente);
                                    $cnpj = $row_banco_cliente['cpfcnpj'];
                                }

                                if ($cnpj != $tomador_CNPJ) {
                    ?> <?php

                                } else {

                                    $insert = "INSERT INTO tb_nfs_item ";
                                    $insert .= "(codigo_autenticacao,numero_nf,item_lista_servico,discriminacao,id_referencia)";
                                    $insert .= " VALUES ";
                                    $insert .= "( '$codigo_autenticacao','$nNF','$ItemListaServico','$discriminacao_b','$id_referencia')";

                                    $operacao_inserir_item = mysqli_query($conecta, $insert);
                                    if (!$operacao_inserir_item) {
                                        die("Erro no banco de dados || tabela tb_nfs_item");
                                    }
                                }
                            }
                        }
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
                //===============================================================================================================================================			
            } else {
                echo "<h4>N�o existe o arquivo com a chave " . $chave . " informada!</h4>";
            }


            //verificar se o usuario já está cadastrado^
        }
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