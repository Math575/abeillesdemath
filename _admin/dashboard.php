<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1])) {
        header('Location: /');
        exit;
    }

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        require_once'../_head/meta.php';
        require_once'../_head/link.php';
        require_once'../_head/script.php';
        require_once'../_head/style.php';
    ?>
    <title>Tableau de Bord</title>
</head>
<body>
    <?php
        require_once'../_menu/menu.php';
    ?>
    <div class="text-center my-3">
      <a  class="btn btn-primary" href="../_ruche/ajout-visite.php"><i class="bi bi-plus-circle"></i> Créer une visite</a>
      <a  class="btn btn-primary" href="../_ruche/list-visite.php"><i class="fa-solid fa-list"></i>  Liste des visites</a>
    </div>
    <div class="text-center my-3">
      <a  class="btn btn-info" href="../_ruche/ajout-nourrissement.php"><i class="bi bi-plus-circle"></i>  Nourrissement</a>
      <a  class="btn btn-info" href="../_ruche/list-nourrissement.php"><i class="fa-solid fa-list"></i> Liste  Nourrissement</a>
    </div>
    <div class="text-center my-3">
      <a  class="btn btn-info" href="../_ruche/ajout-traitement.php"><i class="bi bi-plus-circle"></i>  Traitement</a>
      <a  class="btn btn-info" href="../_ruche/list-traitement.php"><i class="fa-solid fa-list"></i> Liste Traitement</a>
    </div>
    <hr>
    <?php
        require_once'../_footer/footer.php';
    ?>
</body>
</html>
