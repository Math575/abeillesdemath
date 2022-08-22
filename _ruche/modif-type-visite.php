<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1,2])) {
        header('Location: /');
        exit;
    }

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $req = $DB->query("SELECT * FROM type_visite WHERE id_type_visite=$id");
        $mod = $req->fetch();
    }

    if (isset($_POST['modiftype'])) {
        $type = ucfirst(trim($_POST['type']));
        $req = $DB->prepare("UPDATE type_visite SET type = ? WHERE id_type_visite=$id");
        $req->execute(array($type));

        if ($req) {
            header('Location: list-type-visite.php');
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
    <h4 class="text-center my-4">Modification Type de Visite</h4>
    <div class="container">
        <form method="POST">
            <div class="mb-3">
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
