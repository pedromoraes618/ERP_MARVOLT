<?php 
include("../../conexao/sessao.php");
include("../../conexao/conexao.php"); 


$select = "SELECT  tb_subgrupo_receita_despesa.subgrupo as sbgrupo,sum(lancamento_financeiro.valor) as total
from  lancamento_financeiro   inner join tb_subgrupo_receita_despesa
on lancamento_financeiro.grupoID = tb_subgrupo_receita_despesa.subGrupoID
inner join grupo_lancamento on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID 
where lancamento_financeiro.status = 'Pago' group by tb_subgrupo_receita_despesa.subgrupo,grupo order by total desc ";
$consulta_por_grupo = mysqli_query($conecta,$select);

$select = "SELECT sum(lancamento_financeiro.valor) as total
from  lancamento_financeiro   inner join tb_subgrupo_receita_despesa
on lancamento_financeiro.grupoID = tb_subgrupo_receita_despesa.subGrupoID
inner join grupo_lancamento on  tb_subgrupo_receita_despesa.grupo = grupo_lancamento.grupo_lancamentoID 
where lancamento_financeiro.status = 'Pago' ";
$consulta_valor_total = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_valor_total);
$somatorio = $linha['total'];

?>

<script type="text/javascript">
google.charts.load("current", {
    packages: ['corechart']
});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ["Element", "Density", {
            role: "style"
        }],
     
        <?php
   
        while($linha = mysqli_fetch_assoc($consulta_por_grupo)){
        $subgrupo = utf8_encode($linha['sbgrupo']);
        $valorTotalGrupo = utf8_encode($linha['total']);
        
        $valorMultiplicado = 100 * $valorTotalGrupo;
        $valorTotal = $valorMultiplicado / $somatorio;
        $valorTotal = number_format($valorTotal,2,".","")
        ?>
        ['<?php echo $subgrupo; ?>', <?php echo  ($valorTotal) ?>,"#b57333"],

        <?php
        }?>
    ]);

    var view = new google.visualization.DataView(data);
    view.setColumns([0, 1,
        {
            calc: "stringify",
            sourceColumn: 1,
            type: "string",
            role: "annotation"
        },
        2
    ]);

    var options = {
        title: "Despesa por grupo %",
        width: 1500,
        height: 500,
        bar: {
            groupWidth: "60%"
        },
        legend: {
            position: "none"
        },
    };
    var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
    chart.draw(view, options);
}
</script>
<div id="columnchart_values" style="width: 1500px; height: 300px;"></div>