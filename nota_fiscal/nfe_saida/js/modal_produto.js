
var id_produto = $("#id_produto").val()
var codigo_nf_prod = $("#codigo_nf").val()
var numero_nf_prod = $("#numero_nf").val()


// $("#fechar_prod").click(function () {

//     $("#modal_produto").modal('hide');//fechar o modal


// })


//retorna os dados para o formulario
if (id_produto == "") {
    //  $(".title .sub-title").html("Cadastro de produtos")//alterar a label cabeçalho
    //    $("#button_form").html("Cadastrar")
} else {
    //   $(".title .sub-title").html("Alterar produto")
    // $('#button_form').html('Salvar');
    showProduto(id_produto) // funcao para retornar os dados para o formulario
}



function calculaValorTotalProduto() {

    var qtd_produto = parseFloat($("#qtd_prod").val()) || 0;
    var valor_unitario = parseFloat($("#vlr_unitario_prd").val()) || 0;

    var valorTotal = qtd_produto * valor_unitario;

    $("#vlr_total_prd").val(valorTotal.toFixed(2));
}




$("#salvar_prod").click(function () {

    // var descricao = $("#descricao_prod").val();
    // var und = $("#und_prod").val();
    // var qtd = $("#qtd_prod").val();
    // var vlr_unitario = $("#vlr_unitario_prd").val();
    // var vlr_total = $("#vlr_total_prd").val();
    // var cfop = $("#cfop_prod").val();
    // var ncm = $("#ncm_prod").val();
    // var cest = $("#cest_prod").val();
    // var cst = $("#cst_prod").val();
    // var base_icms = $("#base_icms_prod").val();
    // var aliq_icms = $("#aliq_icms_prod").val();
    // var vlr_icms = $("#vlr_icms_prod").val();
    // var base_icms_sub = $("#base_icms_sub_prod").val();
    // var icms_sub = $("#icms_sub_prod").val();
    // var desconto = $("#desconto_prod").val();
    // var aliq_ipi = $("#aliq_ipi_prod").val();
    // var ipi = $("#ipi_prod").val();
    // var ipi_devolvido = $("#ipi_devolvido_prod").val();
    // var base_pis = $("#base_pis_prod").val();
    // var pis = $("#pis_prod").val();
    // var cst_pis = $("#cst_pis_prod").val();
    // var base_cofins = $("#base_cofins_prod").val();
    // var cofins = $("#cofins_prod").val();
    // var cst_cofins = $("#cst_cofins_prod").val();
    // var base_iss = $("#base_iss_prod").val();
    // var iss = $("#iss_prod").val();

    var itens = {
        id_produto: id_produto,
        descricao: $("#descricao_prod").val(),
        und: $("#und_prod").val(),
        qtd: $("#qtd_prod").val(),
        vlr_unitario: $("#vlr_unitario_prd").val(),
        vlr_total: $("#vlr_total_prd").val(),
        cfop: $("#cfop_prod").val(),
        ncm: $("#ncm_prod").val(),
        cest: $("#cest_prod").val(),
        cst: $("#cst_prod").val(),
        base_icms: $("#base_icms_prod").val(),
        aliq_icms: $("#aliq_icms_prod").val(),
        vlr_icms: $("#vlr_icms_prod").val(),
        base_icms_sub: $("#base_icms_sub_prod").val(),
        icms_sub: $("#icms_sub_prod").val(),
        desconto: $("#desconto_prod").val(),
        aliq_ipi: $("#aliq_ipi_prod").val(),
        ipi: $("#ipi_prod").val(),
        ipi_devolvido: $("#ipi_devolvido_prod").val(),
        base_pis: $("#base_pis_prod").val(),
        pis: $("#pis_prod").val(),
        cst_pis: $("#cst_pis_prod").val(),
        base_cofins: $("#base_cofins_prod").val(),
        cofins: $("#cofins_prod").val(),
        cst_cofins: $("#cst_cofins_prod").val(),
        base_iss: $("#base_iss_prod").val(),
        iss: $("#iss_prod").val(),
        gtin: $("#gtin_prod").val(),
        numero_nf: numero_nf_prod,
        codigo_nf: codigo_nf_prod,
    };

    if (id_produto != "") {//update
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja alterar esse prduto",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                updateProduto(itens, codigo_nf_prod, numero_nf_prod)
            }
        })
    } else{//INSERT
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja Incluir esse produto, Será necessario recalcular a nota",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                insertProduto(itens, codigo_nf_prod, numero_nf_prod)
            }
        })
    }
})


$("#remover_prod").click(function () {

    var itens = {
        id_produto: id_produto,
        numero_nf: numero_nf_prod,
        codigo_nf: codigo_nf_prod,
    };

    if (id_produto != "") {//update
       
        Swal.fire({
            title: 'Tem certeza?',
            text: "Deseja alterar remover esse produto, Será necessario recalcular a nota",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Não',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteProduto(itens, codigo_nf_prod, numero_nf_prod)
            }
        })
    }
})



function updateProduto(itens, codigo_nf_prod, numero_nf_prod) {
    let itensJSON = JSON.stringify(itens); //codificar para json

    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&acao=updateProduto&itens=" + itensJSON,
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

            tabela_prod(codigo_nf_prod, numero_nf_prod);//atualizar a tabela

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


function deleteProduto(itens, codigo_nf_prod, numero_nf_prod) {
    let itensJSON = JSON.stringify(itens); //codificar para json
    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&acao=delete_produto&itens=" + itensJSON,
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

            tabela_prod(codigo_nf_prod, numero_nf_prod);//atualizar a tabela
            $('#fechar_modal_prod').trigger('click'); // clicar automaticamente para realizar fechar o modal

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


function insertProduto(itens, codigo_nf_prod, numero_nf_prod) {
    let itensJSON = JSON.stringify(itens); //codificar para json
    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&acao=insert_produto&itens=" + itensJSON,
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

            tabela_prod(codigo_nf_prod, numero_nf_prod);//atualizar a tabela
            $('#fechar_modal_prod').trigger('click'); // clicar automaticamente para realizar fechar o modal

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
function showProduto(id) {

    $.ajax({
        type: "POST",
        data: "formulario_nota_fiscal=true&acao=showProduto&id_produto=" + id,
        url: "crud/gerenciar_nfe.php",
        async: false
    }).then(sucesso, falha);

    function sucesso(data) {

        $dados = $.parseJSON(data)["dados"];
        if ($dados.sucesso == true) {
            $("#codigo_prod").val($dados.valores['codigo'])
            $("#descricao_prod").val($dados.valores['descricao'])
            $("#und_prod").val($dados.valores['und'])
            $("#qtd_prod").val($dados.valores['quantidade'])
            $("#vlr_unitario_prd").val($dados.valores['valor_unitario'])
            $("#vlr_total_prd").val($dados.valores['valor_produto'])
            $("#cfop_prod").val($dados.valores['cfop'])
            $("#ncm_prod").val($dados.valores['ncm'])
            $("#cest_prod").val($dados.valores['cest'])
            $("#cst_prod").val($dados.valores['cst'])
            $("#base_icms_prod").val($dados.valores['bc_icms'])
            $("#aliq_icms_prod").val($dados.valores['aliq_icms'])
            $("#vlr_icms_prod").val($dados.valores['valor_icms'])
            $("#base_icms_sub_prod").val($dados.valores['base_icms_sub'])
            $("#icms_sub_prod").val($dados.valores['icms_sub'])
            $("#desconto_prod").val($dados.valores['desconto'])
            $("#aliq_ipi_prod").val($dados.valores['aliq_ipi'])
            $("#ipi_prod").val($dados.valores['valor_ipi'])
            $("#ipi_devolvido_prod").val($dados.valores['ipi_devolvido'])
            $("#base_pis_prod").val($dados.valores['base_pis'])
            $("#pis_prod").val($dados.valores['valor_pis'])
            $("#cst_pis_prod").val($dados.valores['cst_pis'])
            $("#base_cofins_prod").val($dados.valores['base_cofins'])
            $("#cofins_prod").val($dados.valores['valor_cofins'])
            $("#cst_cofins_prod").val($dados.valores['cst_cofins'])
            $("#base_iss_prod").val($dados.valores['base_iss'])
            $("#iss_prod").val($dados.valores['valor_iss'])
            $("#gtin_prod").val($dados.valores['gtin'])


        }

        // tabela_prod(codigo_nf, numero_nf);

    }

    function falha() {
        console.log("erro");
    }

}