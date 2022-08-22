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
        $type = (string) ucfirst(trim($type));

        if (empty($type)) {
          $valid = false;
          $err_type = "Ce champ ne peut pas etre vide";
        }

        if($valid){

        $req = $DB->prepare("INSERT INTO type_visite(type) VALUES (?)");

        $req->execute(array($type));
        header('Location: list-type-visite.php');
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
    <title>Visite</title>
</head>
<body>
    <?php
        require_once'../_menu/menu.php';
    ?>
    <div class="container">
      <div class="d-flex justify-content-center">
        <h4><i class="bi bi-plus-circle"></i> Ajout type de visiste</h4>
      </div>
        <div class="row">
            <div class="col-12">
            <form method="post">
              <div class="mb-6">
                <?php if (isset($err_type)) { echo '<div class="text-danger">' . $err_type . '</div>' ; } ?>
                <label class="form-label">Type de visite</label>
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
