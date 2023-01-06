<?php 
include "../crud/query.php";
include "../../../_incluir/funcoes.php";

?>
<div class="operacional">
    <div class="title">
        <p>Receita a liquidar</p>
    </div>
    <table border="0" whidth="100%" cellspacing="0">
        <tbody class="top_tabela">
            <tr>

            <td style="width: 200px;">
            <p>Grupo</p>
                </td>
                <td style="width: 400px;">
                    
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
                    <p>Pedidos Entregues</p>
                </td>
                <td>
                    <p></p>
                </td>
                <td>
                    <p></p>
                </td>
                <td>
                    <p><?php echo real_format($valor_total_receita_liquidar_entrega_realizada); ?></p>
                </td>
            </tr>
            <tr>

                <td>
                    <p>Pedidos Não entrgues</p>
                </td>
                <td>
                    <p></p>
                </td>
                <td>
                    <p></p>
                </td>
                <td>
                    <p><?php echo real_format($valor_total_receita_liquidar_entrega_nao_realizada); ?></p>
                </td>
            </tr>

            <tr class="valor_total">
                <td>Total</td>
                <td></td>
                <td>
                    <p></p>
                </td>
                <td><?php echo real_format($valor_total_receita_a_liquidar); ?></td>
            </tr>
        </tbody>
    </table>
</div>