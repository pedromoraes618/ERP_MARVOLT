<?php 
include "../crud/query.php";
include "../../../_incluir/funcoes.php";

?>
<div class="operacional">
    <div class="title">
        <p>Despesa</p>
    </div>
    <table border="0" whidth="100%" cellspacing="0">
        <tbody class="top_tabela">
            <tr>
                <td style="width: 200px;">
                    <p>Data</p>
                </td>
                <td  style="width: 400px;">
                    <p>Grupo</p>
                </td>
                <td  style="width: 300px;">
                    <p>Tipo</p>
                </td>
                <td>
                    <p>Valor</p>
                </td>
            </tr>
        </tbody>
        <tbody class="corpo_tabela">
            <?php 
        $valor_total = 0;
            while($linha = mysqli_fetch_assoc($consulta_despesa_por_grupo)){
                $valor = $linha['valor'];
                $grupo = utf8_encode($linha['grupo']);
                $tipo = utf8_encode($linha['tipo']);
                if($tipo == "Despesa Fixa"){ $tipo = "Fixa";
                }
                if($tipo == "Despesa Variáveis"){
                    $tipo ="Variável";
                }
                $valor_total = $valor_total +$valor;
        
            ?>
            <tr>
                <td>
                    <p><?php echo $ano_ini. "-". $ano_fim ?></p>
                </td>

                <td>
                    <p><?php echo $grupo; ?></p>
                </td>
                <td>
                    <p><?php echo $tipo; ?></p>
                </td>
                <td>
                    <p><?php echo real_format($valor); ?></p>
                </td>

            </tr>
            <?php } ?>
            <tr class="valor_total">
                <td>Total</td>
                <td></td>
                <td></td>
                <td><?php echo real_format($valor_total); ?></td>
            </tr>

        </tbody>
    </table>
</div>