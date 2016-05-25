<?php

function send_mail($subject, $user_email, $user_name)
{
global $end_date;
global $invoice;
global $product;
global $product_user;

$admin_email = "hello@doolhof.mz-web.fr";

if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $user_email)) // On filtre les serveurs qui rencontrent des bugs.
{
    $passage_ligne = "\r\n";
}
else
{
    $passage_ligne = "\n";
}

$head_email_txt = 'Bonjour '.$user_email.','.$passage_ligne;
$head_email_html = '<html><head></head><body><p>Bonjour '.$user_email.',</p>';

$footer_email_txt = $passage_ligne.'Cordialement,'.$passage_ligne.'
L\'équipe Doolhof'.$passage_ligne.'
ps : si vous avez la moindre question, n\'hésitez pas à répondre à cet Email !';

$footer_email_html = '<p>Bon jeu !</p>
<p>L\'équipe de Doolhof</p>
<p>ps : si vous avez la moindre question, n\'hésitez pas à répondre à cet Email !</p></body></html>';
    
switch ($subject) 
{ 
    case "new_account": 
    
$subject = "Bienvenue sur Doolhof !";

$message_txt = $head_email_txt.'
Votre compte sur Doolhof a bien été créé !'.$passage_ligne.'
Vous pouvez désormais vous connecter sur notre super jeu.'.$passage_ligne.'
Identifiant : '.$user_name.'
Mot de passe : pour des raisons de sécurité, votre mot de passe ne vous sera jamais envoyé par mail. En cas d\'oubli de celui-ci, une section “Mot de passe oublié” se trouve sur notre site.'.$passage_ligne.'
Pour bien débuter, vous pouvez aller lire notre foire aux questions et même faire un tour sur notre forum ! Vous pourrez ainsi rentrer en contact avec la communauté. '.$passage_ligne.$footer_email_txt;

$message_html = $head_email_html.'
<p>Votre compte sur Doolhof a bien été créé !<br />
Vous pouvez désormais jouer à notre super jeu, et à vous connecter au site web.</p>

<p>Identifiant : '.$user_email.'<br />
Mot de passe : pour des raisons de sécurité, votre mot de passe ne vous sera jamais envoyé par mail. En cas d\'oubli de celui-ci, une section “Mot de passe oublié” se trouve sur notre site.</p>
                    
<p>Pour bien débuter, vous pouvez aller lire notre <a href="https://doolhof.mz-web.fr/foire-aux-questions/">foire aux questions</a> <a href="https://doolhof.mz-web.fr/documentation/">notre documentation</a> et même faire un tour sur notre <a href="https://doolhof.mz-web.fr/forum/">forum</a> ! Vous pourrez ainsi rentrer en contact avec la communauté et lire des tutoriels sur divers sujets.</p>'.$footer_email_html;
    
    break;
    
}
                    

//=====Création de la boundary
$boundary = "-----=".md5(rand());
 
//=====Création du header de l'e-mail.
$header = "From: \"Contact - Doolhof\"<contact@doolhof.mz-web.fr>".$passage_ligne;
$header.= "MIME-Version: 1.0".$passage_ligne;
$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
 
//=====Création du message.
$message = $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format texte.
$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_txt.$passage_ligne;

$message.= $passage_ligne."--".$boundary.$passage_ligne;
//=====Ajout du message au format HTML
$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
$message.= $passage_ligne.$message_html.$passage_ligne;

$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
 
//=====Envoi de l'e-mail + copie admin
mail($user_email,$subject,$message,$header);
mail($admin_email,$subject,$message,$header);
    
}

