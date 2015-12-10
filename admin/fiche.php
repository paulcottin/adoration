<?php
$id = 0;
if (isset($_GET['id'])) {
	$id = $_GET['id'];
}

include '../x.php';

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
$sql = "SELECT jour, heure FROM `creneaux_bis` WHERE user_id = ? AND date(date_debut) <= now() AND date(date_fin) > now();";

$stmt = $db->prepare($sql);
$stmt->execute(array($pers['id']));

$data = $stmt->fetchAll();
$creneaux = $data;
?>

<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="../style.css">
        <title>Inscription adoration NDL</title>
    </head>
    <script type="text/javascript">
    	function supprimer () {
    		if (confirm('Êtes-vous sûr de vouloir supprimer cet adorateur ?')){
    			document.location.href = "supprimerAdoProcessing_bis.php?id=<?php echo $pers['id'] ?>";
    		}
    	}
    </script>
    <body>
    	<p class="centerWhite70">Fiche adorateur</p>
    	<p class="centerWhite40"><?php echo($pers['prenom']." ".$pers['nom']) ?></p>
    	<a href="ficheModif.php?id=<?php echo($pers['id']); ?>" class="button">Modifier</a>
    	<a class="button" onclick="supprimer();">Supprimer</a>
    	<div>
    		<span style="float:left">
    			<div style="margin:10px 100px 100px 100px;">
    				<p class="text20">
	    				Adresse : <?php echo($pers['adresse']); ?> <br/>
	    				E-mail : <?php echo($pers['email']); ?> <br/>
	    				Téléphone : <?php echo($pers['telephone']); ?> <br/>
	    				Portable : <?php echo($pers['portable']); ?>
	    			</p>
    			</div>
    		</span>
    		<span style="float:center;">
    			<div style="margin:50px 100px 100px 100px;;">
    				<p class="text20" style="text-decoration:underline">
	    				Créneaux :
	    			</p>
	    			<p class="text20">
	    				<?php 
	    				for ($i=0; $i < sizeof($creneaux); $i++) { 
	    					echo(" - Le ".$creneaux[$i]['jour']." à ".$creneaux[$i]['heure']."h<br/>");
	    				}
	    				?>
	    			</p>
    			</div>
    		</span>
    	</div>
    	<a href="privateTab.php">Retour aux créneaux</a>
    </body>
</html>