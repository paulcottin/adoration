<?php

if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
if (isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
}

include '../x.php';

$sql = "DELETE FROM creneaux_bis WHERE id = ?;";

$stmt = $db->prepare($sql);
$stmt->execute(array($id));

//Redirection
$redirection = "Location: fiche.php?id=".$user_id;
header($redirection);

?>