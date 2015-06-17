<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>English Quiz</title>
    </head>
    <body>
    	<form method="post" action="connexionProcessing.php?login=1" onsubmit="return check()">
                    <p class="align40">Connexion</p>
                    <div align="center">
                        <input type="text" name="email" id="email" class="connectForm" placeholder="Email"></input><br/>
                        <input type="password" name="mdp" id="mdp" class="connectForm" placeholder="Password"></input><br/>
                        <input type="submit" class="button" style="text-align:right" name="submit" value="Connect"/>
                    </div>
            </form>
            <?php if (isset($_GET['error'])) { 
            			if ($_GET['error'] == 1) { ?>
            	<p class="text20">Le nom d'utilisateur ou le mot de passe est incorrect</p>
            	<a href="creneaux.php" class="text20">Retour aux créneaux</a> <br/>
            <?php }} ?>
    </body>
</html>