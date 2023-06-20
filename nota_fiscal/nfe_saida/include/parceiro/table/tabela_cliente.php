<?php
include "../../../../../conexao/conexao.php";
include "../../../crud/gerenciar_cliente.php";

if (isset($_GET['consultar_cliente'])) {
     $modal_selecionar =  'selecionar_parceiro';
} else {
     $modal_selecionar = 'selecionar_transportadora';
}

?>

<table class="table table-hover">
    <thead>

        <tr>
            <th scope="col">Código</th>
            <th scope="col">Razão social</th>
            <th scope="col">Cnpj/Cpf</th>
            <th scope="col">Cidade</th>
            <th scope="col">Status</th>
            <th scope="col"></th>

        </tr>

    </thead>
    <tbody>
        <?php while ($linha = mysqli_fetch_assoc($consultar_clientes)) {
            $cliente_id_b = $linha['clienteID'];
            $razao_social_b = utf8_encode($linha['razaosocial']);
            $nome_fantasia_b = utf8_encode($linha['nome_fantasia']);
            $cnpj_cpf_b = $linha['cpfcnpj'];
            $cidade_b = utf8_encode($linha['cidade']);

        ?>
            <tr class="rounded">

                <th scope="row"><?php echo $cliente_id_b ?></th>
                <td class="max_width_descricao"><?php echo $razao_social_b;  ?><br>
                    <hr class="mb-0"><?php echo $nome_fantasia_b; ?>
                </td>
                <td><?php echo formatCNPJCPF2($cnpj_cpf_b);  ?></td>
                <td><?php echo $cidade_b  ?></td>

                <td class="td-btn">
                    <button type="button" r_social=<?php echo $razao_social_b; ?> id_parceiro=<?php echo $cliente_id_b; ?> class="btn btn-info   btn-sm <?php echo $modal_selecionar; ?> ">Selecionar</button>
                </td>

                <td><input type="hidden" id="<?php echo $cliente_id_b; ?>" class="cliente_razao" value="<?php echo $razao_social_b; ?>"></td>

            </tr>

        <?php } ?>
    </tbody>
</table>


<script src="js/pesquisa_parceiro.js"></script>