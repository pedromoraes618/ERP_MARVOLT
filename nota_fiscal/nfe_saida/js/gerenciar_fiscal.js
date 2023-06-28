
var id = $("#id").val()
var codigo_nf = $("#codigo_nf").val()
var numero_nf = $("#numero_nf").val()
var chave_acesso_nf = $("#chave_acesso").val()
var nprotocolo_nf = $("#nprotocolo").val()

//retorna os dados para o formulario
if (id != "") {
    showResumo(id) // funcao para retornar os dados
}


$("#enviar_nf").click(function () {

    if (id != "") {//verificar se existe a nota

    
            Swal.fire({
                title: 'Tem certeza?',
                text: "Deseja enviar essa Nfe?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Não',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim'
            }).then((result) => {
                if (result.isConfirmed) {
                    modal_enviar(id)
                }
            })
        
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Verifique!',
            text: "Nfe não encontrada, Favor verifique",
            timer: 7500,

        })
    }
})


$("#consultar_pdf_nf").click(function () {
    consultar_pdf_nf(id)
})

$("#consultar_xml_nf").click(function () {
    consultar_xml_nf(id)
})

$("#cancelar_nf").click(function () {

    if (id != "") {//verificar se existe a nota
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja cancelar essa Nfe?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                modal_cancelar(id)
            }
        })
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Verifique!',
            text: "Nfe não encontrada, Favor verifique",
            timer: 7500,

        })
    }


})



function modal_enviar(id) {
    $.ajax({
        type: 'GET',
        data: "formulario_nota_fiscal=true&acao=enviar_nf&id_nf=" + id,
        url: "include/consultar_nf/modal_consulta_nf.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_consulta_nf").modal('show')

        },
    });

}


function modal_cancelar(id) {
    $.ajax({
        type: 'GET',
        data: "formulario_nota_fiscal=true&acao=cancelar_nf&id_nf=" + id,
        url: "include/consultar_nf/modal_consulta_nf.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_consulta_nf").modal('show')

        },
    });

}


function consultar_pdf_nf(id) {//consultar nfe
    //  alert("iokj")
    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&nfe=true&acao=consultar_nf_pdf&id_nf=" + id,
        url: "crud/gerenciar_nfe.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {

            window.open($dados.opem_danfe_nf);

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Verifique!',
                text: $dados.title,
                timer: 7500,

            })

        }
    }

    function falha() {
        console.log("erro");
    }

}
function consultar_xml_nf(id) {//consultar nfe
    //  alert("iokj")
    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&nfe=true&acao=consultar_nf_xml&id_nf=" + id,
        url: "crud/gerenciar_nfe.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {
        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {

            window.open($dados.opem_xml);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Verifique!',
                text: $dados.title,
                timer: 7500,

            })
        }
    }

    function falha() {
        console.log("erro");
    }

}


//mostrar as informações no formulario show
function showResumo(id) {
    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&acao=resumo_nf&nf_id=" + id,
        url: "crud/gerenciar_nfe.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];

        if ($dados.sucesso == true) {

            var outras_despesas = parseFloat($dados.valores['outras_despesas']) || 0;
            var vlr_total_produtos = parseFloat($dados.valores['vlr_total_produtos']) || 0;

            var valor_nota = outras_despesas + vlr_total_produtos

            $("#cliente").val($dados.valores['parceiro_descricao'])
            $("#valor").val(valor_nota)
            $("#desconto").val($dados.valores['desconto_nota'])
            $("#valor_total").val($dados.valores['vlr_total_nota'])
            $("#chave_acesso").val($dados.valores['chave_acesso'])
            $("#nprotocolo").val($dados.valores['protocolo'])


        }

        // tabela_prod(codigo_nf, numero_nf);

    }

    function falha() {
        console.log("erro");
    }

}