<?php session_start();

include '../../x.php';

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mdp = $_POST['password'];
$adresse = $_POST['adresse'];
$email = $_POST['email'];
$tel = $_POST['telephone'];
$portable = $_POST['portable'];



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

//Détermination de l'id associé au mail
$sql = "SELECT id FROM utilisateurs WHERE email LIKE ?;";
$stmt = $db->prepare($sql);
$stmt->execute(array($email));
$user_id = $stmt->fetch()[0];

//Ajout du mot de passe
$sql = "UPDATE utilisateurs set mdp = ? where id = ?";
$stmt = $db->prepare($sql);
$stmt->execute(array(password_hash($mdp, PASSWORD_DEFAULT), $user_id));

//Redirection
$redirection = "Location: gestion.php";
header($redirection);

?>