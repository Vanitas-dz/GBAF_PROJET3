<?php
session_start();
// connexion base de donnée
$bdd = new PDO('mysql:host=localhost;dbname=login;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

// déclarrer les variables et pour savoir si aucune des variables sont vides
if(isset($_GET['t'],$_GET['id'], $_SESSION['id']) AND !empty($_GET['t']) AND !empty($_GET['id'])) {
    $getid = intval($_GET['id']); // pour etre sur que le type de variables est un  nombre
    $gett = intval($_GET['t']);
    $check = $bdd->prepare('SELECT id FROM acteurs WHERE id = ?'); // recuperer info acteurs
    $check->execute(array($getid));
    $check->fetch();

    if ($gett == 1) { 
        // pour savoir si ya deja un like
        $check_like= $bdd->prepare('SELECT * FROM likes WHERE id_acteurs = ? AND id_user= ?');
        $check_like->execute(array($getid, $_SESSION['id'])); 

        $del= $bdd->prepare('DELETE FROM dislikes WHERE id_acteurs = ? AND id_user= ?');
        $del->execute(array($getid, $_SESSION['id'])); // si ya un like, le dislikes est supprimer

    if ($check_like->fetch()){ // pour savoir si ya deja un like
        // si ya deja un like on re-clique sur likes pour enlever le like
        $del= $bdd->prepare('DELETE FROM likes WHERE id_acteurs = ? AND id_user= ?');
        $del->execute(array($getid, $_SESSION['id']));
    }else{
        $ins = $bdd->prepare('INSERT INTO likes (id_acteurs, id_user) VALUES (?,?)');
        $ins->execute(array($getid, $_SESSION['id'])); // liker l'acteur'
        
        
            
    }
        }elseif($gett == 2) {
            // pour savoir si ya deja un dislike
            $check_like= $bdd->prepare('SELECT * FROM dislikes WHERE  id_acteurs = ? AND id_user= ?');
            $check_like->execute(array($getid, $_SESSION['id']));

            $del= $bdd->prepare('DELETE FROM likes WHERE id_acteurs = ? AND id_user= ?');
            $del->execute(array($getid, $_SESSION['id'])); // si ya un dislike, le like est supprimer

        if ($check_like->fetch()){// pour savoir si ya deja un dislike
            // si ya deja un dislike on re-clique sur dislikes pour enlever le dislike
            $del= $bdd->prepare('DELETE FROM dislikes WHERE id_acteurs = ? AND id_user= ?');
            $del->execute(array($getid, $_SESSION['id']));
        }else{
            $ins = $bdd->prepare('INSERT INTO dislikes (id_acteurs, id_user) VALUES (?,?)');
            $ins->execute(array($getid, $_SESSION['id'])); // disliker l'acteur
            
        }
    
    }
    
    
    header('Location: page_acteur.php?id='.$getid);
}   
?>

