<?php
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$adresse = $_POST['adresse'];
$telephone = $_POST['telephone'];
$portable = $_POST['portable'];
$email = $_POST['email'];

$id = -1;
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}

include '../x.php';

//On update la table utilisateur
$sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, adresse = ?, telephone = ?, portable = ?, email = ? WHERE id = ?;";

$stmt = $db->prepare($sql);
$stmt->execute(array($nom, $prenom, $adresse, $telephone, $portable, $email, $id));


//On update la table creneaux

$size = $_POST['size'];
echo("size : ".$size."<br/>");
for ($i=0; $i < $size+1; $i++) { 
	$name = "date_".$i;

	if (isset($_POST[$name])) {
		$date = str_replace("T", " ", $_POST[$name]);
		echo("isset : ".$name.", ".$date.", ".$i."<br/>");
		$date = creerDate($date);
		updateCreneaux($db, $date, $id);
	}
}

//Redirection
$redirection = "Location: fiche.php?id=".$id;
header($redirection);

function updateCreneaux($db, $date, $user_id) {
	//En fonction de la répétition on insère plusieurs fois un nouveau créneau
	//On récupère le nombre de créneaux pris par l'utilisateur :
	$sql = "SELECT count(id) FROM creneaux WHERE user_id = ?;";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($user_id));
	$nbCreneaux = $stmt->fetch()[0]+0;

	//On supprime tous les créneaux de l'utilisateur
	$sql = "DELETE FROM creneaux WHERE user_id = ?;";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($user_id));

	//Création d'un interval d'une semaine
	$timeI = new DateInterval("P7D");

	//Ajout des différents créneaux
	$sql = "INSERT INTO creneaux VALUES (null, ?, ?);";
	$stmt = $db->prepare($sql);
	for ($i=0; $i < $nbCreneaux; $i++) { 
		$stmt->execute(array($date->format("Y-m-d H:i"), $user_id));
		$date->add($timeI);
	}
	$stmt->execute(array($date->format("Y-m-d H:i"), $user_id));
}


function creerDate($string){
	$s = str_replace("T", " ", $string);
	$date = DateTime::createFromFormat('Y-m-d H:i', $s);
	$heure = explode("/", explode(" ", $date->format("d/m/Y H/i"))[1])[0];
	$date->setTime($heure+0, 0);
	return $date;
}

?>