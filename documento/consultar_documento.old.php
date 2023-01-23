<?php

//inportar o alertar js
include('../alert/alert.php');

if(isset($_GET['codigo'])){
    $codigo = $_GET['codigo'];
}


//funcao para anexar o inserir as informacoes no banco de dados
function anexarArquivoNfe($nome,$codigo,$pasta){
    include("../conexao/conexao.php");
    $insert = "INSERT INTO tb_anexo_nfe_saida ";
    $insert .= "( descricao,numero_nf,diretorio )";
    $insert .= " VALUES ";
    $insert .= "( '$nome','$codigo','$pasta$nome' )";
    $operacao_insert = mysqli_query($conecta, $insert);
    if(!$operacao_insert){
        die("Erro no banco de dados || Inserir o diretorio no banco de dados");
    }

}


if(isset($_GET['deletar'])){
    $codigo = $_GET['deletar'];
    $remover = "DELETE FROM tb_anexo_nfe_saida WHERE anexoID = '$codigo' ";
    $operacao_remover = mysqli_query($conecta, $remover);
    if(!$operacao_remover) {
         die("Erro na tabela || tb_anexo_nfe_saida");   
    }      
    
}


if(isset($_POST['enviar_formulario'])){
    $formatosPermitidos = array("png","jpeg","jpg","pdf","gif","xml","PNG");
    $extensao = pathinfo($_FILES['arquivo']['name'],PATHINFO_EXTENSION);

    if(in_array($extensao,$formatosPermitidos)){
        $pasta = "anexos/";
        $temporario = $_FILES['arquivo']['tmp_name'];
        $nome = ($_FILES['arquivo']['name']);

        if(move_uploaded_file($temporario,$pasta.$nome)){
            //incliur no banco de dados         
             anexarArquivoNfe($nome,$codigo,$pasta);
            ?>
<script>
alertify.sucess("Uplop efetuado com sucesso");
</script>
<?php

        }else{
            ?>
<script>
alertify.error("Não foi possivel fazer o Upload");
</script>
<?php
        }
        
    }else{
        ?>
<script>
alertify.error("Arquivo com formato invalido");
</script>
<?php
    }
}

//select no banco de dados
if((!($_GET)) or isset($_POST['enviar_formulario'])){
    $select = "SELECT * from tb_anexo_certificado" ;
    $consultar_certificado = mysqli_query($conecta, $select);
    if(!$consultar_certificado){
        die("Erro no banco de dados || select no diretorio do anexo no banco de dados");
    }
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
    <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>
    <a href="https://icons8.com/icon/59832/cardápio"></a>
</head>

<body>
    <?php include_once("../_incluir/topo.php"); ?>
    <?php include("../_incluir/body.php"); ?>
    <?php include_once("../_incluir/funcoes.php"); ?>

    <main>
        <div style="margin:0 auto; width:1400px; ">
            <div id="titulo">
                </p>Anexar Certificados</p>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="" style="display:flex;justify-content: center;">
                    <div style="display: block;" class="">
                        <input type="file" name="arquivo" id="file">
                        <input type="submit" value="Upload" id="upload" class="btn-btn-info" name="enviar_formulario">
                    </div>
                    <div style="display: block;" >
                        <input style="width: 100px; " type="text" id="CampoPesquisaData" name="CampoPesquisaData"
                            placeholder="Data Expirar" onkeyup="mascaraData(this);" value="">
                        <input style="width: 100px; " type="text" id="CampoPesquisaData" name="CampoPesquisaData"
                            placeholder="Descrição" value="">
                    </div>
                </div>
            </form>

            <table border="0" cellspacing="0" width="100%" class="tabela_pesquisa" style="margin-top:50px ;">
                <tbody>
                    <tr id="cabecalho_pesquisa_consulta">

                        <td>
                            <p>Data Lançamento</p>
                        </td>
                        <td>
                            <p>Data Expirar</p>
                        </td>
                        <td>
                            <p>Descrição</p>
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                    </tr>
                    <?php   
                                
                             
                                    
                                while($linha = mysqli_fetch_assoc($consultar_certificado)){
                                    $id_certificado = $linha['cl_id'];
                                    $data_lancamento_b = $linha['cl_data_lancamento'];
                                    $data_expirar_b = $linha['cl_data_vencimento'];
                                    $descricao_b = $linha['cl_descricao'];
                                  

                                ?>

                    <tr id="linha_pesquisa">

                        <td>
                            <p><?php echo $id_certificado; ?></p>
                        </td>
                        <td>
                            <p><?php echo formatardataB2($data_lancamento_b); ?></p>
                        </td>
                        <td>
                            <p><?php echo  formatardataB2($data_expirar_b);; ?></p>
                        </td>
                        <td>
                            <p><?php echo $descricao_b; ?></p>
                        </td>
                        <form>
                            <td>
                                <a href="" class="excluir" title="<?php echo $id_certificado ?>"><button type="button"
                                        class="btn btn-danger">Remover</button></a>



                            </td>

                    </tr>



                    <?php

 }?>
        </div>
        </table>
        </div>
    </main>
    <script src="../jquery.js"></script>
    <script>
    $('td a.excluir').click(function(e) {
        e.preventDefault();
        var id = $(this).attr("title");
        var elemento = $(this).parent().parent();
        $(elemento).fadeOut();
        alertify.success("Anexo removido com sucesso!")
        $.ajax({
            type: "GET",
            data: "deletar=" + id,
            url: "anexar_arquivo.php",
            async: false
        }).done(function(data) {

        })

    });
    </script>

</body>



</html>