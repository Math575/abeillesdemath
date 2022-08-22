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


    if (!empty($_POST)) {
        extract($_POST);

    if (isset($_POST['form1'])) {
      $id_ruche = (int) $id_ruche;
      $produit = (string) ucfirst(trim($produit));
      $quantite = (string) ucfirst(trim($quantite));
      $date_nourr = (string) $date_nourr;

      $req = $DB->prepare("INSERT INTO nourrissement(id_ruche, produit, quantite, date_nour, apiculteur) VALUES (?,?,?,?,'$_SESSION[prenom]') ");

      $req->execute(array($id_ruche, $produit, $quantite, $date_nour));
       header('Location: ../_admin/dashboard.php');
       exit;
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
                <label class="form-label">Date</label>
                <input class="form-control" type="date" name="date_nour" value="">
            </div>
            <div class="mb-3">
                <label class="form-label">Produit</label>
                <input class="form-control" type="text" name="produit" value="">
            </div>
            <div class="mb-3">
                <label class="form-label">quantité</label>
                <input class="form-control" type="text" name="quantite" value="">
            </div>
            <div class="mb-3">
                <button type="submit" name="form1" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
    <?php
        require_once'../_footer/footer.php';
    ?>
</body>
</html>
