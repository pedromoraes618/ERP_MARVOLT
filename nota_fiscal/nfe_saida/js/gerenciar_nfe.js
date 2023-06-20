const formulario_post = document.getElementById("nota_fsical");
let id_formulario = document.getElementById("id")
let numero_nf = document.getElementById("numero_nf")
let codigo_nf = document.getElementById("codigo_nf")



//modal para consultar o parceiro
$("#modal_parceiro").click(function () {
    $.ajax({
        type: 'GET',
        data: "adicionar_parceiro=true",
        url: "include/parceiro/modal_parceiro.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_pesquisa_parceiro").modal('show');

        },
    });
});

//modal para consultar a transportadora
$("#modal_transportadora").click(function () {
    $.ajax({
        type: 'GET',
        data: "adicionar_trasnportadora=true",
        url: "include/parceiro/modal_parceiro.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_pesquisa_parceiro").modal('show');

        },
    });
});


//modal para informar dados adicionais 
$("#modal_observacao").click(function () {
    var observacao = $("#observacao").val();
    $.ajax({
        type: 'GET',
        data: "adicionar_dados_adicionais=true",
        url: "include/observacao/modal_observacao.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_dados_complementares").modal('show') + $("#dados_complementares").val(observacao);

        },
    });
});




//retorna os dados para o formulario
if (id_formulario.value == "") {
    //  $(".title .sub-title").html("Cadastro de produtos")//alterar a label cabeçalho
    //    $("#button_form").html("Cadastrar")
} else {
    //   $(".title .sub-title").html("Alterar produto")
    // $('#button_form').html('Salvar');
    show(id_formulario.value, numero_nf.value, codigo_nf.value) // funcao para retornar os dados para o formulario
}


$("#nota_fsical").submit(function (e) {
    e.preventDefault()
    if (id_formulario.value != "") {//update
        var formulario = $(this);
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja alterar essa Nfe?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                var retorno = update(formulario)
            }
        })
    }
})


function update(dados) {

    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&acao=update&" + dados.serialize(),
        url: "crud/gerenciar_nfe.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: $dados.title,
                showConfirmButton: false,
                timer: 3500
            })

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
function show(id, numero_nf, codigo_nf) {

    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&acao=show&nf_id=" + id,
        url: "crud/gerenciar_nfe.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $("#chave_acesso").val($dados.valores['chave_acesso'])
            $("#data_emissao").val($dados.valores['data_emissao'])
            $("#data_saida").val($dados.valores['data_saida'])
            $("#finalidade").val($dados.valores['finalidade'])
            $("#fpagamento").val($dados.valores['fpagamento'])
            $("#cfop").val($dados.valores['cfop'])
            $("#frete").val($dados.valores['frete'])
            $("#protocolo").val($dados.valores['protocolo'])
            $("#parceiro_descricao").val($dados.valores['parceiro_descricao'])
            $("#parceiro_id").val($dados.valores['parceiro_id'])
            $("#vlr_total_produtos").val($dados.valores['vlr_total_produtos'])
            $("#desconto_nota").val($dados.valores['desconto_nota'])
            $("#vlr_total_nota").val($dados.valores['vlr_total_nota'])
            $("#observacao").val($dados.valores['observacao'])

            $("#transportadora_descricao").val($dados.valores['transportadora_descricao'])
            $("#transportadora_id").val($dados.valores['transportadora_id'])

            $("#placa").val($dados.valores['placa'])
            $("#uf_veiculo").val($dados.valores['uf_veiculo'])
            $("#quantidade_trp").val($dados.valores['quantidade_trp'])
            $("#especie").val($dados.valores['especie'])
            $("#peso_bruto").val($dados.valores['peso_bruto'])
            $("#peso_liquido").val($dados.valores['peso_liquido'])
            $("#outras_despesas").val($dados.valores['outras_despesas'])
            $("#vfrete").val($dados.valores['vfrete'])
            $("#numero_pedido").val($dados.valores['npedido'])

        }

        tabela_prod(codigo_nf, numero_nf);

    }

    function falha() {
        console.log("erro");
    }

}

function tabela_prod(codigo_nf, numero_nf) {
    $.ajax({
        type: 'GET',
        data: "consultar_tabela_prod_nf=true&codigo_nf=" + codigo_nf + "&numero_nf=" + numero_nf,
        url: "tabela/tabela_produto.php",
        success: function (result) {
            return $(".tabela_externa").html(result)
        },
    });

}


function calcularTotal() {
    var outrasDespesas = parseFloat($("#outras_despesas").val()) || 0;
    var totalProdutos = parseFloat($("#vlr_total_produtos").val()) || 0;
    var desconto = parseFloat($("#desconto_nota").val()) || 0;

    var valorTotal = outrasDespesas + totalProdutos - desconto;

    $("#vlr_total_nota").val(valorTotal.toFixed(2));
}
