<?php
require_once("includes/session.php");
$description = 'Accueil';
$keywords = 'accueil';
$title = 'Accueil';
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
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <h1><p class="text-center">Accueil</p></h1>
            <p>&nbsp;</p>
            <p class="text-center">Bienvenue dans l'espace de gestion de votre compte Doolhof !</p>
            <p>&nbsp;</p>
            <p class="text-center"><a href="account.php" class="btn btn-lg btn-default">Gérer mon compte</a> <a href="stats.php" class="btn btn-lg btn-default">Mes statistiques</a></p>
            <p>&nbsp;</p>
            <hr>
            <p>&nbsp;</p>
        <div class="col-lg-4">
          <div class="panel panel-primary">
            <div class="panel-body">
              <h2>Etat du jeu</h2>
              <p>Serveur de jeu : <span class="label label-success">Fonctionnel</span></p>
              <p>Liaison serveur/joueurs : <span class="label label-success">Fonctionnelle</span></p>
              <p>Alerte en cours : <span class="label label-success">Aucune alerte en cours</span></p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="panel panel-primary">
            <div class="panel-body">
              <h2>LeaderBoard</h2>
                <?php
                $rank = 1;
                connexion_bdd();
                //On demande les trois plus gros scores, avec les pseudos correspondant
                $req = $bdd->query('SELECT name, points FROM users ORDER BY points DESC LIMIT 0, 3');
                // Affichage des pseudos et des scores 
                while ($donnees = $req->fetch())
                  {
                    echo '<p>Rang '.$rank.' : <strong>'.htmlspecialchars($donnees['name']).'</strong> avec '.htmlspecialchars($donnees['points']).' points ! </p>';
                    $rank = $rank + 1;
                  }
                $req->closeCursor();
                ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="panel panel-primary">
            <div class="panel-body">
              <h2>Statistiques</h2>
              <p><b>2</b> joueurs connectés</p>
              <p><b><?php
                $rank = 1;
                connexion_bdd();
                //On demande les trois plus gros scores, avec les pseudos correspondant
                $req = $bdd->query('SELECT * FROM users');
                // Affichage des pseudos et des scores
                $req->execute(array('user_id' => 1));
                $total_players = $req -> rowCount();
                $req->closeCursor();
                echo $total_players;
		?></b> joueurs inscrits</p>
	      <p>Record de joueurs connectés : <b>5</b></p>
           </div>
          </div>
        </div>
        <div class="col-md-offset-3"></div>
      </div>
        <?php include("includes/bas-page.php"); ?>
        <?php include("includes/colonne-droite.php"); ?>
        <?php include("includes/footer.php"); ?>
  </body>
</html>


