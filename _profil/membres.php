<?php

    require_once'../include.php';

    $req_sql = "SELECT *
        FROM utilisateurs ";

    if (isset($_SESSION['id'])) {
        $req_sql .= "WHERE id <> ?";
    }

    $req = $DB->prepare($req_sql);

    if (isset($_SESSION['id'])) {
        $req->execute([$_SESSION['id']]);
    }else {
        $req->execute();
    }

    $req_membres = $req->fetchAll();

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
    <title>Membres</title>
</head>
<body>
    <?php
        require_once'../_menu/menu.php';
    ?>
    <h4 class="text-center my-4"><i class="bi bi-people-fill"></i> Membres</h4>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <table id="membre" class="table table-light table-bordered table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($req_membres as $rm) {
                ?>
                    <tr>
                        <td><?= $rm['nom'] ?></td>
                        <td><?= $rm['prenom'] ?></td>
                        <td><a class="btn btn-primary" href="_profil/voir-profil.php?id=<?= $rm['id'] ?>"><i class="bi bi-eye-fill"></i></a></td>
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

</script>
</body>
</html>
