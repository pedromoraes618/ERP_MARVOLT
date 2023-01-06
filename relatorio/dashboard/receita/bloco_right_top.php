<?php 
include "../crud/receita.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio-right-top">
    <div class="title">
        <h4>Nota Por operação</h4>
    </div>
    <div class="bloco">
        <div class="info">
            <div class="title">
                <p>Estaudal</p>
            </div>

            <div class="info-1">
                <p>
                    <?php 
                    /*estadual */
            $valorMultiplicado = 100 * $soma_estaudal_nfe_nfs;
            $porcentagem = $valorMultiplicado / $soma_total_nfe_nfs;
            $porcentagem = real_percent_relatorio($porcentagem);
          
            echo $porcentagem;
            ?>
                </p>
                <p>
                    <?php 
          
       
            echo real_format($soma_estaudal_nfe_nfs);
            ?>
                </p>
            </div>
        </div>
        <hr>
        <div class="info">
            <div class="title">
                <p>Interestadual</p>
            </div>
            <div class="info-1">
                <p>
                    <?php 
                                   /*Interestadual */
            $valorMultiplicado = 100 * $soma_interestadual_nfe_nfs;
            $porcentagem = $valorMultiplicado / $soma_total_nfe_nfs;
            $porcentagem = real_percent_relatorio($porcentagem);
            echo $porcentagem;

            ?>
                </p>
                <p>
                    <?php 
            echo real_format($soma_interestadual_nfe_nfs);
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