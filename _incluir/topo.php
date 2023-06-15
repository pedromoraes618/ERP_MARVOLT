<header>



    <div id="header_central">
        <?php if (isset($_SESSION["user_portal"])) {
            $hoje = date('Y-m-d');
            $user = $_SESSION["user_portal"];
            $saudacao = "SELECT usuario FROM usuarios where usuarioID = {$user}";
            $saudacao_login = mysqli_query($conecta, $saudacao);
            if (!$saudacao_login) {
                die("Falha no banco de dados");
            }
            $saudacao_login = mysqli_fetch_assoc($saudacao_login);
            $nome = $saudacao_login['usuario'];

            $select = "SELECT count(*) as notificacao from tb_contato where cl_data_limite <= '$hoje' and cl_status ='2' ";
            $consulta_contatos_a_fazer = mysqli_query($conecta, $select);
            $linha = mysqli_fetch_assoc($consulta_contatos_a_fazer);
            $contatos_a_fazer = $linha['notificacao'];

        ?>
            <div class="user_acess">
                <nav class="">
                    <ul>
                        <li>
                            <div class="bloco-1">

                                <p><?php echo ucfirst($nome); ?></p>
                                <hr> <i class="fa-solid fa-circle-user"></i>
                                <?php
                                if ($contatos_a_fazer > 0) {
                                ?>
                                    <div class="notificacao"><?php echo $contatos_a_fazer; ?></div>
                                <?php }
                                ?>
                            </div>
                            <ul>
                                <li><a href="../../../marvolt/desenvolvimento.php">Meu usúario</a></li>
                                <li> <a style="cursor:pointer" onclick="window.open('../../../marvolt/lembrete/lembrete.php', 
        'Titulo da Janela', 'STATUS=NO, TOOLBAR=NO, LOCATION=NO, DIRECTORIES=NO, RESISABLE=NO, SCROLLBARS=YES, TOP=10, LEFT=10, WIDTH=1500, HEIGHT=900');">Notificação

                                    </a></li>
                                <li> <a href="../../../../marvolt/sair.php">Sair</a></li>

                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

        <?php
        }
        ?>


    </div>


</header>