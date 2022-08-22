<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand">Les Abeilles de Math</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <!-- <a class="nav-link" aria-current="page" href="_abeille/cycle-abeille.php">Le Cycle de Vie</a> -->
        <?php
          // Visible de tous
          if (!isset($_SESSION['id'])) {
        ?>
        <a class="btn btn-outline-success" href="inscription.php">Inscription</a>
        <!--<a class="btn btn-outline-success" href="connexion.php">Connexion</a>-->
        <?php
          }else {
        ?>
        <?php
          // Visible que SUPER ADMIN
          if ($_SESSION['role'] == 1) {
        ?>
        <li><a class="nav-link" href="_admin/dashboard.php">Dashboard</a></li>
        <li class="nav-item dropdown">
         <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Menu ADMIN
         </a>
         <ul class="dropdown-menu">
          <li><p class="text-center"><strong>Membres</strong></p></li>
          <li><a class="dropdown-item" href="_profil/membres.php">Liste Membres</a></li>
          <li><a class="dropdown-item" href="_admin/niveau.php">Rôle membres</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><p class="text-center"><strong>Ruches</strong></p></li>
          <li><a class="dropdown-item" href="_ruche/ajout-ruche.php">Ajout Ruche</a></li>
          <li><a class="dropdown-item" href="_ruche/list-ruche.php">Liste Ruche</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><p class="text-center"><strong>Visites</strong></p></li>
          <li><a class="dropdown-item" href="_ruche/ajout-type-visite.php">Ajout Type</a></li>
          <li><a class="dropdown-item" href="_ruche/list-type-visite.php">Liste Type</a></li>
         </ul>
       </li>
        <?php
        }
        ?>
        <a class="nav-link" href="_profil/profil.php">Mon Profil</a>
        <a class="btn btn-danger" href="deconnexion.php"><i class="bi bi-x-circle"></i> Deconnexion</a>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</nav>
