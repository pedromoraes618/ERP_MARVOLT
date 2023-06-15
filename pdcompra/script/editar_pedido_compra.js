
function fechar() {
    window.close();
}

function calculavalormargem() {
    var campoPrecoVenda = document.getElementById("txtprecoUnitarioVenda").value;
    var campoPrecoCompra = document.getElementById("txtprecoUnitarioCompra").value;
    var campoMargem = document.getElementById("txtMargem");
    var calculo;

    campoPrecoVenda = parseFloat(campoPrecoVenda);
    campoPrecoCompra = parseFloat(campoPrecoCompra);

    calculo = (((campoPrecoVenda - campoPrecoCompra) / campoPrecoVenda) * 100).toFixed(2);
    campoMargem.value = calculo;
}


function calculavalormargemGeral() {
    var campoPrecoVenda = document.getElementById("txtValorTotalComDesconto").value;
    var campoPrecoCompra = document.getElementById("txtValorTotalCompra").value;
    var campoMargem = document.getElementById("txtValorMargem");
    var calculo;

    campoPrecoVenda = parseFloat(campoPrecoVenda);
    campoPrecoCompra = parseFloat(campoPrecoCompra);

    calculo = (((campoPrecoVenda - campoPrecoCompra) / campoPrecoVenda) * 100).toFixed(2);
    campoMargem.value = calculo;
}

function calculavalordescontoReais() {

    var campoDesconto = document.getElementById("txtDescontoGeral");
    var campoValorTotalH = document.getElementById("txtValorTotal").value;
    var campoDescontoReais = document.getElementById("txtDescontoGeralReais").value;
    var campoValorTotal = document.getElementById("txtValorTotalComDesconto");

    var calculoValorTotal;
    var calculoTotalCDescontoReais;

    campoValorTotalH = parseFloat(campoValorTotalH);
    campoDescontoReais = parseFloat(campoDescontoReais);

    calculoValorTotal = (campoValorTotalH - campoDescontoReais);
    calculoTotalCDescontoReais = ((campoDescontoReais / campoValorTotalH) * 100).toFixed(2);
    campoValorTotal.value = calculoValorTotal.toFixed(2);
    campoDesconto.value = calculoTotalCDescontoReais;
}


$("#gerar_nfe").click(function() {
    var cd_pedido = $("#txtcodigo").val() //pegar o codigo do pedido de compra
    var user_id = $("#user_id").val() //pegar o codigo do pedido de compra


    Swal.fire({
        title: 'Tem certeza?',
        text: "Deseja gerar uma nota fiscal desse pedido de compra?",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Não',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim'
    }).then((result) => {
        if (result.isConfirmed) {
            var retorno = create(cd_pedido,user_id)
        }
    })

})


function create(cd_pedido,user_id) {
   
    $.ajax({
        type: "POST",
        data: "gerar_nfe=true&acao=create&codigo_pedido=" + cd_pedido+"&user_id="+user_id,
        url: "crud/gerenciar_pedido_compra.php",
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