<?php 
include "crud.php";

?>
<div class="operacional">
    <div class="title">
        <p>Cotação</p>
    </div>
    <table border="0" whidth="100%" cellspacing="0">
        <tbody class="top_tabela">
            <tr>
                <td style="width: 200px;">
                    <p>Lançamento</p>
                </td>
                <td style="width: 200px;">
                    <p>Fechamento</p>
                </td>

                <td style="width: 200px;">
                    <p>Orçamento</p>
                </td>

                <td>
                    <p>Desconto</p>
                </td>
                <td>
                    <p>Vlr Venda</p>
                </td>
                <td>
                    <p>Margem</p>
                </td>
                <td>

                </td>
            </tr>
        </tbody>
        <tbody class="corpo_tabela">
            <?php 
            $valor_total_cotado = 0;
            $n_cotacao = 0;
            $n_cotacao_ganha = 0;
            $n_cotacao_perdida = 0;
            $valor_cotacao_ganha =0;
            $valor_cotacao_perdida = 0;
            $n_aberto = 0;
            $valor_cotacao_aberta = 0;

            while($linha = mysqli_fetch_assoc($consulta_cotacao)){
                $data_fechamento= formatDateB($linha['data_fechamento']);
                $data_lancamento = formatDateB($linha['data_lancamento']);
                $valor_cotado = $linha['valorTotalComDesconto'];
                $n_orcamento = $linha['numero_orcamento'];
               $status = $linha['status_proposta'];
                $desconto = $linha['desconto'];
                $margem = ($linha['margem']);
                $valor_total_cotado = $valor_total_cotado +$valor_cotado;


                $n_cotacao = $n_cotacao + 1;
                if($status ==2){
                    $n_aberto = $n_aberto + 1;
                    $valor_cotacao_aberta = $valor_cotacao_aberta + $valor_cotado;
                }
                if($status == 3){
                    $n_cotacao_ganha =$n_cotacao_ganha + 1;
                    $valor_cotacao_ganha = $valor_cotacao_ganha + $valor_cotado;
                }
                if($status ==5){
                    $n_cotacao_perdida =$n_cotacao_perdida + 1;
                    $valor_cotacao_perdida = $valor_cotacao_perdida + $valor_cotado;
                }
        

            ?>
            <tr>
                <td>
                    <p><?php echo $data_lancamento ?></p>
                </td>
                <td>
                    <p><?php echo $data_fechamento ?></p>
                </td>
                <td>
                    <p><?php echo $n_orcamento ?></p>
                </td>

                <td>
                    <p><?php echo real_format($desconto); ?></p>
                </td>
                <td>
                    <p><?php echo real_format($valor_cotado); ?></p>
                </td>

                <td>
                    <p><?php echo real_percent($margem); ?></p>
                </td>
                <td style="width: 40px;">
                    <font size="3"><?php if(($status==3)){?>
                        <i style="color:green ;" class="fa-solid fa-handshake" title="Ganho"></i>
                        <?php
                            }elseif($status == 4){
                        ?>
                        <i class="fa-solid fa-hand-holding-hand" title="Ganho Parcial"></i>
                        <?php
                            }elseif($status==5){
                                ?>
                        <i style="color:brown;" class="fa-solid fa-x" title="Perdido"></i>
                        <?php
                            } ?>
                    </font>
                </td>
            </tr>
            <?php } ?>
            <tr class="valor_total">
                <td>Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td><?php echo real_format($valor_total_cotado); ?></td>
                <td></td>
                <td></td>

            </tr>

        </tbody>
    </table>
    <div class="bloco-info-add">
        <div class="bloco-1">
            <p>Total de Cotação</p>
            <p><?php echo $n_cotacao; ?></p>
            <hr>
            <p><?php echo real_format($valor_total_cotado); ?></p>
        </div>
        <div class="bloco-1">
            <p>Total C. Ganhas</p>
            <p><?php echo ($n_cotacao_ganha);?></p>
            <hr>
            <p><?php echo real_format($valor_cotacao_ganha);?></p>
        </div>
        <div class="bloco-1">
            <p>Total C. Perdida</p>
            <p><?php echo ($n_cotacao_perdida); ?></p>
            <hr>
            <p><?php echo real_format($valor_cotacao_perdida); ?></p>
        </div>
        <div class="bloco-1">
            <p>Em aberto</p>
            <p><?php echo ($n_aberto); ?></p>
            <hr>
            <p><?php echo real_format($valor_cotacao_aberta); ?></p>
        </div>
    </div>

</div>