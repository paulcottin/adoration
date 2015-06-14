<?php

if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
if (isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
}

$db;
try{
	$db = new PDO('mysql:host=localhost;dbname=adoration', 'root', 'root');
}catch(Exeception $e){
	die('Erreur : ' . $e->getMessage());
}

$sql = "SELECT date FROM creneaux WHERE id = ?;";

$stmt = $db->prepare($sql);
$stmt->execute(array($id));

$date = new DateTime($stmt->fetch()[0]);

$sql = "SELECT count(id), id FROM creneaux WHERE date = ?;";
$stmt = $db->prepare($sql);

$count = 1;
$semaine = new DateInterval("P7D");
$ids = array();
while ($count > 0) {
	$stmt->execute(array($date->format("Y-m-d H:i")));
	$data = $stmt->fetch();
	
	$count = $data[0];
	if ($count > 0) {
		$ids[] = $data[1];
	}

	$date->add($semaine);
}

$sql = "DELETE FROM creneaux WHERE id = ? ;";
$stmt = $db->prepare($sql);

for ($i=0; $i < sizeof($ids); $i++) { 
	$stmt->execute(array($ids[$i]));
}

//Redirection
$redirection = "Location: fiche.php?id=".$user_id;
header($redirection);
?>