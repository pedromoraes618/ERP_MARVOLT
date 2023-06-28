
var acao_modal = document.getElementById("acao_modal").value;
var msg_sefaz_modal = document.getElementById("msg_sefaz").value;

if (acao_modal == "enviar_nf") {
    atualizar_status(id)//atualizar status da nota
} else if (acao_modal == "cancelar_nf") {
    cancelar_nf(id) //botão manual para atualizar o status
}

$("#reconsultar_nf").click(function () {
    recunsultar_status(id) //botão manual para atualizar o status
})

$("#cancelar_nf").click(function () {
    cancelar_nf(id) //botão manual para atualizar o status
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

            $("#status_processamento").val($dados.valores)

        } else {
            console.log('erro')

        }
    }

    function falha() {
        console.log("erro");
    }

}

function recunsultar_status(id) {
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
            if ($dados.status == "autorizado") {
                $("#status_processamento").val($dados.valores)
                $("#chave_acesso").val($dados.chave_acesso)
                $("#nprotocolo").val($dados.nprotocolo)
                window.open($dados.opem_danfe_nf);
            } else if ($dados.status == "erro_autorizacao") {
                $("#chave_acesso").val($dados.chave_acesso)
            }

        } else {
            console.log('erro')

        }
    }

    function falha() {
        console.log("erro");
    }

}

// function info_nf(id) {//consultar nfe
//     $.ajax({
//         type: "POST",
//         data: "formulario_nota_fiscal=true&nfe=true&acao=consultar_nf&id_nf=" + id,
//         url: "crud/gerenciar_nfe.php",
//         async: false
//     }).then(sucesso, falha);

//     function sucesso(data) {
//         $dados = $.parseJSON(data)["dados"];
//         if ($dados.sucesso == true) {
//             $("#status_processamento").val($dados.valores)
//             $("#chave_acesso").val($dados.chave_acesso)
//             $("#nprotocolo").val($dados.nprotocolo)
//             //   window.open($dados.opem_danfe_nf);
//         } else {


//         }
//     }

//     function falha() {
//         console.log("erro");
//     }

// }

function cancelar_nf(id) {
    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&nfe=true&acao=cancelar_nf&id_nf=" + id,
        url: "crud/gerenciar_nfe.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $("#status_processamento").val($dados.valores)
        }
    }

    function falha() {
        console.log("erro");
    }

}