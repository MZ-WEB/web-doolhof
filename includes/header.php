<header>
<div class="masthead">
<a href="/"><h1 class="text-muted">Doolhof</h1></a>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          <li><a href="index.php">Accueil</a></li>
      </ul>
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Mon compte<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="account.php">Gérer mon compte</a></li>
            <li><a href="stats.php">Mes statistiques</a></li>
          </ul>
        </li>
	      <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Aide<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Support technique</a></li>
            <li><a href="#">Foire aux questions</a></li>
            <li><a href="#">Forum</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Suivez-nous !<span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="#">Google+</a></li>
          </ul>
        </li>
      </ul>
      <?php
      if (isset($_SESSION['user_id']))
      {
        ?>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Connecté en tant que <?php echo user_id_to_name($_SESSION['user_id']); ?><span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="account.php">Mon compte</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </li>
        </ul>
        <?php
      }
      else
      {
        ?>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Bonjour, visiteur !<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="login.php">Connexion</a></li>
                    <li><a href="register.php">Inscription</a></li>
                </ul>
            </li>
        </ul>
        <?php
      }
      
      ?>
    </div>
  </div>
</nav>
</div>
</header>
