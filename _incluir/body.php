<?php
//pegar o nivel do usuario
if ($_SESSION["user_portal"]) {
    $user = $_SESSION["user_portal"];
    $saudacao = "SELECT usuarios.usuario,usuarios.nivel,usuarios.nome, tb_nivel_usuario.descricao FROM usuarios
     inner join tb_nivel_usuario on usuarios.nivel = tb_nivel_usuario.nivel_usuarioID where usuarioID = {$user}";
    $saudacao_login = mysqli_query($conecta, $saudacao);
    if (!$saudacao_login) {
        die("Falha no banco de dados");
    }
    $saudacao_login = mysqli_fetch_assoc($saudacao_login);
    $nome = $saudacao_login['usuario'];
    $nivel = $saudacao_login['nivel'];
    $descricaoNivel = $saudacao_login['descricao'];
}
?>


<head>
    <link rel="shortcut icon" type="imagex/png" href="img/marvolt.ico">
    <script src="https://kit.fontawesome.com/e8ff50f1be.js" crossorigin="anonymous"></script>

</head>

<body>
    <div id="menulateral">
        <input type="checkbox" id="chec">

        <label for="chec">
            <img src="https://img.icons8.com/windows/32/000000/menu--v4.png" />

        </label>

        <nav>
            <img src="../../../marvolt/images/marvolt.png">
            <ul>
                <li><a href="../../../marvolt/index.php">Home</a></li>

                <li> <a
                        onclick="window.open('../../../marvolt/lembrete/lembrete.php', 
        'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">Lembrete

                    </a>
                </li>

                <?php if ($nivel == 2 or $nivel == 4 or $nivel ==  5) { ?>

                <li><a>Cliente<i class="fa-solid fa-arrow-down"></i></a>
                    <ul>
                        <li><a href="../../../marvolt/cdcliente/consulta_cliente.php">Cadastro de Cliente</a></li>
                    </ul>
                </li>
                <?php
                }
                ?>

                <li><a>Produto<i class="fa-solid fa-arrow-down"></i></a>
                    <ul>
                        <li><a href="../../../marvolt/cdproduto/consulta_produto.php">Produto</a></li>

                        <li><a href="../../../marvolt/cdproduto/consulta_prod_estoque.php">Produtos com estoque</a></li>
                        <li><a href="../../../marvolt/cdproduto/consultar_prod_pcompra/consultar.php">Produtos de
                                pedidos de compra</a></li>
                        <li><a href="../../../marvolt/cdproduto/consultar_prod_ml/consulta_produto.php">Consulta de
                                produto Ml</a></li>

                    </ul>
                </li>

                <?php if ($nivel == 2 or $nivel == 4 or $nivel ==  5) { ?>
                <li><a>Cotação<i class="fa-solid fa-arrow-down"></i></a>
                    <ul>
                        <li><a href="../../../marvolt/cotacao/consulta_cotacao.php">Cotação</a></li>
                        <li><a href="../../../marvolt/cotacao/relatorioEmpresa.php">Relatório / Contábil</a></li>

                    </ul>
                </li>
                <?php } ?>

                <li><a>Pedido de compra<i class="fa-solid fa-arrow-down"></i></a>
                    <ul>
                        <?php if ($nivel == 2 or $nivel == 4 or $nivel ==  5) { ?>
                        <li><a href="../../../marvolt/pdcompra/consulta_pdcompra.php">Pedido de Compra</a></li>
                        <?php } ?>

                        <li><a href="../../../marvolt/pdcompra/consulta_pdcompra_produtos.php">Check Produtos</a></li>
                    </ul>

                </li>
                <?php if ($nivel == 2 or $nivel == 4 or $nivel ==  5) { ?>
                <li><a>Nota fiscal<i class="fa-solid fa-arrow-down"></i></a>
                    <ul>
                        <li><a href="../../../marvolt/nota_fiscal/consulta_nota_fiscal.php">NFE - Entrada</a></li>
                        <li><a href="../../../marvolt/nota_fiscal/consulta_nota_fiscal_saida.php">NFE - Saida</a></li>
                        <li><a href="../../../marvolt/nota_fiscal/consulta_nota_fiscal_nfs_entrada.php">NFS -
                                Entrada</a></li>
                        <li><a href="../../../marvolt/nota_fiscal/consulta_nota_fiscal_nfs.php">NFS - Saida</a></li>
                    </ul>
                </li>
                <?php } ?>

                <?php if ($nivel == 2 or $nivel == 4 or $nivel ==  5) { ?>
                <li><a>Financeiro<i class="fa-solid fa-arrow-down"></i></a>
                    <ul>
                        <li><a href="../../../marvolt/financeiro/consulta_financeiro.php">Lançar no Financeiro</a></li>
                        <li><a href="../../../marvolt/financeiro/caixa.php">Caixa</a></li>
                        <li><a href="../../../marvolt/financeiro/relatorio_apagar_receber.php">Relatórios Pagamentos e
                                Recebimentos</a></li>
                    </ul>
                </li>

                <?php }
                ?>
                <?php if ($nivel == 4 or $nivel ==  5) { ?>

                <li><a>Relatório<i class="fa-solid fa-arrow-down"></i></a>
                    <ul>
                        <li><a href="../../../marvolt/relatorio/geral/pagina.php">Relatório / Geral</a>
                        </li>
                        <li><a href="../../../marvolt/relatorio/dashboard/pagina.php">Relatório / Dashboard</a>
                        </li>

                    </ul>
                </li>
                <?php } ?>


                <li><a>Patrimônio<i class="fa-solid fa-arrow-down"></i></a>
                    <ul>
                        <li><a href="../../../marvolt/patrimonio/consulta_patrimonio.php">Consultar</a>
                        </li>

                    </ul>
                </li>


                <?php if ($nivel == 2 or $nivel == 4 or $nivel ==  5) { ?>
                <li><a>Configuração<i class="fa-solid fa-arrow-down"></i></a>
                    <ul>
                        <?php if ($nivel == 4 or $nivel ==  5) { ?>
                        <li><a href="../../../marvolt/configuracao/usuario/consulta_usuario.php">Usuário</a></li>
                        <li><a
                                href="../../../marvolt/configuracao/empresa/registro_empresa.php?codEmpresa=<?php echo 1 ?>">Empresa</a>
                        </li>
                        <?php } ?>
                        <li><a href="../../../marvolt/configuracao/categoria/consultar_categoria.php">Categoria de
                                Produtos</a></li>
                        <li><a href="../../../marvolt/configuracao/forma_pagamento/consultar_forma_pagamento.php">Forma
                                de Pagamento</a></li>
                        <li><a
                                href="../../../marvolt/configuracao/sub_grupo_despesa_receita/consultar_subgrupo.php">SubGrupo</a>
                        </li>
                        <?php if ($nivel == 4 or $nivel ==  5) { ?>
                        <li><a href="../../../marvolt/configuracao/parametros/consultar_parametro.php">Parâmetros</a>
                        </li>
                        <?php } ?>

                    </ul>
                </li>
                <?php
                }
                ?>

            </ul>
        </nav>
    </div>
</body>