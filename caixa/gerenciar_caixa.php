<?php 
include("../conexao/sessao.php");
include("../conexao/conexao.php"); 
include("../relatorio/dashboard/include/mes.php");
include("../_incluir/funcoes.php");
?>

<!doctype html>
<html>

<head>
    <meta charset="UTF-8">

    <!-- estilo -->
    <link href="../_css/estilo.css" rel="stylesheet">
    <link href="../_css/pesquisa_tela.css" rel="stylesheet">
    <link href="../_css/relatorio.css" rel="stylesheet">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="rla_operacional">
    <?php include("../_incluir/topo.php"); ?>
    <?php include("../_incluir/body.php"); ?>

    <main>
        <div class="bloco-principal">
            <section id="topo">
                <div class="title">
                    <h3>Abertura e fechamento Caixa</h3>
                </div>
                <div class="topo-1">
                    <div class="btn_operacional">
                        <button id="btn_abrir_caixa" class="button">Abrir</button>
                        <button id="btn_fechar_caixa" class="button">Fechar</button>
                    </div>
                    <div class="hidden">
                        <input type="hidden" id="id_usuario" value="<?php echo $user; ?>">
                        <input type="hidden" id="user" value="<?php echo $nome; ?>">
                    </div>

                    <div class="filtro-ano">
                        <div class="title">
                            <h4>Mês</h4>
                        </div>
                        <div class="bloco">
                            <div id="filtro-1" class="filtro-group">
                                <select id="mes_caixa" name="mes_caixa">

                                    <?php
                                    while($row = mysqli_fetch_assoc($consulta_mes_ini)){
                                    $mes_id = ($row['cl_id']);
                                    $descricao_b = utf8_encode($row['cl_descricao']);
                                    $numero_b = utf8_encode($row['cl_numero']);
                                    if($mes == $mes_id){
                                        echo "<option selected value='$numero_b'>$descricao_b</option>";
                                    }else{
                                        echo "<option value='$numero_b'>$descricao_b</option>";
                                    }
                                }
                              
                                    ?>



                                </select>

                            </div>
                            <div id="filtro-1" class="filtro-group">
                                <select id="ano_caixa" name="ano">
                                    <?php
                                    for ($anoInicio = date('Y') - 5; $anoInicio <= date('Y'); $anoInicio++)
                                    {
                                        ?>
                                    <option <?php if($anoInicio == date('Y')){
                                        ?> selected <?php
                                    } ?> value="<?php echo $anoInicio?>"><?php echo $anoInicio ?>
                                    </option>

                                    <?php
                                    }
                                    ?>

                                </select>

                            </div>

                        </div>

                    </div>
                </div>
            </section>
            <section class="operacional">

            </section>
        </div>
    </main>
    <script src="../jquery.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
</body>

</html>

<script>
var mes_caixa = document.getElementById("mes_caixa");
var ano_caixa = document.getElementById("ano_caixa");
var usuario_id = document.getElementById("id_usuario");
var user = document.getElementById("user");

$(document).ready(function(e) {
    $('.bloco-principal .operacional').css("display", "block")
    $.ajax({
        type: 'GET',
        data: "status_caixa=true&mes_caixa=" + mes_caixa.value + "&ano_caixa=" + ano_caixa.value,
        url: "status_caixa.php",
        success: function(result) {
            return $('.bloco-principal .operacional').html(result);
        },
    });
})



$("#mes_caixa").change(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'GET',
        data: "status_caixa=true&mes_caixa=" + mes_caixa.value + "&ano_caixa=" + ano_caixa.value,
        url: "status_caixa.php",
        success: function(result) {
            return $('.bloco-principal .operacional').html(result);
        },
    });
})

$("#btn_abrir_caixa").click(function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Tem certeza?',
        text: "Deseja abrir o caixa desse mês?",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Não',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim'
    }).then((result) => {
        if (result.isConfirmed) {
            var retorno = abrir_caixa(mes_caixa.value, ano_caixa.value, usuario_id.value, user.value)
        }
    })

})

$("#btn_fechar_caixa").click(function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Tem certeza?',
        text: "Deseja fechar o caixa desse periodo?",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Não',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim'
    }).then((result) => {
        if (result.isConfirmed) {
            var retorno = fechar_caixa(mes_caixa.value, ano_caixa.value, usuario_id.value, user.value)

        }
    })

})


function abrir_caixa(mes_caixa, ano_caixa, usuario_id, user) {
    $.ajax({
        type: "POST",
        data: "abertura_caixa=true&mes_caixa=" + mes_caixa + "&ano_caixa=" + ano_caixa + "&usuario_id=" +
            usuario_id + "&user=" + user,
        url: "crud/gerenciar_caixa.php",
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
                timer: 1500
            })


            $.ajax({
                type: 'GET',
                data: "status_caixa=true&mes_caixa=" + mes_caixa + "&ano_caixa=" + ano_caixa,
                url: "status_caixa.php",
                success: function(result) {
                    return $('.bloco-principal .operacional').html(result);
                },
            });

        }
    }

    function falha() {
        console.log("erro")
    }
}

function fechar_caixa(mes_caixa, ano_caixa, usuario_id, user) {
   
    $.ajax({
        type: "POST",
        data: "fechar_caixa=true&mes_caixa=" + mes_caixa + "&ano_caixa=" + ano_caixa + "&usuario_id=" +
            usuario_id + "&user=" + user,
        url: "crud/gerenciar_caixa.php",
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
                timer: 1500
            })

            $.ajax({
                type: 'GET',
                data: "status_caixa=true&mes_caixa=" + mes_caixa + "&ano_caixa=" + ano_caixa,
                url: "status_caixa.php",
                success: function(result) {
                    return $('.bloco-principal .operacional').html(result);
                },
            });

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Verifique!',
                text: $dados.title,
                timer: 7500,
            })

            $.ajax({
                type: 'GET',
                data: "status_caixa=true&mes_caixa=" + mes_caixa + "&ano_caixa=" + ano_caixa,
                url: "status_caixa.php",
                success: function(result) {
                    return $('.bloco-principal .operacional').html(result);
                },
            });
        }
    }

    function falha() {
        console.log("erro")
    }
}
</script>