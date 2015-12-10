<?php

$db;
//Olympe
try{
	$db = new PDO('mysql:host=sql2.olympe.in;dbname=elghblxo', 'elghblxo', 'mot_de_passe_BDD_ado');
}catch(Exeception $e){
	die('Erreur : ' . $e->getMessage());
}

//Hostinger
/*try{
	$db = new PDO('mysql:host=mysql.hostinger.fr;dbname=u774340827_ado', 'u774340827_user', 'adorationNDL');
}catch(Exeception $e){
	die('Erreur : ' . $e->getMessage());
}*/

//Localhost
/*try{
	$db = new PDO('mysql:host=localhost;dbname=adoration;charset=UTF8', 'root', '');
}catch(Exeception $e){
	die('Erreur : ' . $e->getMessage());
}
*/
?>