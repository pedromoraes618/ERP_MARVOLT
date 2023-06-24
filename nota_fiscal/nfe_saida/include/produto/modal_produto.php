<?php
include "../../../../conexao/conexao.php";
include "../../crud/gerenciar_nfe.php";
if (isset($_GET['id_produto_nf'])) {
    $id_produto = $_GET['id_produto_nf'];
} else {
    $id_produto = "";
}
if (isset($_GET['codigo_nf'])) {
    $codigo_nf = $_GET['codigo_nf'];
} else {
    $codigo_nf = "";
}
if (isset($_GET['numero_nf'])) {
    $numero_nf = $_GET['numero_nf'];
} else {
    $numero_nf = "";
}
?>

<div class="modal fade" id="modal_produto" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Item</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="col-md">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end ">
                        <button type="button" class="btn btn-sm btn-success" id="salvar_prod">Salvar</button>
                        <button type="button" class="btn btn-sm btn-danger" id="remover_prod">Remover</button>
                        <button type="button" class="btn btn-sm btn-secondary"  onclick="window.history.back();" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
                <div class="row mb-2">
                    <input type="hidden" id="id_produto" value="<?php echo $id_produto; ?>">
                    <input type="hidden" id="codigo_nf" value="<?php echo $codigo_nf; ?>">
                    <input type="hidden" id="numero_nf" value="<?php echo $numero_nf; ?>">
                    <div class="col-md-2 mb-2">
                        <label for="item_prod" class="form-label">Item</label>
                        <input type="text" disabled class="form-control" id="item_prod" name="item_prod" value="">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md mb-2">
                        <label for="descricao_prod" class="form-label">Descrição *</label>
                        <input type="text" class="form-control" id="descricao_prod" name="descricao_prod" value="">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-2 mb-2">
                        <label for="und" class="form-label">Und *</label>
                        <input type="text" class="form-control" id="und_prod" name="und_prod" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="qtd" class="form-label">Qtd *</label>
                        <input type="text" class="form-control" onchange="calculaValorTotalProduto()" id="qtd_prod" name="qtd_prod" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="vlr_unitario_prd" class="form-label">Vlr unitario *</label>
                        <input type="text" class="form-control" onchange="calculaValorTotalProduto()" id="vlr_unitario_prd" name="vlr_unitario_prd" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="vlr_total_prd" class="form-label">Vlr total *</label>
                        <input type="text" class="form-control" disabled id="vlr_total_prd" name="vlr_total_prd" value="">
                    </div>
                </div>
                <hr>
                <div class="row mb-2">
                    <div class="col-md mb-2">
                        <label for="cfop_prod" class="form-label">Natureza de operação * </label>
                        <select name="cfop_prod" class="form-control" id="cfop_prod">
                            <option value="0">Selecione..</option>
                            <?php
                            while ($linha = mysqli_fetch_assoc($consulta_cfop2)) {
                                $id = $linha['cl_id'];
                                $codigo = ($linha['cl_codigo']);
                                $descricao = utf8_encode($linha['cl_descricao']);
                                echo "<option value='$codigo'>$codigo - $descricao </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="ncm_prod" class="form-label">Ncm *</label>
                        <input type="text" list="datalistOptionsNcm_prod" class="form-control" id="ncm_prod" name="ncm_prod" value="">
                        <datalist id="datalistOptionsNcm_prod">
                            <?php while ($linha = mysqli_fetch_assoc($consulta_ncm)) {
                                $cest = $linha['cl_cest'];
                                $ncm = ($linha['cl_ncm']);
                                $descricao = utf8_encode($linha['cl_descricao']);
                                echo "<option value='$ncm'>$ncm - $descricao </option>";
                            } ?>
                        </datalist>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="cest_prod" class="form-label">Cest</label>
                        <input type="text" list="datalistOptionsCest_prod" class="form-control" id="cest_prod" name="cest_prod" value="">
                        <datalist id="datalistOptionsCest_prod">
                            <?php while ($linha = mysqli_fetch_assoc($consulta_cest)) {
                                $cest = $linha['cl_cest'];
                                $ncm = ($linha['cl_ncm']);
                                $descricao = utf8_encode($linha['cl_descricao']);
                                echo "<option value='$cest'>$cest - $descricao </option>";
                            } ?>
                        </datalist>
                    </div>
                    <div class="col-md-1 mb-2">
                        <label for="cst_prod" class="form-label">Cst *</label>
                        <input type="text" list="datalistOptionsCst_prod" class="form-control" id="cst_prod" name="cst_prod" value="">
                        <datalist id="datalistOptionsCst_prod">
                            <?php while ($linha  = mysqli_fetch_assoc($consulta_icms)) {
                                $icms_b = ($linha['cl_icms']);
                                $descricao_b = utf8_encode($linha['cl_descricao']);

                                echo "<option  value='$icms_b'> $descricao_b</option>";
                            } ?>
                        </datalist>
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-md-2 mb-2">
                        <label for="base_icms_prod" class="form-label">Base Icms</label>
                        <input type="text" class="form-control" id="base_icms_prod" name="base_icms_prod" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="aliq_icms_prod" class="form-label">% Icms *</label>
                        <input type="text" class="form-control" id="aliq_icms_prod" name="aliq_icms_prod" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="vlr_icms_prod" class="form-label">Icms</label>
                        <input type="text" class="form-control" id="vlr_icms_prod" name="vlr_icms_prod" value="">
                    </div>

                    <div class="col-md-2 mb-2">
                        <label for="base_icms_sub_prod" class="form-label">Base Icms Sub</label>
                        <input type="text" class="form-control" id="base_icms_sub_prod" name="base_icms_sub_prod" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="icms_sub_prod" class="form-label">Icms Sub</label>
                        <input type="text" class="form-control" id="icms_sub_prod" name="icms_sub_prod" value="">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label for="desconto_prod" class="form-label">Desconto rat</label>
                        <input type="text" class="form-control" id="desconto_prod" name="desconto_prod" value="">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md mb-2">
                        <label for="aliq_ipi_prod" class="form-label">% IPI</label>
                        <input type="text" class="form-control" id="aliq_ipi_prod" name="aliq_ipi_prod" value="">
                    </div>
                    <div class="col-md mb-2">
                        <label for="ipi_prod" class="form-label">IPI</label>
                        <input type="text" class="form-control" id="ipi_prod" name="ipi_prod" value="">
                    </div>

                    <div class="col-md mb-2">
                        <label for="ipi_devolvido" class="form-label">IPI Devolvido</label>
                        <input type="text" class="form-control" id="ipi_devolvido_prod" name="ipi_devolvido_prod" value="">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md mb-2">
                        <label for="base_pis_prod" class="form-label">Base Pis</label>
                        <input type="text" class="form-control" id="base_pis_prod" name="base_pis_prod" value="">
                    </div>
                    <div class="col-md mb-2">
                        <label for="pis_prod" class="form-label">Pis</label>
                        <input type="text" class="form-control" id="pis_prod" name="pis_prod" value="">
                    </div>

                    <div class="col-md mb-2">
                        <label for="cst_pis_prod" class="form-label">Cst Pis *</label>
                        <input type="text" class="form-control" list="datalistOptionsCst_pis_prod" id="cst_pis_prod" name="cst_pis_prod" value="">
                        <datalist id="datalistOptionsCst_pis_prod">
                            <?php while ($linha  = mysqli_fetch_assoc($consulta_cst_pis)) {
                                $cst_pis = ($linha['cl_cofins']);
                                $descricao_b = utf8_encode($linha['cl_descricao']);

                                echo "<option  value='$cst_pis'> $descricao_b</option>";
                            } ?>
                        </datalist>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md mb-2">
                        <label for="base_cofins_prod" class="form-label">Base Cofins</label>
                        <input type="text" class="form-control" id="base_cofins_prod" name="base_cofins_prod" value="">
                    </div>
                    <div class="col-md mb-2">
                        <label for="cofins_prod" class="form-label">Cofins</label>
                        <input type="text" class="form-control" id="cofins_prod" name="cofins_prod" value="">
                    </div>

                    <div class="col-md mb-2">
                        <label for="cst_cofins_prod" class="form-label">Cst cofins *</label>
                        <input type="text" class="form-control" list="datalistOptionsCst_cofins_prod" id="cst_cofins_prod" name="cst_cofins_prod" value="">
                        <datalist id="datalistOptionsCst_cofins_prod">
                            <?php while ($linha  = mysqli_fetch_assoc($consulta_cst_cofins)) {
                                $cst_cofins = ($linha['cl_cofins']);
                                $descricao_b = utf8_encode($linha['cl_descricao']);

                                echo "<option  value='$cst_cofins'> $descricao_b</option>";
                            } ?>
                        </datalist>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md mb-2">
                        <label for="base_iss_prod" class="form-label">Base ISS</label>
                        <input type="text" class="form-control" id="base_iss_prod" name="base_iss_prod" value="">
                    </div>
                    <div class="col-md mb-2">
                        <label for="iss_prod" class="form-label">Iss</label>
                        <input type="text" class="form-control" id="iss_prod" name="iss_prod" value="">
                    </div>
                    <div class="col-md mb-2">
                        <label for="gtin_prod" class="form-label">GTIN *</label>
                        <input type="text" class="form-control" id="gtin_prod" name="gtin_prod" value="">
                    </div>

                </div>
            </div>



        </div>
    </div>
</div>

<script src="js/modal_produto.js"></script>