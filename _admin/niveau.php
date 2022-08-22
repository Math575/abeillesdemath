<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1,2])) {
        header('Location: /');
        exit;
    }

    $req = $DB->prepare("SELECT u.*, ar.libelle
    FROM utilisateurs u
    LEFT JOIN admin_role ar ON ar.role = u.role
    WHERE u.id <> ?");

    $req->execute([$_SESSION['id']]);

    $req_list_user = $req->fetchAll();

    $req = $DB->prepare("SELECT *
    FROM admin_role");

    $req->execute();

    $req_list_role = $req->fetchAll();

    $tab_list_role = [];

    foreach ($req_list_role as $r) {
        array_push($tab_list_role, [$r['role'], $r['libelle']]);
    }

    if (!empty($_POST)) {
      extract($_POST);

      $valid = true;

      if (isset($_POST['changement_role'])) {
        $id_user = (int) $id_user;
        $role = (int) $role;

        $req = $DB->prepare("SELECT *
        FROM utilisateurs
        WHERE id = ?");

        $req->execute([$id_user]);

        $verif_user = $req->fetch();

        if (!$verif_user) {
          $valid = false;
          $err_role = "L'utilisateur n'existe plus";
        }else {

          $req = $DB->prepare("SELECT *
          FROM admin_role
          WHERE role = ?");

          $req->execute([$role]);

          $verif_role = $req->fetch();

          if (!$verif_role) {
            $valid = false;
            $err_role = "Ce rôle n'existe pas";
          }

          if ($valid) {
            $req = $DB->prepare("UPDATE utilisateurs SET role = ? WHERE id = ?");

            $req->execute([$verif_role['role'], $id_user]);

            header('Location: niveau.php');
            exit;
          }
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
    <title>Changement Rôle</title>
</head>
<body>
    <?php
        require_once'../_menu/menu.php';
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="text-center my-2">Changement de rôle</h4>
                <br>
                <div>
                        <?php
                            foreach ($req_list_user as $rlu) {
                        ?>
                        <form method="post">
                        <div>
                            <div><?= $rlu['nom']?></div>
                            <select class="form-select" name="role">
                                <option value="<?= $rlu['role'] ?>" hidden><?= $rlu['libelle'] ?></option>
                                <?php
                                    foreach ($tab_list_role as $tr) {
                                ?>
                                <option value="<?= $tr['0'] ?>"><?= $tr['1'] ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <br>
                            <input type="hidden" name="id_user" value="<?= $rlu['id'] ?>">
                            <button class="btn btn-primary" type="submit" name="changement_role">Modifier</button>
                        </div>
                        </form>
                        <br>
                        <?php
                            }
                        ?>
                </div>
            </div>
        </div>
    </div>
    <?php
        require_once'../_footer/footer.php';
    ?>
</body>
</html>
