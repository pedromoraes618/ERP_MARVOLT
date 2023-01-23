<?php

include("../conexao/sessao.php");
include("../conexao/conexao.php");
//inportar o alertar js
include('../alert/alert.php');
include ("../_incluir/funcoes.php"); 


echo "<p style=display:none>'</p>";

//funcao para anexar o inserir as informacoes no banco de dados
function anexarArquivoCertificado($hoje,$data_vencimento,$descricao,$codigo,$pasta,$novo_nome){
    include("../conexao/conexao.php");
    $insert = "INSERT INTO tb_anexo_certificado ";
    $insert .= "( cl_data_lancamento,cl_data_vencimento,cl_descricao,cl_codigo,cl_diretorio )";
    $insert .= " VALUES ";
    $insert .= "( '$hoje','$data_vencimento','$descricao','$codigo','$pasta$novo_nome')";
    $operacao_insert = mysqli_query($conecta, $insert);
    if(!$operacao_insert){
        die("Erro no banco de dados || Inserir o diretorio no banco de dados");
    }

}


if(isset($_POST['enviar_formulario'])){
    $data_vencimento = $_POST['data_vencimento'];
    $descricao = $_POST['descricao'];
    if($descricao ==""){
        ?>
<script>
alertify.alert("Favor informe a descrição");
</script>
<?php
    }else{
      
        if($data_vencimento == ""){

        }else{
            $div1 = explode("/",$_POST['data_vencimento']);
            $data_vencimento = $div1[2]."-".$div1[1]."-".$div1[0];  
        }

    
    $formatosPermitidos = array("png","jpeg","jpg","pdf","gif","xml","PNG");
    $extensao = pathinfo($_FILES['arquivo']['name'],PATHINFO_EXTENSION);

    if(in_array($extensao,$formatosPermitidos)){
        $pasta = "anexos/";
        $temporario = $_FILES['arquivo']['tmp_name'];
        $nome = ($_FILES['arquivo']['name']);
        $codigo = rand(1,1000000000);
        $novo_nome = $codigo.".".$extensao;

        if(move_uploaded_file($temporario,$pasta.$novo_nome)){
            //incliur no banco de dados         
            anexarArquivoCertificado($hoje,$data_vencimento,$descricao,$codigo,$pasta,$novo_nome);

            ?>
<script>
alertify.success("Upload efetuado com sucesso");
</script>
<?php
 $data_vencimento = "";
 $descricao = "";
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
alertify.alert("Não foi possivel fazer o Upload, verifique se o arquivo foi carregado");
</script>
<?php
    $data_vencimento = "";
    $descricao = "";
    }
}

}
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- estilo -->
    <link href="../_css/tela_cadastro_editar.css" rel="stylesheet">
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>
</head>

<body>

    <main>
        <div style="margin:0 auto;width:1000px">
            <form method="POST" enctype="multipart/form-data">
                <table>
                    <div id="titulo">
                        </p>Anexar Certificados</p>
                        <tr>
                            <td>
                                <input type="file" name="arquivo" id="file">
                                <input type="submit" value="Upload" id="upload" class="btn-btn-info"
                                    name="enviar_formulario">
                            </td>
                            <td align=left> <button type="button" name="btnfechar"
                                    onclick="window.opener.location.reload();fechar();"
                                    class="btn btn-secondary">Voltar</button>
                            </td>
                        </tr>
                    </div>
                </table>
                <hr>
                <div class="bloco-input">


                    <div class="group-input">
                        <label>Data Vencimento</label>
                        <input name="data_vencimento" value="<?php if($_POST){
                            echo $data_vencimento;
                        };?>" placeholder="//" onkeyup="mascaraData(this);" type="text">
                    </div>

                    <div class="group-input">
                        <label>Descrição</label>
                        <input name="descricao" value="<?php if($_POST){
                            echo $descricao;
                        };?>" style="width: 500px;" type="text">
                    </div>




                </div>
            </form>


        </div>
    </main>
    <script src="../jquery.js"></script>
    <?php include '../_incluir/funcaojavascript.jar'; ?>
    <script src="sweetalert2.all.min.js"></script>
    <script>
    $('td #remover_certificado').click(function(e) {
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

    function fechar() {
        window.close();
    }
    </script>

</body>



</html>