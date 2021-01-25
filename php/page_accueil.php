<?php
    session_start();
    
    $bdd = new PDO('mysql:host=localhost;dbname=login;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    // recupere les infos acteurs dans la base de donnée
    $acteurs = $bdd->prepare("SELECT * FROM acteurs");
    $acteurs->execute();
     
    
    ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page d'acceuil du Groupe GBAF</title>
        <link rel="stylesheet" href="../css/style_accueil.css">
    </head>



    <body>
        <header><?php include('header_gbaf.php')  ?></header>
        <div class= bloc_page>
        <p class =img><img src='../img/logo_gbaf'/></p>
        <h1> le Groupement Banque-Assurance Français </h1> 
        <p>Le Groupement Banque Assurance Français (GBAF) est une fédération représentant les 6 grands groupes français : </p>
        <div class=liste_ul>
        <ul>
            <li>BNP Paribas</li> 
            <li>BPCE</li> 
            <li>Crédit Agricole</li> 
        </ul>
        <ul>
            <li>Crédit Mutuel-CIC</li> 
            <li>Société Générale</li> 
            <li>La Banque Postale</li> 
        </ul>
        </div>
        <p>
        Le GBAF est le représentant de la profession bancaire et des assureurs sur tous
        les axes de la réglementation financière française. Sa mission est de promouvoir
        l'activité bancaire à l’échelle nationale. C’est aussi un interlocuteur privilégié des
        pouvoirs publics.
        </p>

        <h2 class='titreh2'> Nos partenaires </h2>
        <?php
        foreach($acteurs as $acteur){ // requete pour afficher tous les acteurs de la base de donnée
        ?>
        <div class='forma_co' >
        <h2><?php echo $acteur['titre'];?></h2>
        <img src="<?php echo $acteur['image'];?>" />
        <p><?php echo $acteur['contenu'];?></p>
        <div class="lien">
        <p class =a1><a href =<?php echo "page_acteur.php?id=" .  $acteur['id']; ?>>Plus d'informations</a></p>
        </div>
        </div>
        <?php
        }
        ?>
        

    </div>
    <?php include('footer_gbaf.php')  ?>         
    </body>
</html>
