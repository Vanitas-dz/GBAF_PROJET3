<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=login;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

if(isset($_GET['t'],$_GET['id'], $_SESSION['id']) AND !empty($_GET['t']) AND !empty($_GET['id'])) {
    $getid = intval($_GET['id']);
    $gett = intval($_GET['t']);
    $check = $bdd->prepare('SELECT id FROM acteurs WHERE id = ?');
    $check->execute(array($getid));
    $check->fetch();

    if ($gett == 1) {
        $check_like= $bdd->prepare('SELECT * FROM likes WHERE id_acteurs = ? AND id_user= ?');
        $check_like->execute(array($getid, $_SESSION['id']));

        $del= $bdd->prepare('DELETE FROM dislikes WHERE id_acteurs = ? AND id_user= ?');
        $del->execute(array($getid, $_SESSION['id']));

    if ($check_like->fetch()){
        
        $del= $bdd->prepare('DELETE FROM likes WHERE id_acteurs = ? AND id_user= ?');
        $del->execute(array($getid, $_SESSION['id']));
    }else{
        $ins = $bdd->prepare('INSERT INTO likes (id_acteurs, id_user) VALUES (?,?)');
        $ins->execute(array($getid, $_SESSION['id']));
        
        
            
    }
        }elseif($gett == 2) {
            $check_like= $bdd->prepare('SELECT * FROM dislikes WHERE  id_acteurs = ? AND id_user= ?');
            $check_like->execute(array($getid, $_SESSION['id']));

            $del= $bdd->prepare('DELETE FROM likes WHERE id_acteurs = ? AND id_user= ?');
            $del->execute(array($getid, $_SESSION['id']));

        if ($check_like->fetch()){
            
            $del= $bdd->prepare('DELETE FROM dislikes WHERE id_acteurs = ? AND id_user= ?');
            $del->execute(array($getid, $_SESSION['id']));
        }else{
            $ins = $bdd->prepare('INSERT INTO dislikes (id_acteurs, id_user) VALUES (?,?)');
            $ins->execute(array($getid, $_SESSION['id']));
            
        }
    
    }
    
    
    header('Location: page_acteur.php?id='.$getid);
}   
?>

