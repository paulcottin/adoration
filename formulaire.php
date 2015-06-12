<?php session_start(); ?>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css">
        <title>Inscription adoration NDL</title>
    </head>
    <script type="text/javascript">
    var ok = 1

    function check() {
        var nom = document.getElementById('nom');
        var prenom = document.getElementById('prenom');
        var date = document.getElementById('date');
        var repetition = document.getElementById('repetition');
        var email = document.getElementById('email');

        if (nom.value == "") {
            ok = 0;
            alert('Veuillez renseigner votre nom');
        }
        if (prenom.value == "") {ok = 0;
            alert('Veuilez renseigner votre prénom');
        }
        if (date.value == "") {ok = 0;
            alert('Veuillez sélectionner une date/heure');
        }
        if (repetition.value == "--") {ok = 0;
            alert('Veuillez indiquer une fréquence');
        }
        if (email.value == "") {ok = 0;
            alert('Veuillez renseigner votre email');
        }
        if (ok == 1)
            return true;
        else
            return false;
    }

    </script>
    <body>
        <p class="centerWhite70">Adoration Notre-Dame de Lourdes</p>
        <p class="align40">Inscription</p>
        <div align="center">
            <form method="post" action="formulaireProcessing.php" onsubmit="return check()"/> <br/>
                <input type="text" class="connectForm" id ="nom" name="nom" placeholder="Nom" maxlength="20" default=""/> <br/>
                <input type="text" class="connectForm" id ="prenom" name="prenom" placeholder="Prénom" maxlength="20" default=""/> <br/>
                <input type="text" class="connectForm" id ="adresse" name="adresse" placeholder="Adresse" maxlength="20" default=""/> <br/>
                <input type="text" class="connectForm" id ="telephone" name="telephone" placeholder="Numéro de téléphone" maxlength="15" default=""/> <br/>
                <input type="text" class="connectForm" id ="portable" name="portable" placeholder="Numéro de portable" maxlength="15" default=""/> <br/>
                <input type="text" class="connectForm" id ="email" name="email" placeholder="Adresse email" maxlength="50" default=""/> <br/>
                <input type="datetime-local" class="connectForm" id ="date" name="date" default=""/> <br/>
                <label for="repetition" class="text20">Répétition</label>
                   <select name="repetition" id="repetition" class="connectForm">
                        <option value="default" selected>--</option>
                        <option value="1">Une seule fois</option>
                        <option value="2s">Deux semaines</option>
                        <option value="3s">Trois semaines</option>
                        <option value="1m">Un mois</option>
                        <option value="2m">Deux mois</option>
                        <option value="3m">Trois mois</option>
                        <option value="4m">Quatre mois</option>
                        <option value="5m">Cinq mois</option>
                        <option value="6m">Six mois</option>
                        <option value="1a">Un an</option>
                    </select>
                    <br/>
                <input type="submit" class="button" style="text-align:right" name="submit" value="S'inscrire"/>
            </form>
        </div>
    </body>
</html>