
var id_produto =  $("#id_produto").val()

//retorna os dados para o formulario
if (id_produto.value == "") {
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
            $("#item_prod").val($dados.valores['item'])
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
        

        }

       // tabela_prod(codigo_nf, numero_nf);

    }

    function falha() {
        console.log("erro");
    }

}