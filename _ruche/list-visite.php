<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1])) {
        header('Location: /');
        exit;
    }

    $req_sql = "SELECT * , DATE_FORMAT(date_visite, '%d-%m-%Y') as date_v
    FROM visite v
    LEFT JOIN ruches r ON v.id_ruche = r.id_ruche
    LEFT JOIN type_visite tv ON v.id_type_visite = tv.id_type_visite WHERE statut = '0'";
    $req = $DB->prepare($req_sql);
    $req->execute();
    $req_visite = $req->fetchAll();

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
    <title>Liste visite</title>
</head>
<body>
    <?php
        require_once'../_menu/menu.php';
    ?>
    <h4 class="text-center my-4"><i class="fa-solid fa-list"></i> Liste des visites</h4>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <table id="tache" class="table table-light table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Ruche</th>
                        <th scope="col">Date visite</th>
                        <th scope="col">Type visite</th>
                        <th scope="col">Description</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($req_visite as $rv) {
                ?>
                    <tr>
                        <td><?= $rv['libelle'] ?></td>
                        <td><?= $rv['date_v'] ?></td>
                        <td><?= $rv['type'] ?></td>
                        <td><?= $rv['desc_visite'] ?></td>
                        <td>
                          <a class="btn btn-danger" href="_ruche/supprimer-visite.php?id=<?= $rv['id'] ?>"><i class="bi bi-trash"></i></a>
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
