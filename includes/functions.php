<?php
//Fonctions utiles pour simplifier le développement

//Vérifie que l'utilisateur est connecté
function verify_connexion()
{
   if ($_SERVER['PHP_SELF'] == '/login.php' || $_SERVER['PHP_SELF'] == '/register.php' || $_SERVER['PHP_SELF'] == '/lost-password.php' || $_SERVER['PHP_SELF'] == '/reset-password.php')
    {

    }
    else
    {
	        if (!isset($_SESSION['user_id']))
	        {

            	$_SESSION['page_before_connexion'] = $_SERVER['PHP_SELF'];
	            header('location: /login.php');
	        }
	        else
	        {
	            $user_id = $_SESSION['user_id'];
	        }
    }

    if (isset($_SESSION['user_id']))
    {
      $user_id = $_SESSION['user_id'];
    }
}

//Vérifie id invoice exist
//Redirige sur la page visitée avant de s'être connecté
function redirect_page_before_connexion()
{
    if (isset($_SESSION['page_before_connexion'])) {
        header ('Refresh: 4;URL=https://doolhof.mz-web.fr'.$_SESSION["page_before_connexion"]);
    }
    else
    {
        header ('Refresh: 4;URL=https://doolhof.mz-web.fr');
    }
}

function connexion_bdd()
{
    global $bdd;
    try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
	}
	    catch (exception $e)
    {
		die('Erreur : '. $e->getMessage());
	}
}

function user_id_to_email($user_id)
{
    //connexion bdd
    try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
	}
	    catch (exception $e)
    {
		die('Erreur : '. $e->getMessage());
	}
	
    $req = $bdd->prepare('SELECT email FROM users WHERE id = :id');
    $req->execute(array('id' => $user_id));
    while ($donnees = $req->fetch())
    {
        $email = $donnees['email'];
    }
    $req ->closeCursor();
    return $email;
}

function user_id_to_name($user_id)
{
    //connexion bdd
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
    }
        catch (exception $e)
    {
        die('Erreur : '. $e->getMessage());
    }

    $req = $bdd->prepare('SELECT name FROM users WHERE id = :id');
    $req->execute(array('id' => $user_id));
    while ($donnees = $req->fetch())
    {
        $name = $donnees['name'];
    }
    $req ->closeCursor();
    return $name;
}

function user_id_to_ip_last_connexion($user_id)
{
    //connexion bdd
    try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
	}
	    catch (exception $e)
    {
		die('Erreur : '. $e->getMessage());
	}
	
    $req = $bdd->prepare('SELECT ip_last_connexion FROM users WHERE id = :id');
    $req->execute(array('id' => $user_id));
    while ($donnees = $req->fetch())
    {
        $ip_last_connexion = $donnees['ip_last_connexion'];
    }
    $req ->closeCursor();
    return $ip_last_connexion;
}

function user_id_to_ip_registration($user_id)
{
    //connexion bdd
    try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
	}
	    catch (exception $e)
    {
		die('Erreur : '. $e->getMessage());
	}
	
    $req = $bdd->prepare('SELECT ip_registration FROM users WHERE id = :id');
    $req->execute(array('id' => $user_id));
    while ($donnees = $req->fetch())
    {
        $ip_registration = $donnees['ip_registration'];
    }
    $req ->closeCursor();
    return $ip_registration;
}

function user_id_to_points($user_id)
{
    //connexion bdd
    try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
        }
            catch (exception $e)
    {
                die('Erreur : '. $e->getMessage());
        }

    $req = $bdd->prepare('SELECT points FROM users WHERE id = :id');
    $req->execute(array('id' => $user_id));
    while ($donnees = $req->fetch())
    {
        $points = $donnees['points'];
    }
    $req ->closeCursor();
    return $points;
}

function user_id_to_last_level($user_id)
{
    //connexion bdd
    try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
        }
            catch (exception $e)
    {
                die('Erreur : '. $e->getMessage());
        }

    $req = $bdd->prepare('SELECT last_level FROM users WHERE id = :id');
    $req->execute(array('id' => $user_id));
    while ($donnees = $req->fetch())
    {
        $last_level = $donnees['last_level'];
    }
    $req ->closeCursor();
    return $last_level;
}

function user_id_to_time_spent($user_id)
{
    //connexion bdd
    try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
        }
            catch (exception $e)
    {
                die('Erreur : '. $e->getMessage());
        }

    $req = $bdd->prepare('SELECT time_spent FROM users WHERE id = :id');
    $req->execute(array('id' => $user_id));
    while ($donnees = $req->fetch())
    {
        $time_spent = $donnees['time_spent'];
    }
    $req ->closeCursor();
    return $time_spent;
}

function email_to_user_id($email)
{
    //connexion_bdd
    try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
	}
	    catch (exception $e)
    {
		die('Erreur : '. $e->getMessage());
	}
	
    $req = $bdd->prepare('SELECT id FROM users WHERE email = :email');
    $req->execute(array('email' => $email));
    while ($donnees = $req->fetch())
    {
        $user_id = $donnees['id'];
    }
    $req ->closeCursor();
    return $user_id;
}

function name_to_user_id($name)
{
    //connexion_bdd
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
    }
        catch (exception $e)
    {
        die('Erreur : '. $e->getMessage());
    }
    
    $req = $bdd->prepare('SELECT id FROM users WHERE name = :name');
    $req->execute(array('name' => $name));
    while ($donnees = $req->fetch())
    {
        $user_id = $donnees['id'];
    }
    $req ->closeCursor();
    return $user_id;
}

function ip_update($user_id, $new_ip)
{
    $paid_date = date("Y-m-d");
    //connexion_bdd
    try
	{
	    $bdd = new PDO('mysql:host=localhost;dbname=doolhof', 'doolhof', 'password');
	}
	    catch (exception $e)
    {
		die('Erreur : '. $e->getMessage());
	}
    $req = $bdd->prepare('UPDATE users SET ip_last_connexion = :ip_last_connexion WHERE id = :id');
    $req->execute(array(
        'id' => $user_id,
        'ip_last_connexion' => $new_ip,
        ));
}

function convert_seconds($seconds)
{
    //On le divise pour connaitre le nombre de jours 
    $time = intval($seconds / 86400) .' jour(s), ';
    //On enlève l'équivalent du nombre de jours avec un modulo --> ce qui nous permet d'obtenir le nombre de secondes sans les jours. 
    $seconds = $seconds % 86400;

    //Ce qui nous permet d'avoir le nombre d'heures
    $time = $time . intval($seconds / 3600) .' heure(s), ';
    $seconds = $seconds % 3600;

    //De même pour les minutes
    $time = $time . intval($seconds / 60) .' minute(s), ';
    $seconds = $seconds % 60;

    //Et enfin les secondes
    $time = $time . $seconds .' secondes.';

    //Et on retourne le tout
    return $time;
}

