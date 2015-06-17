<?php
$prenom = $_POST['prenom'];
$nom = $_POST['nom'];
$adresse = $_POST['adresse'];
$telephone = $_POST['telephone'];
$portable = $_POST['portable'];
$email = $_POST['email'];

$id = 3;
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}

$db;
try{
	$db = new PDO('mysql:host=sql2.olympe.in;dbname=elghblxo', 'elghblxo', 'mot_de_passe_BDD_ado');
}catch(Exeception $e){
	die('Erreur : ' . $e->getMessage());
}

//On update la table utilisateur
$sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, adresse = ?, telephone = ?, portable = ?, email = ? WHERE id = ?;";

$stmt = $db->prepare($sql);
$stmt->execute(array($nom, $prenom, $adresse, $telephone, $portable, $email, $id));


//On update la table creneaux

$sql = "UPDATE creneaux SET `date` = ? WHERE id = ?;";

$stmt = $db->prepare($sql);
$size = $_POST['size'];
echo("size : ".$size."<br/>");
for ($i=0; $i < $size+1; $i++) { 
	$name = "date_".$i;

	if (isset($_POST[$name])) {
		$date = str_replace("T", " ", $_POST[$name]);
		echo("isset : ".$name.", ".$date.", ".$i."<br/>");
		$stmt->execute(array($date, $i));
	}
}
//Redirection
$redirection = "Location: fiche.php?id=".$id;
header($redirection);

?>