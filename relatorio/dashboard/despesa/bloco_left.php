<?php 
include "../crud/despesa.php";
include "../../../_incluir/funcoes.php";
?>
<div class="relatorio">
    <div class="title">
        <h4>Despesa Detalhada</h4>
    </div>
    <nav>
        <ul>
            <?php 
            $valor_total = 0;
            while($linha = mysqli_fetch_assoc($consulta_somatorio_grupo_des)){ 
                $valor = $linha['totalPorGrupo'];
                $categoria = utf8_encode($linha['grupo']);
                $valorMultiplicado = 100 * $valor;
                $porcentagem = $valorMultiplicado / $somatorio;
                $valor_total = $valor  + $valor_total;
                ?>

            <li>
                <div class="info">
                    <p><?php echo $categoria; ?></p>
                    <p class="number"><?php echo real_format($valor); ?></p>
                </div>
                <div class="info-2">
                    <p><?php echo real_percent($porcentagem);?></p>
                </div>


            </li>
            <?php
        }
            ?>

        </ul>
    </nav>
</div>
<div class="footer">
    <div class="info">
        <p>Valor total</p>
    </div>
    <div class="info-2">
        <p><?php echo real_format($valor_total); ?></p>
    </div>
</div>