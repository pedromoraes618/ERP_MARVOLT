<?php 
include "../crud/receita.php";
include "../../../_incluir/funcoes.php";

?>
<div class="relatorio_center_top">
    <div class="title">
        <h4>Top 5 Rceita por cliente</h4>
    </div>
    <nav>
        <ul>
            <?php
        $valor_total = 0;
            while($linha = mysqli_fetch_assoc($consulta_clientes_por_receita_agrupados)){
            $valor = $linha['valor'];
            $id_grupo_cliente = $linha['id'];
            $grupo_Cliente = utf8_encode($linha['grupo']);
            $valorMultiplicado = 100 * $valor;

            $porcentagem = $valorMultiplicado / $somtorio_receita_por_cliente;
            $porcentagem = real_percent_relatorio($porcentagem);
            ?>
            <li>
                <div class="bloco-dados">
                    <div class="info">
                        <div desc_grupo=<?php echo $grupo_Cliente; ?> id_grupo="<?php echo $id_grupo_cliente;?>" class="info-1">
                            <p><?php echo $grupo_Cliente; ?></p>
                        </div>
                        <div class="info-2">
                            <div class="barra">
                                <div style="width:<?php echo $porcentagem?>"></div>
                            </div>
                        </div>
                        <div class="info-3">
                            <p><?php echo real_format($valor); 
                            
                            $valor_total = $valor_total + $valor;
                            ?></p>

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
        data: "id_grupo_cliente_bloco_left=" + id_grp + "&filtroano=" + ano.value + "&filtromesini=" +
            mes_ini.value + "&filtromesfim=" + mes_fim.values + "&grupocliente=" + desc_grupo,
        url: "receita/bloco_left_detalhe_cliente.php",
        success: function(result) {
            return $(".bloco-left").html(result);
        },
    });
    $.ajax({
        type: 'GET',
        data: "id_grupo_cliente_bloco_center_bottom=" + id_grp + "&filtroano=" + ano.value + "&filtromesini=" +
            mes_ini
            .value + "&filtromesfim=" + mes_fim.values + "&grupocliente=" + desc_grupo,
        url: "receita/bloco_center_bottom_detalhado_grupo.php",
        success: function(result) {
            return $(".bloco-center-bottom").html(result);
        },
    });
})
</script>