<?php 
require_once("includes/session.php");
    if (isset ($_POST['envoi']))  
    {
        if ( !empty($_POST['name']) && !empty($_POST['password']))
          {
            $password = htmlspecialchars($_POST['password']);
            $name = strtolower(htmlspecialchars($_POST['name']));

                  connexion_bdd();
                  $req = $bdd->prepare('SELECT name, password FROM users WHERE name = :name');
                  $req->execute(array('name' => $name));
                    while ($donnees = $req->fetch())
                        {
                        if (isset($donnees['name']))
                          {
                            $name_exist = true;
                          }
                          $password_hash = $donnees['password'];
                        }
                    $req ->closeCursor();

                    if (isset($name_exist)) 
                    {
                      //Name existe
                      //Vérification mdp
                      if (password_verify($password, $password_hash))
                      {
                        //Mdp OK
                        $new_ip = $_SERVER['REMOTE_ADDR'];
                        $user_id = name_to_user_id($name);
                        $_SESSION['user_id'] = $user_id;
                        ip_update($user_id, $new_ip);
                        $connexion_success = true;
                        redirect_page_before_connexion();
                      }
                      else
                      {
                        $error = '<div class="alert alert-danger" role="alert">Mot de passe erroné.</div>';
                        $_SESSION['error_connexion'] = true;
                      }

                    }
                    else
                    {
                      $error = '<div class="alert alert-danger" role="alert">Ce pseudo n\'est pas utilisé</div>';
                      $_SESSION['error_connexion'] = true;
                    }
          }
          else
          {
            $error = '<div class="alert alert-danger" role="alert">Tous les champs ne sont pas remplis.</div>';
            $_SESSION['error_connexion'] = true;
          }
    }
if (isset($_SESSION['name']) && !isset($connexion_success)) 
{
  header('location: https://doolhof.mz-web.fr');
}
$description = 'Connexion';
$keywords = 'compte, connexion seedbox';
$title = 'Connexion';
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
<?php
      if (isset($connexion_success)) {
        ?>
            <h1><p class="text-center">Connexion</p></h1>
        <div class="col-md-1"></div>
        <div class="col-lg-8">
          	<p>&nbsp;</p>
	        <div class="col-lg-offset-3 alert alert-success" role="alert"><p class="text-center">Vous êtes bien connecté ! Vous allez être redirigé automatiquement vers la page que vous visitiez auparavant d'ici 5 secondes. S'il ne se passe rien <a href="/">cliquez ici</a>.</p></div></div>
            <div class="col-md-offset-3"></div>
<?php 
      } else {
?>
      <h1><p class="text-center">Connexion</p></h1>
      <div class="col-md-1"></div>
      <div class="col-lg-8">
      <p>&nbsp;</p>
        <div class="col-lg-offset-4"><p>Connectez-vous pour accéder à l'espace de gestion de votre compte.</p>
      <p>&nbsp;</p>
      <?php   
      if(isset($error))
        {
        echo $error; 
        }
      ?>
        </div>     
        <form class="form-horizontal" method="post" role="form">
          <div class="form-group form-group-lg">
             <label class="col-sm-4 control-label" for="name">Nom d'utilisateur</label>
            <div class="input-group col-sm-8">
              <input type="text" class="form-control" id="name" name="name" placeholder="Nom d'utilisateur">
            </div>
           </div>
           <div class="form-group form-group-lg">
            <label for="password" class="col-sm-4 control-label">Mot de passe</label>
             <div class="input-group col-sm-8">
               <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe">
            </div>
           </div>
          <input type="hidden"  name="envoi"  value="" />
          <button type="submit" class="btn btn-primary btn-lg col-md-offset-4 col-md-8 col-xs-12">Connexion</button>
         </form>
        <div class="col-lg-offset-4">
            <p class="text-center"><a href="lost-password.php">Mot de passe oublié</a></p>
            <p>&nbsp;</p>
            <hr>
            <p class="text-center"><b>Pas de compte ?</b></p>
            <p class="text-center"><a href="register.php" class="col-xs-12 btn btn-lg btn-primary">Je m'inscris en 20 secondes !</a></p>
            <p>&nbsp;</p>
	          <p>&nbsp;</p>
        </div>
        </div>
        <div class="col-md-offset-3"></div>
         <?php 
        } //fin else !connexion_success
        ?>
      </div>       
    <?php include("includes/bas-page.php"); ?>
    <?php include("includes/colonne-droite.php"); ?>
    <?php include("includes/footer.php"); ?>
  </body>
</html>
