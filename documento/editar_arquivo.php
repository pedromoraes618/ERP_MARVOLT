<?php

include("../conexao/sessao.php");
include("../conexao/conexao.php");
//inportar o alertar js
include('../alert/alert.php');
include ("../_incluir/funcoes.php"); 


echo "<p style=display:none>'</p>";

if(isset($_GET['codigo'])){
    $id_doc = $_GET['codigo'];
}




if(isset($_POST['salvar'])){
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

        //atualizar o numero da cotacao
        $update = "UPDATE tb_anexo_certificado set cl_descricao = '{$descricao}',cl_data_vencimento = '{$data_vencimento}' where cl_id = $id_doc ";
        $operacao_update_dados= mysqli_query($conecta, $update);
        if(!$operacao_update_dados){
        die("Erro no banco de dados inserir tb_parametro");
        }else{
            ?>
<script>
alertify.success("Doumento alterado com sucesso");
</script>
<?php
        }

        
        
    } 
}

if(isset($_POST['enviar_formulario'])){
    $data_vencimento = $_POST['data_vencimento'];
    $descricao = $_POST['descricao'];
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
            anexarArquivoCertificado($pasta,$novo_nome,$id_doc);

            ?>
<script>
alertify.success("Upload efetuado com sucesso");
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
alertify.alert("Não foi possivel fazer o Upload, verifique se o arquivo foi carregado");
</script>
<?php
    
    }
}
//funcao para anexar o inserir as informacoes no banco de dados
function anexarArquivoCertificado($pasta,$novo_nome,$id){
    include("../conexao/conexao.php");
    $update = "UPDATE tb_anexo_certificado set cl_diretorio = '$pasta$novo_nome' where cl_id = $id";
    $operacao_update_doc = mysqli_query($conecta, $update);
    if(!$operacao_update_doc){
        die("Erro no banco de dados || Inserir o diretorio no banco de dados");
    }

}


$select ="SELECT * from tb_anexo_certificado where cl_id = '$id_doc'";
$consultar_doc = mysqli_query($conecta,$select);
$linha = mysqli_fetch_assoc($consultar_doc);
$data_vencimento_b = ($linha['cl_data_vencimento']);
$descricao_b = $linha['cl_descricao'];




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
                                <input type="submit" value="Upload" id="upload" style="background-color:darkgoldenrod;"
                                    class="btn-btn-info" name="enviar_formulario">
                                <input type="submit" value="Salvar" name="salvar" id="upload" class="btn-btn-success">
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
                            if($data_vencimento !=""){
                                echo formatardataB2 ($data_vencimento);
                            }else{
                                echo $data_vencimento;
                            }
              
                        }else{
                            echo formatardataB2($data_vencimento_b);
                        };?>" placeholder="//" onkeyup="mascaraData(this);" type="text">
                    </div>

                    <div class="group-input">
                        <label>Descrição</label>
                        <input name="descricao" value="<?php if($_POST){
                            echo $descricao;
                        }else{
                            echo $descricao_b;
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