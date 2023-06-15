<?php include 'crud.php'; ?>

<table class="table table-hover ">
    <thead>
        <tr style="background-color: cadetblue">
            <th class="text-light" scope="col">Lançamento</th>
            <th class="text-light" scope="col">A Fazer</th>
            <th class="text-light" scope="col">Comprador</th>
            <th class="text-light" scope="col">Descrição</th>
            <th class="text-light" scope="col">Status</th>
            <th class="text-light" scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($linha  = mysqli_fetch_assoc($consulta_contato)) {
            $id = $linha['cl_id'];
            $data_lancamento = $linha['cl_data_lancamento'];
            $data_limite = $linha['cl_data_limite'];
            $descricao = utf8_encode($linha['cl_descricao']);
            $comprador = $linha['comprador'];
            $status = $linha['cl_status'];
            if ($status == '1') {
                $status = "Concluido";
            } else {
                $status = "A Fazer";
            }
        ?>
            <tr>
                <th scope="row"><?php echo formatDateB($data_lancamento); ?></th>
                <td><?php echo formatDateB($data_limite); ?></td>
                <td><?php echo $comprador; ?></td>
                <td style="max-width: 500px;"><?php echo $descricao; ?></td>
                <td><?php echo $status; ?></td>
                <td class="td-btn"><button type="button" contato_id=<?php echo $id; ?> class="btn btn-info   btn-sm editar_contato">Editar</button>

            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    
    //abrir a pagina de edição do formulario, pegando o id 
    $(".editar_contato").click(function() {
        var form_id = $(this).attr("contato_id");

        $.ajax({
            type: 'GET',
            data: "contato=true&form_id=" + form_id,
            url: "tela_contato.php",
            success: function(result) {
                return $(".modal_externo").html(result) + $("#modal_contato").modal('show');
            },
        });



    });
</script>