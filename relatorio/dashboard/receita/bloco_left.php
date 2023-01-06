<?php 
include "../crud/receita.php";
include "../../../_incluir/funcoes.php";
?>
<div class="relatorio">
    <div class="title">
        <h4>Receita Detalhada</h4>
    </div>
    <nav>
        <ul>
            <?php 
            $valor_total = 0;
            while($linha = mysqli_fetch_assoc($consulta_receita_detalhada)){ 
        
                
                $clinte = utf8_encode($linha['cliente']);
                $grupo = utf8_encode($linha['grupo']);
                $id_grupo = utf8_encode($linha['id_grupo']);
              
                if($id_grupo != 20 ){ // não incluir imprestimo em receita
                    $valor = $linha['valor'];
                    $valorMultiplicado = 100 * $valor;
                    $porcentagem = $valorMultiplicado / $somatorio_total_receita;
                    $valor_total = $valor + $valor_total;
                ?>

            <li>
                <div class="info">
                    <p><?php echo $clinte; ?></p>
                    <p class="sub_title"><?php echo $grupo; ?></p>
                    <p class="number"><?php echo real_format($valor); ?></p>
                </div>
                <div class="info-2">
                    <p><?php echo real_percent($porcentagem);?></p>
                </div>


            </li>
            <?php
            }
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
        <p><?php
             echo real_format($valor_total); 
             // echo real_format($somatorio_total_receita); 
        ?></p>
    </div>
</div>