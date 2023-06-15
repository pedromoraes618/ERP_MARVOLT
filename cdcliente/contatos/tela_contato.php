<?php
include("../../conexao/conexao.php");
include("crud.php");
?>
<div class="modal fade" id="modal_contato" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Contato</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="" id="contato">

                <input type="hidden" id="id" name="id" value="<?php if (isset($_GET['form_id'])) {
                                                                    echo $_GET['form_id'];
                                                                } ?>">

                <input type="hidden" name="empresa_id" id="empresa_id" value="<?php if (isset($_GET['cliente_id'])) {
                                                                                echo $_GET['cliente_id'];
                                                                            }  ?>">
                <div class="modal-body">
                    <div class="title mb-2">
                        <span class=" form-label sub-title badge rounded-pill text-bg-dark"></span>

                    </div>

                    <div class="row mb-3">
                        <div class="col-md  mb-2">
                            <label for="data_lancamento" class="form-label">Data lançamento</label>
                            <input type="text" disabled class="form-control" id="data_lancamento" value="<?php if (!isset($_GET['form_id'])) {
                                                                                                                echo date('d/m/Y');
                                                                                                            } ?>">
                        </div>
                        <div class="col-md  mb-2">
                            <label for="comprador_id" class="form-label">Comprador</label>
                            <select name="comprador_id" id="comprador" class="form-select">
                                <option value="0">Comprador..</option>
                                <?php
                                while ($linha = mysqli_fetch_assoc($consulta_comprador)) {
                                    $id = $linha['id_comprador'];
                                    $comprador = utf8_encode($linha['comprador']);
                                ?>
                                    <option value="<?php echo $id; ?>"><?php echo $comprador; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md  mb-2">
                            <label for="data_pagamento" class="form-label">Data a fazer</label>
                            <input type="text" class="form-control " onkeyup="mascaraData(this);" maxlength="10" id="data_fazer" name="data_fazer" value="">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md  mb-2">
                            <textarea class="form-control" placeholder="Informe o que foi realizado" name="descricao" id="descricao" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md  mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="status" id="status">
                                <label class="form-check-label" for="ativo">

                                    A Realizar

                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                            <button type="submit" id="button_form" class="btn btn-success">Salvar</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>



            </form>
        </div>
    </div>
</div>

<script>
    const formulario_post = document.getElementById("contato");
    let id_formulario = document.getElementById("id")
    let titulo = document.getElementById('title_modal')
    let btn_form = document.getElementById('button_form')
    //formulario para cadastro

    //retorna os dados para o formulario
    if (id_formulario.value == "") {

        $('#button_form').html('Adicionar');

        $(".title .sub-title").html("Lançar Contato") //alterar a label cabeçalho


    } else {
        $('#button_form').html('Alterar');
        $(".title .sub-title").html("Alterar Contato")
        show(id_formulario.value) // funcao para retornar os dados para o formulario
    }

    $("#contato").submit(function(e) {

        e.preventDefault()
        if (id_formulario.value == "") { //cadastrar
            var formulario = $(this);
            Swal.fire({
                title: 'Tem certeza?',
                text: "Deseja adicionar esse contato?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Não',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim'
            }).then((result) => {
                if (result.isConfirmed) {
                    var retorno = create(formulario)
                }
            })
        } else { //editar
            e.preventDefault()
            var formulario = $(this);
            Swal.fire({
                title: 'Tem certeza?',
                text: "Deseja alterar essa contato",
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


    function create(dados) {

        $.ajax({
            type: "POST",
            data: "formulario_contato=true&acao=create&" + dados.serialize(),
            url: "crud.php",
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


                formulario_post.reset(); // redefine os valores do formulário
                $('#pesquisar_filtro_pesquisa').trigger('click'); // clicar automaticamente para realizar a consulta

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



    function update(dados) {

        $.ajax({
            type: "POST",
            data: "formulario_contato=true&acao=update&" + dados.serialize(),
            url: "crud.php",
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

                $('#pesquisar_filtro_pesquisa').trigger('click'); // clicar automaticamente para realizar a consulta

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
    function show(id) {
        $.ajax({
            type: "POST",
            data: "formulario_contato=true&acao=show&contato_id=" + id,
            url: "crud.php",
            async: false
        }).then(sucesso, falha);

        function sucesso(data) {

            $dados = $.parseJSON(data)["dados"];

            if ($dados.sucesso == true) {

                $("#data_lancamento").val($dados.valores['data_lancamento'])
                $("#empresa_id").val($dados.valores['empresa_id'])
                $("#comprador").val($dados.valores['comprador'])
                $("#descricao").val($dados.valores['descricao'])
                $("#data_fazer").val($dados.valores['data_limite'])
                if(($dados.valores['status'])=="2"){
                    $("#status").prop("checked", true);
                }
             

            }
        }

        function falha() {
            console.log("erro");
        }

    }
</script>