<?php 
include "../crud/receita.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio-right-top">
    <div class="title">
        <h4>Nfe por Operação</h4>
    </div>

    <nav>
        <ul>
            <?php
        $operacao = "Estadual";
        $valorMultiplicado = 100 * $somatorio_total_nfe_saida_estadual;
        $porcentagem = $valorMultiplicado / $somatorio_total_nfe_saida;
        $porcentagem = real_percent_relatorio($porcentagem);

        ?>
            <li>
                <div class="bloco-dados">
                    <div id_tipo=<?php echo $estadual; ?> percent=<?php echo $porcentagem;?> class="info">
                        <div class="info-1">
                            <p><?php echo $operacao; ?></p>
                        </div>
                        <div class="info-2">
                            <div class="barra">
                                <?php if($porcentagem > 50){
                                    ?>
                                <div style="background-color:red;width:<?php echo $porcentagem; ?>"></div>
                                <?php }else{
                                    ?>
                                <div style="background-color:#032dab;width:<?php echo $porcentagem; ?>">
                                </div>
                                <?php
                                } ?>

                            </div>
                        </div>
                        <div id="<?php echo $estadual; ?>" class="bloco-sub-dados">
                            <p><?php echo $porcentagem; ?></p>
                            <hr>
                            <p><?php echo real_format($somatorio_total_nfe_saida_estadual); ?></p>
                        </div>

                    </div>
                </div>
            </li>
            <?php
        $operacao = "Interestadual";
        $valorMultiplicado = 100 * $somatorio_total_nfe_saida_inerestadual;
        $porcentagem = $valorMultiplicado / $somatorio_total_nfe_saida;
        $porcentagem = real_percent_relatorio($porcentagem);

        ?>
            <li>
                <div id="bloco-2" class="bloco-dados">
                    <div id_tipo=<?php echo $interestadual; ?> percent=<?php echo $porcentagem;?> class="info">
                        <div class="info-1">
                            <p><?php echo $operacao; ?></p>
                        </div>
                        <div class="info-2">
                            <div class="barra">
                                <?php if($porcentagem > 50){
                                    ?>
                                <div style="background-color:red;width:<?php echo $porcentagem; ?>"></div>
                                <?php }else{
                                    ?>
                                <div style="background-color:#032dab;width:<?php echo $porcentagem; ?>">
                                </div>
                                <?php
                                } ?>

                            </div>
                        </div>
                        <div id="<?php echo $interestadual; ?>" class="bloco-sub-dados">
                            <p><?php echo $porcentagem; ?></p>
                            <hr>
                            <p><?php echo real_format($somatorio_total_nfe_saida_inerestadual); ?></p>
                        </div>

                    </div>
                </div>
            </li>
        </ul>

</div>
</nav>
</div>
<script>
$(".relatorio-right-top .bloco-dados .info").mouseover(function(e) {
    e.preventDefault();
    let id_tipo = $(this).attr("id_tipo")

    $(".relatorio-right-top .bloco-dados  #" + id_tipo).css("display", "block")
})
$(".relatorio-right-top .bloco-dados  .info").mouseout(function(e) {
    let id_tipo = $(this).attr("id_tipo")
    $(".relatorio-right-top .bloco-dados  #" + id_tipo).css("display", "none")
})

$(".relatorio-right-top #bloco-2 .info").mouseover(function(e) {
    e.preventDefault();
    let id_tipo = $(this).attr("id_tipo")
  
    $(".relatorio-right-top #bloco-2  #" + id_tipo).css("display", "block")
})
$(".relatorio-right-top #bloco-2 .info").mouseout(function(e) {
    $(".relatorio-right-top #bloco-2  #" + id_tipo).css("display", "none")
})
</script>