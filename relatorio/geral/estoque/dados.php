<?php 
include "../crud/query.php";
include "../../../_incluir/funcoes.php";

?>
<div class="operacional">
    <div class="title">
        <p>Estoque</p>
    </div>
    <table border="0" whidth="100%" cellspacing="0">
        <tbody class="top_tabela">
            <tr>
                <td style="width: 200px;">
                    <p>Data</p>
                </td>
                <td style="width: 400px;">
                    <p>Grupo</p>
                </td>
                <td style="width: 300px;">

                </td>
                <td>
                    <p>Valor</p>
                </td>
            </tr>
        </tbody>
        <tbody class="corpo_tabela">


            <tr>
                <td>
                    <p><?php echo $ano_ini. "-". $ano_fim ?></p>
                </td>

                <td>
                    <p>Produtos</p>
                </td>
                <td>

                </td>
                <td>
                    <p><?php echo real_format($valor_total_estoque); ?></p>
                </td>
            </tr>


        </tbody>
    </table>
</div>