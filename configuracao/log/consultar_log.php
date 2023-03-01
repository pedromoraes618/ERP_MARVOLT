<?php
include("../../conexao/sessao.php");
require_once("../../conexao/conexao.php");
include ("../../_incluir/funcoes.php");



//consultar pedido de compra
if($_GET){
    $pesquisaData = $_GET["CampoPesquisaData"];
    $pesquisaDataf = $_GET["CampoPesquisaDataf"];
    $pesquisa = $_GET["CampoPesquisa"];
    $usuario = $_GET["usuario"];
    
    if($pesquisaData==""){
          
    }else{
        $div1 = explode("/",$_GET['CampoPesquisaData']);
        $pesquisaData = $div1[2]."-".$div1[1]."-".$div1[0];  
       
    }
    if($pesquisaDataf==""){
       
    }else{
    $div2 = explode("/",$_GET['CampoPesquisaDataf']);
    $pesquisaDataf = $div2[2]."-".$div2[1]."-".$div2[0];
    }

     $select="SELECT log.cl_data_modificacao,user.usuario as usuario,log.cl_descricao as descricao
      from tb_log as log inner join usuarios as user on user.usuarioID = log.cl_usuario where 
      log.cl_data_modificacao between '$pesquisaData' and '$pesquisaDataf' and log.cl_descricao  LIKE '%{$pesquisa}%' ";
      if($usuario!="1"){
        $select .="and log.cl_usuario = '$usuario'";
      }
      $consultar_log = mysqli_query($conecta, $select);
    
}


//recuperar valores via get
if (isset($_GET["CampoPesquisaData"])){
    $pesquisaData=$_GET["CampoPesquisaData"];
  }
  if (isset($_GET["CampoPesquisaDataf"])){
    $pesquisaDataf=$_GET["CampoPesquisaDataf"];
  }

//consultar dados do usuaio no banco de dados 
$select = " SELECT * from usuarios";
$consultar_usuarios = mysqli_query($conecta,$select);


?>
<!doctype html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- estilo -->
    <link href="../../_css/estilo.css" rel="stylesheet">
    <link href="../../_css/pesquisa_tela.css" rel="stylesheet">

    <a href="https://icons8.com/icon/59832/cardápio"></a>
</head>

<body>
    <?php include_once("../../_incluir/topo.php"); ?>
    <?php include("../../_incluir/body.php"); ?>
    <?php include_once("../../_incluir/funcoes.php"); ?>



    <main>

        <div id="janela_pesquisa">
            <ul>
                <li>
                    <b> Data Modificação</b>
                </li>

            </ul>

            <form style="width:100%;" action="" method="get">
                <input style="width: 100px; " type="text" maxlength="10" id="CampoPesquisaData" name="CampoPesquisaData"
                    placeholder="Data incial" onkeyup="mascaraData(this);" value="<?php if( !isset($_GET["CampoPesquisa"])){ echo formatardataB(date('Y-m-01')); }
                              if (isset($_GET["CampoPesquisaData"])){
                                 echo $pesquisaData;
                                    }?>">
                <input style="width: 100px;" type="text" maxlength="10" name="CampoPesquisaDataf"
                    placeholder="Data final" onkeyup="mascaraData(this);" value="<?php if(!isset($_GET["CampoPesquisa"])){ echo date('d/m/Y');
                        } if (isset($_GET["CampoPesquisaDataf"])){ echo $pesquisaDataf;} ?>">



                <input style="margin-left:300px;" type="text" name="CampoPesquisa" value="<?php if(isset($_GET['CampoPesquisa'])){
                    echo $pesquisa;
                } ?>" placeholder="Pesquisa / Ação ">
                <input type="image" name="pesquisa" src="https://img.icons8.com/ios/50/000000/search-more.png" />


                <select style="width: 150px; float:right; margin-right:100px;" id="usuario" name="usuario">
                    <?php
                    while($linha = mysqli_fetch_assoc($consultar_usuarios)){
                        $usuarioB = $linha['usuario'];
                        $usuario_id_b = $linha['usuarioID'];
                        ?>
                    <option value="<?PHP echo $usuario_id_b; ?>"><?php echo $usuarioB; ?></option>
                    <?php
                    }
                    
                    ?>
                </select>
            </form>


        </div>

        <form action="consulta_pdcompra.php" method="get">

            <table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
                <tbody>
                    <tr id="cabecalho_pesquisa_consulta">
                        <td>
                            <p>Data modificação</p>
                        </td>
                        <td>
                            <p>Usúario</p>
                        </td>

                        <td>
                            <p>Ação</p>
                        </td>

                    </tr>

                    <?php

if(isset($_GET["CampoPesquisaData"])){
 
                    while($linha = mysqli_fetch_assoc($consultar_log)){
                        $data_modificacao = $linha['cl_data_modificacao'];
                        $usuario = $linha['usuario'];
                        $descricao = $linha['descricao'];

                    ?>

                    <tr id="linha_pesquisa">
                        <td style="width: 200px;">
                            <font size="3">
                                <p><?php  echo formatDateB($data_modificacao);?></p>
                            </font>
                        </td>
                        <td style="width: 250px;">
                            <font size="3">
                                <p><?php  echo $usuario;?></p>
                            </font>
                        </td>
                        <td>
                            <font size="3">
                                <p><?php  echo $descricao;?></p>
                            </font>
                        </td>

                    </tr>



                    <?php
                    }

        
             }
            
            ?>
                </tbody>
            </table>

        </form>

    </main>


</body>





</html>
<?php include '../../_incluir/funcaojavascript.jar'; ?>

<?php
    // Fechar conexao
    mysqli_close($conecta);
?>