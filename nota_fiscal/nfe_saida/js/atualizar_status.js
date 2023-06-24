
atualizar_status(id)//atualizar status da nota
$("#reconsultar_nf").click(function () {
    atualizar_status(id) //botão manual para atualizar o status
})


function atualizar_status(id) {
    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&nfe=true&acao=enviar_nf&id_nf=" + id,
        url: "crud/gerenciar_nfe.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            if ($dados.http_code == "422") {//valido
                info_nf(id)
            } else {
                $("#status_processamento").val($dados.valores)
            }
        } else {


        }
    }

    function falha() {
        console.log("erro");
    }

}


function info_nf(id) {//consultar nfe
    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&nfe=true&acao=consultar_nf&id_nf=" + id,
        url: "crud/gerenciar_nfe.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $("#status_processamento").val($dados.valores)
            $("#chave_acesso").val($dados.chave_acesso)
            $("#nprotocolo").val($dados.nprotocolo)
        } else {


        }
    }

    function falha() {
        console.log("erro");
    }

}