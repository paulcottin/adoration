<?php
session_start();
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$date = $_POST['date'];
$adresse = $_POST['adresse'];
$email = $_POST['email'];
$tel = $_POST['telephone'];
$portable = $_POST['portable'];
$repetition = $_POST['repetition'];

$db;
try{
	$db = new PDO('mysql:host=localhost;dbname=adoration', 'root', 'root');
}catch(Exeception $e){
	die('Erreur : ' . $e->getMessage());
}

//On vérifie que la personne n'est pas déjà inscrite => pas déjà l'adresse mail
$sql = "SELECT count(id) FROM utilisateurs WHERE email LIKE '?' ";

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

$date = creerDate($date);

//En fonction de la répétition on insère plusieurs fois un nouveau créneau
$nbCreneaux = 0;
switch ($repetition) {
	case '1':
		$nbCreneaux = 1;
		break;
	case '2s':
		$nbCreneaux = 2;
		break;
	case '3s':
		$nbCreneaux = 3;
		break;
	case '1m':
		$nbCreneaux = 4;
		break;
	case '2m':
		$nbCreneaux = 8;
		break;
	case '3m':
		$nbCreneaux = 13;
		break;
	case '4m':
		$nbCreneaux = 17;
		break;
	case '5m':
		$nbCreneaux = 21;
		break;
	case '6m':
		$nbCreneaux = 26;
		break;
	case '1a':
		$nbCreneaux = 52;
		break;
}

//Détermination de l'id associé au mail
$sql = "SELECT id FROM utilisateurs WHERE email LIKE ?;";
$stmt = $db->prepare($sql);
$stmt->execute(array($email));
$user_id = $stmt->fetch()[0];

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

//Redirection
$redirection = "Location: thanks.php";
header($redirection);


function creerDate($string){
	$s = str_replace("T", " ", $string);
	$date = DateTime::createFromFormat('Y-m-d H:i', $s);
	$heure = split("/", split(" ", $date->format("d/m/Y H/i"))[1])[0];
	$date->setTime($heure+0, 0);
	return $date;
}
?>