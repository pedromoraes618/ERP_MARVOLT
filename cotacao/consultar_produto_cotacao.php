<?php
include("../conexao/sessao.php");
require_once("../conexao/conexao.php");
include("../_incluir/funcoes.php");


if (isset($_GET['descr_prod'])) {
    $descricao = $_GET['descr_prod'];
    $select = "SELECT ctc.cotacaoID as idcotacao,ctc.cod_cotacao as 
    codCotacao,clt.nome_fantasia,ctc.numero_solicitacao, ctc.numero_orcamento,prdc.preco_venda, prdc.descricao as
     descricao,status.descricao as status from produto_cotacao as prdc inner join cotacao as ctc on 
     ctc.cod_cotacao = prdc.cotacaoID INNER JOIN status_produto_cotacao as status on status.status_produtoID = prdc.status inner join clientes as clt on clt.clienteID = ctc.clienteID where prdc.descricao like '%$descricao%'";
    $consulta_produto = mysqli_query($conecta, $select);
}

?>
<!doctype html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- estilo -->
    <link href="../_css/estilo.css" rel="stylesheet">
    <link href="../_css/pesquisa_tela.css" rel="stylesheet">

    <a href="https://icons8.com/icon/59832/cardápio"></a>
</head>

<body>
    <table border="0" cellspacing="0" class="tabela_pesquisa">
        <tbody>
            <tr id="cabecalho_pesquisa_consulta">

                <td>
                    <p>N°Orç</p>
                </td>
                <td>
                    <p>N°Solicitação</p>
                </td>
                <td>
                    <p>Cliente</p>
                </td>
                <td>
                    <p>Descrição</p>
                </td>
                <td>
                    <p>Status</p>
                </td>

                <td>
                    <p>P. venda</p>
                </td>

                <td>

                </td>
        

                <?php

                ?>
                <?php
                if (isset($_GET['descr_prod'])) {
                    $descricao_produto = $_GET['descr_prod'];
                    if ($descricao_produto != "") {
                        while ($linha = mysqli_fetch_assoc($consulta_produto)) {
                            $descricao = $linha['descricao'];
                            $numeroOrcamento = $linha['numero_orcamento'];
                            $status = $linha['status'];
                            $preco_venda = $linha['preco_venda'];
                            $cotacaoID = $linha['idcotacao'];
                            $codCotacao = $linha['codCotacao'];
                            $numero_solicitacao = $linha['numero_solicitacao'];
                            $nome_fantasia = $linha['nome_fantasia'];

                ?>
            <tr id="linha_pesquisa">
                <td>
                    <p><?php echo $numeroOrcamento; ?></p>
                </td>
                <td>
                    <p><?php echo $numero_solicitacao; ?></p>
                </td>
                <td style="width: 300px;">
                    <p><?php echo utf8_encode($nome_fantasia); ?></p>
                </td>
                <td style="width: 700px;">
                    <p><?php echo  utf8_encode($descricao); ?></p>
                </td>
                <td>
                    <p style="color:<?php if ($status == "Ganho") {
                                        echo 'green';
                                    } elseif ($status == "Perdido") {
                                    } {
                                        echo 'red';
                                    } ?>"><?php echo $status; ?></p>
                </td>
                <td>
                    <p><?php echo real_format($preco_venda); ?></p>
                </td>


                <td id="botaoEditar">


                    <a onclick="window.open('editar_cotacao.php?codigo=<?php echo $cotacaoID; ?>&cotacaoCod=<?php echo $codCotacao; ?>', 
'Editar_cotacao', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1600, HEIGHT=900');">

                        <button type="button" name="editar">Cotação</button>
                    </a>

                </td>

            </tr>
<?php }
                    }
                } ?>


</body>

</html>