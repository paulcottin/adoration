<?php
session_start();
if (isset($_POST['email']) && isset($_POST['mdp'])) {
	$email = $_POST['email'];
	$mdp = $_POST['mdp'];
}

$login = $_GET['login'];

$db;
try{
	$db = new PDO('mysql:host=sql2.olympe.in;dbname=elghblxo', 'elghblxo', 'mot_de_passe_BDD_ado');
}catch(Exeception $e){
	die('Erreur : ' . $e->getMessage());
}

//Si c'est une connexion
if ($login == "1") {
	$sql = "SELECT mdp FROM utilisateurs WHERE email=?";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($email));

	$mdp_bd = $stmt->fetch()[0];

	/*if (password_verify($mdp, $mdp_bd)) {*/
	if ($mdp == $mdp_bd) {
		
		$sql = "SELECT id, prenom, nom FROM utilisateurs WHERE email=?";
		$stmt = $db->prepare($sql);
		$stmt->execute(array($email));

		$data = $stmt->fetch();
		$_SESSION['id'] = $data[0];
		$_SESSION['prenom'] = $data[1];
		$_SESSION['nom'] = $data[2];

		/*session_register($_SESSION['id']);
		session_register($_SESSION['prenom']);
		session_register($_SESSION['nom']);*/

		header("Location: admin/privateTab.php");
	}else{
		header("Location: connexion.php?error=1");
	}
}
//Si  c'est une déconnexion
else if ($login == "0") {
	session_unset();
	header("Location: creneaux.php");
}
?>