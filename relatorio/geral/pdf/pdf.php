<?php
//referenciar o dompdf com namespace
include "../crud/query.php";
include "../../../_incluir/funcoes.php";


$data = date('d/m/Y');

$html ="<div class='top-1'>
    <div class='img_logo_relatorio'><img src='../../../images/logo_marvolt_relatorio.jpg'></div>
   
</div>
<div class='titulo_relatorio'><p>RELATÓRIO GERAL</p></div>";


$html .= "<div class='tabela_relatoio'>
<table width=100% cellspacing='0' id='table_relatorio'>";
$html .= "<tbody class='top_tabela'>";
$html .="<tr>";
$html .="<td align=left style=width:500px;><p>Receita</p></td>";
$html .="<td align=left><p>Valor</p></td>";
$html .="</tr>";
$html .= "</tbody>";

/*receita */
$html .= "<tbody class='corpo_tabela'>";
$valor_total = 0;
while($linha = mysqli_fetch_assoc($consulta_receita_por_grupo)){
    $valor = $linha['valor'];
    $grupo = utf8_encode($linha['grupo']);
    $valor_total = $valor_total +$valor;

$html .="<tr>";
$html .="<td align=left><p>".$grupo."</p></td>";
$html .="<td align=left><p>".real_format($valor)."</p></td>";
$html .="</tr>";
}
$html .="<tr class='valor_total'>";
$html .="<td align=left><p>Total</p></td>";
$html .="<td align=left><p>".real_format($valor_total)."</p></td>";
$html .="</tr>";
$html .= "</tbody>";
$html .= "</table>";



/*despesa */
$html .= "<div class='tabela_relatoio'>
<table width=100% cellspacing='0' id='table_relatorio'>";
$html .= "<tbody class='top_tabela'>";
$html .="<tr>";
$html .="<td align=left style=width:500px;><p>Despesa</p></td>";
$html .="<td align=left><p size=2>Valor</p></td>";
$html .="</tr>";
$html .= "</tbody>";


$html .= "<tbody class='corpo_tabela'>";
$valor_total = 0;
while($linha = mysqli_fetch_assoc($consulta_despesa_por_grupo)){
    $valor = $linha['valor'];
    $grupo = utf8_encode($linha['grupo']);
    $tipo = utf8_encode($linha['tipo']);
    if($tipo == "Despesa Fixa"){ $tipo = "Fixa";
    }
    if($tipo == "Despesa Variáveis"){
        $tipo ="Variável";
    }
    $valor_total = $valor_total +$valor;


$html .="<tr>";
$html .="<td align=left><p>".$grupo."</p></td>";
$html .="<td align=left><p>".real_format($valor)."</p></td>";
$html .="</tr>";
}


$html .="<tr class='valor_total'>";
$html .="<td align=left><p>Total</p></td>";
 
$html .="<td align=left><p>".real_format($valor_total)."</p></td>";
$html .="</tr>";
$html .= "</tbody>";
$html .= "</table>";

/*estoque */
$html .= "<div class='tabela_relatoio'>
<table width=100% cellspacing='0' id='table_relatorio'>";
$html .= "<tbody class='top_tabela'>";
$html .="<tr>";
$html .="<td align=left style=width:500px;><p>Estoque</p></td>";
$html .="<td align=left><p size=2>Valor</p></td>";
$html .="</tr>";
$html .= "</tbody>";


$html .= "<tbody class='corpo_tabela'>";
$html .="<tr class='valor_total'>";
$html .="<td align=left><p>Estoque</p></td>";
$html .="<td align=left><p>".real_format($valor_total_estoque)."</p></td>";
$html .="</tr>";
$html .= "</tbody>";
$html .= "</table>";


/*patrimonio */
$html .= "<div class='tabela_relatoio'>
<table width=100% cellspacing='0' id='table_relatorio'>";
$html .= "<tbody class='top_tabela'>";
$html .="<tr>";
$html .="<td align=left style=width:500px;><p>Patrimônio</p></td>";
$html .="<td align=left><p size=2>Valor</p></td>";
$html .="</tr>";
$html .= "</tbody>";


$html .= "<tbody class='corpo_tabela'>";
$html .="<tr class='valor_total'>";
$html .="<td align=left><p>Patrimonio</p></td>";
$html .="<td align=left><p>".real_format($valor_total_patrimonio_equipamentos)."</p></td>";
$html .="</tr>";
$html .= "</tbody>";
$html .= "</table>";


/*Receita a liquidar */
$html .= "<div class='tabela_relatoio'>
<table width=100% cellspacing='0' id='table_relatorio'>";
$html .= "<tbody class='top_tabela'>";
$html .="<tr>";
$html .="<td align=left style=width:500px;><p>Receita a liquidar</p></td>";
$html .="<td align=left><p size=2>Valor</p></td>";
$html .="</tr>";
$html .= "</tbody>";


$html .= "<tbody class='corpo_tabela'>";
$html .="<tr>";
$html .="<td align=left><p>Pedidos Entregues</p></td>";
$html .="<td align=left><p>".real_format($valor_total_receita_liquidar_entrega_realizada)."</p></td>";
$html .="</tr>";
$html .="<tr>";
$html .="<td align=left><p>Pedidos Não Entregues</p></td>";
$html .="<td align=left><p>".real_format($valor_total_receita_liquidar_entrega_nao_realizada)."</p></td>";
$html .="</tr>";


$html .="<tr class='valor_total'>";
$html .="<td align=left><p>Total</p></td>";
 
$html .="<td align=left><p>".real_format($valor_total_receita_a_liquidar)."</p></td>";
$html .="</tr>";
$html .= "</tbody>";
$html .= "</table>";


/*despesa a pagar*/
$html .= "<div class='tabela_relatoio'>
<table width=100% cellspacing='0' id='table_relatorio'>";
$html .= "<tbody class='top_tabela'>";
$html .="<tr>";
$html .="<td align=left style=width:500px;><p>Despesa a Pagar</p></td>";
$html .="<td align=left><p size=2>Valor</p></td>";
$html .="</tr>";
$html .= "</tbody>";


$html .= "<tbody class='corpo_tabela'>";
$valor_total = 0;
while($linha = mysqli_fetch_assoc($consulta_despesa_a_pagar_por_grupo)){
    $valor = $linha['valor'];
    $grupo = utf8_encode($linha['grupo']);
    $tipo = utf8_encode($linha['tipo']);
    if($tipo == "Despesa Fixa"){ $tipo = "Fixa";
    }
    if($tipo == "Despesa Variáveis"){
        $tipo ="Variável";
    }
    $valor_total = $valor_total +$valor;

$html .="<tr>";
$html .="<td align=left><p>".$grupo."</p></td>";
$html .="<td align=left><p>".real_format($valor)."</p></td>";
$html .="</tr>";
}

$html .="<tr>";
$html .="<td align=left><p>Empréstimo 2023</p></td>";
$html .="<td align=left><p>".real_format($valor_total_apartir_2023)."</p></td>";
$html .="</tr>";

$html .="<tr>";
$html .="<td align=left><p>Empréstimo 2024</p></td>";
$html .="<td align=left><p>".real_format($valor_total_apartir_2024)."</p></td>";
$html .="</tr>";

$html .="<tr class='valor_total'>";
$html .="<td align=left><p>Total</p></td>";
$html .="<td align=left><p>".real_format($valor_total + $valor_total_apartir_2024 + $valor_total_apartir_2023)."</p></td>";
$html .="</tr>";
$html .= "</tbody>";
$html .= "</table>";

$html .= "</div>";




use Dompdf\Dompdf;

include("../../../pdf/dompdf/autoload.inc.php");

$dompdf = new DOMPDF();
$dompdf->setPaper('a4', 'portrait');
$codigo_html = $html;
$dompdf -> loadHtml('<link href="../../../_css/cotacaoPdf.css" rel="stylesheet">'. $codigo_html );

ob_clean(); 
$dompdf->render();
//renderizar com o html


//exibibir a página
$dompdf ->stream("Relatorio geral",array("Attachment"=>false));//para realizar o download somente alterar para true

file_put_contents("cotacao.pdf", $output);
// redirecionamos o usuário para o download do arquivo
die("<script>location.href='minuta.pdf';</script>");
?>