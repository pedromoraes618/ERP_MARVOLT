//modal para informar dados adicionais 
$(".editar_prod").click(function () {
    var id_prod = $(this).attr("id_prod")
    $.ajax({
        type: 'GET',
        data: "alterar_produto=true&id_produto_nf=" + id_prod,
        url: "include/produto/modal_produto.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_produto").modal('show')

        },
    });
});


