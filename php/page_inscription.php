<?php
$bdd = new PDO('mysql:host=localhost;dbname=login', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if(isset($_POST['forminscription']))
{

    if(isset($_POST['nom']) AND isset($_POST['prenom']) AND isset($_POST['username']) AND isset($_POST['mail']) AND isset($_POST['mail2']) AND isset($_POST['password']) AND isset($_POST['password_confirm']) AND isset($_POST['question']) AND isset($_POST['reponse']))
    {
         
        if(!empty($_POST['nom']) AND !empty($_POST['prenom'])AND !empty($_POST['username']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['password']) AND !empty($_POST['password_confirm'])AND !empty($_POST['question']) AND !empty($_POST['reponse']))
        {
            $nom=trim(htmlspecialchars($_POST['nom']));
            $prenom=trim(htmlspecialchars($_POST['prenom']));
            $username=trim(htmlspecialchars($_POST['username']));
            $mail=trim(htmlspecialchars($_POST['mail']));
            $mail2=trim(htmlspecialchars($_POST['mail2']));
            $password=trim(htmlspecialchars($_POST['password']));
            $password_confirm=trim(htmlspecialchars($_POST['password_confirm']));
            $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $question=trim(htmlspecialchars($_POST['question']));
            $reponse=trim(htmlspecialchars($_POST['reponse']));


            
            if (strlen($nom) >= 3 AND strlen($prenom) <=255)
            {
                if (strlen($prenom) >= 3 AND strlen($prenom) <=255)
                {
                    if (strlen($username) >= 3 AND strlen($username) <=255)
                    {
                        if($mail == $mail2)
                        {
                            if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                            {
                                $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ? ");
                                $reqmail->execute(array($mail));
                                $mailexist = $reqmail->rowCount();
                                if($mailexist == 0)
                                {
                                    if($password == $password_confirm)
                                    {
                                        $req = $bdd->prepare('INSERT INTO membres(nom, prenom, username, mail, motdepasse, question, reponse) VALUES(?, ?, ?, ?, ?, ?, ?)');
                                        $req->execute(array($nom, $prenom, $username, $mail,$pass_hash, $question, $reponse));
                                        $msg = "<span style=' color:green'>Votre compte a bien été créer<span>";
                                        
                                    }
                                    else
                                    {
                                        $erreur = ' Vos mot de passe ne correspondent pas';
                                    }
                                }
                                else
                                {
                                    $erreur = 'Adresse mail déja utlisée ! ';
                                }
                            }
                            else
                            {
                                $erreur = "Votre adresse mail n'est pas valide !";
                            }
                        }
                        else
                        {
                            $erreur = 'Vos adresses mail ne correspondent pas !';
                        }

                    }
                    else
                    {
                        $erreur = ' Votre username ne doit comporter que 3 à 255 caractères !';
                    }
                }
                else
                {
                    $erreur = ' Votre prenom ne doit comporter que 3 à 255 caractères !';
                }
            }
            else
            {
                $erreur = ' Votre nom ne doit comporter que 3 à 255 caractères !';
            }
        }    
        else
        {
            $erreur ='Tous les champs doivent être complétés';
        }
    }    

}
?>   




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Page d'inscription</title>
        <link rel="stylesheet" href="../css/style_inscription.css">
    </head>

    <body>
        <div class = block_register>
        <img src ="../img/gbaf.png" alt='image'>
        <p class=txt>Le Groupement Banque Assurance Français</p>
        <hr>
        <h1>Bienvenue </h1>
        <h3>Inscrivez-vous</h3>
        <form action="" method="POST" >
            <table>
                
            <tr>
                    <td>
                        <label> Nom: </label>
                    </td>
                    <td>
                        <input type="text"  name="nom" value="<?php if(isset($nom)) { echo $nom; } ?>" />
                    </td>

                </tr>
                <tr>
                    <td>
                        <label> Prenom: </label>
                    </td>
                    <td>
                        <input type="text"  name="prenom" value="<?php if(isset($prenom)) { echo $prenom; } ?>" />
                    </td>

                </tr>
                <tr>
                    <td>
                        <label> Username: </label>
                    </td>
                    <td>
                        <input type="text"  name="username" value="<?php if(isset($username)) { echo $username; } ?>" />
                    </td>

                </tr>


                <tr>
                    <td>
                        <label> Votre Email: </label>
                    </td>
                    <td>
                        <input type="email" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />
                    </td>
                </tr>  

                
                <tr>
                    <td>
                        <label> Confirmez votre Email: </label>
                    </td>
                    <td>
                        <input type="email"  name="mail2" />
                    </td>
                </tr>  

                <tr>
                    
                    <td>
                        <label> Mot de passe: </label>
                    </td>
                    <td>
                        <input type="password"  name="password" />
                    </td>

                </tr>


                <tr>
                    <td>
                        <label> Confirmez votre mot de passe: </label>
                    </td>
                    <td>
                        <input type="password"  name="password_confirm" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <label> Choisissez votre question secrete: </label>
                    </td>
                    <td>
                        <select  name="question" >
                        <option>Le nom de votre superhero préféres ?</option>
                        <option>Le nom de votre Pays ?</option>
                        <option>Le nom de votre professeur préféré ? ?</option>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label> Réponse: </label>
                    </td>
                    <td>
                        <input type="text"  name="reponse" />
                    </td>
                </tr>
            </table>
                    <input type="submit" name="forminscription" class=inscrire value="S'inscrire"/>

         </form>
         <?php 
         if(isset($erreur))
         {
             echo $erreur;
         }
        ?>
        <?php 
         if(isset($msg))
         {
             echo $msg;
         }
        ?>
        <br>

        <a href ='page_connexion.php'>Déja un compte ? connecter-vous</a>
    </div>    
    </body>
</html>