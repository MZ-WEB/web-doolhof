<?php
require_once("includes/session.php");

if (isset ($_POST['envoi'])) {
       
    if (!empty($_POST['email'])) {
        $email = strtolower(htmlspecialchars($_POST['email']));
        connexion_bdd();
        $req = $bdd->prepare('SELECT email FROM users WHERE email = :email');
        $req->execute(array('email' => $email));       
            while ($donnees = $req->fetch())
                {
                  if (isset($donnees['email'])){
                    $utilisateur_existe = true;
                    $mail = $donnees['email'];       
                  }
                }
                $req ->closeCursor();
                if (isset($utilisateur_existe)) {
                    $reset_code = sha1(openssl_random_pseudo_bytes(30));
                    $req2 = $bdd->prepare('UPDATE users SET reset_code = :reset_code, date_reset_request = NOW() WHERE email = :email');
                            $req2->execute(array(
                                'reset_code' => $reset_code,
                                'email' => $email,
                                ));               
                    $req2 ->closeCursor();

                    //Envoi mail
                    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bugs.
                      {
                        $passage_ligne = "\r\n";
                      }
                    else
                      {
                        $passage_ligne = "\n";
                      }
                    //=====Déclaration des messages au format texte et au format HTML.
                    $message_txt = 'Bonjour, '.$passage_ligne.'
Vous venez de demander à changer le mot de passe de votre compte '.$email.'. '.$passage_ligne.'
Si vous n\'avez jamais demandé cela, ne tenez pas compte de cet Email et supprimez-le.'.$passage_ligne.'
Si c\'est bien vous, cliquez ici : https://doolhof.mz-web.fr/reset-password.php?email='.$email.'&code='.$reset_code.' (parfois, le lien ne marche pas, dans ce cas, vous devez copier-coller le lien dans la barre de recherche d\'url de votre navigateur.)'.$passage_ligne.'
Cordialement,'.$passage_ligne.'
L\'équipe Doolhof';
                    $message_html = '<p>Bonjour,</p>
                    <p>Vous venez de demander à changer le mot de passe de votre compte '.$email.'.</p>
                    <p>Si vous n\'avez jamais demandé cela, ne tenez pas compte de cet Email et supprimez-le.</p>

                    <p>Si c\'est bien vous, cliquez ici : <a href="https://doolhof.mz-web.fr/reset-password.php?email='.$email.'&code='.$reset_code.'">https://doolhof.mz-web.fr/reset-password.php?email='.$email.'&code='.$reset_code.'</a> (parfois, le lien ne marche pas, dans ce cas, vous devez copier-coller le lien dans la barre de recherche d\'url de votre navigateur.)</p>

                    <p>Cordialement,</p>
                    <p>L\'équipe Doolhof</p></body></html>';
                    //==========

                    //=====Création de la boundary
                    $boundary = "-----=".md5(rand());
                    //==========

                    //=====Définition du sujet.
                    $sujet = "Doolhof - Mot de passe oublié";
                    //=========

                    //=====Création du header de l'e-mail.
                    $header = "From: \"Contact - Doolhof\"<contact@doolhof.mz-web.fr>".$passage_ligne;
                    $header.= "MIME-Version: 1.0".$passage_ligne;
                    $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
                    //==========

                    //=====Création du message.
                    $message = $passage_ligne."--".$boundary.$passage_ligne;
                    //=====Ajout du message au format texte.
                    $message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
                    $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
                    $message.= $passage_ligne.$message_txt.$passage_ligne;
                    //==========
                    $message.= $passage_ligne."--".$boundary.$passage_ligne;
                    //=====Ajout du message au format HTML
                    $message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
                    $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
                    $message.= $passage_ligne.$message_html.$passage_ligne;
                    //==========
                    $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
                    $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
                    //==========
 
                    //=====Envoi de l'e-mail.
                    mail($mail,$sujet,$message,$header);

                    $fin_demande_reset = true;
                    //==========

                  } else {
                    $error = '<div class="alert alert-danger" role="alert">Il semble que ce nom d\'utilisateur ('.$email.') ne soit pas utilisé. Peut-être avez-vous fait une faute de frappe ?</div>';
                  }            
    } else {
        $error = '<div class="alert alert-danger" role="alert">Tous les champs ne sont pas remplis.</div>';
    }

} //fin if isset envoi

$description = 'Mot de passe oublié ? Sur cette page vous pourrez rénitialiser votre mot de passe et ainsi avoir de nouveau accès à votre compte.';
$keywords = 'mot de passe';
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
      <div class="col-lg-offset-3"><div class="col-xs-offset-2"><h1>Mot de passe oublié ?</h1></div></div>
      <div class="col-md-1"></div>
      <div class="col-lg-8"> 
      <p>&nbsp;</p>
           <?php 
            if(!isset($fin_demande_reset))
                { 
          ?>
                  <div class="col-lg-offset-4"><p>Vous avez oublié votre mot de passe ? Remplissez ce court formulaire pour le récupérer.</p>
                  <p>&nbsp;</p>
      <?php     }

            if(isset($error)) {
        echo $error; 
            }
        if(!isset($fin_demande_reset)) {
      ?>      
                  </div>     
                    <form class="form-horizontal" method="post" role="form">
                        <div class="form-group form-group-lg">
                            <label class="col-sm-4 control-label" for="email">Email</label>
                            <div class="input-group col-sm-8">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                        </div>
                      <input type="hidden"  name="envoi"  value="" />
                      <button type="submit" class="btn btn-primary btn-lg col-md-offset-4 col-md-8 col-xs-12">Rénitialiser mon mot de passe</button>
                    </form>
		    <p>&nbsp;</p>
                    <div class="col-lg-offset-4"><p class="text-muted">Si vous souhaitez juste modifier votre mot de passe ou modifier un des paramètres de votre compte, allez sur cette page : <a href="account.php">Gestion du Compte</a></p>
                    </div>
                   <?php  
        } else {
            echo '<div class="col-lg-offset-3 alert alert-success" role="alert"><p>Un Email contenant un lien de rénitialisation de votre mot de passe vient de vous être envoyé sur l\'adresse Email de récupération que vous aviez renseignée lors de votre inscription. Ce lien est valable 12 heures, passé ce délai, il faudra refaire une demande.<br />Regardez bien votre boîte Email, il se peut que cet Email ait été stocké dans le dossier spams.</p></div>';
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
