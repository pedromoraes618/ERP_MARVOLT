<head>
    <meta charset="UTF-8">
</head>
<nav id="cabecalho">
    <ul>

        <li>
            Contatos <i class="fa-solid fa-comment-dots"></i>
        </li>
    </ul>
</nav>
<table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
    <tbody>

        <tr id="cabecalho_pesquisa_consulta">

            <td>
                <p>Data a realizar</p>
            </td>

            <td>
                <p>Empresa</p>
            </td>
            <td>
                <p>Comprador</p>
            </td>
            <td>
                <p>Descrição</p>
            </td>

            <td>
                <p>Status</p>
            </td>
        </tr>

        <?php

        while ($linha = mysqli_fetch_assoc($lista_contatos)) {
            $data_a_fazer = $linha["cl_data_limite"];
            $empresa = $linha["nome_fantasia"];
            $comprador = $linha["comprador"];
            $descricao = $linha["cl_descricao"];
            $statuts = $linha["cl_status"];
            $data_atual = date('Y-m-d');

        ?>
            
            <tr  id="linha_pesquisa">
             

                <td  style="width:300px;">
                    <p style="<?php  if($data_atual == $data_a_fazer or $data_a_fazer < $data_atual){ echo "color:red";} ?>">
                        <font size="2"><?php echo formatDateB($data_a_fazer) ?></font>
                    </p>
                </td>
                <td style="width:350px;">
                    <font size="2"><?php echo utf8_encode($empresa) ?></font>
                </td>


                <td style="width:200px;">
                    <font size="2"> <?php echo utf8_encode($comprador) ?></font>
                </td>


                <td style="width:170px;">
                    <font size="2"> <?php echo utf8_encode($descricao)  ?></font>
                </td>


                <td style="width:90px;">
                    <font size="2"> <?php if($statuts=="2"){
                        echo "A fazer";

                    } ?> </font>
                </td>


              
            </tr>
        <?php
        }

        ?>
    </tbody>
</table>
