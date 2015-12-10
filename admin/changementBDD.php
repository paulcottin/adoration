<?php

include '../x.php';

//On récupère tous les IDs des personnes
$sql = "SELECT id FROM utilisateurs;";
$stmt = $db->prepare($sql);
$stmt->execute();

$temp = $stmt->fetchAll();
$ids = array();

for ($i=0; $i < sizeof($temp); $i++) { 
	$ids[] = $temp[$i][0];
}

$sql = "INSERT INTO creneaux_bis VALUES (null, ?, ?, ?, ?, ?);";
$stmt = $db->prepare($sql);

for ($i=0; $i < sizeof($ids); $i++) { 
	$creneaux = creneauxPersonne($ids[$i], $db);
	for ($j=0; $j < sizeof($creneaux['jour']); $j++) { 
		//echo "id : ".$ids[$i].", ".$creneaux['jour'][$j]." ".$creneaux['heure'][$j]."h<br/>";
		$stmt->execute(array("2015-09-01", "2115-09-01", $creneaux['jour'][$j], $creneaux['heure'][$j], $ids[$i]));
	}
	
}

function creneauxPersonne($id, $db) {
	//On obtient tous les créneaux qu'elle a
	$sql = "SELECT date FROM `creneaux` WHERE user_id = ?;";

	$stmt = $db->prepare($sql);
	$stmt->execute(array($id));

	$data = $stmt->fetchAll();
	$creneaux = array();
	for ($i=0; $i < sizeof($data); $i++) { 
		array_push($creneaux, new DateTime($data[$i][0]));
	}

	return getCreneaux($creneaux);
}	    				

function getCreneaux($creneaux){
	$jour = array();
	$heure = array();

	for ($i=0; $i < sizeof($creneaux); $i++) { 
		if (array_search(getDay($creneaux[$i]), $jour) !== false) {
			if (array_search(getHour($creneaux[$i]), $heure) === false) {
				array_push($jour, getDay($creneaux[$i]));
				array_push($heure, getHour($creneaux[$i]));
			}
		}
		else{
			$jour[] = getDay($creneaux[$i]);
			$heure[] = getHour($creneaux[$i]);
		}
	}

	$r = array('jour' => $jour, 'heure' => $heure);
	return $r;
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

function getHour($date){
	return $date->format('H');
}
?>