<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1])) {
        header('Location: /');
        exit;
    }

    $req = $DB->prepare("SELECT *
    FROM ruches");

    $req->execute();

    $req_ruche = $req->fetchAll();

    $req = $DB->prepare("SELECT *
    FROM type_visite");

    $req->execute();

    $req_type_visite = $req->fetchAll();

    if (!empty($_POST)) {
        extract($_POST);

        $valid = true;

    if (isset($_POST['addvisite'])) {
      $id_ruche = (int) $id_ruche;
      $id_type_visite = (int) $id_type_visite;
      $date_visite = (string) $date_visite;
      $desc_visite = (string) ucfirst(trim($desc_visite));

      if (empty($date_visite)) {
        $valid = false;
        $err_date = "Ce champ ne peut pas etre vide";
      }elseif (empty($desc_visite)) {
        $valid = false;
        $err_desc = "ce champ ne peut pas etre vide";
      }

      if($valid){

      $req = $DB->prepare("INSERT INTO visite(id_ruche, id_type_visite, date_visite, desc_visite, apiculteur) VALUES (?,?,?,?,'$_SESSION[prenom]') ");

      $req->execute(array($id_ruche, $id_type_visite, $date_visite, $desc_visite));
       header('Location: ../_admin/dashboard.php');
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
    <title>Tâches</title>
</head>
<body>
    <?php
        require_once'../_menu/menu.php';
    ?>
    <div class="container">
        <div class="d-flex justify-content-center">
            <h2>Compte rendu Visite</h2>
        </div>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Ruche</label>
                <select class="form-select" name="id_ruche">
                  <?php
                  foreach ($req_ruche as $rr) {
                  ?>
                  <option value="<?= $rr['0'] ?>"><?= $rr['1'] ?></option>
                  <?php
                  }
                  ?>

                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Type de visite</label>
                <select class="form-select" name="id_type_visite">
                  <?php
                  foreach ($req_type_visite as $rtv) {
                  ?>
                  <option value="<?= $rtv['0'] ?>"><?= $rtv['1'] ?></option>
                  <?php
                  }
                  ?>

                </select>
            </div>
            <div class="mb-3">
                <?php if (isset($err_date)) { echo '<div class="text-danger">' . $err_date . '</div>' ; } ?>
                <label class="form-label">Date visite</label>
                <input class="form-control" type="date" name="date_visite" value="">
            </div>
            <div class="mb-3">
                <?php if (isset($err_desc)) { echo '<div class="text-danger">' . $err_desc . '</div>' ; } ?>
                <label class="form-label">Description</label>
                <textarea class="form-control" name="desc_visite" aria-label=""></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" name="addvisite" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
    <?php
        require_once'../_footer/footer.php';
    ?>
</body>
</html>
