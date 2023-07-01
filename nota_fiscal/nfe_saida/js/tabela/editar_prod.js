//modal para informar dados adicionais 
$(".editar_prod").click(function () {
    var id_prod = $(this).attr("id_prod")
    var codigo_nf = $(this).attr("codigo_nf")
    var numero_nf = $(this).attr("numero_nf")
    
    $.ajax({
        type: 'GET',
        data: "alterar_produto=true&id_produto_nf=" + id_prod + "&codigo_nf=" + codigo_nf + "&numero_nf=" + numero_nf ,
        url: "include/produto/modal_produto.php",
        success: function (result) {
            return $(".modal_externo").html(result) + $("#modal_produto").modal('show')

        },
    });
});
