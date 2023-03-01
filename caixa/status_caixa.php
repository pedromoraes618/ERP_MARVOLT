<?php
include("../conexao/sessao.php");
include("../conexao/conexao.php"); 
include("../_incluir/funcoes.php");
include("crud/gerenciar_caixa.php"); 

?>

<div class="caixa_ilustra">
    <?php if($status == "aberto" or $status=="reaberto"){
    echo "<img src='../images/caixa_aberto.svg'><p>Caixa Aberto</p>";
    }elseif($status ==""){
        echo "<img src='../images/caixa_nao_aberto.svg'><p>Caixa não aberto</p>";
    }elseif($status=="fechado"){
        echo "<img src='../images/caixa_fechado.svg'><p>Caixa Fechado</p>";
    }
    ?>

</div>