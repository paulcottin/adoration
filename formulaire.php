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
        <p class="align40">Inscription</p>
        <div align="center">
            <form method="post" action="formulaireProcessing.php" onsubmit="return check()"/> <br/>
                <input type="text" class="connectForm" id ="nom" name="nom" placeholder="Nom" maxlength="20" default=""/> <br/>
                <input type="text" class="connectForm" id ="prenom" name="prenom" placeholder="Prénom" maxlength="20" default=""/> <br/>
                <input type="text" class="connectForm" id ="adresse" name="adresse" placeholder="Adresse" maxlength="20" default=""/> <br/>
                <input type="text" class="connectForm" id ="telephone" name="telephone" placeholder="Numéro de téléphone" maxlength="15" default=""/> <br/>
                <input type="text" class="connectForm" id ="portable" name="portable" placeholder="Numéro de portable" maxlength="15" default=""/> <br/>
                <input type="text" class="connectForm" id ="email" name="email" placeholder="Adresse email" maxlength="50" default=""/> <br/>
                <label for"jour" class="text20">Jour</label>
                    <select name="jour" class="connectForm" id="jour">
                        <option value="Lundi">Lundi</option>
                        <option value="Mardi">Mardi</option>
                        <option value="Mercredi">Mercredi</option>
                        <option value="Jeudi">Jeudi</option>
                        <option value="Vendredi">Vendredi</option>
                        <option value="Samedi">Samedi</option>
                        <option value="Dimanche">Dimanche</option>
                    </select>
                <label for"heure" class="text20">Heure</label>
                    <select name="heure" class="connectForm" id="heure">
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
                <label for="repetition" class="text20">Répétition</label>
                   <select name="repetition" id="repetition" class="connectForm">
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
                <input type="submit" class="button" style="text-align:right" name="submit" value="S'inscrire"/>
            </form>
        </div>
    </body>
</html>