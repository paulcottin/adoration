<?php


if (isset($_GET['id'])) {
	$id = $_GET['id'];
}

include '../x.php';

//Suppression de l'adorateur
$sql = "DELETE FROM utilisateurs WHERE id = ? ;";

$stmt = $db->prepare($sql);
$stmt->execute(array($id));

//Et de ses créneaux
$sql = "DELETE FROM creneaux_bis WHERE user_id = ? ;";

$stmt = $db->prepare($sql);
$stmt->execute(array($id));

//Redirection
$redirection = "Location: privateTab_bis.php";
header($redirection);
?>