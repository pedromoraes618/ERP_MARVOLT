<?php
require_once("../../conexao/conexao.php"); 
//select no banco de dados
if(isset($_GET['pesquisa_a'])){
    $descricao = $_GET['pesquisa_a'];
    $select = "SELECT * from tb_anexo_certificado where cl_descricao LIKE '%{$descricao}%' order by cl_descricao asc ";
    $consultar_certificado = mysqli_query($conecta, $select);
    if(!$consultar_certificado){
        die("Erro no banco de dados || select no diretorio do anexo no banco de dados");
    }
}

//deletar o certificado
if(isset($_GET['deletar_certifcado'])){
    $id_certificado = $_GET['deletar_certifcado'];

    $select = "DELETE FROM tb_anexo_certificado where cl_id = '$id_certificado'";
    $consultar_certificado = mysqli_query($conecta, $select);
    if(!$consultar_certificado){
        die("Erro no banco de dados || select no diretorio do anexo no banco de dados");
    }
    
}

