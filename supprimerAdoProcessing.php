<?php


if (isset($_GET['id'])) {
	$id = $_GET['id'];
}

$db;
try{
	$db = new PDO('mysql:host=localhost;dbname=adoration', 'root', 'root');
}catch(Exeception $e){
	die('Erreur : ' . $e->getMessage());
}

//Suppression de l'adorateur
$sql = "DELETE FROM utilisateurs WHERE id = ? ;";

$stmt = $db->prepare($sql);
$stmt->execute(array($id));

//Et de ses créneaux
$sql = "DELETE FROM creneaux WHERE user_id = ? ;";

$stmt = $db->prepare($sql);
$stmt->execute(array($id));

//Redirection
$redirection = "Location: privateTab.php";
header($redirection);
?>