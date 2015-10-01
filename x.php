<?php

$db;
/*try{
	$db = new PDO('mysql:host=sql2.olympe.in;dbname=elghblxo', 'elghblxo', 'mot_de_passe_BDD_ado');
}catch(Exeception $e){
	die('Erreur : ' . $e->getMessage());
}*/

try{
	$db = new PDO('mysql:host=localhost;dbname=adoration', 'root', '');
}catch(Exeception $e){
	die('Erreur : ' . $e->getMessage());
}

?>