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
  		<div class="col-md-2"></div>
      	<div class="col-lg-8">
          	<h1><p class="text-center">Gestion du compte</p></h1>
          	<p>&nbsp;</p>
            <h3>Informations du compte:</h3>
            <ul>
                <li>
                    <p>Pseudo : <?php echo user_id_to_name($_SESSION['user_id']); ?> <a href="modify-name.php" class="btn btn-default">Modifier mon pseudo</a></p>
                </li>
                <li>
                    <p>Email : <?php echo user_id_to_email($_SESSION['user_id']); ?> <a href="modify-email.php" class="btn btn-default">Modifier mon adresse Email</a></p>
                </li>
                <li>
                    <p>Mot de passe : Protégé <a href="modify-password.php" class="btn btn-default">Modifier mon mot de passe</a></p>
                </li>
            </ul>
       	</div>
        <div class="col-md-offset-3"></div>
      </div>
		<?php include("includes/bas-page.php"); ?>
        <?php include("includes/colonne-droite.php"); ?>
        <?php include("includes/footer.php"); ?>
  </body>
</html>


