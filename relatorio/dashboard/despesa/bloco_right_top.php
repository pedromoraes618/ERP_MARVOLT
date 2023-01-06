<?php 
include "../crud/despesa.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio-right-top">
    <div class="title">
        <h4> Depesa por tipo </h4>
    </div>

    <nav>
        <ul>
            <?php
        while($linha = mysqli_fetch_assoc($total_valor_despesa_por_tipo)){
        $valor = $linha['somatorio'];
        $tipo = utf8_encode($linha['tipo']);
        $id = ($linha['id']);
        if($tipo == "Despesa Fixa"){
            $tipo = "Fixa";

        }elseif($tipo == "Despesa Variáveis"){
            $tipo = "Variáveis";
        }
        $valorMultiplicado = 100 * $valor;
        $porcentagem = $valorMultiplicado / $somatorio;
        $porcentagem = real_percent_relatorio($porcentagem);

        ?>
            <li>
                <div class="bloco-dados">
                    <div id_tipo=<?php echo $id; ?> percent=<?php echo $porcentagem;?>  class="info">
                        <div class="info-1">
                            <p><?php echo $tipo; ?></p>
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
                        <div id="<?php echo $id; ?>" class="bloco-sub-dados">
                            <p><?php echo $porcentagem; ?></p>
                            <hr>
                            <p><?php echo real_format($valor); ?></p>
                        </div>

                    </div>
                </div>
            </li>
            <?php }?>

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
</script>