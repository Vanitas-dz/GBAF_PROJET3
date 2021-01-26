<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=login', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if(isset($_SESSION['id'])) // savoir si une variable existe
{
    $requser = $bdd->prepare("SELECT * FROM membres WHERE id_user = ?"); // recuperer tous les info de l'user en fonction de session id
    $requser->execute(array($_SESSION['id']));
    $user = $requser->fetch();
    
    if (isset($_POST['newnom']) AND !empty($_POST['newnom']) AND $_POST['newnom'] != $user['nom'])
    {
        $newnom = htmlspecialchars($_POST['newnom']);
        $insertnom = $bdd->prepare('UPDATE membres SET nom = ? WHERE id_user = ?');
        $insertnom->execute(array($newnom, $_SESSION['id']));
        header('Location: page_accueil.php?id=' . $_SESSION['id']);
    }

    if (isset($_POST['newprenom']) AND !empty($_POST['newprenom']) AND $_POST['newprenom'] != $user['prenom'])
    {
        $newprenom = htmlspecialchars($_POST['newprenom']);
        $insertprenom = $bdd->prepare('UPDATE membres SET prenom = ? WHERE id_user = ?');
        $insertprenom->execute(array($newprenom, $_SESSION['id']));
        header('Location: page_accueil.php?id=' . $_SESSION['id']);
    }

    if (isset($_POST['newusername']) AND !empty($_POST['newusername']) AND $_POST['newusername'] != $user['username'])
    {
        $newusername = htmlspecialchars($_POST['newusername']);
        
        $insertusername = $bdd->prepare('UPDATE membres SET username = ? WHERE id_user = ?');
        $insertusername->execute(array($newusername, $_SESSION['id']));
        header('Location: page_accueil.php?id=' . $_SESSION['id']);
    }

    if (isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail'])
    {
        $newmail = htmlspecialchars($_POST['newmail']);
        if(filter_var($newmail, FILTER_VALIDATE_EMAIL))
        {
            $insertmail = $bdd->prepare("UPDATE  membres SET mail = ? WHERE id_user = ? ");
            $insertmail->execute(array($newmail, $_SESSION['id'] ));
            $mailexist = $insertmail->rowCount();
            header('Location: page_accueil.php?id=' . $_SESSION['id']);
            
        }
        else
        {
            $alert = "Votre adresse mail n'est pas valide !";
        }
    }
    
    if (isset($_POST['newquestion']) AND !empty($_POST['newquestion']) AND $_POST['newquestion'] != $user['question'])
    {
        $newquestion = htmlspecialchars($_POST['newquestion']);
        $insertquestion = $bdd->prepare('UPDATE membres SET question = ? WHERE id_user = ?');
        $insertquestion->execute(array($newquestion, $_SESSION['id']));
        header('Location: page_accueil.php?id=' . $_SESSION['id']);
    }
    if (isset($_POST['newreponse']) AND !empty($_POST['newreponse']) AND $_POST['newreponse'] != $user['reponse'])
    { 
        $newreponse = htmlspecialchars($_POST['newreponse']);
        $insertprenom = $bdd->prepare('UPDATE membres SET reponse= ? WHERE id_user = ?');
        $insertprenom->execute(array($newreponse, $_SESSION['id']));
        header('Location: page_accueil.php?id=' . $_SESSION['id']);
    }
    if (isset($_POST['newpassword']) AND !empty($_POST['newpassword']) AND  isset($_POST['newpassword_confirm']) AND !empty($_POST['newpassword_confirm']))
    {
        $newpassword = htmlspecialchars($_POST['newpassword']);
        $newpassword_confirm = htmlspecialchars($_POST['newpassword_confirm']);
        if($newpassword == $newpassword_confirm)

        {
            $pass_hash = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
            $pass_hash2 = password_hash($_POST['newpassword_confirm'], PASSWORD_DEFAULT);
            $req = $bdd->prepare('UPDATE membres SET motdepasse = ? WHERE id_user = ?');
            $req->execute(array($pass_hash, $_SESSION['id'] ));
            header('Location: page_accueil.php?id=' . $_SESSION['id']);
        }
        else
        {
            $erreur = ' Vos mot de passe ne correspondent pas';
        }
    }
    if (isset($_POST['newnom']) AND $_POST['newnom'] == $user['nom'])
    {
        header('Location: page_accueil.php?id=' . $_SESSION['id']);
    }

   
?>



 
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil</title>
        <link rel="stylesheet" href="../css/style_modif_profil.css">
    </head>

    <body>
        <div class= block_modif>
        <img src ="../img/gbaf.png" alt='image'>
        
        <h1>Edition du profil</h1>
        <form action="" method="POST" enctype="multipart/form-data">
        <table>
                
                    <tr>
                        <td>
                            <label> Veuillez entrée votre nouveau nom: </label>
                        </td>
                        <td>
                            <input type="text"  name="newnom" value="<?php echo $user['nom']; ?>"  />
                        </td>
    
                    </tr>

                    <tr>
                        <td>
                            <label> Veuillez entrée votre nouveau prenom: </label>
                        </td>
                        <td>
                            <input type="text"  name="newprenom" value="<?php echo $user['prenom']; ?>" />
                        </td>
    
                    </tr>

                    <tr>
                        <td>
                            <label> Veuillez entrée votre nouveau username:  </label>
                        </td>
                        <td>
                            <input type="text"  name="newusername" value="<?php echo $user['username']; ?>" />
                        </td>
    
                    </tr>
    
    
                    <tr>
                        <td>
                            <label> Veuillez entrée votre nouveau Email: </label>
                        </td>
                        <td>
                            <input type="email" name="newmail" value="<?php echo $user['mail']; ?>" />
                        </td>
                    </tr>

                    <tr>
                        
                        <td>
                            <label> Veuillez entrée votre nouveau Mot de passe: </label>
                        </td>
                        <td>
                            <input type="password"  name="newpassword" />
                        </td>
    
                    </tr>
    
    
                    <tr>
                        <td>
                            <label> Veuillez confirmez votre nouveau mot de passe: </label>
                        </td>
                        <td>
                            <input type="password"  name="newpassword_confirm" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label> Choisissez votre nouvel question secrete: </label>
                        </td>
                        <td>
                            <select  name="newquestion" >
                            <option>Le nom de votre superhero préféres ?</option>
                            <option>Le nom de votre Pays ?</option>
                            <option>Le nom de votre professeur préféré ? ?</option>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label> Veuillez entrée votre nouvel réponse: </label>
                        </td>
                        <td>
                            <input type="text"  name="newreponse" />
                        </td>
                    </tr>
                </table>
                        <input type="submit" name="newprofil"  class = "ajour" value="Mettre à jour mon profil"/>
        
        
        </form>
        <?php 
            if (isset($alert)) 
            {
               echo $alert;
            }
        ?>    
    </div>   
    </body>
    </html>
    <?php
    }
    else
    {
        header("location: page_connexion.php");
    }
    
    ?>