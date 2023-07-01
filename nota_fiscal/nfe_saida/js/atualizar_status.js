
var acao_modal = document.getElementById("acao_modal").value;
var msg_sefaz_modal = document.getElementById("msg_sefaz");

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

$("#enviar_carta_correcao").click(function () {
    carta_correcao(id, msg_sefaz_modal.value)
})

$("#enviar_inutilizacao").click(function () {
    var numero_ini = $("#numero_ini").val()

    if (numero_ini != "") {
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja inutilizar esta numeração? Por favor, observe que ela não poderá ser utilizada novamente no futuro.",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                inutilizar_nf(id, numero_ini)
            }
        })
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Verifique!',
            text: "Informe o número da Nf-e",
            timer: 7500,

        })
    }

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

function carta_correcao(id, texto) {

    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&nfe=true&acao=carta_correcao&id_nf=" + id + "&texto=" + texto,
        url: "crud/gerenciar_nfe.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $("#status_processamento").val($dados.valores)
            if ($dados.status == "autorizado") {
                window.open($dados.opem_danfe_crt)//abrir a nota
            }
        }
    }

    function falha() {
        console.log("erro");
    }

}

function inutilizar_nf(id, numero_ini) {

    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&nfe=true&acao=intulizar&id_nf=" + id + "&numero_inicial=" + numero_ini ,
        url: "crud/gerenciar_nfe.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $("#status_processamento").val($dados.valores)
            $("#nprotocolo").val($dados.protocolo_sefaz)
        }
    }

    function falha() {
        console.log("erro");
    }

}