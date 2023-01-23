<?php 
include "crud.php";
include "../../_incluir/funcoes.php";
?>


<table border="0" cellspacing="0" width="100%" class="tabela_pesquisa">
    <tbody>
        <tr id="cabecalho_pesquisa_consulta">
            <td  style="width: 70px;">
                <p>Código</p>
            </td>

            <td>
                <p>Data de lançamento</p>
            </td>

            <td>
                <p>Data de vencimento</p>
            </td>
            <td style="width: 500px;">
                <p>Descrição</p>
            </td>
          
            <td>
                <p>Doc</p>
            </td>
            <td>
                <p></p>
            </td>
        </tr>
        <?PHP while($linha = mysqli_fetch_assoc($consultar_certificado)){ 
             $id_certificado = $linha['cl_id'];
             $data_lancamento_b = $linha['cl_data_lancamento'];
             $data_expirar_b = $linha['cl_data_vencimento'];
             $descricao_b = ($linha['cl_descricao']);
             $diretorio = ($linha['cl_diretorio']);
           
            ?>
        <tr id="linha_pesquisa">
            <td>
                <font size="3"><?php echo $id_certificado; ?> </font>
            </td>
            <td>
                <p><?php echo formatardataB2($data_lancamento_b); ?></p>
            </td>
            <td>
                <p><?php echo formatardataB2($data_expirar_b); ?></p>
            </td>
            <td >
                <p><?php echo ($descricao_b); ?></p>
            </td>

            <td >
                <a target="blank" href="<?php echo $diretorio?>">
                    <i class="fa-regular fa-folder-open"></i>
                </a>
            </td>
            <td>
                <button type="button" style="background-color: red;" id="remover_certificado"
                    id_certificado="<?php echo $id_certificado ?>" class="btn btn-danger">Remover</button>
            </td>
            <!-- <td id="botaoEditar">
                <a
                    onclick="window.open('anexao_arquivo.php?codigo=2', 
'editar_produto', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">
                    <button type="button" name="editar">Editar</button>
                </a>
            </td> -->
        </tr>
        <?php }?>
    </tbody>
</table>

<script src="../jquery.js"></script>

<script>
$('td button').click(function(e) {
    var id_certificado = $(this).attr("id_certificado");

    Swal.fire({
        title: 'Você tem certeza?',
        text: "Deseja deletar esse doc?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim!',
        cancelButtonText: 'Não!'
    }).then((result) => {
        if (result.isConfirmed) {
            var elemento = $(this).parent().parent();
            $(elemento).fadeOut();
            $.ajax({
                type: "GET",
                data: "deletar_certifcado=" + id_certificado,
                url: "tabela/crud.php",
                async: false
            }).done(function(data) {

            })

            Swal.fire(
                'Deltar!',
                'Doc deletado com sucesso',
                'success'
            )
        } else {

        }
    })






});
</script>