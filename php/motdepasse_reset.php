<?php
$bdd = new PDO('mysql:host=localhost;dbname=login', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if (isset($_POST['valider']) AND isset($_POST['username'])){
    
    if (!empty($_POST['username'])){
        
        $username = htmlspecialchars($_POST['username']);
        $requete_User = $bdd->prepare("SELECT username, question, reponse FROM membres WHERE username = ?");
        $requete_User->execute(array($_POST['username']));
        $req = $requete_User->fetch();
        $question = $req['question'];
    }
    else{
        
        $erreur = 'Remplir le champ';
    }
}

if (isset($_POST['valider']) AND isset($_POST['reponse'])){
    
    if (!empty($_POST['reponse'])){
        
        $req = $bdd->prepare('SELECT * FROM membres WHERE username = ?');
        $req->execute(array($_POST['username']));
        $reponse = $req->fetch();
        
        if (trim($_POST['reponse']) === $reponse['reponse']) {
            $reponsetrue = true;
        
        }
        else{
            $erreur = 'la réponse est incorrect';
        }
    }
    else{
        
        $erreur = 'Remplir le champ';
    }
}

    

if (isset($_POST['newpassword']) AND !empty($_POST['newpassword']) AND  isset($_POST['newpassword_confirm']) AND !empty($_POST['newpassword_confirm']) AND isset($_POST['username'])){
        $newpassword = htmlspecialchars($_POST['newpassword']);
        $newpassword_confirm = htmlspecialchars($_POST['newpassword_confirm']);
        if($newpassword == $newpassword_confirm){
            
            $pass_hash = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
            $req = $bdd->prepare('UPDATE membres SET motdepasse = ? WHERE username = ?');
            $req->execute(array($pass_hash, $_POST['username']));
            header('Location: page_connexion.php');
        }
        else{
            
            $erreur = ' Vos mot de passe ne correspondent pas';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mot de passe oublié: Username</title>
        <link rel="stylesheet" href="../css/style_motdepasse_reset.css">
    </head>
    <body>
    <div class='block_page'>
    <img src ="../img/gbaf.png" alt='image'>
    
            <?php
            if (!isset($question)) {
            ?>  
                <form action="" method="POST">
                    <label>Entrée votre username : <input type="text" name="username"/></label>
                    <input type="submit" name ="valider" value="Valider">
                </form>
            <?php
            }
            ?>
        

      
            <?php
            if (isset($question) && !isset($reponsetrue)) {
            ?>
            <p><?php echo $question;?></p>
                <form action="" method="POST">
                    <label>Entrée reponse : <input type="text" name="reponse"/></label>
                    <input type="hidden" name="username" value="<?php echo $username ?>">
                    <input type="submit" name ="valider" value="Valider">
                </form>
            <?php
            }
            ?>
        

        
            <?php
            if (isset($reponsetrue)) {
            ?>
            <form action="" method="POST">
                <table>
                    <tr>
                        <td>
                            <label> Veuillez entrée votre nouveau Mot de passe: </label>
                        </td>
                        <td>
                            <input type="password"  name="newpassword" />
                            <input type="hidden" name="username" value="<?php echo $username ?>">
                        </td>
                    </tr>
                    <table>
                    <tr>
                        <td>
                            <label> Veuillez confimer votre nouveau Mot de passe: </label>
                        </td>
                        <td>
                            <input type="password"  name="newpassword_confirm" />
                        </td>
                    </tr>
                    <tr>
                    <td><input type="submit" name="valider" value="Valider"/></td>
                    </tr>
                </table>
                
            </form>
            <?php           
            }       
            ?>

        <?php
        if(isset($erreur))
        {
            echo $erreur;
        }
        ?>
        <br>
        <a href="page_connexion.php">Retour a la page de connexion</a>
        </div>
      
      </body>
</html>