<?php session_start(); 

$db;
try{
	$db = new PDO('mysql:host=localhost;dbname=adoration', 'root', 'root');
}catch(Exeception $e){
	echo("erreur db");
	die('Erreur : ' . $e->getMessage());
}

//Date actuelle
$now = new DateTime();
$lundi = getLundi($now);
$jour = new DateInterval("P1D");

//Préparation de la requete pour chaque créneaux horaire :
$sql = "SELECT prenom, nom FROM utilisateurs WHERE id IN (SELECT user_id FROM creneaux WHERE date = ?)";
$stmt = $db->prepare($sql);
?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Inscription adoration NDL</title>
    </head>
    <body>
    	<table border="1"> 
		  <caption> Voici le titre du tableau </caption> 
	   	<tr> 
			<th></th> 
			<?php
			//première ligne du tableau (jours (Lundi, Mardi, ...))
				$current = new DateTime($lundi->format("d/m/Y"));
				for ($i=0; $i < 7; $i++) { 
					?>
					<th> <?php echo(getDay($current)."<br/>".$current->format("d/m/Y")); ?> </th>
					<?php 
					$current->add($jour);
				}
			?>
	  	</tr> 
	  	<?php
	  	for ($i=0; $i < 24; $i++) { 
	  	?>
		<tr> 
			<th> <?php echo $i;?>h00 </th> 
			<?php
				$current->setDate($lundi->format("Y"), $lundi->format("m"), $lundi->format("d"));
				for ($j=0; $j < 7; $j++) { 
					echo("<td> ".getPersonnes($current, $i, $stmt)."</td>");
					$current->add($jour);
				}
			?>
		</tr> 
		<?php
		}
		?>
		</table> 
    </body>
</html>


<?php 
//Renvoie le jour (Lundi, Mardi, ...) en fonction de la date
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

//Récupère la date du lundi de la semaine courante
function getLundi($date){
	$d = $date;
	$jour = new DateInterval("P1D");
	for ($i=0; $i < 8; $i++) { 
		if (getDay($d) != "Lundi") {
			$d = $d->sub($jour);
		}
	}
	return $d;
}

//Renvoie le nom prénom des personnes inscrites tel jour, telle heure.
function getPersonnes($jour, $heure, $stmt){
	$date = $jour;
	$jour->setTime($heure, 0);
	$stmt->execute(array($jour->format("Y-m-d H:i")));
	$string = "";
	if (($data = $stmt->fetchAll())){
		//Si il y a plusieurs résultats
		if (sizeof($data) > 1) {
			for ($i=0; $i < sizeof($data); $i++) { 
				$string = $data[$i][0]." ".$data[$i][1]."<br/>".$string;
			}
		//Si il y en a qu'un seul
		}elseif (sizeof($data) == 1) {
			$string = $data[0][0]." ".$data[0][1];
		}
	}
	return $string;
}
?>