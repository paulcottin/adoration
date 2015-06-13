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
$sql = "SELECT prenom, nom, email, telephone, id FROM utilisateurs;";
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
        function redirect (id) {
            document.location.href = "fiche.php?id="+id;
        }
    </script>
    <body>
    	 <div style="overflow:scroll; border:#FFFFFF 1px solid; width:40%; height:50%">
	 		<?php
    		for ($i=0; $i < sizeof($data); $i++) { 
    			echo('<input type="button" onclick="redirect('.$data[$i][4].')" style="background:none; border:none; color:white; font:20px bold;" value="&nbsp - '.$data[$i][0].' '.$data[$i][1].', '.$data[$i][2].' ; '.$data[$i][3].'"/><br/><hr/>');
    		}
    		?>
    	</div>
    </body>
</html>