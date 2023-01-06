<?php 

include("../conexao/conexao.php");
$hoje = date('Y-m-d');
if(isset($_POST['campo_codigo'])){
	$retornar = array();
     $id_produto = $_POST['campo_codigo'];
     $tipo_operacao = $_POST['tipo'];
    $qtd_disponivel = $_POST['campoQtdDisponivel'];
    $quantidade = $_POST['campoQuantidade'];
    $quantidade_unico = $_POST['campoQuantidade'];

    if($tipo_operacao == 0){
        $retornar['mensagem'] = "Favor informe o tipo de ajuste";
    }elseif($quantidade == ""){
        $retornar['mensagem'] = "Favor informe q quantidade";
    }else{
        if($tipo_operacao == 1){
            $quantidade = $qtd_disponivel + $quantidade;
        }elseif($tipo_operacao == 2){
            $quantidade = $qtd_disponivel - $quantidade;
        }
    
    $inserir = "INSERT INTO tb_ajuste_estoque";
    $inserir .= "(cl_data,cl_produtoID,cl_qtd,cl_anterior_qtd,cl_nova_qtd,cl_tipo)";
    $inserir .= " VALUES ";
    $inserir .= "($hoje,'$id_produto','$quantidade_unico','$qtd_disponivel','$quantidade','$tipo_operacao')";
    $resultado_inserir_ajuste = mysqli_query($conecta, $inserir);

    $update = "UPDATE produtos set estoque = $quantidade where produtoID = $id_produto";
    $resultado_ajuste_estoque = mysqli_query($conecta, $update);
        if($resultado_ajuste_estoque){
			$retornar["sucesso"] = true;
            $retornar["qtd"] = $quantidade;

    
        }


    }
	echo json_encode($retornar);
}



//cadasrar produtos com estoque
if(isset($_POST["campoNomeProdutoEstoque"])){
    $retornar = array();
    $nome_produto = utf8_decode($_POST["campoNomeProdutoEstoque"]);
    $estoque = utf8_decode($_POST["campoEstoque"]);
    $unidade_medida = utf8_decode($_POST["campoUnidadedeMedida"]);
    $categoria = utf8_decode($_POST["campoCategoria"]);
    $precoCusto = utf8_decode($_POST["campoPrecoCusto"]);
    $observacao = utf8_decode($_POST["campoObservacao"]);
    $fabricante =  utf8_decode($_POST["campoFabricante"]);
    $valorTotal = $estoque * $precoCusto;

    if($categoria==0){
        $retornar['mensagem'] = "Favor informar a categoria do produto";
     
    }elseif($nome_produto==""){
        $retornar['mensagem'] = "Favor informe a descrição do produto";

    }else{
//inserindo as informações no banco de dados
  $inserir = "INSERT INTO tb_produto_estoque ";
  $inserir .= "(cl_descricao,cl_fabricante,cl_categoria,cl_und,cl_estoque,cl_preco_custo,cl_observacao,cl_total)";
  $inserir .= " VALUES ";
  $inserir .= "('$nome_produto','$fabricante',' $categoria',' $unidade_medida','$estoque','$precoCusto','$observacao','$valorTotal')";

  $operacao_inserir = mysqli_query($conecta, $inserir);
  if($operacao_inserir){
   $retornar["sucesso"] = true;
      
  }else{
    $retornar["sucesso"] = false;
  }


}
echo json_encode($retornar);

}


//excluir produto
if(isset($_POST["codigo"])){
    $retornar = array();
    $codigo = $_POST["codigo"];
    //delete as informações no banco de dados
    $delete = "DELETE from tb_produto_estoque where cl_id = $codigo";
    $resultado_remover = mysqli_query($conecta, $delete);
    if($resultado_remover){
    $retornar["sucesso"] = true;
        
    }else{
        $retornar["sucesso"] = false;
    }

  echo json_encode($retornar);
}


//cadasrar produtos com estoque
if(isset($_POST["campoNomeEditarProdutoEstoque"])){
    $retornar = array();
    $codigo = utf8_decode($_POST["cammpoProdutoID"]);
    $nome_produto = utf8_decode($_POST["campoNomeEditarProdutoEstoque"]);
    $estoque = utf8_decode($_POST["campoEstoque"]);
    $unidade_medida = utf8_decode($_POST["campoUnidadedeMedida"]);
    $categoria = utf8_decode($_POST["campoCategoria"]);
    $precoCusto = utf8_decode($_POST["campoPrecoCusto"]);
    $observacao = utf8_decode($_POST["campoObservacao"]);
    $fabricante =  utf8_decode($_POST["campoFabricante"]);
    $valorTotal = $estoque * $precoCusto;
    if($categoria==0){
        $retornar['mensagem'] = "Favor informar a categoria do produto";
     
    }elseif($nome_produto==""){
        $retornar['mensagem'] = "Favor informe a descrição do produto";

    }else{
//alterar as informações no banco de dados

$alterar = "UPDATE tb_produto_estoque set cl_descricao = '{$nome_produto}', cl_fabricante = '{$fabricante}', cl_categoria = '{$categoria}',  cl_und = '{$unidade_medida}',
 cl_estoque = '{$estoque}', cl_preco_custo = '{$precoCusto}', cl_observacao = '{$observacao}',cl_total = '{$valorTotal}' where cl_id = $codigo";
  $operacao_alterar = mysqli_query($conecta, $alterar);
  if($operacao_alterar){
   $retornar["sucesso"] = true;
      
  }else{
    $retornar["sucesso"] = false;
  }


}
echo json_encode($retornar);

}