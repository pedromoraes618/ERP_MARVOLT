<?php 
include("../conexao/sessao.php");
include("../conexao/conexao.php"); 
//consultar cliente
$select = "SELECT clienteID, razaosocial,nome_fantasia from clientes where clienteFtID = 1 order by nome_fantasia asc ";
$lista_clientes = mysqli_query($conecta,$select);
if(!$lista_clientes){
    die("Falaha no banco de dados || select clientes");
}

//consultar situação da cotação
$select = "SELECT * from situacao_proposta ";
$lista_situacao = mysqli_query($conecta,$select);
if(!$lista_situacao){
    die("Falaha no banco de dados || tabela situacao_proposta");
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

    <?php 
    include_once("../_incluir/topo.php"); 
    include("../_incluir/body.php"); 
    include_once("../_incluir/funcoes.php");
    include("../classes/select2/select2_link.php");
    ?>

    <main>
        <div style="width:1480px;" class="topo_pesquisa">
            <div id="bloco" class="bloco-1">
                <div class="titulo">
                    <p>Data Lançamento</p>
                </div>
                <div id="sub_bloco" class="date">
                    <input type="text" id="CampoPesquisaData" name="CampoPesquisaData" placeholder="Data incial"
                        onkeyup="mascaraData(this);">

                    <input type="text" name="CampoPesquisaDataf" placeholder="Data final" onkeyup="mascaraData(this);">

                </div>
            </div>

            <div id="bloco" class="bloco-2">
                <div class="titulo">
                    <p>Data Lançamento</p>
                </div>
                <div id="sub_bloco" class="pesquisa">
                    <input type="text" name="CampoPesquisaNorcamento" placeholder="N° Orçamento">
                </div>

            </div>
            <div id="bloco" class="bloco-3">
                <div style="padding-top: 50px;" id="sub_bloco" class="pesquisa">
                    <select style="width:400px;" name="campoCliente" id="campoCliente">
                        <option value="0">Pesquise por nome fantasia</option>
                        <?php  
                    while($linha_cliente = mysqli_fetch_assoc($lista_clientes)){
                    $cliente_Principal = utf8_encode($linha_cliente["clienteID"]);

                        ?>
                        <option value="<?php echo utf8_encode($linha_cliente["clienteID"]);?>">
                            <?php echo utf8_encode($linha_cliente["nome_fantasia"]);?>
                        </option>
                        <?php
}

?>
                    </select>
                </div>
            </div>
            <div id="bloco" class="bloco-4">
                <div class="titulo">
                    <p>Situação</p>
                </div>
                <div id="sub_bloco" class="pesquisa">
                    <select>
                        <option value="1">Selecione</option>
                        <?php 
                        
                             while($linha_situacao_proposta  = mysqli_fetch_assoc($lista_situacao)){
                            $receita_despesa_principal = utf8_encode($linha_situacao_proposta["statusID"]);
                            ?>
                        <option value="<?php echo utf8_encode($linha_situacao_proposta["statusID"]);?>">
                            <?php echo utf8_encode($linha_situacao_proposta["descricao"]);?>
                        </option>
                        <?php

                            }
                            ?>

                    </select>
                </div>

            </div>
        </div>
    </main>

</body>

<?php include '../_incluir/funcaojavascript.jar'; ?>
<?php include '../classes/select2/select2_java.php'; ?>

</html>