<?php
// <!-- consultar mês -->

$select = "SELECT * from tb_mes";
$consulta_mes_ini = mysqli_query($conecta,$select);
$consulta_mes_fim = mysqli_query($conecta,$select);
