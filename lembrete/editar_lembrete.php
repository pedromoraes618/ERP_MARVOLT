<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->

<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css" />
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css" />
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css" />
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css" />

<?php
require_once("../conexao/conexao.php");

include("../conexao/sessao.php");

include ("../_incluir/funcoes.php");

echo ".";

//consultar estados 
$select = "SELECT usuarioID, usuario from usuarios";
$lista_usuario = mysqli_query($conecta,$select);
if(!$lista_usuario){
    die("Falaha no banco de dados  Linha 19 cadastro_cliente");
}



//insert no banco de dados
if(isset($_POST['btnsalvar'])){

    //inlcuir as varias do input
$IlembreteID = utf8_decode($_POST["cammpoLembreteID"]);
  $Icliente = utf8_decode($_POST["campoCliente"]);
  $Iusuario = utf8_decode($_POST["campoUsuario"]);
  $Istatus_Lembrete = utf8_decode($_POST["campoStatusLembrete"]);
  $Idescricao = utf8_decode($_POST["observacao"]);

   
   //query para alterar o cliente no banco de dados
   $alterar = "UPDATE lembrete set descricao = '{$Idescricao}', statusID = '{$Istatus_Lembrete}', clienteID = '{$Icliente}',  usuarioID = '{$Iusuario}'  WHERE lembreteID = {$IlembreteID}  ";

     $operacao_alterar = mysqli_query($conecta, $alterar);
     if(!$operacao_alterar) {
         die("Erro na alteracao - banco de dados");   
     } else {  
        ?>
<script>
alertify.success("Dados alterados");
</script>
<?php
         //header("location:listagem.php"); 
          
     }
   
   }

//consultar cliente
$select = "SELECT clienteID, razaosocial,nome_fantasia from clientes";
$lista_clientes = mysqli_query($conecta,$select);
if(!$lista_clientes){
    die("Falaha no banco de dados || select clientes");
}

//consultar cliente
$select = "SELECT statusID, descricao from status_lembrete";
$status_lembrete = mysqli_query($conecta,$select);
if(!$status_lembrete){
    die("Falaha no banco de dados || select clientes");
}

//data lan??amento
$hoje = date('Y-m-d'); 


//variaveis 
$consulta = "SELECT * FROM lembrete ";
if (isset($_GET["codigo"])){
   $lembreteID=$_GET["codigo"];
$consulta .= " WHERE lembreteID= {$lembreteID} ";
}else{
   $consulta .= " WHERE lembreteID = 1 ";
}

//consulta ao banco de dados
$detalhe = mysqli_query($conecta, $consulta);
if(!$detalhe){
   die("Falha na consulta ao banco de dados");
}else{
   $dados_detalhe = mysqli_fetch_assoc($detalhe);
   $lembreteID=  utf8_encode($dados_detalhe['lembreteID']);
   $usuarioID =  utf8_encode($dados_detalhe['usuarioID']);
   $clienteID =  utf8_encode($dados_detalhe['clienteID']);
   $statusID =  utf8_encode($dados_detalhe['statusID']);
   $descricao =  utf8_encode($dados_detalhe['descricao']);
}



 if(isset($_POST['btnremover'])){
 
    //inlcuir as varias do input
 $IlembreteID = utf8_decode($_POST["cammpoLembreteID"]);
  $Icliente = utf8_decode($_POST["campoCliente"]);
  $Iusuario = utf8_decode($_POST["campoUsuario"]);
  $Istatus_Lembrete = utf8_decode($_POST["campoStatusLembrete"]);
  $Idescricao = utf8_decode($_POST["observacao"]);


   //query para remover o cliente no banco de dados
   $remover = "DELETE FROM lembrete WHERE lembreteID = {$IlembreteID}";

     $operacao_remover = mysqli_query($conecta, $remover);
     if(!$operacao_remover) {
         die("Erro linha 44");   
     } else {
        ?>
<script>
alertify.error("Lembrete removido com sucesso");
</script>
<?php
         //header("location:listagem.php"); 
          
     }
   
   }

 ?>



<!doctype html>

<html>



<head>
    <meta charset="UTF-8">
    <!-- estilo -->

    <link href="../_css/tela_cadastro_editar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

</head>

<body>
    <main>
        <form action="" method="post">
            <div id="titulo">
                </p>Lembrete</p>
            </div>


            <table width=100%>

                <tr>
                    <td style="width: 120px;">N?? Lembrete:</td>
                    <td align=left><input readonly type="text" size="10" id="cammpoLembreteID" name="cammpoLembreteID"
                            value="<?php echo $lembreteID;?>">
                    </td>
                </tr>

                <tr>


                    <td align=left> <b>Usu??rio:</b></td>
                    <td align=left> <select style="width: 168px; margin-right:20px" name="campoUsuario"
                            id="campoUsuario">

                            <?php  
                            $meu_usuario = $usuarioID;
                            while($linha_usuario  = mysqli_fetch_assoc($lista_usuario)){
                                $usuarioPrincipal = utf8_encode($linha_usuario["usuarioID"]);
                    
                                if($meu_usuario==$usuarioPrincipal){
                                ?> <option value="<?php echo utf8_encode($linha_usuario["usuarioID"]);?>" selected>
                                <?php echo utf8_encode($linha_usuario["usuario"]);?>
                            </option>

                            <?php
                                         }else{
                                
                               ?>
                            <option value="<?php echo utf8_encode($linha_usuario["usuarioID"]);?>">
                                <?php echo utf8_encode($linha_usuario["usuario"]);?>
                            </option>
                            <?php
   
           }
           
       }
   
                             

      
?>

                        </select>

                        <b>Status:</b>
                        <select style="width: 168px; margin-right:20px;" name="campoStatusLembrete"
                            id="campoStatusLembrete">


                            <?php  
                            $meustatus = $statusID;
                            while($linha_usuario  = mysqli_fetch_assoc($status_lembrete)){
                                $statusLembretePrincipal = utf8_encode($linha_usuario["statusID"]);

                                if($meustatus==$statusLembretePrincipal){
                                ?> <option value="<?php echo utf8_encode($linha_usuario["statusID"]);?>" selected>
                                <?php echo utf8_encode($linha_usuario["descricao"]);?>
                            </option>

                            <?php
                                         }else{
                                
                               ?>
                            <option value="<?php echo utf8_encode($linha_usuario["statusID"]);?>">
                                <?php echo utf8_encode($linha_usuario["descricao"]);?>
                            </option>
                            <?php
   
           }
           
       }
   
                             

      
?>

                        </select>

                        <b>Cliente:</b>
                        <select style="width: 500px;" name="campoCliente" id="campoCliente">

                            <?php  
                            $meu_Cliente = $clienteID;
                            while($linha_cliente = mysqli_fetch_assoc($lista_clientes)){
                                $cliente_Principal = utf8_encode($linha_cliente["clienteID"]);
                                if($meu_Cliente==$cliente_Principal){
                                ?> <option value="<?php echo utf8_encode($linha_cliente["clienteID"]);?>" selected>
                                <?php echo utf8_encode($linha_cliente["nome_fantasia"]);?>
                            </option>

                            <?php
                                         }else{
                                
                               ?>
                            <option value="<?php echo utf8_encode($linha_cliente["clienteID"]);?>">
                                <?php echo utf8_encode($linha_cliente["nome_fantasia"]);?>
                            </option>
                            <?php
   
           }
           
       }
   
                             

      
?>

                        </select>

                    </td>
                </tr>




                <tr>
                    <td align=left><b>Descri????o:<b></td>
                    <td><textarea rows=4 cols=300 style="width:600px; height:100px;"  name="observacao" id="observacao"><?php echo $descricao;?></textarea>


                    </td>
                </tr>



                </talbe>
                <table width=100%>
                    <tr>
                        <div style="margin-left:120px" id="botoes">
                            <input type="submit" name=btnsalvar value="Salvar" class="btn btn-info btn-sm"></input>

                            <button type="button" onclick="fechar()" class="btn btn-secondary">Voltar</button>

                            <input id="remover" type="submit" name="btnremover" value="Remover" class="btn btn-danger"
                                onClick="return confirm('Deseja remover esse lembrete?');"></input>

                        </div>
                    </tr>

        </form>



    </main>
</body>

<?php include '../_incluir/funcaojavascript.jar'; ?>
<script>
function fechar() {
    window.close();
}
</script>

</html>

<?php 
mysqli_close($conecta);
?>