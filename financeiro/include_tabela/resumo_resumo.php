<nav id="cabecalho">
    <ul>

        <li>
        Cx - Resumo
        </li>

    </ul>
</nav>

<table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
    <tbody>

        <tr id="cabecalho_pesquisa_consulta">

            <td>
                <p>Receita A receber (+)</p>
            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>
                <p><?php echo real_format($somaReceitaAreceber); ?></p>
            </td>

        </tr>
        <tr id="cabecalho_pesquisa_consulta">

            <td>
                <p>Despessa A Pagar (-)</p>
            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>
                <p><?php echo real_format($somaDespesaApagar); ?></p>
            </td>

        </tr>

        <tr id="cabecalho_pesquisa_consulta">

            <td>
                <p>Total</p>
            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>
                <p><?php echo real_format($somaReceitaAreceber-$somaDespesaApagar); ?></p>
            </td>

        </tr>

        <?php
                             
                        
                    
        
            ?>
    </tbody>
</table>