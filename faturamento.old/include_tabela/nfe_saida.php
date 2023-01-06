<nav id="cabecalho">
    <ul>
        <?php if(isset($_GET['pNfeSaida'])){?>
        <li>
            Faturamento Por Nfe Saida
        </li>
        <?php }
                ?>
    </ul>
</nav>

<table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
    <tbody>

        <tr id="cabecalho_pesquisa_consulta">
            <?php
                       
                          
                ?>
            <td>
                <p>Número Nfe</p>
            </td>
            <td>
                <p>Data de Saida</p>
            </td>
            <td>
                <p>Empresa</p>
            </td>
            <td>
                <p>Valor total</p>
            </td>
            <td>
                <p>Chave acesso</p>
            </td>

        </tr>

        <?php
                    $linhas = 0;
                    while($linha_pesquisa = mysqli_fetch_assoc($lista_nfe_saida)){
                    $numeroNfe = $linha_pesquisa["numero_nf"];
                    $data_saida = $linha_pesquisa["data_saida"];
                    $razao_social =utf8_encode($linha_pesquisa['razao_social']);
                    $chave_acesso = $linha_pesquisa['chave_acesso'];
                    $valor_total_nota = $linha_pesquisa["valor_total_nota"];
                   
               
                   
                    ?>

        <tr id="linha_pesquisa">



            <td style="width: 70px; ">
                <p style="margin-left: 15px; margin-top:10px;">
                    <font size="3"><?php echo $numeroNfe?></font>
                </p>
            </td>

            <td style="width:100px;">

                <p>
                    <font size="2"><?php echo formatardataB($data_saida)?></font>
                </p>
            </td>

            <td style="width:300px;">

                <p>
                    <font size="2"><?php echo ($razao_social)?></font>
                </p>
            </td>
            <td style="width:200px;">

                <p>
                    <font size="2"><?php echo real_format($valor_total_nota)?></font>
                </p>
            </td>
            <td style="width:200px;">

                <p>
                    <font size="2"><?php echo real_format($chave_acesso)?></font>
                </p>
            </td>


            <?PHP } ?>

        <tr id="cabecalho_pesquisa_consulta">

            <td>
                <p>Valor</p>
            </td>

            <td>
                <p></p>
            </td>
            <td>
                <p></p>
            </td>


            <td style="width: 80px;">
                <p><?php echo real_format($soma_nfe_saida) ?></p>
            </td>
            <td>
                <p></p>
            </td>


        </tr>


    </tbody>
</table>