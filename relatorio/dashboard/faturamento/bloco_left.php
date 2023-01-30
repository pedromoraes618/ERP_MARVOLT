<?php 
include "../crud/faturamento.php";
include "../../../_incluir/funcoes.php";
?>
<div class="relatorio">
    <div class="title">
        <h4>Faturamento Por cliente</h4>
    </div>
    <nav style="cursor: pointer;">
        <ul>
            <?php 
            $valor_total = 0;
            while($linha = mysqli_fetch_assoc($consultar_nfe_saida_agrupado)){ 
        
                
                $clinte = utf8_encode($linha['cliente']);
                $clienteID = $linha['clienteid'];
                    $valor = $linha['valor_total_nfe'];
                    $cnpj = $linha['cnpj'];
                    
                    
                    $valorMultiplicado = 100 * $valor;
                    $porcentagem = $valorMultiplicado / $valor_total_nfe_saida;
                    $valor_total = $valor + $valor_total;
                ?>

            <li cnpjclt=<?php echo $cnpj; ?> id_cliente="<?php echo $clienteID; ?>" >
                <div  class="info">
                    <p><?php echo $clinte; ?></p>
                    <p class="number"><?php echo real_format($valor); ?></p>
                </div>
                <div id="cursor_pointer"  class="info-2">
                    <p title="Porcentagem em relação ao faturamento total"><?php echo real_percent($porcentagem);?></p>
                </div>


            </li>
            <?php
            
        }
            ?>

        </ul>
    </nav>
</div>
<div class="footer">
    <div class="info">
        <p>Valor total</p>
    </div>
    <div class="info-2">
        <p><?php
             echo real_format($valor_total); 
             // echo real_format($somatorio_total_receita); 
        ?></p>
    </div>
</div>

<script>
    $(".relatorio nav ul li ").click(function(e) {

    let id_cliente = $(this).attr("id_cliente")
    let cnpj = $(this).attr("cnpjclt")
  
    
    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value + "&cliente_id=" + id_cliente+"&cliente_cnpj="+cnpj,
        url: "faturamento/bloco_center_top_detalhado.php",
        success: function(result) {
            return $(".bloco-center-top").html(result);
        },
    });

    $.ajax({
        type: 'GET',
        data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
            .value + "&cliente_id=" + id_cliente+"&cliente_cnpj="+cnpj,
            url: "faturamento/bloco_right_top_detalhado.php",
        success: function(result) {
            return $(".bloco-right-footer").html(result);
        },
    });

        // $(".bloco-center-bottom").css("display","block")
    // $(".bloco-center-top").css("height","250px")
    // $.ajax({
    //     type: 'GET',
    //     data: "filtroano=" + ano.value + "&filtromesini=" + mes_ini.value + "&filtromesfim=" + mes_fim
    //         .value + "&cliente_cnpj=" + cnpj,
    //     url: "faturamento/bloco_center_bottom_detalhado.php",
    //     success: function(result) {
    //         return $(".bloco-center-bottom").html(result);
    //     },
    // });
 
 

})
</script>