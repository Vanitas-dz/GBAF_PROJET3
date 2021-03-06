<?php
    session_start();
    if(isset($_GET['id'])){

    $bdd = new PDO('mysql:host=localhost;dbname=login;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    // requete pour recuperer les donnée acteurs
    $acteurs = $bdd->prepare("SELECT * FROM acteurs WHERE id =? ");
    $acteurs->execute(array($_GET['id']));
    $acteur = $acteurs->fetch();
    $acteurs->closeCursor();
        
    // requete pour inserer un commentaire en fonction de l'utilisateur
    if(isset($_SESSION['id']) AND isset($_POST['content']) AND isset($_POST['submit'])) {
        
        $reqcomments = $bdd->prepare('SELECT * FROM commentaire WHERE id_user= ? AND id_acteurs= ?');
        $reqcomments->execute(array($_SESSION['id'],$_GET['id']));
        $commentexist = $reqcomments->fetch(); // requete pour savoir si l'utilisateur a deja commenter
        if($commentexist == 0){  

            $comments = $bdd->prepare('INSERT INTO commentaire (id_user, id_acteurs, content) VALUES(?, ?, ?)');
            $comments->execute(array($_SESSION['id'],$_GET['id'], $_POST['content']));
            $msg = "<span style=' color:green;'>Votre commentaire a bien été créer<span>";
        }
        else{
            $erreur = "<span style=' color:red;'>Vous avez déja commenté cet acteur <span>";
        }
        
    }

    // requete pour compter le nombre de like et dislike par rapport a chaque utlisateur
    $likes = $bdd->prepare('SELECT COUNT(id) FROM likes WHERE id_acteurs= ?');
    $likes->execute(array($_GET['id']));
    $like = $likes->fetch();
    
    $dislikes = $bdd->prepare('SELECT COUNT(id) FROM dislikes WHERE id_acteurs= ? ');
    $dislikes->execute(array($_GET['id']));
    $dislike = $dislikes->fetch();
    

   
  
  
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page acteur</title>
        <link rel="stylesheet" href="../css/style_acteur.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" integrity="sha384-vSIIfh2YWi9wW0r9iZe7RJPrKwp6bG+s9QZMoITbCckVJqGCCRhc+ccxNcdpHuYu" crossorigin="anonymous">
    </head>
    <body>
        <header><?php include('header_gbaf.php')  ?></header>

        <!-- afficher données acteur-->
        <div>
        <div class='forma_co' >
        <div class= 'acteur'>
            <h2><?php echo $acteur['titre'];?></h2>
            <img src="<?php echo $acteur['image'];?>" alt ="image acteur" />
            <p><?php echo $acteur['contenu'];?></p>

            <!-- affichage like/dislike des acteurs-->
            <a href="vote.php?t=1&id=<?php echo $_GET['id']; ?>"><i class="fas fa-thumbs-up" style="color:green;"></i> (<?php echo $like[0]; ?>) </a> 
            <a href="vote.php?t=2&id=<?php echo $_GET['id']; ?>"> <i class="fas fa-thumbs-down" style="color:red;"></i> (<?php echo $dislike[0]; ?>) </a>
            
        </div>
        </div>
        <h1>commentaires</h1>
        <div class= comments>
            <form action="#" method='POST'>
                <textarea name="content" placeholder="Votre commentaire" ></textarea>
                <br>
                <input type="submit" name="submit" value="Envoyer">
                </form>
                <?php if(isset($msg)){ echo $msg;}?>
                <?php if(isset($erreur)){ echo $erreur; } ?>
                
            <!-- recuperation des commentaires en fonction de l'utilisateur-->
                <?php
                $reponse = $bdd->prepare('SELECT * 
                FROM commentaire
                INNER JOIN membres
                ON commentaire.id_user = membres.id_user
                WHERE id_acteurs= ? 
                ORDER BY id ');
                
                $rep=$reponse->execute(array($_GET['id'],));
    
                while($donnees = $reponse->fetch())
                {
                    echo '<div class= message> <p><strong>' . htmlspecialchars($donnees['nom']) . " " . htmlspecialchars($donnees['prenom']) .  '</strong> : ' . htmlspecialchars($donnees['date_creation']) . " <br> " . htmlspecialchars($donnees['content']) .  '</p></div>' ;
                ?>
               
                
                <?php } ?>
                
                </div>

                <p><a href="<?php echo "page_accueil.php?id=" . $_SESSION['id']; ?>">Revenir a la page d'acceuil</a></p>


           </div>
        <footer> <?php include('footer_gbaf.php') ?> </footer>
    </body>
</html>
<?php
}
?>
