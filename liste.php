<?php session_start(); 

//Création de la liaison à la base de données
$db;
try{
	$db = new PDO('mysql:host=localhost;dbname=adoration', 'root', 'root');
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
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Inscription adoration NDL</title>
    </head>
    <script type="text/javascript">

    	function selectAll(){
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
    		var b = document.getElementById('selectAll');
    		if (b.value = 'Sélectionner tout') {
    			b.value = 'Déselectionner tout';
    		}
    		else if (b.value = 'Déselectionner tout'){
    			b.value = 'Sélectionner tout';
    		}
    	}
    </script>
    <body>
    	 <div style="overflow:scroll; border:#000000 1px solid; width:40%; height:50%">
    	 	<form id="form">
    	 		<?php
	    		for ($i=0; $i < sizeof($data); $i++) { 
	    			echo('<input type="checkbox"/>'.$data[$i][0].' '.$data[$i][1].', <a href="'.$data[$i][2].'" style="color:white">'.$data[$i][2].'</a> - '.$data[$i][3].'<br/><hr/>');
	    		}
	    		?>
    	 	</form>
    	</div>
    	<p>
    		<input id="selectAll" type="button" value="Sélectionner tout" onclick="selectAll();"/>
    	</p>
    </body>
</html>