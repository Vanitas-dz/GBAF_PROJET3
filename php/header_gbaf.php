<?php


$bdd = new PDO('mysql:host=localhost;dbname=login', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if(isset($_SESSION['id']))
{
    $getid = intval($_SESSION['id']);
    $requser = $bdd->prepare('SELECT * FROM membres WHERE id_user = ?');
    $requser->execute(array($getid));
    $resultat = $requser->fetch();

?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil</title>
        <link rel="stylesheet" href="../css/style_header.css">
    </head>

    <body>
        <div class='block_page'>
        <img src ="../img/gbaf.png" alt='image'>
        <div class= bloc_header>
        <div class = titre>  
        <h3> <?php echo $resultat['nom']; ?> <?php echo $resultat['prenom']; ?> </h3>
        </div>
        <?php
       if (isset($_SESSION['id']) AND $resultat['id_user'] == $_SESSION['id'])
       {
       ?>
       
       <p><a href='modification_profil.php' class= modif_profil>Parametrer mon compte</a> 
       
       
       <a href ='page_deconexion.php' class= a_deco>Déconnexion</a></p>
       
       <?php
       }
       ?>
    </div>
    </div> 
    </body>
    </html>
    <?php
    }
    
    ?>