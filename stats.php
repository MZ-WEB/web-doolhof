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
            <h3>Statistiques du compte <?php echo user_id_to_name($_SESSION['user_id']); ?> :</h3>
            <ul>
                <li>
                    <p>Temps de jeu : <?php echo convert_seconds(user_id_to_time_spent($_SESSION['user_id'])); ?></p>
                </li>
                <li>
                    <p>Points gagnés : <?php echo user_id_to_points($_SESSION['user_id']); ?></p>
                </li>
                <li>
                    <p>Niveau actuel : <?php echo user_id_to_last_level($_SESSION['user_id']); ?></p>
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


