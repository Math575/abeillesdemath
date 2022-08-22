<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1])) {
        header('Location: /');
        exit;
    }

    $req_sql = "SELECT * FROM ruches";
    $req = $DB->prepare($req_sql);
    $req->execute();
    $req_ruches = $req->fetchAll();

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
    <h4 class="text-center my-4">
      <img src="_dist\bootstrap-icons-1.9.1/beehive.svg" alt="Bootstrap" width="32" height="32">
      Mes ruches</h4>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <table id="membre" class="table table-light table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Type</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($req_ruches as $rr) {
                ?>
                    <tr>
                        <td><?= $rr['libelle'] ?></td>
                        <td><?= $rr['type'] ?></td>
                        <td>
                        <a class="btn btn-warning" href="_ruche/modif-ruche.php?id=<?= $rr['id_ruche'] ?>"><i class="bi bi-pencil-square"></i></a>
                        <a class="btn btn-danger" href="_ruche/supprimer-ruche.php?id=<?= $rr['id_ruche'] ?>"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                </tbody>
                <?php
                }
                ?>
            </table>
            </div>
        </div>
    </div>
    <?php
        require_once'../_footer/footer.php';
    ?>
</body>
</html>
