<?php
include("../../conexao/sessao.php");
include("../../conexao/conexao.php");
include("crud.php");

if (isset($_GET['nfantasia'])) {
    $nome_fantasia = $_GET['nfantasia'];
    $cliente_id = $_GET['codigo'];
}

$ano  = date('Y') - 1;
$data_inicial = date("01/m/$ano");
$data_final = date('d/m/Y')


?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">

    <!-- estilo -->
    <link href="../../_css/estilo.css" rel="stylesheet">
    <link href="../../_css/pesquisa_tela.css" rel="stylesheet">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- icons bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="icon" type="img/icon.svg" href="img/icon.png">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="container container-sm pt-5">
        <div class="card m-3 border-0">
            <div class="row  mb-3">
                <div style="background-color:#f1f1f1;" class="col-md-auto  border border-1 rounded p-2">
                    <div class="row">
                        <h5>Contatos</h5>
                        <div> <?php echo $nome_fantasia ?></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card border-0">
            <div class="row">
                <div class="col-sm-4 col-auto   mb-2">
                    <div class="input-group">
                        <span class="input-group-text">Dt Lançamento</span>
                        <input type="text" class="form-control" maxlength="10" onkeyup="mascaraData(this);" id="data_inicial" name="data_incial" title="Data vencimento" placeholder="Data Inicial" value="<?php echo $data_inicial ?>">
                        <input type="text" class="form-control" maxlength="10" onkeyup="mascaraData(this);" id="data_final" name="data_final" title="Data vencimento" placeholder="Data Final" value="<?php echo $data_final; ?>">
                    </div>
                </div>
                <div class="col-md-2 mb-2">

                    <select name="comprador_id" class="form-select" id="comprador_id">

                        <option value="0">Comprador..</option>
                        <?php

                        while ($linha = mysqli_fetch_assoc($consulta_comprador)) {
                            $id = $linha['id_comprador'];
                            $comprador = utf8_encode($linha['comprador']);
                            $cliente = utf8_encode($linha['nome_fantasia']);
                        ?>
                            <option value="<?php echo $id; ?>"><?php echo $comprador ." - ". $cliente ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md  mb-2">
                    <div class="input-group">
                        <input type="hidden" id="cliente_id" value="<?php echo $cliente_id ?>">
                        <input type="text" class="form-control" id="pesquisa_conteudo" placeholder="Tente pesquisar pela descrição" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="button" id="pesquisar_filtro_pesquisa">Pesquisar</button>
                    </div>
                </div>
                <div class="col-md-auto  d-grid gap-2 d-sm-block mb-1">
                    <button type="button" class="btn btn-dark" id="adicionar_contato">Adicionar Contato</button>
                    <button class="btn btn-secondary" type="button" onclick="fechar();">Voltar</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="tabela table-responsive-sm">

        </div>
    </div>
    <div class="modal_externo">

    </div>


</body>
<?php include '../../_incluir/funcaojavascript.jar'; ?>

</html>


<script src="../../jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script src="https://malsup.github.io/jquery.form.js"></script>
<script src="js/menu/estilo/gerenciar_menu.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<!-- Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
</body>

</html>



<script>
    $("#adicionar_contato").click(function() {   
        var id_cliente = document.getElementById("cliente_id").value
        $.ajax({
            type: 'GET',
            data: "contato=true&cliente_id="+id_cliente,
            url: "tela_contato.php",
            success: function(result) {
                return $(".modal_externo").html(result) + $("#modal_contato").modal('show');
            },
        });

    });

    $(document).ready(function() {
        $('#pesquisar_filtro_pesquisa').trigger('click'); // clicar automaticamente para realizar a consulta
    })
    $("#pesquisar_filtro_pesquisa").click(function() { //realizar a pesquisa
        var id_cliente = document.getElementById("cliente_id").value
        var conteudo_pesquisa = document.getElementById("pesquisa_conteudo").value
        var data_inicial = document.getElementById("data_inicial").value
        var data_final = document.getElementById("data_final").value
        var comprador_id = document.getElementById("comprador_id").value;

        $.ajax({
            type: 'GET',
            data: {
                consultar_chamado: "detalhado",
                clienteID: id_cliente,
                pesquisar_conteudo: conteudo_pesquisa,
                dt_inicial: data_inicial,
                dt_final: data_final,
                comprador: comprador_id
            },

            url: "tabela_contatos.php",
            success: function(result) {
                return $(".container  .tabela").html(result);
            },
        });

    })



    function fechar() {
        window.close()

    }
</script>