<?php

    require_once'../include.php';

    if (!isset($_SESSION['id'])) {
        header('Location: /');
        exit;
    }

    $req = $DB->prepare("SELECT *
    FROM utilisateurs
    WHERE id = ?");

    $req->execute([$_SESSION['id']]);

    $req_user = $req->fetch();

    $date = date_create($req_user['date_creation']);
    $date_inscription = date_format($date, 'd/m/Y');

    $date = date_create($req_user['date_connexion']);
    $date_connexion = date_format($date, 'd/m/Y H:i');

    switch ($req_user['role']) {
        case 0:
            $role = "Utilisateur";
        break;

        case 1:
            $role = "Super Admin";
        break;

        case 2:
            $role = "Administrateur";
        break;

        case 3:
            $role = "Modérateur";
        break;

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
    <title>Profil de <?= $req_user['nom'] ." ". $req_user['prenom'] ?></title>
</head>
<body>
    <?php
        require_once'../_menu/menu.php';
    ?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Profil de <?= $req_user['nom'] ." ". $req_user['prenom'] ?></h1>
                <br>
                <div>
                    Date d'inscription : <?= $date_inscription?>
                </div>
                <div>
                    Date dernière Connexion : <?= $date_connexion?>
                </div>
                <div>
                    Rôle utilisateur : <?= $role?>
                </div>
                <br>
                <div>
                    Adresse : <?= $req_user['adresse'] ?>
                </div>
                <div>
                    Code Postal : <?= $req_user['cp'] ?>
                </div>
                <div>
                    Ville : <?= $req_user['ville'] ?>
                </div>
                <br>
                <div>
                    Email : <?= $req_user['email'] ?>
                </div>
                <br>
                <div>
                    Téléphone : <?= $req_user['tel'] ?>
                </div>
                <br>
                <div>
                    NAPI : <?= $req_user['napi'] ?>
                </div>
                <br>
                <div>
                    <a class="btn btn-warning" href="_profil/modifier-profil.php">Modifier mon compte</a>
                </div>
            </div>

        </div>
    </div>
    <?php
        require_once'../_footer/footer.php';
    ?>
</body>
</html>
