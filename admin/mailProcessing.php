<?php

/*
Page crée en suivant le tuto 
http://openclassrooms.com/courses/e-mail-envoyer-un-e-mail-en-php
*/
//On récupère le contenu du message et les destinataires.
$mail = "";
$dest = array();
$size = 0;
$sujet = "Adoration Notre-Dame de Lourdes Nancy";
if (isset($_GET['mail'])) {
	$mail = $_GET['mail'];
}
if (isset($_GET['size'])) {
	$size = $_GET['size']+0;
}
if (isset($_GET['sujet'])) {
	$sujet = $_GET['sujet'];
}

for ($i=0; $i < $size; $i++) { 
	array_push($dest, $_GET['dest'.$i]);
}

//Pour les sauts de lignes dans les mails.
if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)){
	$passage_ligne = "\r\n";
}
else{
	$passage_ligne = "\n";
}

//Création du header
$header = "From: \"Adoration NDL\" no-reply@adoration-ndl.fr".$passage_ligne;
$header.= "Reply-to: \"Adoration NDL\" no-reply@adoration-ndl.fr".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne; 
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;

//Création du message
$message .= $passage_ligne.$mail.$passage_ligne;

//Configuration du serveur de mail
ini_set('SMTP', "smtp.gmail.com");
ini_set('smtp_port', "465");
ini_set('sendmail_from', "paulcottin@gmail.com");

//Envoi du mail
for ($i=0; $i < sizeof($dest); $i++) { 
	mail($dest[$i], $sujet, $message, $header);
}

//Redirection
$redirection = "Location: privateTab.php";
header($redirection);
?>