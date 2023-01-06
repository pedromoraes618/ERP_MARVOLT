<?php 
$ano = date('Y');
$mes = date('m');
$dia = date('d');
$ano_anterior = date('Y') - 1;

//despesas dos ultimos 12 meses
$select =" SELECT sum(valor) as valor_despesa from lancamento_financeiro ";
if($mes == 12){
$select .= "where  status = 'Pago' and data_do_pagamento BETWEEN '$ano-01-01' and '$ano-$mes-$dia'"; 
}else{
$select .= "where  status = 'Pago' and data_do_pagamento BETWEEN '$ano_anterior-$mes-01' and '$ano-$mes-$dia'";
}
$consulta_despesa = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_despesa);
$valor_despesa = $linha['valor_despesa'];

//receita dos ultimos 12 meses
$select =" SELECT sum(valor) as valor_receita from lancamento_financeiro ";
if($mes == 12){
$select .= "where status = 'Recebido' and data_do_pagamento BETWEEN '$ano-01-01' and '$ano-$mes-$dia'";
}else{
$select .= "where status = 'Recebido' and data_do_pagamento BETWEEN '$ano_anterior-$mes-01' and '$ano-$mes-$dia'";
}

$consulta_despesa = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_despesa);
$valor_receita = $linha['valor_receita'];

//receita total
$select =" SELECT sum(valor) as receita_total  from lancamento_financeiro  where 
status = 'Recebido'";
$consulta_despesa = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consulta_despesa);
$receita_total = $linha['receita_total'];


$saldo = $valor_receita - $valor_despesa;
$lucratividade = ($saldo / $receita_total) *100
?>



<div class="dash">
    <div class="bloco">
        <div class="group">
            <div class="title">
                <h3>Dashboard - últimos 12 meses</h3>
            </div>
            <div class="group-card">
                <div id="card" class="bloco-1">
                    <div class="info">
                        <div class="info-1">
                            <p>Saldo em caixa</p>
                        </div>
                        <div class="info-2">
                            <p><?php echo real_format($saldo); ?></p>
                        </div>
                    </div>
                    <div class="icon">
                        <img src="images/carteira.png">
                    </div>
                </div>
                <div id="card" class="bloco-2">
                    <div class="info">
                        <div class="info-1">
                            <p>Receita</p>
                        </div>
                        <div class="info-2">
                            <p><?php echo real_format($valor_receita); ?></p>
                        </div>
                    </div>
                    <div class="icon">
                        <img src="images/receita.png">
                    </div>
                </div>
                <div id="card" class="bloco-3">
                    <div class="info">
                        <div class="info-1">
                            <p>Despesa</p>
                        </div>
                        <div class="info-2">
                            <p><?php echo real_format($valor_despesa); ?></p>
                        </div>
                    </div>
                    <div class="icon">
                        <img src="images/despesa.png">
                    </div>
                </div>
                <div id="card" class="bloco-4">
                    <div class="info">
                        <div class="info-1">
                            <p>lucratividade</p>
                        </div>
                        <div class="info-2">
                            <p><?php echo real_percent($lucratividade); ?></p>
                        </div>
                    </div>
                    <div class="icon">
                        <img src="images/lucratividade.png">
                    </div>
                    <ul>
                        <li>A lucratividade é baseada no cálculo <br>
                            L = (lucro líquido / Receita Total) *100 </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>