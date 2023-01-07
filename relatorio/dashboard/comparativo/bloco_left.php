<?php 
include "../crud/comparativo.php";
include "../../../_incluir/funcoes.php";
?>
<div class="relatorio">
    <div class="title">
        <h4>Receita & Despesa Detalhada</h4>
    </div>
    <nav>
        <ul>
            <?php 
                $valor_soma_venda = 0;
                $valor_soma_compra = 0;

            while($linha = mysqli_fetch_assoc($consulta_valor_receita_despesa_pd_compra_2)){ 
                $cliente = utf8_encode($linha['nome_fantasia']);
                $cliente_id = utf8_encode($linha['id_cliente']);
                $valor_total_venda = $linha['valor_total_venda'];
                $valor_total_compra = $linha['valor_total_compra'];

                $valor_soma_venda = $valor_soma_venda + $valor_total_venda;
                $valor_soma_compra = $valor_soma_compra + $valor_total_compra;
                
                $saldo = $valor_total_venda - $valor_total_compra;
                $lucratividade = ($saldo / $valor_total_venda) *100
                ?>

            <li id_cliente=<?php echo $cliente_id; ?> cliente_nome=<?php echo $cliente; ?> style="cursor: pointer;">
                <div class="info">
                    <p><?php echo $cliente; ?></p>
                    <p class="sub_title"><i style="margin-right:5px;color: rgb(173,16,16);"
                            class="fa-solid fa-money-check-dollar"></i><?php echo real_format($valor_total_compra); ?>
                    </p>
                    <p class="number"> <i style="color: rgb(20,148,71);" class="fa-solid fa-sack-dollar"></i>
                        <?php echo real_format($valor_total_venda); ?></p>
                </div>
                <div class="info-2">

                    <p style="margin:0 auto;" title="lucratividade referente ao valor de venda e compra">
                        <?php echo real_percent($lucratividade);?></p>

                </div>
            </li>
            <?php
            
        }
            ?>

        </ul>
    </nav>
</div>
<div class="footer">

    <div class="footer-2">
        <div class="info">
            <p>Receita</p>
            <p><?php echo real_format($valor_soma_venda); ?></p>
        </div>
        <hr>
        <div class="info">
            <p>Despesa</p>
            <p><?php echo real_format($valor_soma_compra); ?></p>
        </div>

    </div>
</div>
<script>
$(".relatorio nav ul li ").click(function(e) {
    e.preventDefault();
    let id_cliente = $(this).attr("id_cliente")
    let cliente = $(this).attr("cliente_nome");
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value+"&cliente_id="+id_cliente+"&cliente_nome="+cliente,
        url: "comparativo/bloco_center_bottom_detalhado.php",
        success: function(result) {
            return $(".bloco-center-bottom").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value,
        url: "comparativo/bloco_center_top2.php",
        success: function(result) {
            return $(".bloco-center-top").html(result);
        },
    });
 
    $(".bloco-center-bottom").css("display","block")
    $(".bloco-center-top").css("height","250px")

})
</script>