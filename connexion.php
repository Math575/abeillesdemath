<?php

   require_once'include.php';

    if (isset($_SESSION['id'])) {
        header('Location: /');
        exit;
    }

    if (!empty($_POST)) {
        extract($_POST);

        if (isset($_POST['connexion'])) {
            [$err_nom, $err_password] = $_Connexion->verification_connexion($nom, $password);
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        require_once'_head/meta.php';
        require_once'_head/link.php';
        require_once'_head/script.php';
        require_once'_head/style.php';
    ?>
    <title>Connexion</title>
</head>
<body>
    <?php
      //  require_once'_menu/menu.php';
    ?>

    <div class="container">
            <div class="row">
                <div class="col-12">
                  <div class="text-center">
                  <img src="_img/abeille.png" class="img-fluid" style="width: 120px" alt="">
                </div>
                    <h1><i class="bi bi-box-arrow-in-right"></i>  Connexion</h1>
                    <form method="POST">
                    <div class="mb-6">
                            <?php if (isset($err_nom)) { echo '<div>' . $err_nom . '</div>' ; } ?>
                            <label class="form-label">Nom</label>
                            <input class="form-control" type="text" name="nom" value="<?php if(isset($nom)){ echo $nom; }?>" placeholder="Votre Nom">
                        </div>
                        <div class="mb-3">
                        <?php if (isset($err_password)) { echo '<div>' . $err_password . '</div>' ; } ?>
                            <label class="form-label">Mot de passe</label>
                            <input class="form-control" type="password" name="password" value="<?php if(isset($password)){ echo $password; }?>">
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="connexion" class="btn btn-primary">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
      </div>

    <?php
        require_once'_footer/footer.php';
    ?>
</body>
</html>
