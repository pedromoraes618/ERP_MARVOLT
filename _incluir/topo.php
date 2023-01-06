<header>



    <div id="header_central">
        <?php if($_SESSION["user_portal"]){

            $user= $_SESSION["user_portal"];
            $saudacao = "SELECT usuario FROM usuarios where usuarioID = {$user}";
            $saudacao_login = mysqli_query($conecta,$saudacao);
            if (!$saudacao_login){
                die ("Falha no banco de dados");
            }
            $saudacao_login = mysqli_fetch_assoc($saudacao_login);
            $nome = $saudacao_login['usuario'];
          

        ?>
        <div class="user_acess">
            <nav class="">
                <ul>
                    <li>
                        <div class="bloco-1">
                            <p><?php echo ucfirst($nome); ?></p>
                            <hr> <i class="fa-solid fa-circle-user"></i>
                        </div>
                        <ul>
                            <li><a href="../../../marvolt/desenvolvimento.php">Meu usúario</a></li>
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