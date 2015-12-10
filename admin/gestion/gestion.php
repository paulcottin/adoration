<?php session_start();

include '../../x.php';

?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="../../style.css">
        <title>Adoration NDL</title>
    </head>
    <body>
    	<input type="button" class="button" value="Ajouter un administrateur" onclick="document.location.href='ajoutAdmin.php'"/>
    	<br/>
    	<a href="../privateTab.php">Revenir aux créneaux</a>
    </body>
</html>

<?php
?>