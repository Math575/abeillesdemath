<?php
    require_once'include.php';

    if (isset($_SESSION['id'])) {
        header('Location: /');
        exit;
    }

    if (!empty($_POST)) {
        extract($_POST);

        if (isset($_POST['inscription'])) {
            [$err_nom, $err_prenom, $err_email, $err_password] = $_Inscription->verification_inscription($nom, $prenom, $email, $confemail, $password, $confpassword);
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
        ?>
        <title>Inscription</title>
    </head>
    <body>
        <?php
            require_once'_menu/menu.php';
        ?>
        <div class="container">
            <div class="row">
                <div class="col-3"></div>
                <div class="col-6">
                    <h1><i class="fa-solid fa-user-plus"></i>  Inscription</h1>
                    <form method="POST">
                    <div class="mb-3">
                            <?php if (isset($err_nom)) { echo '<div>' . $err_nom . '</div>' ; } ?>
                            <label class="form-label">Nom</label>
                            <input class="form-control" type="text" name="nom" value="<?php if(isset($nom)){ echo $nom; }?>">
                        </div>
                        <div class="mb-3">
                            <?php if (isset($err_prenom)) { echo '<div>' . $err_prenom . '</div>' ; } ?>
                            <label class="form-label">Prénom</label>
                            <input class="form-control" type="text" name="prenom" value="<?php if(isset($prenom)){ echo $prenom; }?>">
                        </div>
                        <div class="mb-3">
                        <?php if (isset($err_email)) { echo '<div>' . $err_email . '</div>' ; } ?>
                            <label class="form-label">Email</label>
                            <input class="form-control" type="email" name="email" value="<?php if(isset($email)){ echo $email; }?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmation Email</label>
                            <input class="form-control" type="email" name="confemail" value="<?php if(isset($confemail)){ echo $confemail; }?>">
                        </div>
                        <div class="mb-3">
                        <?php if (isset($err_password)) { echo '<div>' . $err_password . '</div>' ; } ?>
                            <label class="form-label">Mot de passe</label>
                            <input class="form-control" type="password" name="password" value="<?php if(isset($password)){ echo $password; }?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirmation mot de passe</label>
                            <input class="form-control" type="password" name="confpassword" value="">
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="inscription" class="btn btn-primary">S'inscrire</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php
            require_once'_footer/footer.php';
        ?>

    </body>
</html>