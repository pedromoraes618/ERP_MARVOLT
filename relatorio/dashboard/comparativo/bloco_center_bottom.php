<?php 
include "../crud/comparativo.php";
include "../../../_incluir/funcoes.php";
?>

<div class="relatorio_center_bottom">
    <div class="title">
        <h4>Receita x Despesa por Pedido de Compra</h4>
    </div>
    <!-- <div class="bloco-tipo">
        <button id="rb1">R1</button>
        <button id="rb2">R2</button>
    </div> -->


    <div class="bloco">

        <div class="bloco-1-r-d">

            <nav class="nav-1">
                <ul>
                    <?php 
                      $cont = 0;
                    foreach($array_valores_pd_compra as $linha){
                      $cont = $cont + 1;
                        if($cont <= 4){
                            $valor_venda = $linha['valor_venda'];
                            $valor_compra = $linha['valor_compra'];
                            $cliente = $linha['cliente'];
                            $cliente_id = $linha['cliente_id'];
                            $valor_total = $valor_venda + $valor_compra;
                            $valor_percent_venda = real_percent_grafico(($valor_venda * 100) / $valor_total);
                            $valor_percent_compra = real_percent_grafico(($valor_compra * 100) / $valor_total);
                            
                        ?>

                    <li>
                        <div id_cliente=<?php echo $cliente_id;?> class="info-1">
                            <div class="titulo">
                                <p><?php echo $cliente; ?></p>
                            
                            </div>
                            <div class="barra-info">
                                <div style="width:<?php echo $valor_percent_venda ?>%" class="barra-1"></div>
                                <div style="width:<?php echo $valor_percent_compra ?>%;left: <?php echo $valor_percent_venda ?>%"
                                    class="barra-2"></div>
                            </div>
                            <div id="<?php echo $cliente_id; ?>" class="bloco-sub-dados">
                                <div class="bloco-sub-info">
                                    <div class="bloco-sub-1">
                                        <p>Receita <i style="color: green;" class="fa-solid fa-money-bill-wave"></i></p>
                                   
                                        <hr>
                                        <p><?php echo real_format($valor_venda); ?></p>
                                    </div>
                                    <hr>
                                    <div class="bloco-sub-1">
                                        <p>Despesa <i style="color:red"class="fa-regular fa-money-bill-1"></i></p>
                
                                        <hr>
                                        <p><?php echo real_format($valor_compra); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php
                    }};
                    ?>
                </ul>

            </nav>

            <nav class="nav-1">
                <ul>
                    <?php 
                      $cont = 0;
                    foreach($array_valores_pd_compra as $linha){
                      $cont = $cont + 1;
                 
                
                        if($cont > 4 and $cont <= 8){
                            $valor_venda = $linha['valor_venda'];
                            $valor_compra = $linha['valor_compra'];
                            $cliente = $linha['cliente'];
                            $cliente_id = $linha['cliente_id'];
                            $valor_total = $valor_venda + $valor_compra;
                            $valor_percent_venda = real_percent_grafico(($valor_venda * 100) / $valor_total);
                            $valor_percent_compra = real_percent_grafico(($valor_compra * 100) / $valor_total);
                     
                        ?>

                    <li>
                        <div id_cliente=<?php echo $cliente_id;?> class="info-1">
                            <div class="titulo">
                                <p><?php echo $cliente; ?></p>
                            </div>
                            <div class="barra-info">
                                <div style="width:<?php echo $valor_percent_venda ?>%" class="barra-1"></div>
                                <div style="width:<?php echo $valor_percent_compra ?>%;left: <?php echo $valor_percent_venda ?>%"
                                    class="barra-2"></div>
                            </div>
                            <div id="<?php echo $cliente_id; ?>" class="bloco-sub-dados">
                                <div class="bloco-sub-info">
                                    <div class="bloco-sub-1">
                                        <p>Receita <i style="color: green;" class="fa-solid fa-money-bill-wave"></i></p>
                                   
                                        <hr>
                                        <p><?php echo real_format($valor_venda); ?></p>
                                    </div>
                                    <hr>
                                    <div class="bloco-sub-1">
                                        <p>Despesa <i style="color:red"class="fa-regular fa-money-bill-1"></i></p>
                
                                        <hr>
                                        <p><?php echo real_format($valor_compra); ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </li>
                    <?php
                    }};
                    ?>
                </ul>

            </nav>



        </div>



    </div>


</div>

<script>
$(".bloco-1-r-d .nav-1 .info-1").mouseover(function(e) {
    e.preventDefault();
    let id_cliente = $(this).attr("id_cliente")
    $(".bloco-1-r-d .nav-1 #" + id_cliente).css("display", "block")
})

$(".bloco-1-r-d .nav-1 .info-1").mouseout(function(e) {
    e.preventDefault();
    let id_cliente = $(this).attr("id_cliente")

    $(".bloco-1-r-d .nav-1 #" + id_cliente).css("display", "none")


})
</script>