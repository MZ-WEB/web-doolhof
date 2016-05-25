<?php
session_name('doolhof');
session_start();

require_once("includes/functions.php");
require_once("includes/functions_email.php");

$accueil = "";
$deconnexion = "";

verify_connexion();

//Pour que l'user_id soit égal au contenu de la variable $_SESSION['user_id']
  if (isset($_SESSION['user_id']))
  {
     $user_id = $_SESSION['user_id'];
  }

