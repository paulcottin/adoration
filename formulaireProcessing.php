<?php
session_start();

include 'x.php';

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$jour = $_POST['jour'];
$heure = $_POST['heure'];
$adresse = $_POST['adresse'];
$email = $_POST['email'];
$tel = $_POST['telephone'];
$portable = $_POST['portable'];
$repetition = $_POST['repetition'];



//On vérifie que la personne n'est pas déjà inscrite => pas déjà l'adresse mail
$sql = "SELECT count(id) FROM utilisateurs WHERE email LIKE ? ";

$stmt = $db->prepare($sql);
$stmt->execute(array($email));

$nb_email = $stmt->fetch()[0];
if ($nb_email > 0) {
	//Si elle est déjà inscrite on ne l'ajoute pas de nouveau, seulement le créneau
}else{
	//Sinon on l'ajoute
	$sql = "INSERT INTO utilisateurs VALUES (null, ?, ?, ?, ?, ?, ?)";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($nom, $prenom, $adresse, $tel, $portable, $email));
}

//Ajout des créneaux
$date = createDate($jour, $heure);


//Détermination de l'id associé au mail
$sql = "SELECT id FROM utilisateurs WHERE email LIKE ?;";
$stmt = $db->prepare($sql);
$stmt->execute(array($email));
$user_id = $stmt->fetch()[0];

//Création des données nécessaires
$duree = new DateInterval("P100Y");

$sql = "INSERT INTO creneaux_bis VALUES (null, ?, ?, ?, ?, ?);";
$stmt = $db->prepare($sql);
if ($_POST['repetition'] == "toujours")
	$stmt->execute(array($date->format("Y-m-d"), $date->add($duree)->format("Y-m-d"), $jour, $heure, $user_id));
else
	$stmt->execute(array($date->format("Y-m-d"), $date->format("Y-m-d"), $jour, $heure, $user_id));

//Redirection
$redirection = "Location: thanks.php";
header($redirection);

function createDate($jour, $heure) {
	$dateActuelle = new DateTime();
	$aDay = new DateInterval("P1D");
	while (getDay($dateActuelle) != $jour) {
		$dateActuelle->add($aDay);
	}
	$dateActuelle->setTime($heure+0, 0);
	return $dateActuelle;
}

function getDay($date){
	$s = $date->format("D");
	$day = "";
	switch ($s) {
		case 'Mon':
			$day = "Lundi";
			break;
		case 'Tue':
			$day = "Mardi";
			break;
		case 'Wed':
			$day = "Mercredi";
			break;
		case 'Thu':
			$day = "Jeudi";
			break;
		case 'Fri':
			$day = "Vendredi";
			break;
		case 'Sat':
			$day = "Samedi";
			break;
		case 'Sun':
			$day = "Dimanche";
			break;
		default:
			$day = $s;
			break;
	}
	return $day;
}

?>