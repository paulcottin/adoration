<?php session_start(); 
//initialise variable
$plus = 0;
$moins = 0;

//Défini quelle semaine afficher (décalage par rapport à NOW()
$now = new DateTime();
$semaine = new DateInterval("P7D");

if (isset($_GET['plus'])) {
    $plus = $_GET['plus'];
    $plus = $plus+0;
    for ($i=0; $i < $plus; $i++) { 
        $now->add($semaine);
    }
}
elseif (isset($_GET['moins'])) {
    $moins = $_GET['moins'];
    $moins = $moins+0;
    for ($i=0; $i < $moins; $i++) { 
        $now->sub($semaine);
    }
}
    
$lundi = getLundi($now);
$jour = new DateInterval("P1D");

//Création de la liaison à la base de données
$db;
try{
    $db = new PDO('mysql:host=sql2.olympe.in;dbname=elghblxo', 'elghblxo', 'mot_de_passe_BDD_ado');
}catch(Exeception $e){
    echo("erreur db");
    die('Erreur : ' . $e->getMessage());
}

//Préparation de la requete pour chaque créneaux horaire :
$sql = "SELECT prenom, nom FROM utilisateurs WHERE id IN (SELECT user_id FROM creneaux WHERE date = ?)";
$stmt = $db->prepare($sql);
?>

<html>
    <head>
        <meta charset="utf-8" />
        <title>Inscription adoration NDL</title>
    </head>
    	
    </script>
    <body>
        <div>
            <span style="float:left">
                <table border="1px"> 
                <?php 
                //pour afficher l'intervalle de la semaine
                $current = new DateTime();
                $current->setDate($lundi->format("Y"), $lundi->format("m"), $lundi->format("d"));
                $current->add(new DateInterval("P6D"));
                ?>
                <caption>
                    Semaine du <?php echo($lundi->format("d/m/Y"));?> au <?php echo($current->format("d/m/Y"));?> 
                </caption> 
                <tr> 
                    <th></th> 
                    <?php
                    //première ligne du tableau (jours (Lundi, Mardi, ...))
                        $current->setDate($lundi->format("Y"), $lundi->format("m"), $lundi->format("d"));
                        for ($i=0; $i < 7; $i++) { 
                            ?>
                            <th> <?php echo(getDay($current)."<br/>".$current->format("d/m/Y")); ?> </th>
                            <?php 
                            $current->add($jour);
                        }
                    ?>
                </tr> 
                <?php
                for ($i=0; $i < 24; $i++) { 
                ?>
                <tr> 
                    <th> <?php echo $i;?>h00 </th> 
                    <?php
                        $current->setDate($lundi->format("Y"), $lundi->format("m"), $lundi->format("d"));
                        for ($j=0; $j < 7; $j++) { 
                            echo("<td> ".getPersonnes($current, $i, $stmt)."</td>");
                            $current->add($jour);
                        }
                    ?>
                </tr> 
                <?php
                }
                ?>
                </table> 
            </span>
        </div>
        <script type="text/javascript">
            window.print() ;
        </script>
    </body>
</html>

<?php 
//Renvoie le jour (Lundi, Mardi, ...) en fonction de la date
function getDay($date){
    $s = $date->format("D");
    $day = "";
    switch ($s) {
        case 'Mon':
            $day = "Lundi";
            break;
        case 'Tue':
            $day = "Mardi";
            break;
        case 'Wed':
            $day = "Mercredi";
            break;
        case 'Thu':
            $day = "Jeudi";
            break;
        case 'Fri':
            $day = "Vendredi";
            break;
        case 'Sat':
            $day = "Samedi";
            break;
        case 'Sun':
            $day = "Dimanche";
            break;
        default:
            $day = $s;
            break;
    }
    return $day;
}

//Récupère la date du lundi de la semaine courante
function getLundi($date){
    $d = $date;
    $jour = new DateInterval("P1D");
    for ($i=0; $i < 8; $i++) { 
        if (getDay($d) != "Lundi") {
            $d = $d->sub($jour);
        }
    }
    return $d;
}

//Renvoie le nom prénom des personnes inscrites tel jour, telle heure.
function getPersonnes($jour, $heure, $stmt){
    $date = $jour;
    $jour->setTime($heure, 0);
    $stmt->execute(array($jour->format("Y-m-d H:i")));
    $string = "";
    if (($data = $stmt->fetchAll())){
        //Si il y a plusieurs résultats
        if (sizeof($data) > 1) {
            for ($i=0; $i < sizeof($data); $i++) { 
                $string = $data[$i][0]." ".$data[$i][1]."<br/>".$string;
            }
        //Si il y en a qu'un seul
        }elseif (sizeof($data) == 1) {
            $string = $data[0][0]." ".$data[0][1];
        }
    }
    return $string;
}
?>