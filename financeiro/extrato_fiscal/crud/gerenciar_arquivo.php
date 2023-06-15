<?php
if (isset($_POST['id_doc'])) {
    include "../../../conexao/conexao.php";
    $retornar = array();
    $id = $_POST['id_doc'];
    $delete = "DELETE FROM tb_extrato_fiscal where cl_id ='$id'";
    $operacao_delete = mysqli_query($conecta, $delete);
    if ($operacao_delete) {
        $retornar["dados"] = array("sucesso" => true, "title" => "Doc removido com sucesso");
    } else {
        $retornar["dados"] = array("sucesso" => false, "title" => "Não foi possivel remover o doc");
    }
    echo json_encode($retornar);

}
