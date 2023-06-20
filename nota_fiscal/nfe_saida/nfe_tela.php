<?php
include "../../conexao/sessao.php";
include "../../conexao/conexao.php";
include "crud/gerenciar_nfe.php";

if ((isset($_GET['numero_nf'])) and (isset($_GET['codigo_nf'])) and isset($_GET['id'])) {
    $numero_nf = $_GET['numero_nf'];
    $codigo_nf = $_GET['codigo_nf'];
    $id = $_GET['id'];
} else {
    $numero_nf = "";
    $codigo_nf = "";
    $id = "";
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <head>
        <link href="../../_css/tela_bootstrap.css" rel="stylesheet">
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

</head>

<body>
    <div class="bloco_principal">
        <div class="row m-0 mb-3">
            <div class="col-md p-2  card p-2">
                <h5 class="fw-bold">Notal fiscal</h5>
            </div>

        </div>

        <div class="card">
            <form class="form_principal" id="nota_fsical">

                <div class="col-md mb-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                        <button type="submit" id="concluir_venda" onclick="calcula_v_liquido()" class="btn btn-sm btn-success">Salvar</button>
                        <button type="button" id="modal_observacao" class="btn btn-sm btn-dark">Informação adicionais</button>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="window.opener.location.reload(); window.close();" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-1 mb-2">
                        <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                        <input type="hidden" id="codigo_nf" name="codigo_nf" value="<?php echo $codigo_nf ?>">
                        <label for="numero_nf" class="form-label">Nº NF</label>
                        <input type="text" class="form-control" disabled id="numero_nf" name="numero_nf" value="<?php echo $numero_nf; ?>">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="data_emissao" class="form-label">Data emissão</label>
                        <input type="text" class="form-control" disabled id="data_emissao" name="data_emissao" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="data_saida" class="form-label">Data saida</label>
                        <input type="text" class="form-control" disabled id="data_saida" name="data_saida" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="finalidade" class="form-label">Finalidade </label>
                        <select name="finalidade" class="form-control" id="finalidade">
                            <option value="0">Selecione..</option>
                            <?php
                            while ($linha = mysqli_fetch_assoc($consulta_finalidade)) {
                                $id = $linha['finalidadeID'];
                                $descricao = $linha['descricao'];
                                echo "<option value='$id'> $descricao </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="fpagamento" class="form-label">Forma de pagamento </label>
                        <select name="fpagamento" class="form-control" id="fpagamento">
                            <option value="0">Selecione..</option>
                            <?php
                            while ($linha = mysqli_fetch_assoc($consulta_forma_pagamento)) {
                                $id = $linha['formapagamentoID'];
                                $descricao = utf8_encode($linha['nome']);
                                echo "<option value='$id'> $descricao </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md mb-2">
                        <label for="cfop" class="form-label">Natureza de operação </label>
                        <select name="cfop" class="form-control" id="cfop">
                            <option value="0">Selecione..</option>
                            <?php
                            while ($linha = mysqli_fetch_assoc($consulta_cfop)) {
                                $id = $linha['cl_id'];
                                $codigo = ($linha['cl_codigo']);
                                $descricao = utf8_encode($linha['cl_descricao']);
                                $descricao = substr($descricao, 0, 40) . '..';
                                echo "<option value='$codigo'>$codigo - $descricao </option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-2">
                    <input type="hidden" name="formulario_nota_fiscal">
                    <div class="col-md-2 mb-2">
                        <label for="numero_pedido" class="form-label">Nº pedido</label>
                        <input type="text" class="form-control" id="numero_pedido" name="numero_pedido" value="">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label for="frete" class="form-label">Frete</label>
                        <select name="frete" class="form-control" id="frete">
                            <option value="0">Selecione..</option>
                            <?php
                            while ($linha = mysqli_fetch_assoc($consulta_frete)) {
                                $id = $linha['freteID'];
                                $descricao = utf8_encode($linha['descricao']);

                                echo "<option value='$id'>$descricao </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md mb-2">
                        <label for="chave_acesso" class="form-label">Chave de acesso</label>
                        <input type="text" class="form-control" disabled id="chave_acesso" name="chave_acesso" value="">
                    </div>
                    <div class="col-md-3  mb-2">
                        <label for="protocolo" class="form-label">Protocolo</label>
                        <input type="text" class="form-control" disabled id="protocolo" name="protocolo" value="">
                    </div>

                </div>
                <div class="row mb-2">

                </div>
                <div class="row mb-2">
                    <div class="col-md  mb-2">
                        <label for="parceiro_descricao" class="form-label">Cliente</label>
                        <div class="input-group">
                            <input type="text" class="form-control" readonly id="parceiro_descricao" name="parceiro_descricao" placeholder="Pesquise pelo Cliente/Fornecedor" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <input type="hidden" class="form-control" name="parceiro_id" id="parceiro_id" value="">
                            <button class="btn btn-outline-secondary" type="button" name="modal_parceiro" id="modal_parceiro">Pesquisar</button>

                        </div>
                    </div>
                    <div class="col-md ">
                        <label for="transportadora_descricao" class="form-label">Trasnportadora</label>
                        <div class="input-group">
                            <input type="text" class="form-control" readonly id="transportadora_descricao" name="transportadora_descricao" placeholder="Pesquise pela Transportadora" aria-label="Recipient's username" aria-describedby="button-addon2">
                            <input type="hidden" class="form-control" name="transportadora_id" id="transportadora_id" value="">
                            <button class="btn btn-outline-secondary" type="button" name="modal_transportadora" id="modal_transportadora">Pesquisar</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 ">
                        <label for="placa" class="form-label">Placa</label>
                        <input type="text" class="form-control" id="placa" name="placa" value="">
                    </div>
                    <div class="col-md-1  mb-2">
                        <label for="uf_veiculo" class="form-label">UF Veículo</label>
                        <input type="text" class="form-control" id="uf_veiculo" name="uf_veiculo" value="">
                    </div>
                    <div class="col-md-2  mb-2">
                        <label for="quantidade_trp" class="form-label">Quantidade</label>
                        <input type="text" class="form-control" id="quantidade_trp" name="quantidade_trp" value="">
                    </div>
                    <div class="col-md-1  mb-2">
                        <label for="especie" class="form-label">Espécie</label>
                        <input type="text" class="form-control" id="especie" name="especie" value="">
                    </div>
                    <div class="col-md-2  mb-2">
                        <label for="peso_bruto" class="form-label">Peso bruto</label>
                        <input type="text" class="form-control" id="peso_bruto" name="peso_bruto" value="">
                    </div>
                    <div class="col-md-2  mb-2">
                        <label for="peso_liquido" class="form-label">Peso Liquido</label>
                        <input type="text" class="form-control" id="peso_liquido" name="peso_liquido" value="">
                    </div>
                    <div class="col-md-2  mb-2">
                        <label for="vfrete" class="form-label">Frete</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" name="vfrete" id="vfrete" value="">
                        </div>
                    </div>
                </div>


                <div class="row border-success">

                    <div class="col-md-2  mb-2">
                        <label for="outras_despesas" class="form-label">Outras despesas</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" onchange="calcularTotal()" name="outras_despesas" id="outras_despesas" value="">
                        </div>
                    </div>
                    <div class="col-md-2  mb-2">
                        <label for="vlr_total_produtos" class="form-label">Valor total produtos</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" disabled name="vlr_total_produtos" id="vlr_total_produtos" value="">
                        </div>
                    </div>
                    <div class="col-md-2  mb-2">
                        <label for="desconto_nota" class="form-label">Desconto</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" onchange="calcularTotal()" name="desconto_nota" id="desconto_nota" value="">
                        </div>
                    </div>
                    <div class="col-md-2  mb-2">
                        <label for="vlr_total_nota" class="form-label">Valor total nota</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" disabled name="vlr_total_nota" id="vlr_total_nota" value="">
                        </div>
                    </div>
                </div>
                <input type="hidden" id="observacao" name="observacao">
            </form>


            <div class="tabela_externa"></div>
        </div>
        <div class="modal_externo"></div>
    </div>


    <script src="../../jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script src="https://malsup.github.io/jquery.form.js"></script>
    <script src="js/menu/estilo/gerenciar_menu.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="js/gerenciar_nfe.js"></script>
</body>

</html>