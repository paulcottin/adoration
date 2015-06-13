<?php

$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$adresse = $_POST['adresse'];
$telephone = $_POST['telephone'];
$portable = $_POST['portable'];
$email = $_POST['email'];
$id = 0;

if (isset($_GET['id'])) {
	$id = $_GET['id'];
}

$db;
try{
	$db = new PDO('mysql:host=localhost;dbname=adoration', 'root', 'root');
}catch(Exeception $e){
	die('Erreur : ' . $e->getMessage());
}

//On update la table
$sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, adresse = ?, telephone = ?, portable = ?, email = ? WHERE id = ?";

$stmt = $db->prepare($sql);
$stmt->execute(array($nom, $prenom, $adresse, $telephone, $portable, $email, $id));

//Redirection
$redirection = "Location: fiche.php?id=".$id;
header($redirection);

?>