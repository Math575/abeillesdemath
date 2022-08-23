<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1])) {
        header('Location: /');
        exit;
    }

    $req_sql = "SELECT * , DATE_FORMAT(date_nour, '%d-%m-%Y') as date_n
    FROM nourrissement n
    LEFT JOIN ruches r ON n.id_ruche = r.id_ruche WHERE statut = '0'";
    $req = $DB->prepare($req_sql);
    $req->execute();
    $req_nourrissement = $req->fetchAll();

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
    <title>Liste nourrissement</title>
</head>
<body>
    <?php
        require_once'../_menu/menu.php';
    ?>
    <h4 class="text-center my-4"><i class="fa-solid fa-list"></i> Liste des nourrissement</h4>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <table id="tache" class="table table-light table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Ruche</th>
                        <th scope="col">Date</th>
                        <th scope="col">Produit</th>
                        <th scope="col">Quantité</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($req_nourrissement as $rn) {
                ?>
                    <tr>
                        <td><?= $rn['libelle'] ?></td>
                        <td><?= $rn['date_n'] ?></td>
                        <td><?= $rn['produit'] ?></td>
                        <td><?= $rn['quantite'] ?></td>
                        <td>
                          <a class="btn btn-danger" href="_ruche/archiver-nourrissement.php?id=<?= $rn['id'] ?>"><i class="fa-solid fa-box-archive"></i></a>
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
