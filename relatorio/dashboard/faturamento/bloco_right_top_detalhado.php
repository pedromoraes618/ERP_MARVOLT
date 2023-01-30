<?php 
include "../crud/faturamento.php";
include "../../../_incluir/funcoes.php";
?>

<!-- detalhado por cliente -->
<div class="relatorio-right-footer">
    <div class="title">
        <h4>Valores - <?php echo $nome_fantasia; ?></h4>
    </div>
    <div class="bloco" style="height:420px; overflow-y: auto;border:0px">
        <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div title="Média inclui nfe e nfs saida" class="info-card">
                <p class="cabecalho">Média faturamento</p>
                <p><?php echo  real_format($media_faturamento); ?> </p>
            </Div>
        </div>
        <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div class="info-card">
                <p class="cabecalho">Ticket médio</p>
                <p><?php echo  real_format($ticket_medio); ?> </p>
            </Div>
        </div>
        <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div class="info-card">
                <p class="cabecalho">Total Nfe saida</p>
                <p><?php echo  real_format($valor_total_nfe_saida); ?> </p>
            </Div>
        </div>
        <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div class="info-card">
                <p class="cabecalho">Total Nfs saida</p>
                <p><?php echo  real_format($valor_total_nfs_saida); ?> </p>
            </Div>
        </div>
        <!-- <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div class="info-card">
                <p class="cabecalho">Total Nfe Entrada</p>
                <p><?php // echo real_format($valor_total_nfe_entrada); ?> </p>
            </Div>
        </div> -->
        <!-- <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div class="info-card">
                <p class="cabecalho">Total em Estoque</p>
                <p><?php // echo real_format($valor_estoque); ?> </p>
            </Div>
        </div> -->
        <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div class="info-card">
                <p class="cabecalho">Margem de lucro</p>
                <p><?php echo real_percent($margem_total); ?> </p>
            </Div>
        </div>
        <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div class="info-card">
                <p class="cabecalho">Desconto valor orçado</p>
                <p><?php echo real_format($valor_desconto_total); ?> </p>
            </Div>
        </div>
        <div class="card_media">
            <div class="leg-1"><img src="../../images/total_cotacao.png"></div>
            <Div class="info-card">
                <p class="cabecalho">Média desconto Vlr Orçado e fechado</p>
                <p><?php echo real_format($media_desconto_orcado); ?> </p>
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