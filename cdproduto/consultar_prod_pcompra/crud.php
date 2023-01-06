<?php
include("../../conexao/conexao.php");


/*Salvar a avaliacao no banco de dados */
if(isset($_POST['campoCategoria'])){
    $retorno = array();
    $categoria = $_POST['campoCategoria'];
    $Idproduto = $_POST['campoId'];
 
	if($categoria =="0"){
		$retorno["mensagem"] = "Favor selecione a Categoria do produto";
	}else{
		$update = "UPDATE tb_pedido_item set categoria_produto = '{$categoria}' where pedido_itemID = '$Idproduto' ";
		$update_categoria_produto = mysqli_query($conecta, $update);

		if($update_categoria_produto){
			$retorno["sucesso"] = true;
			$retorno["mensagem"] = "Categoria alterada com sucesso";
		}else{
			$retorno["sucesso"] = false;
		}   
	}
    echo json_encode($retorno);
}



?>