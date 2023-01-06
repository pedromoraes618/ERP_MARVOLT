    <?php 
    include "../crud/receita.php";
    include "../../../_incluir/funcoes.php";


    ?>
    <div class="relatorio">
        <div class="title">
            <h4> <?php 
            if(isset($_GET['grupocliente'])){
                $desc_grupo = $_GET['grupocliente'];
                echo  "Receita - $desc_grupo ";
            }?></h4>
        </div>
        <nav>
            <ul>
                <?php 
                $valor_total = 0;
                while($linha = mysqli_fetch_assoc($consulta_clientes_agrupado_por_cnpj)){ 
                    $valor = $linha['valor'];
                    $cliente = utf8_encode($linha['cliente']);
                    $valorMultiplicado = 100 * $valor;
                    $porcentagem = $valorMultiplicado / $consulta_clientes_agrupado_por_cnpj_somatorio;
                    $valor_total = $valor + $valor_total;
                    ?>

                <li>
                    <div class="info">
                        <p><?php echo $cliente; ?></p>
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
            <p><?php echo real_format($valor_total);
            // echo real_format($somatoro_valor_total_nfe_por_cliente); 
                ?></p>
        </div>
    </div>