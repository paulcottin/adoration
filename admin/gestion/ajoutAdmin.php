<?php session_start();

include '../../x.php';

?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="../../style.css">
        <title>Adoration NDL</title>
    </head>
    <script type="text/javascript">
        function check () {
            var password = document.getElementById('password');
            var password2 = document.getElementById('password2');
            var email = document.getElementById('email');

            if (email.value == "") {
                alert('Veuillez renseigner une adresse mail');
                return false;
            }

            if (password2.value != password.value) {
                alert('Les mots de passes sont différents, veuillez les rentrer à nouveau');
                password2.value = "";
                password.value = "";
                return false;
            }

            if (password.value == "") {
                alert('Veuillez rentrer un mot de passe !');
                return false;
            }

            return true;
        }
    </script>
    <body>
    	<h3>Si l'administrateur est un adorateur, ne remplir que les champs "Email" et "Mot de passe" <br/>Sinon remplir l'intégralité des informations</h3>

        <form method="post" action="ajoutAdminProcessing.php" onsubmit="return check()"/> <br/>
                <input type="text" class="connectForm" id ="nom" name="nom" placeholder="Nom" maxlength="20" default=""/> <br/>
                <input type="text" class="connectForm" id ="prenom" name="prenom" placeholder="Prénom" maxlength="20" default=""/> <br/>
                <input type="text" class="connectForm" id ="adresse" name="adresse" placeholder="Adresse" maxlength="20" default=""/> <br/>
                <input type="text" class="connectForm" id ="telephone" name="telephone" placeholder="Numéro de téléphone" maxlength="15" default=""/> <br/>
                <input type="text" class="connectForm" id ="portable" name="portable" placeholder="Numéro de portable" maxlength="15" default=""/> <br/>
                <input type="text" class="connectForm" id ="email" name="email" placeholder="Adresse email" maxlength="50" default=""/> <br/>
                <input type="password" class="connectForm" id ="password" name="password" placeholder="Mot de passe" maxlength="50"/> <br/>
                <input type="password" class="connectForm" id ="password2" name="password2" placeholder="Vérification du mot de passe" maxlength="50"/> <br/>
                    
                <input type="submit" class="button" style="text-align:right" name="submit" value="Ajouter"/>
            </form>

            <?php include 'retour.php';?>
    </body>
</html>

<?php
?>