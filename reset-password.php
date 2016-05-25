<?php
require_once("includes/session.php");

if (isset ($_POST['envoi'])) {
  
  if (!empty($_GET['email']) &&  !empty($_GET['code']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
    $email = strtolower(htmlspecialchars($_GET['email']));
    $password = htmlspecialchars($_POST['password']);
    $password_confirm = htmlspecialchars($_POST['password_confirm']);
    $code = htmlspecialchars($_GET['code']);
    
    if ($password == $password_confirm && !preg_match("# #", $password)) {
      connexion_bdd();
      $req = $bdd->prepare('SELECT email, reset_code, date_reset_request FROM users WHERE email = :email');
      $req->execute(array('email' => $email));
      while ($donnees = $req->fetch())
        {
          if (!empty($donnees['email']))
          {
            $utilisateur_existe = true;
          }
        $reset_code = $donnees['reset_code'];
	    $date_demande_reset = $donnees['date_reset_request'];
        }
      $req ->closeCursor();
      
      if (isset($utilisateur_existe)) {
        
        if ($reset_code == $code) {

          if ((strtotime("now") - 43200) <= strtotime($date_demande_reset)) {
            //Hash MDP
            $options = ['cost' => 14,
                                      ];
            $password_hash = password_hash("$password", PASSWORD_BCRYPT, $options);

            $reset_code = NULL;

            connexion_bdd();
            $req = $bdd->prepare('UPDATE users SET reset_code = :reset_code, password = :password WHERE email = :email');
            $req->execute(array(
                'email' => $email,
                'reset_code' => $reset_code,
                'password' => $password_hash,
                ));               
            $req ->closeCursor();

            $fin_demande_reset = true;

            } else {
                $error = '<div class="alert alert-danger" role="alert">La demande de changement de mot de passe n\'est plus valable.</div>';
            }

        } else {
            $error = '<div class="alert alert-danger" role="alert">La demande de changement de mot de passe n\'est plus valable !</div>';
        }

      } else {
          $error = '<div class="alert alert-danger" role="alert">Le compte dont vous souhaitez changer le mot de passe n\'existe pas.</div>';
      }

    } else {
      $error = '<div class="alert alert-danger" role="alert">Les deux mots de passe ne correspondent pas.</div>';
    }
  
  } else {
      $error = '<div class="alert alert-danger" role="alert">Tous les champs ne sont pas remplis.</div>';
  }  
} //fin if isset envoi
$description = 'Mot de passe oubié ? Sur cette page vous pourrez rénitialiser votre mot de passe et ainsi avoir de nouveau accès à votre compte.';
$keywords = '';
$title = 'Mot de passe oublié ?';
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
      <div class="col-lg-offset-2"><div class="col-xs-offset-2"><h1>Rénitialiser mon mot de passe</h1></div></div>
      <div class="col-md-1"></div>
      <div class="col-lg-8"> 
      <p>&nbsp;</p>
           <?php 
            if(empty($_GET['email']) || empty($_GET['code']))
                {
          ?>
                  <div class="col-lg-offset-4"><p>Bizarre, vous ne devriez pas être là... Si vous voulez modifier un des paramètres de votre compte, allez sur cette page : <a href="account.php">Gestion du Compte</a>.</p>
      <?php     }

            if(isset($error)) {
        echo $error;
            }
        if(!isset($fin_demande_reset) && isset($_GET['email'], $_GET['code'])) {
      ?>          
                  <div class="col-lg-offset-4"><p>Pour changer le mot de passe de votre compte, remplissez ce formulaire :</p>
                  </div>          
                    <form class="form-horizontal" method="post" role="form">
                      <div class="form-group form-group-lg">
                        <label for="password" class="col-sm-4 control-label">Mot de passe</label>
                        <div class="input-group col-sm-8">
                          <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
                        </div>
                      </div>
                      <div class="form-group form-group-lg">
                        <label class="col-sm-4 control-label" for="password">Mot de passe (encore)</label>
                        <div class="input-group col-sm-8">
                          <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirmation du Mot de passe">
                        </div>
                      </div>
                      <input type="hidden"  name="envoi"  value="" />
                      <button type="submit" class="btn btn-primary btn-lg col-md-offset-4 col-md-8 col-xs-12">Rénitialiser mon mot de passe</button>
                    </form>
                   <?php  
        } elseif(isset($fin_demande_reset)) {
            echo '<div class="col-lg-offset-3 alert alert-success" role="alert"><p>Votre mot de passe a bien été modifié ! Vous pouvez dès à présent aller sur la <a href="account.php" target="_blank">page de gestion de votre compte</a>.</p></div>';

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

