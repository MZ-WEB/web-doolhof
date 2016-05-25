<?php
require_once("includes/session.php");
$description = 'Gérez votre compte';
$keywords = 'compte';
$title = 'Gestion du compte';
//$nom de la page = 'class="active"';
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
          	<h1><p class="text-center">Gestion du compte</p></h1>
          	<p class="text-center"></p>
       	 </div>
         <div class="col-md-offset-3"></div>
      </div>
	<?php include("includes/bas-page.php"); ?>
        <?php include("includes/colonne-droite.php"); ?>
        <?php include("includes/footer.php"); ?>
  </body>
</html>


