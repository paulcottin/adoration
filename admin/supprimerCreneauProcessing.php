<?php

if (isset($_GET['id'])) {
	$id = $_GET['id'];
}
if (isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
}

include '../x.php';

$sql = "SELECT date FROM creneaux WHERE id = ?;";

$stmt = $db->prepare($sql);
$stmt->execute(array($id));

$dateSvg = new DateTime($stmt->fetch()[0]);

$sql = "SELECT count(id), id FROM creneaux WHERE date = ?;";
$stmt = $db->prepare($sql);

$count = 1;
$semaine = new DateInterval("P7D");
$ids = array();
$date = $dateSvg;
while ($count > 0) {
	$stmt->execute(array($date->format("Y-m-d H:i")));
	$data = $stmt->fetch();
	
	$count = $data[0];
	if ($count > 0) {
		$ids[] = $data[1];
	}

	$date->add($semaine);
}
//TODO: Il ne reste plus qu'un créneaux sur tous ceux qui étaient sélectionnés, c'est le dernier à priori. 
/*$date = $dateSvg;
$count = 1;
while ($count > 0) {
	$stmt->execute(array($date->format("Y-m-d H:i")));
	$data = $stmt->fetch();
	
	$count = $data[0];
	if ($count > 0) {
		$ids[] = $data[1];
	}

	$date->sub($semaine);
}*/

$sql = "DELETE FROM creneaux WHERE id = ? ;";
$stmt = $db->prepare($sql);

for ($i=0; $i < sizeof($ids); $i++) { 
	$stmt->execute(array($ids[$i]));
}

//Redirection
$redirection = "Location: fiche.php?id=".$user_id;
header($redirection);
?>