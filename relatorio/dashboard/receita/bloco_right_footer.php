<?php 
include "../crud/receita.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio-right-footer">
    <div class="title">
        <h4>Nfe / Nfs</h4>
    </div>
    <div class="bloco">
        <div class="info">
            <div class="title">
                <p>NFE</p>
            </div>

            <div class="info-1">
                <p>
                    <?php 
          
            echo $qtd_nfe;
            ?>
                </p>
                <p>
                    <?php 
          

            echo real_format($somatorio_total_nfe_saida);
            ?>
                </p>
            </div>
        </div>
        <hr>
        <div class="info">
            <div class="title">
                <p>NFS</p>
            </div>
            <div class="info-1">
                <p>
                    <?php 
            echo $qtd_nfs;

            ?>
                </p>
                <p>
                    <?php 
            echo real_format($somatorio_total_nfs_saida);
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