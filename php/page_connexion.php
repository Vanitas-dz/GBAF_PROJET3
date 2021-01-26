<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=login', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if(isset($_POST['connecter']))
{
    if(isset($_POST['username']) AND isset($_POST['password'])) // déclarer la demande (variables)
    {
        if(!empty($_POST['username']) AND !empty($_POST['password']))  // tous les champs remplis
        {
            $username=trim(htmlspecialchars($_POST['username']));
           
            $password=$_POST['password'];
            

            $requser = $bdd->prepare("SELECT * FROM membres WHERE username = ? "); // recuperer les infos de l'user en fonction de l'username
            $requser->execute(array($username));
            $resultat = $requser->fetch();
            $verifpass = password_verify($password,$resultat['motdepasse']);  // on recupere le mdp de l'utilisateur
            if($verifpass == true) // si le mdp entrée est = au mdp de la base de donnée
            {
                $_SESSION['id'] = $resultat['id_user'];
                $_SESSION['nom'] = $resultat['nom'];
                $_SESSION['prenom'] = $resultat['prenom'];
                $_SESSION['username'] = $resultat['username'];
                $_SESSION['mail'] = $resultat['mail'];
                echo ' Vous êtes connecté !';
                header('Location: page_accueil.php?id=' . $_SESSION['id']); // redirection page d'acceuil
            }
            else
            {
                $erreur = "Username ou mot de passe incorrecte" ;
            }
        }
       else
        {
        $erreur = "Tous les champs doivent être complétés ! ";
        }
    }   
}    
    

?>








<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page de connexion</title>
        <link rel="stylesheet" href="../css/style_connexion.css">
    </head>

    <body>
        <div class = block_connexion>
            <img src ="../img/gbaf.png" alt='image'>
            <p class=txt>Le Groupement Banque Assurance Français</p>
            <hr>
            <h1>Bienvenue </h1>
            <h3>Veuillez vous connecter pour acceder au site</h3>

            <form action="page_connexion" method="POST" >
                <table>
                    <tr>
                            <td>
                                <label> Veuilez entrer votre Username: </label>
                            </td>
                            <td>
                                <input type="text" name="username" value="<?php if(isset($username)) { echo $username; } ?>" />
                            </td>
                    </tr>
                    <tr>
                        
                        <td>
                            <label> Veuilez entrer votre  Mot de passe: </label>
                        </td>
                        <td>
                            <input type="password"  name="password" />
                        </td>

                    </tr>  
            </table>
            <input type="submit" name="connecter" class= connecter value="Se connecter !"/>

            </form>
            <?php 
            if(isset($erreur))
            {
                echo $erreur;
            }
            ?>
            <div class= last>

            <br>
            <a href ='motdepasse_reset.php'>Mot de passe oublié ?</a>
            <br>
            <a href ='page_inscription.php'>Pas de compte ? Inscrivez-vous</a>
            </div>
        </div>       
        
        
    </body>
    </html>