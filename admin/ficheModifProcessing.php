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
for ($i=0; $i < $size+1; $i++) { 
	$nameJour = "jour_".$i;
	$nameHeure = "heure_".$i;

	if (isset($_POST[$nameJour])) {
		$creneau_id = substr(strrchr($nameJour, "_"), 1);
		updateCreneaux($db, $_POST[$nameJour], $_POST[$nameHeure], $creneau_id+0);
	}
}


//On ajoute un créneau si besoin est
if (isset($_POST['jourAjout']) && $_POST['repetitionAjout'] != "default") {
	$jourAjout = $_POST['jourAjout'];
	$heureAjout = $_POST['heureAjout'];
	$repetitionAjout = $_POST['repetitionAjout'];
	
	createCreneaux($db, $jourAjout, $heureAjout, $repetitionAjout, $id);
}

//Redirection
$redirection = "Location: fiche.php?id=".$id;
header($redirection);

function updateCreneaux($db, $jour, $heure, $creneau_id) {
	//Modification du créneau
	$sql = "UPDATE creneaux_bis SET jour = ?, heure = ? WHERE id = ?;";
	$stmt = $db->prepare($sql);
	
	$stmt->execute(array($jour, $heure, $creneau_id));
}


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

function createCreneaux($db, $jour, $heure, $repetition, $user_id) {
	$dateActuelle = new DateTime();
	$duree = new DateInterval("P100Y");

	$sql = "INSERT INTO creneaux_bis VALUES (null, ?, ?, ?, ?, ?);";
	$stmt = $db->prepare($sql);
	if ($repetition == "toujours")
		$stmt->execute(array($dateActuelle->format("Y-m-d"), $dateActuelle->add($duree)->format("Y-m-d"), $jour, $heure, $user_id));
	else
		$stmt->execute(array($date->format("Y-m-d"), $date->format("Y-m-d"), $jour, $heure, $user_id));
}

?>