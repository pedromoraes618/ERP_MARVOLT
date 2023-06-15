<nav id="cabecalho">
    <ul>

        <li>
            Financeiro
        </li>

    </ul>
</nav>

<table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
    <tbody>

        <tr id="cabecalho_pesquisa_consulta">
            <?php
            ?>
            <td>
                <p>Conta</p>
            </td>
            <td>
                <p>Saldo Inicial</p>
            </td>
            <td>
                <p>Receita (+)</p>
            </td>
            <td>
                <p>Despesa (-)</p>
            </td>
            <td>
                <p>Total</p>
            </td>
            <td>

            </td>
        </tr>

        <?php
        while ($linha = mysqli_fetch_assoc($consulta_saldo_bnaco_receita_mes)) {
            $valor_receita = $linha['valor'];
            $banco = $linha['cl_banco'];
            $conta_financeira_id = $linha['contafid'];



            if ($pesquisaData == "") {
            } else {
                $div1 = explode("/", $_GET['CampoPesquisaData']);
                $pesquisaData = $div1[2] . "-" . $div1[1] . "-" . $div1[0];
                $mes_caixa = $div1[1];
            }
            if ($pesquisaDataf == "") {
            } else {
                $div2 = explode("/", $_GET['CampoPesquisaDataf']);
                $pesquisaDataf = $div2[2] . "-" . $div2[1] . "-" . $div2[0];
            }


            $select = "SELECT  * from tb_caixa where cl_mes = $mes and cl_ano= $ano and cl_banco ='$banco' ";
            $consulta_saldo_inicil_conta_financeira = mysqli_query($conecta, $select);
            $linha = mysqli_fetch_assoc($consulta_saldo_inicil_conta_financeira);
            $saldo_inicial_conta_financeira = $linha['cl_valor_fechamento'];


            $select = " SELECT sum(valor) as valor,ctf.cl_id, ctf.cl_banco from lancamento_financeiro as fn inner join tb_conta_financeira as ctf on ctf.cl_id =fn.cl_conta_financeira_id where fn.status ='Pago' and fn.data_do_pagamento between '$pesquisaData' and '$pesquisaDataf'and ctf.cl_id= '$conta_financeira_id' ";
            $consulta_saldo_bnaco_despesa_mes = mysqli_query($conecta, $select);
            $linha = mysqli_fetch_assoc($consulta_saldo_bnaco_despesa_mes);
            $valor_despesa = $linha['valor'];
        ?>

            <tr id="linha_pesquisa">

                <td>
                    <p>
                        <font size="2"><?php echo ($banco); ?></font>
                    </p>
                </td>
                <td>
                    <p>
                        <font size="2"><?php echo real_format($saldo_inicial_conta_financeira); ?></font>
                    </p>
                </td>

                <td>
                    <p>
                        <font size="2"><?php echo real_format($valor_receita); ?></font>
                    </p>
                </td>
                <td>
                    <p>
                        <font size="2"><?php echo real_format($valor_despesa); ?></font>
                    </p>
                </td>
                <td>
                    <p>
                        <font size="2"><?php echo real_format($saldo_inicial_conta_financeira + $valor_receita - $valor_despesa); ?></font>
                    </p>
                </td>
                <td>

                </td>


            </tr>


        <?php
        }


        ?>



    </tbody>
</table>