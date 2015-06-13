<?php
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

//On prend les informations de la personne grâce à son mail
$sql = "SELECT id, nom, prenom, adresse, telephone, portable, email FROM utilisateurs WHERE id = ?;";

$stmt = $db->prepare($sql);
$stmt->execute(array($id));

$data = $stmt->fetchAll()[0];
$pers = array('id' => $data[0],
			'nom' => $data[1],
			'prenom' => $data[2],
			'adresse' => $data[3],
			'telephone' => $data[4],
			'portable' => $data[5],
			'email' => $data[6] 
			);

//On obtient tous les créneaux qu'elle a
$sql = "SELECT date FROM `creneaux` WHERE user_id = ?;";

$stmt = $db->prepare($sql);
$stmt->execute(array($pers['id']));

$data = $stmt->fetchAll();
$creneaux = array();
for ($i=0; $i < sizeof($data); $i++) { 
	array_push($creneaux, new DateTime($data[$i][0]));
}
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Inscription adoration NDL</title>
    </head>
    <script type="text/javascript">
    	function supprimer () {
    		if (confirm('Êtes-vous sûr de vouloir supprimer cet adorateur ?')){
    			document.location.href = "supprimerAdoProcessing.php?id=<?php echo $pers['id'] ?>";
    		}
    	}
    </script>
    <body>
    	<p class="centerWhite70">Fiche adorateur</p>
    	<form action="ficheModifProcessing.php?id=<?php echo $id; ?>" class="text20" method="POST">
    	Prénom : <input type="text" class="connectForm" name="prenom" value="<?php echo($pers['prenom']); ?>"/> <br/>
    	Nom : <input type="text" class="connectForm" name="nom" value="<?php echo($pers['nom']); ?>"/> <br/>
    	<div>
    		<span style="float:left">
    			<div style="margin:10px 100px 100px 100px;">
	    				Adresse : <input type="text" class="connectForm" name="adresse" value="<?php echo($pers['adresse']); ?>"/> <br/>
	    				E-mail : <input type="text" class="connectForm" name="email" value="<?php echo($pers['email']); ?>"/> <br/>
	    				Téléphone : <input type="text" class="connectForm" name="telephone" value="<?php echo($pers['telephone']); ?>"/> <br/>
	    				Portable : <input type="text" class="connectForm" name="portable" value="<?php echo($pers['portable']); ?>"/><br/>

	    				<input type="button" class="button" value="Annuler" onclick="document.location.href = 'privateTab.php'">
	    				<input type="submit" class="button" value="Enregistrer"/>
	    			</form>
    			</div>
    		</span>
    		<span style="float:center;">
    			<div style="margin:50px 100px 100px 100px;;">
    				<p class="text20" style="text-decoration:underline">
	    				Créneaux :
	    			</p>
	    			<p class="text20">
	    				<?php 
	    				$c = getCreneaux($creneaux);
	    				for ($i=0; $i < sizeof($c['jour']); $i++) { 
	    					echo(" - Le ".$c['jour'][$i]." à ".$c['heure'][$i]."h<br/>");
	    				}
	    				?>
	    			</p>
    			</div>
    		</span>
    	</div>
    </body>
</html>

<?php
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