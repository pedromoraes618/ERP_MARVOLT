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
    <center>
        <h1>Importar XML da NFs</h1>
        <form method="post" action="entrada_xml_nfs_entrada.php" method="post" enctype="multipart/form-data">
            <input type="file" name="xml_nfs" id="xml_nfs">
            <input type="submit" name="upload" value="upload Arquivo.xml!">
        </form>


        <br><br>

</body>

</html>