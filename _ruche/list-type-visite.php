<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1])) {
        header('Location: /');
        exit;
    }

    $req_sql = "SELECT * FROM type_visite";
    $req = $DB->prepare($req_sql);
    $req->execute();
    $req_type = $req->fetchAll();

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
    <h4 class="text-center my-4">Liste type de visite</h4>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <table id="membre" class="table table-light table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Libellé</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($req_type as $rt) {
                ?>
                    <tr>
                        <td><?= $rt['type'] ?></td>
                        <td>
                          <a class="btn btn-warning" href="_ruche/modif-type-visite.php?id=<?= $rt['id_type_visite'] ?>"><i class="bi bi-pencil-square"></i></a>
                          <a class="btn btn-danger" href="_ruche/supprimer-type-visite.php?id=<?= $rt['id_type_visite'] ?>"><i class="bi bi-trash"></i></a>
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
