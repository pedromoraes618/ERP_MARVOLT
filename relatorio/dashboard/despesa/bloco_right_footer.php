<?php 
include "../crud/despesa.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio-right-footer">
    <div class="title">
        <h4> Nota fiscal Tipo Recebimento</h4>
    </div>
    <div class="bloco">
        <div class="info">
            <div class="title">
                <p>A vista</p>
            </div>

            <div class="info-1">
                <p>
                    <?php 
          
            echo $avista_nfe + $avista_nfs;
            ?>
                </p>
                <p>
                    <?php 
    
            echo real_format($soma_total_avista_nfs + $soma_total_avista_nfe);
            ?>
                </p>
            </div>
        </div>
        <hr>
        <div class="info">
            <div class="title">
                <p>Faturado</p>
            </div>
            <div class="info-1">
                <p>
                    <?php 
            echo $parcelado_nfs + $parcelado_nfe;

            ?>
                </p>
                <p>
                    <?php 
            echo real_format($soma_total_parcelado_nfs + $soma_total_parcelado_nfe);
            ?>
                </p>
            </div>
        </div>
    </div>
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