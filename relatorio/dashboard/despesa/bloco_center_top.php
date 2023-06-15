<?php 
include "../crud/despesa.php";
include "../../../_incluir/funcoes.php";

?>
<div class="relatorio_center_top">
    <div class="title">
        <h4>Despesas por Grupo</h4>
    </div>
    <nav>
        <ul>
            <?php
        $valor_total = 0;
            while($linha = mysqli_fetch_assoc($consulta_top_seis_despesa)){
            $valor = $linha['totalPorGrupo'];
            $id_grupo = $linha['cl_id'];
            $categoria = utf8_encode($linha['grupo']);
            $valorMultiplicado = 100 * $valor;
                
            $porcentagem = $valorMultiplicado / $soma_total_grupo;
            $porcentagem = real_percent_relatorio($porcentagem);

            $valor_total = $valor  + $valor_total;
            ?>
            <li>
                <div class="bloco-dados">
                    <div class="info">
                        <div id_grupo="<?php echo $id_grupo;?>" desc_grupo="<?php echo $categoria; ?>" class="info-1">
                            <p><?php echo $categoria; ?></p>
                        </div>
                        <div class="info-2">
                            <div class="barra">
                                <div style="width:<?php echo $porcentagem?>"></div>
                            </div>
                        </div>
                        <div class="info-3">
                            <p><?php echo real_format($valor); ?></p>
                        </div>
                        <?php 
                    ?>
                    </div>  
                </div>
            </li>
            <?php
             }
            
            ?>

        </ul>
        <div class="resultado">
            <p>Total <?php echo real_format($valor_total); ?></p>
            <p class="subtitulo">
                Total 5 grupos
            </p>
        </div>

</div>
</nav>

</div>

<script>
$(".bloco-center-top nav ul li .info .info-1").click(function(e) {
    e.preventDefault();

    let id_grp = $(this).attr("id_grupo")
    let desc_grupo = $(this).attr("desc_grupo")
 
    $.ajax({
        type: 'GET',
        data: "id_cliente_bloco_left=" + id_grp + "&filtroano=" + ano.value + "&filtromesini=" + mes_ini
            .value + "&filtromesfim=" + mes_fim.values,
        url: "despesa/bloco_left_detalhe_cliente.php",
        success: function(result) {
            return $(".bloco-left").html(result);
        },
    });

    $.ajax({
        type: 'GET',
        data: "id_grupo_despesa_bloco_center_bottom=" + id_grp + "&filtroano=" + ano.value + "&filtromesini=" +
            mes_ini
            .value + "&filtromesfim=" + mes_fim.values + "&grupo_despesa=" + desc_grupo,
        url: "despesa/bloco_center_bottom_detalhado_grupo.php",
        success: function(result) {
            return $(".bloco-center-bottom").html(result);
        },
    });
})
</script>