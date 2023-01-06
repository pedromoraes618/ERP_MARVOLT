<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css" />
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css" />
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css" />
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css" />
<?php echo "."; ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <?php if (isset($_POST['upload'])) {
        //upload na nota fiscal de saida
        $formatosPermitidos = array("xml");
        $extensao = pathinfo($_FILES['xml_nfs']['name'], PATHINFO_EXTENSION);
        $name = ($_FILES['xml_nfs']['name']);
        if (in_array($extensao, $formatosPermitidos)) {
            $pasta = "arquivos/";
            $temporario = $_FILES['xml_nfs']['tmp_name'];

            if (move_uploaded_file($temporario, $pasta . $name)) {
                $mensagem = "Upload feito com sucesso!";
                echo $name;
            } else {
                $mensagem = "Erro, não foi possivel fazer o upload";
            }
        } else {
            $mensagem = "Formato inválido";
        }
        echo $mensagem;
    }
    ?>
    <center>
        <h1>Importar XML da NFs</h1>
        <form method="post" action="entrada_xml_nfs.php" method="post" enctype="multipart/form-data">
            <input type="file" name="xml_nfs" id="xml_nfs">
            <input type="submit" name="upload" value="upload Arquivo.xml!">
        </form>


        <br><br>

</body>

</html>