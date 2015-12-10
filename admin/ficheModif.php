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
$sql = "SELECT id, jour, heure FROM `creneaux_bis` WHERE user_id = ? AND date(date_debut) <= now() AND date(date_fin) > now();";

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
    	function supprimer (id) {
    		if (confirm('Êtes-vous sûr de vouloir supprimer ce créneau ? \n\n(Pensez à sauvegarder vos modifications en cours avant la suppression, sinon elles seront perdues)')){
    			document.location.href = "supprimerCreneauProcessing.php?id="+id+"&user_id=<?php echo($id); ?>";
    		}
    	}

    	function ajoutC () {
    		var jour = document.getElementById('jourAjout');
    		var heure = document.getElementById('heureAjout');
    		var repetition = document.getElementById('repetitionAjout');
    		var jourLabel = document.getElementById('jourLabelAjout');
    		var heureLabel = document.getElementById('heureLabelAjout');
    		var repetitionLabel = document.getElementById('repetitionLabelAjout');

    		jour.hidden = false;
    		jourLabel.hidden = false;
    		heure.hidden = false;
    		heureLabel.hidden = false;
    		repetition.hidden = false;
    		repetitionLabel.hidden = false;
    		ajoutCreneau.hidden = true;
    	}

    	function check () {
    		var ok = 1;
    		var jour = document.getElementById('jourAjout');
    		var heure = document.getElementById('heureAjout');
    		var repetition = document.getElementById('repetitionAjout');	
    		if (jour.hidden == false && repetition.value == "default") {
				ok = 0;
            	alert('Veuillez indiquer une fréquence');
    		}

    		if (ok == 1)
    			return true;
    		else
    			return false;
    	}
    </script>
    <body>
    	<p class="centerWhite70">Fiche adorateur</p>
    	<form action="ficheModifProcessing.php?id=<?php echo $id; ?>" class="text20" method="POST" onsubmit="return check()">
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
	    				$cpt = 0;
	    				for ($i=0; $i < sizeof($creneaux); $i++) { ?>
	    						
                    <select name="jour_<?php echo($creneaux[$cpt]['id']);?>" class="connectForm" id="jour">
                        <option value="Lundi" <?php if ($creneaux[$cpt]['jour'] == "Lundi") { echo "selected"; } ?>>Lundi</option>
                        <option value="Mardi" <?php if ($creneaux[$cpt]['jour'] == "Mardi") { echo "selected"; } ?>>Mardi</option>
                        <option value="Mercredi" <?php if ($creneaux[$cpt]['jour'] == "Mercredi") { echo "selected"; } ?>>Mercredi</option>
                        <option value="Jeudi" <?php if ($creneaux[$cpt]['jour'] == "Jeudi") { echo "selected"; } ?>>Jeudi</option>
                        <option value="Vendredi" <?php if ($creneaux[$cpt]['jour'] == "Vendredi") { echo "selected"; } ?>>Vendredi</option>
                        <option value="Samedi" <?php if ($creneaux[$cpt]['jour'] == "Samedi") { echo "selected"; } ?>>Samedi</option>
                        <option value="Dimanche" <?php if ($creneaux[$cpt]['jour'] == "Dimanche") { echo "selected"; } ?>>Dimanche</option>
                    </select>
                
                    <select name="heure_<?php echo($creneaux[$i]['id']);?>" class="connectForm" id="heure">
                        <option value="0" <?php if ($creneaux[$cpt]['heure'] == "00") { echo "selected"; } ?>>00h</option>
                        <option value="1" <?php if ($creneaux[$cpt]['heure'] == "01") { echo "selected"; } ?>>01h</option>
                        <option value="2" <?php if ($creneaux[$cpt]['heure'] == "02") { echo "selected"; } ?>>02h</option>
                        <option value="3" <?php if ($creneaux[$cpt]['heure'] == "03") { echo "selected"; } ?>>03h</option>
                        <option value="4" <?php if ($creneaux[$cpt]['heure'] == "04") { echo "selected"; } ?>>04h</option>
                        <option value="5" <?php if ($creneaux[$cpt]['heure'] == "05") { echo "selected"; } ?>>05h</option>
                        <option value="6" <?php if ($creneaux[$cpt]['heure'] == "06") { echo "selected"; } ?>>06h</option>
                        <option value="7" <?php if ($creneaux[$cpt]['heure'] == "07") { echo "selected"; } ?>>07h</option>
                        <option value="8" <?php if ($creneaux[$cpt]['heure'] == "08") { echo "selected"; } ?>>08h</option>
                        <option value="9" <?php if ($creneaux[$cpt]['heure'] == "09") { echo "selected"; } ?>>09h</option>
                        <option value="10" <?php if ($creneaux[$cpt]['heure'] == "10") { echo "selected"; } ?>>10h</option>
                        <option value="11" <?php if ($creneaux[$cpt]['heure'] == "11") { echo "selected"; } ?>>11h</option>
                        <option value="12" <?php if ($creneaux[$cpt]['heure'] == "12") { echo "selected"; } ?>>12h</option>
                        <option value="13" <?php if ($creneaux[$cpt]['heure'] == "13") { echo "selected"; } ?>>13h</option>
                        <option value="14" <?php if ($creneaux[$cpt]['heure'] == "14") { echo "selected"; } ?>>14h</option>
                        <option value="15" <?php if ($creneaux[$cpt]['heure'] == "15") { echo "selected"; } ?>>15h</option>
                        <option value="16" <?php if ($creneaux[$cpt]['heure'] == "16") { echo "selected"; } ?>>16h</option>
                        <option value="17" <?php if ($creneaux[$cpt]['heure'] == "17") { echo "selected"; } ?>>17h</option>
                        <option value="18" <?php if ($creneaux[$cpt]['heure'] == "18") { echo "selected"; } ?>>18h</option>
                        <option value="19" <?php if ($creneaux[$cpt]['heure'] == "19") { echo "selected"; } ?>>19h</option>
                        <option value="20" <?php if ($creneaux[$cpt]['heure'] == "20") { echo "selected"; } ?>>20h</option>
                        <option value="21" <?php if ($creneaux[$cpt]['heure'] == "21") { echo "selected"; } ?>>21h</option>
                        <option value="22" <?php if ($creneaux[$cpt]['heure'] == "22") { echo "selected"; } ?>>22h</option>
                        <option value="23" <?php if ($creneaux[$cpt]['heure'] == "23") { echo "selected"; } ?>>23h</option>
                    </select>
	    						<a style="float:right;" onclick="supprimer(<?php echo($creneaux[$i]['id']);?>);">Supprimer le créneau</a>
	    						<br/>
	    						<?php
	    						$cpt++;
	    					}
	    				
	    				?>
	    				<input type="button" id="ajoutCreneau" class="button" value="Ajouter un créneau" onclick="ajoutC();" />
	    				<label for"jour" class="text20" id="jourLabelAjout" hidden>Jour</label>
                    <select name="jourAjout" class="connectForm" id="jourAjout" hidden>
                        <option value="Lundi">Lundi</option>
                        <option value="Mardi">Mardi</option>
                        <option value="Mercredi">Mercredi</option>
                        <option value="Jeudi">Jeudi</option>
                        <option value="Vendredi">Vendredi</option>
                        <option value="Samedi">Samedi</option>
                        <option value="Dimanche">Dimanche</option>
                    </select>
                <label for"heure" class="text20" id="heureLabelAjout" hidden>Heure</label>
                    <select name="heureAjout" class="connectForm" id="heureAjout" hidden>
                        <option value="0">00h</option>
                        <option value="1">01h</option>
                        <option value="2">02h</option>
                        <option value="3">03h</option>
                        <option value="4">04h</option>
                        <option value="5">05h</option>
                        <option value="6">06h</option>
                        <option value="7">07h</option>
                        <option value="8">08h</option>
                        <option value="9">09h</option>
                        <option value="10">10h</option>
                        <option value="11">11h</option>
                        <option value="12">12h</option>
                        <option value="13">13h</option>
                        <option value="14">14h</option>
                        <option value="15">15h</option>
                        <option value="16">16h</option>
                        <option value="17">17h</option>
                        <option value="18">18h</option>
                        <option value="19">19h</option>
                        <option value="20">20h</option>
                        <option value="21">21h</option>
                        <option value="22">22h</option>
                        <option value="23">23h</option>
                    </select>
                    <br/>
                <label for="repetition" class="text20" id="repetitionLabelAjout" hidden>Répétition</label>
                   <select id="repetitionAjout" name="repetitionAjout" class="connectForm" hidden>
                        <option value="default" selected>--</option>
                        <option value="1">Une seule fois</option>
                        <!-- <option value="2s">Deux semaines</option>
                        <option value="3s">Trois semaines</option>
                        <option value="1m">Un mois</option>
                        <option value="2m">Deux mois</option>
                        <option value="3m">Trois mois</option>
                        <option value="4m">Quatre mois</option>
                        <option value="5m">Cinq mois</option>
                        <option value="6m">Six mois</option>
                        <option value="1a">Un an</option> -->
                        <option value="toujours">Régulier</option>
                    </select>
                    <br/>
	    				<input type="text" hidden name="size" value="<?php echo(getMaxId($creneaux)); ?>" />
	    			</p>
    			</div>
    		</span>
    	</div>
    	</form>
    </body>
</html>

<?php
function getMaxId($creneaux) {
    $max = 0;
    for ($i=0; $i < sizeof($creneaux); $i++) { 
        if ($creneaux[$i]['id']+0 > $max)
            $max = $creneaux[$i]['id']+0;
    }
    return $max;
}
?>