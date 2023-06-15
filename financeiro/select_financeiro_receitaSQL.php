<?php 

echo "´´";
$hoje = date('d/m/Y');
//consultar forma de pagamento
$select = "SELECT formapagamentoID, nome, statuspagamento from forma_pagamento";
$lista_formapagamemto = mysqli_query($conecta,$select);
if(!$lista_formapagamemto){
    die("Falaha no banco de dados || select formapagma");
}

//consultar cliente
$select = "SELECT clienteID, razaosocial,nome_fantasia from clientes order by nome_fantasia ";
$lista_clientes = mysqli_query($conecta,$select);
if(!$lista_clientes){
    die("Falaha no banco de dados || select clientes");
}

//consultar lancamento
$select = "SELECT receita_despesaID, nome from receita_despesa";
$lista_receita_despesa = mysqli_query($conecta,$select);
if(!$lista_receita_despesa){
    die("Falaha no banco de dados ||   falha de conexão de red || select clientes");
}


//consultar status do lancamento
$select = "SELECT status_lancamentoID, nome, lancamento from status_lancamento where lancamento = 'Receita' or lancamento = 'Cancelado' or lancamento = 'Selecione' ";
$lista_statusLancamento = mysqli_query($conecta,$select);
if(!$lista_statusLancamento){
    die("Falaha no banco de dados
    || falha de conexão de red
    select status Lancamento");
}

//consultar grupo Lançamento
$select = "SELECT subGrupoID, subgrupo,nome as grupo,lancamento from tb_subgrupo_receita_despesa inner join grupo_lancamento on grupo_lancamento.grupo_lancamentoID = tb_subgrupo_receita_despesa.grupo where lancamento = 'Receita' or grupo = 1";
$lista_grupoLancamento = mysqli_query($conecta,$select);
if(!$lista_grupoLancamento){
    die("Falaha no banco de dados
    || falha de conexão de red
    select tb_subgrupo_receita_despesa");
}

//consultar status da compra
$select = "SELECT statuscompraID, nome from status_compra";
$lista_statuscompra = mysqli_query($conecta,$select);
if(!$lista_statuscompra){
    die("Falha no banco de dados || select statuscompra");
}

//consultar conta_financeira
$select = "SELECT * from tb_conta_financeira";
$consulta_conta_financeira = mysqli_query($conecta,$select);
if(!$consulta_conta_financeira){
    die("Falha no banco de dados || select ");
}