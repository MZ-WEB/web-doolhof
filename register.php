<?php 
    require_once("includes/session.php");
     if (isset ($_POST['envoi']))  
      {
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm']))
          {
            $password = htmlspecialchars($_POST['password']);
            $password_confirm = htmlspecialchars($_POST['password_confirm']);
            $email = strtolower(htmlspecialchars($_POST['email']));
            $name = strtolower(htmlspecialchars($_POST['name']));
            
            if (preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email))
            {
                //Email OK
                //Verification disponibilité email
                //Connexion Bdd
                connexion_bdd();
                $req = $bdd->prepare('SELECT email FROM users WHERE email = :email');
                $req->execute(array('email' => $email));
                    while ($donnees = $req->fetch())
                        {
                        if (isset($donnees['email']))
                          {
                            $email_exist = true;
                          }
                        }
                    $req ->closeCursor();

                    if (!isset($email_exist)) 
                    {
                      //Email pas utilisee : ok
                      //Vérification disponibilité pseudo
                      //Connexion Bdd
                      connexion_bdd();
                      $req = $bdd->prepare('SELECT name FROM users WHERE name = :name');
                      $req->execute(array('name' => $name));
                        while ($donnees = $req->fetch())
                          {
                            if (isset($donnees['name']))
                            {
                              $name_exist = true;
                            }
                          }
                      $req ->closeCursor();

                        if (!isset($name_exist))
                        {
                            //Vérification mdp
                            if ($password == $password_confirm)
                            {

                                //Mdp OK
                                //Hash du mot de passe pour Bdd
                                $options = ['cost' => 14];
                                $password_hash = password_hash("$password", PASSWORD_BCRYPT, $options);

                                //Génération du token unique
                                $is_secure = false;
                                while (!$is_secure)
                                {
                                  $random = openssl_random_pseudo_bytes(32, $is_secure);
                                  $token = bin2hex($random);
                                }

                                $req = $bdd->prepare('SELECT token FROM users WHERE token = :token');
                                $req->execute(array('token' => $token));
                                while ($donnees = $req->fetch())
                                {
                                  if (isset($donnees['token']))
                                  {
                                    $token_used = true;
                                  }
                                }
                                $req ->closeCursor();

                                  if (!isset($token_used))
                                  {
                                    //Tout est OK, on ajoute tout dans la bdd
                                    $ip_registration = $_SERVER['REMOTE_ADDR'];
                                    $ip_last_connexion = $_SERVER['REMOTE_ADDR'];

                                    connexion_bdd();
                                    //Code de debug à ajouter en cas de souci : $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $req = $bdd->prepare('INSERT INTO users (name, email, password, token, date_registration, date_last_connexion, ip_registration, ip_last_connexion) VALUES(:name, :email, :password, :token, NOW(), NOW(), :ip_registration, :ip_last_connexion)');
                                    $req->execute(array(
                                        'name' => $name,
                                        'email' => $email,
                                        'password' => $password_hash,
                'token' => $token,
                                        'ip_registration' => $ip_registration,
                                        'ip_last_connexion' => $ip_last_connexion,
                                        ));
                                    $req ->closeCursor();

                                   //Envoi mail une fois l'inscription effectuée.

                                    $id = name_to_user_id($name);
                                    $_SESSION['user_id'] = $id;
                                    $fin_inscription = true;
                                    send_mail('new_account', $email, $name);
                                    redirect_page_before_connexion();
                                  }
                                  else
                                  {
                                    $error = '<div class="alert alert-danger" role="alert">Quelque chose s\'est mal passé ! Veuillez ré-essayer de vous inscrire.</div>';
                                  }
                              }
                              else
                              {
                              $error = '<div class="alert alert-danger" role="alert">Les deux mots de passe ne correspondent pas.</div>';
                              }
                          }
                          else
                          {
                            $error = '<div class="alert alert-danger" role="alert">Ce pseudo est déjà utilisé.</div>';
                          }
                    }
                    else
                    {
                      $error = '<div class="alert alert-danger" role="alert">Cette adresse Email est déjà utilisée.</div>';
                    }
                  
                }
            else
                {   
                  $error = '<div class="alert alert-danger" role="alert">L\'adresse Email n\'est pas conforme. Si le problème persiste, contactez nous.</div>';
                }
          }
          else
          {
            $error = '<div class="alert alert-danger" role="alert">Tous les champs ne sont pas remplis.</div>';
          }
    }
if (isset($_SESSION['email']) && !isset($fin_inscription)) 
{
  header('location: https://doolhof.mz-web.fr');
}
$description = 'Inscription - Inscrivez-vous';
$keywords = 'Inscription';
$title = 'Inscription';
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
            <h1><p class="text-center">Inscription</p></h1>
                  <div class="col-md-1"></div>
      <div class="col-lg-8">
      <p>&nbsp;</p>
           <?php if(!isset($fin_inscription))
              { ?>
              <div class="col-lg-offset-4"><p class="text-center">Remplissez le court formulaire suivant pour vous inscrire.</p>
                    <p>&nbsp;</p>
      <?php   }
      if(isset($error))
        {
        echo $error; 
        }
      if(!isset($fin_inscription))
        {
            ?>      </div>     
                    <form class="form-horizontal" method="post" role="form">
                      <div class="form-group form-group-lg">
                        <label class="col-sm-4 control-label" for="name">Pseudo</label>
                        <div class="input-group col-sm-8">
                          <input type="text" class="form-control" id="name" name="name" placeholder="Pseudo">
                        </div>
                      </div>
                      <div class="form-group form-group-lg">
                        <label class="col-sm-4 control-label" for="email">Adresse Email</label>
                        <div class="input-group col-sm-8">
                          <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                        </div>
                      </div>
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
                      <button type="submit" class="btn btn-primary btn-lg col-md-offset-4 col-md-8 col-xs-12">Je m'inscris</button>
                        <p class="help-block col-md-offset-4">En m'inscrivant, j'accepte les Conditions Générales d'Utilisation</a>.</p>
                    </form>
                    <div class="col-md-offset-4">
                    <p>&nbsp;</p>
                    <hr>
                    <p class="text-center"><b>Déjà inscrit ?</b></p>
                    <p class="text-center"><a href="login.php" class="col-xs-12 btn btn-lg btn-primary">Connexion</a></p>
                    </div>
                   <?php  }
                        else
                          {
                            echo '<div class="col-lg-offset-3 alert alert-success" role="alert"><p class="text-center">Inscription terminée ! Vous allez être redirigé automatiquement vers la page que vous visitiez auparavant d\'ici 5 secondes. S\'il ne se passe rien <a href="/espace-client/">cliquez ici</a>.</p></div>';
                            } ?>
         </div>
         <div class="col-md-offset-3"></div>
      </div>       
    <?php include("includes/bas-page.php"); ?>
        <?php include("includes/colonne-droite.php"); ?>
        <?php include("includes/footer.php"); ?>
  </body>
</html>

