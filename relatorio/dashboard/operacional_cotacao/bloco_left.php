<?php 
include "../crud/operacional_cotacao.php";
include "../../../_incluir/funcoes.php";

?>
<div id="relatorioc" class="relatorio">
    <div class="title">
        <h4>Cotação por cliente</h4>
    </div>
    <nav>
        <ul>
            <?php 
                $valor_total_cotacao_ganho = 0;
                $valor_total_cotacao_cliente = 0;
                 while($linha = mysqli_fetch_assoc($consulta_valores_cotacao)){
                $valor_total = ($linha['total']);
                $cliente = utf8_encode($linha['nome_fantasia']);
                $cliente_id = $linha['clienteID'];
                $valor_total_cotacao_cliente = $valor_total + $valor_total_cotacao_cliente;
                $valor_cotacao_ganho = cocatao_ganhas_cliente($conecta,$ano,$mes_ini,$mes_fim,$cliente_id);
                $valor_total_cotacao_ganho = $valor_cotacao_ganho + $valor_total_cotacao_ganho;
                ?>

            <li id_cliente=<?php echo $cliente_id; ?> cliente_nome_c=<?php echo $cliente; ?> style="cursor: pointer;">
            <input type="hidden" id="<?php echo $cliente_id; ?>" value="<?php echo $cliente; ?>">
                <div class="info">
                    <p><?php echo $cliente; ?></p>
                    <p class="sub_title"  title="Cotação Ganha"> <i style="color:green;margin-right:5px" class="fa-solid fa-handshake"
                           ></i><?php echo real_format($valor_cotacao_ganho); ?>
                    </p>
                    <p class="number" title="Valor total"> <i class="fa-solid fa-folder-tree"></i>
                        <?php echo real_format($valor_total); ?></p>
                </div>
                <div class="info-2">

                    <p style="margin:0 auto;" title="Margem">
                        <?php echo real_percent((($valor_total * 100)/$valor_total_cotacao));?></p>

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
            <p>Ctc. Total</p>
            <p><?php echo real_format($valor_total_cotacao_cliente); ?></p>
        </div>
        <hr>
        <div class="info">
            <p>Ctc. Ganho</p>
            <p><?php echo real_format($valor_total_cotacao_ganho); ?></p>
        </div>

    </div>
</div>
<script>
$("#relatorioc nav ul li ").click(function(e) {
    e.preventDefault();
    let id_cliente = $(this).attr("id_cliente")
    let cliente = document.getElementById(id_cliente);

    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value + "&cliente_id=" + id_cliente + "&cliente_nome=" + cliente.value,
        url: "operacional_cotacao/bloco_center_top_detalhado.php",
        success: function(result) {
            return $(".bloco-center-top").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value + "&cliente_id=" + id_cliente + "&cliente_nome=" + cliente.value,
        url: "operacional_cotacao/bloco_center_bottom_detalhado.php",
        success: function(result) {
            return $(".bloco-center-bottom").html(result);
        },
    });
 
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value + "&cliente_id=" + id_cliente + "&cliente_nome=" + cliente.value,
        url: "operacional_cotacao/bloco_right_footer_detalhado.php",
        success: function(result) {
            return $(".bloco-right-footer").html(result);
        },
    });

    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value + "&cliente_id=" + id_cliente + "&cliente_nome=" + cliente.value,
        url: "operacional_cotacao/bloco_right_bottom_detalhado.php",
        success: function(result) {
            return $(".bloco-right-bottom").html(result);
        },
    });
    // $.ajax({
    //     type: 'GET',
    //     data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
    //         .value,
    //     url: "comparativo/bloco_center_top2.php",
    //     success: function(result) {
    //         return $(".bloco-center-top").html(result);
    //     },
    // });

    // $(".bloco-center-bottom").css("display", "block")
    // $(".bloco-center-top").css("height", "250px")

})
</script>