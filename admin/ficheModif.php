<?php
$id = 0;
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}

$db;
try{
	$db = new PDO('mysql:host=sql2.olympe.in;dbname=elghblxo', 'elghblxo', 'mot_de_passe_BDD_ado');
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
$sql = "SELECT id, date FROM `creneaux` WHERE user_id = ?;";

$stmt = $db->prepare($sql);
$stmt->execute(array($pers['id']));

$data = $stmt->fetchAll();

$ids = array();
$creneau = array();
$creneaux = array('creneau' => $creneau, 'ids' => $ids);

for ($i=0; $i < sizeof($data); $i++) { 
	$creneaux['creneau'][] = new DateTime($data[$i][1]);
	$creneaux['ids'][] = $data[$i][0];
}
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="../style.css">
        <title>Inscription adoration NDL</title>
    </head>
    <script type="text/javascript">
    	function supprimer (id) {
    		if (confirm('Êtes-vous sûr de vouloir supprimer ce créneau ? \n\n(Pensez à sauvegarder vos modifications en cours avant la suppression, sinon elles seront perdues)')){
    			document.location.href = "supprimerCreneauProcessing.php?id="+id+"&user_id=<?php echo($id); ?>";
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

	    				<input type="button" class="button" value="Annuler" onclick="document.location.href = 'fiche.php?id=<?php echo($id); ?>'">
	    				<input type="submit" class="button" value="Enregistrer"/>
	    			
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
	    				$cpt = 0;
	    				for ($i=0; $i < sizeof($c['string']); $i++) { 
	    					if ($c['hidden'][$i]) {
	    						?>
	    						<input type="datetime-local" class="connectForm" name="date_<?php echo($c['ids'][$i]);?>" id="date" hidden value="<?php echo($c['string'][$i]);?>"/> 
	    						<?php
	    					}
	    					else{
	    						?>
	    						<input type="datetime-local" class="connectForm" name="date_<?php echo($c['ids'][$i]);?>" id="date" value="<?php echo($c['string'][$i]);?>" label=""/>  
	    						(Le <?php echo($c['jour'][$cpt]); ?> à <?php echo($c['heure'][$cpt]); ?>h)
	    						<a style="float:right;" onclick="supprimer(<?php echo($c['ids'][$i]);?>);">Supprimer le créneau</a>
	    						<br/>
	    						<?php
	    						$cpt++;
	    					}
	    				}
	    				?>
	    				<input type="text" hidden name="size" value="<?php echo($c['max']); ?>" />
	    			</p>
    			</div>
    		</span>
    	</div>
    	</form>
    </body>
</html>

<?php
function getCreneaux($creneaux){
	$jour = array();
	$heure = array();
	$string = array();
	$ids = array();
	$hidden = array();

	for ($i=0; $i < sizeof($creneaux['creneau']); $i++) { 
		if (array_search(getDay($creneaux['creneau'][$i]), $jour) !== false) {
			if (array_search(getHour($creneaux['creneau'][$i]), $heure) === false) {
				$hidden[] = false;
				$jour[] = getDay($creneaux['creneau'][$i]);
				$heure[] = getHour($creneaux['creneau'][$i]);
			}
			else{
				$hidden[] = true;
			}
		}
		else{
			$hidden[] = false;
			$jour[] = getDay($creneaux['creneau'][$i]);
			$heure[] = getHour($creneaux['creneau'][$i]);
		}
		$string[] = setDate($creneaux['creneau'][$i]);
		$ids[] = $creneaux['ids'][$i];
	}


	$r = array('string' => $string, 'ids' => $ids, 'hidden' => $hidden, 'jour' => $jour, 'heure' => $heure, 'max' => max($ids));
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

function setDate($date){
	return str_replace(" ", "T", $date->format("Y-m-d H:i"));
}
?>