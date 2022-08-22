<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1])) {
        header('Location: /');
        exit;
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $req = $DB->query("SELECT * FROM ruches WHERE id_ruche=$id");
        $mod = $req->fetch();
    }

    if (!empty($_POST)) {
        extract($_POST);

        $valid = true;

    if (isset($_POST['modiftype'])) {
        $libelle = ucfirst(trim($_POST['libelle']));
        $type = ucfirst(trim($_POST['type']));

        if (empty($libelle)) {
          $valid = false;
          $err_libelle = "Ce champ ne peut pas être vide";
        }elseif (empty($type)) {
          $valid = false;
          $err_type = "Ce champ ne peut pas être vide";
        }

        if ($valid) {

        $req = $DB->prepare("UPDATE ruches SET libelle = ?, type = ?  WHERE id_ruche=$id");
        $req->execute(array($libelle, $type));
        header('Location: list-ruche.php');

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
    <h4 class="text-center my-4">Modification ruche</h4>
    <div class="container">
        <form method="POST">
            <div class="mb-3">
                <?php if (isset($err_libelle)) { echo '<div class="text-danger">' . $err_libelle . '</div>' ; } ?>
                <label class="form-label">Nom</label>
                <input class="form-control" type="text" name="libelle" value="<?= $mod['libelle']?>">
            </div>
            <div class="mb-3">
                <?php if (isset($err_type)) { echo '<div class="text-danger">' . $err_type . '</div>' ; } ?>
                <label class="form-label">Type</label>
                <input class="form-control" type="text" name="type" value="<?= $mod['type']?>">
            </div>
            <div class="mb-3">
                <button type="submit" name="modiftype" class="btn btn-primary">Modifier</button>
            </div>

        </form>

    </div>
    <?php
        require_once'../_footer/footer.php';
    ?>
</body>
</html>
