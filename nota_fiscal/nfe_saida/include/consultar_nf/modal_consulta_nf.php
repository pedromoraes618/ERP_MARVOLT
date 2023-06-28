<?php
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
} else {
    $acao = "";
}
?>
<div class="modal fade" id="modal_consulta_nf" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <input type="hidden" id="acao_modal" value="<?php echo $acao; ?>">

            <div class="modal-header">
                <h1 class="modal-title fs-5">Status nf</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">
                <div class="row">
                    <div class="col-md mb-2">
                        <input type="text" class="form-control" id="msg_sefaz" placeholder="Mensagem da sefaz">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md  mb-2">
                        <textarea class="form-control" id="status_processamento" placeholder="Digite as informações adicionais" name="" cols="30" rows="10"></textarea>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" <?php if ($acao == "consultar_nf") {
                                                                    echo "id='reconsultar_nf'";
                                                                }elseif ($acao == "enviar_nf") {
                                                                    echo "id='reconsultar_nf'";
                                                                } elseif ($acao == "cancelar_nf") {
                                                                    echo "id='cancelar_nf'";
                                                                } ?>>Consultar Nf</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script src="js/atualizar_status.js"></script>
<!-- <script src="js/gerenciar_fiscal.js"></script> -->