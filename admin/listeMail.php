<?php session_start(); 

//Création de la liaison à la base de données
$db;
try{
	$db = new PDO('mysql:host=sql2.olympe.in;dbname=elghblxo', 'elghblxo', 'mot_de_passe_BDD_ado');
}catch(Exeception $e){
	echo("erreur db");
	die('Erreur : ' . $e->getMessage());
}

//récupération des utilisateurs
$sql = "SELECT prenom, nom, email, telephone FROM utilisateurs;";
$stmt = $db->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll();
?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="../style.css">
        <title>Inscription adoration NDL</title>
    </head>
    <script type="text/javascript">

    	function selectAll(){
    		var b = document.getElementById('selectAll');
            if (b.value = 'Sélectionner tout') {
                b.value = 'Déselectionner tout';
            }
            else{
                b.value = 'Sélectionner tout';
            }
            var inputs = document.getElementById('form').getElementsByTagName('input');
    		for(i = 0; i < inputs.length; i++) {
    			if(inputs[i].type == 'checkbox'){
    				if (inputs[i].checked) {
    					inputs[i].checked = false;
    				}else{
    					inputs[i].checked = true;
    				}
    				
    			}
    		}	
    	}

        function afficherMail () {
            var mail = document.getElementById('mailBox')
            if (mail.hidden) {
                mail.hidden = false;
            }
            else{
                mail.hidden = true;
            }
        }

        function envoyerMail () {
            var form = document.getElementById('mailForm');
            var inputs = document.getElementById('form').getElementsByTagName('input');
            var cpt = 0;
            for(i = 0; i < inputs.length; i++) {
                if(inputs[i].type == 'checkbox'){
                    if (inputs[i].checked) {
                        var input = document.createElement("input");
                        input.name = 'dest'+i;
                        input.type = 'text';
                        input.value = inputs[i].value
                        input.hidden = true;
                        form.appendChild(input);           
                        cpt = cpt + 1;
                    }
                }
            }
            if (document.getElementById('mail').value != "") {
                if (cpt > 0) {
                    var input = document.createElement("input");
                    input.name = 'size';
                    input.type = 'text';
                    input.value = cpt;
                    input.hidden = true;
                    form.appendChild(input);           
                    form.submit();
                }else
                    alert('Veuillez mentionner des destinataires');
            }else
                alert('Votre message est vide');
        }
    </script>
    <body>
    	 <div style="overflow:scroll; border:#FFFFFF 1px solid; width:40%; height:50%">
    	 	<form id="form">
    	 		<?php
	    		for ($i=0; $i < sizeof($data); $i++) { 
	    			echo('<input type="checkbox" value="'.$data[$i][2].'"/> '.$data[$i][0].' '.$data[$i][1].', '.$data[$i][2].' ; '.$data[$i][3].'<br/><hr/>');
	    		}
	    		?>
    	 	</form>
    	</div>
    	<p>
    		<input id="selectAll" type="button" class="button" value="Sélectionner tout" onclick="selectAll();"/>
            <input id="mailto" type="button" class="button" value="Envoyer un mail" onclick="afficherMail();">
    	</p>
        
        <div id="mailBox" hidden>
            <p>Ecrivez votre mail ici</p>
            <form id="mailForm" action="mailProcessing.php" class="connectForm">
                <input type="text" class="connectForm" name="sujet" placeholder="Sujet"/><br/>
                <textarea id="mail" class="connectForm" name="mail" rows="10" cols="50"></textarea>
                <input id="envoyer" type="button" class="button" value="Envoyer" onclick="envoyerMail();"/>
            </form>
        </div>
        <a href="privateTab.php" class="text20">Retour au tableau</a>
    </body>
</html>