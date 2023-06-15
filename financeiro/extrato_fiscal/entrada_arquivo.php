<?php
include("../../conexao/conexao.php");
include("../../conexao/sessao.php");
include("../../_incluir/funcoes.php");
?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
echo ".";
$hoje = date('y-m-d');
$user = $_SESSION["user_portal"];

if (isset($_FILES['arquivo'])) {
	include("ofx.php");
	$banco = $_POST['campoBanco'];

	if ($banco == "0") {
?>
		<script>
			Swal.fire({
				position: 'center',
				icon: 'error',
				title: "Não foi possivel efetuar o upload, favor Selecione um banco",
				showConfirmButton: false,
				timer: 3500
			})
		</script>
		<?php
	} else {

		$formatosPermitidos = array("ofx", "OFX");
		$extensao = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
		if (in_array($extensao, $formatosPermitidos)) {
			$pasta = "arquivo/";
			$temporario = $_FILES['arquivo']['tmp_name'];
			$novoNome = uniqid() . "." . $extensao;
			$nome = ($_FILES['arquivo']['name']);

			if (move_uploaded_file($temporario, $pasta . $novoNome)) {
				//incliur no banco de dados
				//anexarArquivoImg($novoNome,$pasta,$codProduto);
		?>
				<script>
					Swal.fire({
						position: 'center',
						icon: 'success',
						title: "Upload efetuado com sucesso",
						showConfirmButton: false,
						timer: 3500
					})
				</script>
			<?php

			} else {
			?>
				<script>
					Swal.fire({
						position: 'center',
						icon: 'error',
						title: "Não foi possivel efetuar o upload, favor verifique",
						showConfirmButton: false,
						timer: 3500
					})
				</script>
			<?php
			}
		} else {
			?>
			<script>
				Swal.fire({
					position: 'center',
					icon: 'error',
					title: "Arquivo com formato invalido",
					showConfirmButton: false,
					timer: 3500
				})
			</script>
<?php
		}
		$ofx = new Ofx("arquivo/$novoNome");
		$saldo = $ofx->getBalance();
	}
}

//Primeiro Envio o XML para o Servidor
$hoje = date('Y-m-d');



?>
<html>

<head>

	<meta http-equiv="Content-Type" content="text/html;">
	<meta charset="UTF-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

	<!-- icons bootstrap -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
	<LINK rel="stylesheet" HREF="estilo.css" TYPE="text/css">
	<title>Extrato fiscal</title>

</head>

<body>
	<div class="card">
		<div class="card-header text-center">Extrato fiscal Bancário
			<button type="button" name="btnfechar" onclick="window.opener.location.reload();fechar();" class="btn btn-secondary">Voltar</button>
		</div>
		<div class="card-body">
			<table class="table table-hover">
				<thead>
					<tr>
						<th>Codigo</th>
						<th>Data</th>
						<th>Descrição</th>
						<th>Doc</th>
						<th>Tipo</th>
						<th>Valor</th>

					</tr>
					<thead>
					<tbody> <?php
							if (isset($ofx)) {
								$saldo_saida = 0;
								$saldo_entrada = 0;
								foreach ($ofx->getTransactions() as $transaction) :
									$codigo = rand(1, 1000000000);
									$data = date("Y-m-d", strtotime(substr($transaction->DTPOSTED, 0, 8)));
									$descricao = $transaction->MEMO;
									$doc = $transaction->FITID;
									$tipo = $transaction->TRNTYPE;
								
									

									// if ($tipo == "DEBIT") {
									// 	echo "sim";
									// }

									$valor = ($transaction->TRNAMT);
									$valor = explode("-", $valor);
									$valores_sem_vazio = array_filter($valor);
									if (!isset($valores_sem_vazio[0])) {
										$valor = $valores_sem_vazio[1];
										$tipo_movimentação = "Saida";
										$valor = floatval($valor);
										$saldo_saida = $saldo_saida + $valor;
									} else {
										$valor = $valores_sem_vazio[0];
										$tipo_movimentação = "Entrada";
										$valor = floatval($valor);

										$saldo_entrada = $saldo_entrada + $valor;
									}

									$select = "SELECT  * from tb_extrato_fiscal where cl_doc ='$doc' and cl_data='$data'"; //verificar se o doc já está inserido no banco para não haver duplicidade
									$operacao_select =  mysqli_query($conecta, $select);
									if ($operacao_select) {
										$resultado = mysqli_num_rows($operacao_select);
										if ($resultado == 0) {
											$inserir = "INSERT INTO `marvolt`.`tb_extrato_fiscal` (`cl_codigo`, `cl_data`, `cl_descricao`, `cl_doc`, `cl_tipo`, `cl_valor`,`cl_conta_financeira`) 
											VALUES ( '$codigo', '$data', '$descricao', '$doc', '$tipo_movimentação', '$valor','$banco'); ";
											$operacao_inserir = mysqli_query($conecta, $inserir);
										}
									}

							?> <tr>
									<td><?php echo $codigo ?></td>
									<td><?php echo formatDateB($data) ?></td>
									<td><?php echo $descricao ?></td>
									<td><?php echo $doc ?></td>
									<td><?php echo $tipo_movimentação; ?></td>
									<td class='text-<?php echo ($tipo_movimentação == "Saida") ? 'danger' : 'success' ?>'><?php echo real_format($valor); ?></td>
								</tr>
							<?php endforeach;
							?>
							<tr>
								<td>Saldo Total</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><?php echo real_format($saldo_entrada - $saldo_saida); ?></td>
							</tr>
						<?php
							} else {
								echo '<div class="alert alert-danger" role="alert">
								Arquivo não encontrado
							  </div>';
							} ?>
					</tbody>
			</table>
		</div>
	</div>



	<script src="../../jquery.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
	<script>
		function fechar() {
			window.close();
		}
	</script>

</html>