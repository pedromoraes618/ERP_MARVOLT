<?php 
include "../crud/operacional_cotacao.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio-right-footer" >
    <div class="title">
        <h4>Media Datas Pdc</h4>
    </div>
    <div class="bloco" style="height:210px; overflow-y: auto;border:0px">
        <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div class="info-card">
                <p class="cabecalho">Média para fechamoto</p>
                <p><?php echo  valor_qtd($dias_para_fechamento)." dias"; ?> </p>
            </Div>
        </div>
        <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div class="info-card">
                <p class="cabecalho">Media Compra de produtos</p>
                <p><?php echo valor_qtd($dias_para_compra) ?></p>
            </Div>
        </div>
        <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div class="info-card">
                <p class="cabecalho">Média Chegada de produtos</p>
                <p><?php echo valor_qtd($media_para_chegada_produto) ?></p>
            </Div>
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