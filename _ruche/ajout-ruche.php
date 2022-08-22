<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1])) {
        header('Location: /');
        exit;
    }

    if (!empty($_POST)) {
      extract($_POST);

      $valid = true;

      if (isset($_POST['form1'])) {
        $libelle = (string) ucfirst(trim($libelle));
        $type = (string) ucfirst(trim($type));

        if (empty($libelle)) {
          $valid = false;
          $err_libelle = "Ce champ ne peut pas etre vide";
        }elseif (empty($type)) {
          $valid = false;
          $err_type = "ce champ ne peut pas etre vide";
        }

        if ($valid) {

        $req = $DB->prepare("INSERT INTO ruches(libelle, type) VALUES (?, ?)");

        $req->execute(array($libelle, $type));
        header('Location: list-ruche.php');
        exit;
        }
      }
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
    <title>Ruches</title>
</head>
<body>
    <?php
        require_once'../_menu/menu.php';
    ?>
    <h4 class="text-center my-4"><img src="_dist\bootstrap-icons-1.9.1/beehive-honey.svg" alt="Bootstrap" width="32" height="32">
    Ajout de ruche</h4>
    <div class="container">
      <div class="g-2 text-center">
          <div class="col-12">
            <form method="post">
              <div class="mb-6">
                <?php if (isset($err_libelle)) { echo '<div class="text-danger">' . $err_libelle . '</div>' ; } ?>
                <label class="form-label">Nom de la ruche</label>
                <input class="form-control" type="text" name="libelle" value="">
              </div>
              <br>
              <div class="mb-6">
                <?php if (isset($err_type)) { echo '<div class="text-danger">' . $err_type . '</div>' ; } ?>
                <label class="form-label">Type de ruche</label>
                <input class="form-control" type="text" name="type" value="">
              </div>
              <br>
              <div class="mb-6">
                <button type="submit" name="form1" class="btn btn-primary">Ajouter</button>
              </div>
            </form>
          </div>
      </div>
    </div>
    <?php
        require_once'../_footer/footer.php';
    ?>
</body>
</html>
