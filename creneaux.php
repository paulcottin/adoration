<?php session_start(); 

$db;
try{
	$db = new PDO('mysql:host=sql2.olympe.in;dbname=elghblxo', 'elghblxo', 'mot_de_passe_BDD_ado');
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
    <script type="text/javascript">
    	

		function init () {
			var form = document.getElementById('formulaire');
			var but = document.getElementById('inscriptionBouton');
			form.style.display = "none";
		}
		

    	function afficherForm () {
    		var form = document.getElementById('formulaire');
			var but = document.getElementById('inscriptionBouton');
    		form.style.display = "";
    		but.style.display = "none";
    	}
    </script>
    <body onload="init();">
    	<div>
    	<a href="connexion.php" style="float:left">Connexion</a>
    	<span style="float:left">
    		<table border="1px"> 
				<caption> En vert, il y a au moins une personne <br/>
				En rouge, il faut quelqu'un<br/>
				En noir, il n'y a pas d'adoration cette heure là
				 </caption> 
			   	<tr> 
					<th></th> 
					<?php
					//première ligne du tableau (jours (Lundi, Mardi, ...))
						$current = new DateTime();
						$current->setDate($lundi->format("Y"), $lundi->format("m"), $lundi->format("d"));
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
							$rep = getCouleur($current, $i, $stmt);
							echo('<td style="background:'.$rep[0].'; text-align:center">'.$rep[1].'</td>');
							$current->add($jour);
						}
					?>
				</tr> 
				<?php
				}
				?>
			</table> 
    	</span>
    	<span style="float:center">
    		<div id="inscriptionBouton">
    			<input type="button" class="button" style="text-align:center" value="S'inscrire" onclick="afficherForm()"/>
    		</div>
    		<div id="formulaire">
    			<?php include 'formInsere.php'; ?>
    		</div>
    	</span>
    	</div>
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
function getCouleur($jour, $heure, $stmt){
	$date = $jour;
	$jour->setTime($heure, 0);
	$stmt->execute(array($jour->format("Y-m-d H:i")));
	$string = "red";
	$nb = "";
	//Si c'est un jour normal
	if (($data = $stmt->fetchAll())){
		//Si il y a des resultats
		if (sizeof($data) > 0) {
			$string = "green";
			$nb = sizeof($data);
		}	
	}
	//Si c'est un jour où il n'y a pas adoration : en noir
	if (getDay($jour) == "Dimanche" || getDay($jour) == "Lundi") {
		$string = "black";
	}
	if (getDay($jour) == "Samedi" && $heure > 12) {
		$string = "black";
	}

	return array($string, $nb);
}
?>