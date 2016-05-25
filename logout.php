<?php
require_once("includes/session.php");
setcookie(session_name(),session_id(),time()-3600);
session_destroy();
$description = 'Page de déconnexion du site.';
$keywords = 'contact';
$title = 'Déconnexion';
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
      	<div class="col-lg-6">
          	<h1><p class="text-center">Déconnexion</p></h1>
          	<p>&nbsp;</p>
		    <div class="alert alert-success" role="alert"><p class="text-center">Voilà, vous êtes bien déconnecté ! </p>
            <p class="text-center">A bientôt !</p></div>
       	 </div>
         <div class="col-md-offset-3"></div>
      </div>       
		<?php include("includes/bas-page.php"); ?>
        <?php include("includes/colonne-droite.php"); ?>
        <?php include("includes/footer.php"); ?>
  </body>
</html>
