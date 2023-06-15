<?php


include("../conexao/sessao.php");
require_once("../conexao/conexao.php");
include("../_incluir/funcoes.php");



//consultar status
$select = "SELECT * from tb_planilha_2 ";
$consulta_planilha_bosh = mysqli_query($conecta, $select);

$select = "SELECT * from tb_planilha_3 ";
$consulta_planilha_bosh_pecas = mysqli_query($conecta, $select);

$select = "SELECT * from tb_planilha_4 ";
$consulta_planilha_ferramentas = mysqli_query($conecta, $select);
?>
<table>
    <thead>
        <tr>
            <td>Linha</td>
            <td>Planilha bosh pecas</td>
            <td>Planilha Sistema</td>
            <td>Condiçao</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $linha_qtd = 0;
        while ($linha = mysqli_fetch_assoc($consulta_planilha_ferramentas)) {
            $referencia_bosh = $linha['cl_valor'];

            //consultar status
            $select = "SELECT * from tb_planilha_1 where cl_valor ='$referencia_bosh' ";
            $consulta_planilha_sistema = mysqli_query($conecta, $select);
            $linha = mysqli_fetch_assoc($consulta_planilha_sistema);
            $referencia_sistema = $linha['cl_valor'];
            if ($referencia_bosh == $referencia_sistema) {
                $linha_qtd = $linha_qtd + 1;
        ?>
                <tr>
                    <td><?php echo $linha_qtd; ?></td>
                    <td><?php echo $referencia_bosh; ?></td>
                    <td><?php echo $referencia_sistema; ?></td>
                    <td><?php if ($referencia_bosh == $referencia_sistema) {
                            echo "Igual";
                        }; ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>