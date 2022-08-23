<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1])) {
        header('Location: /');
        exit;
    }

    $req_sql = "SELECT * , DATE_FORMAT(date_debut, '%d-%m-%Y') as date_d,
    DATE_FORMAT(date_fin, '%d-%m-%Y') as date_f
    FROM traitement t
    LEFT JOIN ruches r ON t.id_ruche = r.id_ruche WHERE statut = '0'";
    $req = $DB->prepare($req_sql);
    $req->execute();
    $req_traitement = $req->fetchAll();

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
                        <th scope="col">Date début</th>
                        <th scope="col">Produit</th>
                        <th scope="col">Date fin</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($req_traitement as $rt) {
                ?>
                    <tr>
                        <td><?= $rt['libelle'] ?></td>
                        <td><?= $rt['date_d'] ?></td>
                        <td><?= $rt['produit'] ?></td>
                        <td><?= $rt['date_f'] ?></td>
                        <td>
                          <a class="btn btn-danger disabled" href="_ruche/supprimer-visite.php?id=<?= $rt['id'] ?>"><i class="bi bi-trash"></i></a>
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
