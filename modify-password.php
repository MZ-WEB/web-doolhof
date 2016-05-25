<?php
require_once("includes/session.php");

if (isset ($_POST['envoi'])) {
  
  if (!empty($_POST['password']) && !empty($_POST['new_password']) && !empty($_POST['new_password_confirm'])) {
    $user_id = strtolower(htmlspecialchars($_SESSION['user_id']));
    $password = htmlspecialchars($_POST['password']);
    $new_password = htmlspecialchars($_POST['new_password']);
    $new_password_confirm = htmlspecialchars($_POST['new_password_confirm']);
   
    if ($new_password == $new_password_confirm) {
      connexion_bdd();
      $req = $bdd->prepare('SELECT password FROM users WHERE id = :id');
      $req->execute(array('id' => $_SESSION['user_id']));
      while ($donnees = $req->fetch())
        {
          $password_hash = $donnees['password'];
        }
      $req ->closeCursor();

      if (password_verify($password, $password_hash)) {
        //Ancien MDP OK
        //Hash New MDP
        $options = ['cost' => 14,
                                   ];
        $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT, $options);
        
        connexion_bdd();
        $req = $bdd->prepare('UPDATE users SET password = :password WHERE id = :id');
        $req->execute(array(
            'id' => $_SESSION['user_id'],
           'password' => $new_password_hash,
            ));               
        $req ->closeCursor();
        $fin_modification = true;

       } else {
          $error = '<div class="alert alert-danger" role="alert">Le mot de passse que vous avez entré ne correspond pas avec votre mot de passe actuel.</div>';
       }

    } else {
      $error = '<div class="alert alert-danger" role="alert">Les deux mots de passe ne correspondent pas.</div>';
    }
  
  } else {
      $error = '<div class="alert alert-danger" role="alert">Tous les champs ne sont pas remplis.</div>';
  }  
} //fin if isset envoi
$description = 'Sur cette page, je peux modifier mon mot de passe. C\'est facile et rapide';
$keywords = '';
$title = 'Modifier mon mot de passe';
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
  <meta charset="UTF-8">
    <?php require_once("includes/head.php"); ?>
  </head>
  <body>
    <div id="wrap">
    <div class="container">
      <?php include("includes/header.php"); ?>
    <?php include("includes/colonne-gauche.php"); ?>     
      <div class="row">
      <div class="col-md-3"></div>
      <h1><p class="text-center">Modifier mon mot de passe</p></h1>
      <div class="col-md-1"></div>
      <div class="col-lg-8"> 
      <div class="col-lg-offset-4">
      <p>&nbsp;</p>
           <?php 
            if(isset($error)) {
        echo $error; 
            }
        if(!isset($fin_modification)) {
      ?>         
                  <p>Pour changer le mot de passe de votre compte <?php echo user_id_to_email($_SESSION['user_id']) ?>, remplissez ce formulaire :</p>        
                  </div>
		   <form class="form-horizontal" method="post" role="form">
                      <div class="form-group form-group-lg">
                        <label class="col-sm-4 control-label" for="password">Mot de passe actuel</label>
                        <div class="input-group col-sm-8">
                          <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe actuel">
                        </div>
                      </div>
                      <div class="form-group form-group-lg">
                        <label for="password" class="col-sm-4 control-label">Nouveau mot de passe</label>
                        <div class="input-group col-sm-8">
                          <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Nouveau mot de passe">
                        </div>
                      </div>
                      <div class="form-group form-group-lg">
                        <label class="col-sm-4 control-label" for="password">Nouveau mot de passe (encore)</label>
                        <div class="input-group col-sm-8">
                          <input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm" placeholder="Confirmation du Mot de passe">
                        </div>
                      </div>
                      <input type="hidden"  name="envoi"  value="" />
                      <button type="submit" class="btn btn-primary btn-lg col-md-offset-4 col-md-8 col-xs-12">Modifier mon mot de passe</button>
                    </form>
                   <?php  
        } elseif(isset($fin_modification)) {
            echo '</div><div class="col-lg-offset-3 alert alert-success" role="alert"><p>Votre mot de passe a bien été modifié ! <a href="account.php">Cliquez ici</a> pour retourner à la page de gestion de votre compte.</p></div>';
        }
                    ?>
          </div>
         <div class="col-md-offset-3"></div>
      </div>      
    <?php include("includes/bas-page.php"); ?>
    <?php include("includes/colonne-droite.php"); ?>
    <?php include("includes/footer.php"); ?>
  </body>
</html>

