<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>teste E-mail</title>
</head>
<body>
<h1>teste E-mail</h1>
<?php
// // Configure com seu login/senha
// $login = 'comercial@marvolt.com.br';
// $senha = 'Naruto_hiro3';

// $str_conexao = '{imap.secureserver.net:993/novalidate-cert}';
// if (!extension_loaded('imap')) {
// die('Modulo PHP/IMAP nao foi carregado');
// }

// // Abrindo conexao
// $mailbox = imap_open($str_conexao, $login, $senha);
// if (!$mailbox) {
// die('Erro ao conectar: '.imap_last_error());
// }else{
// $headers = @imap_headers($mailbox) or die("Não existe e-mails!"); // Chamando o Headers
// $numEmails = sizeof($headers); // Verifica quantidade de e-mails em sua caixa postal
// echo "Você tem <b>$numEmails</b> mensagens em sua caixa de correio.<br / />"; // Mostra conteúdo

// for ($i=1; $i<$numEmails+1; $i++){ // Loop para gerar informações das mensagens
// $mailHeader = @imap_headerinfo($mailbox, $i);
// $from = $mailHeader->fromaddress;
// $subject = strip_tags($mailHeader->subject);
// $date = $mailHeader->date;

// echo "E-mail de: $from // Subject: $subject - ($date)<br />";
// }

// }


$hostname = '{imap.secureserver.net:993/imap/ssl}INBOX';
$username = 'comercial@marvolt.com.br';
$password = 'Naruto_hiro3';

$inbox = imap_open($hostname,$username,$password) or die('Impossível conectar-se: ' . imap_last_error());

$emails = imap_search($inbox,'ALL');

if($emails) {
    foreach($emails as $email_number) {
        $overview = imap_fetch_overview($inbox,$email_number,0);
        $message = imap_fetchbody($inbox,$email_number,1.1);
        echo "Asunto: " . $overview[0]->subject . "<br>";
        echo "De: " . $overview[0]->from . "<br>";
        echo "Fecha: " . $overview[0]->date . "<br>";
        echo "Cuerpo: " . $message . "<br>";
        echo "<hr>";
    }
} 

imap_close($inbox);


?>
</body>
</html>