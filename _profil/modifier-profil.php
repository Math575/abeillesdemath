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

    if (!empty($_POST)) {
        extract($_POST);

        $valid = true;

        if(isset($_POST['form1'])) {
            $email = (String) trim($email);

            if($email == $_SESSION['email']){
                $valid = false;
            }
            if(!isset($email)) {
                $valid = false;
                $err_email = "Ce champ ne peut pas être vide";

            }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $valid = false;
                $err_email = "Format Invalide";

            }else{
                $req = $DB->prepare("SELECT id
                FROM utilisateurs
                WHERE email = ?");

                $req->execute([$email]);

                $req = $req->fetch();

                if (isset($req['id'])) {
                    $valid = false;
                    $err_email = "Cet email n'est pas libre";
                }
            }


            if ($valid) {

                $req = $DB->prepare('UPDATE utilisateurs SET email = ? WHERE id = ?');
                $req->execute([$email, $_SESSION['id']]);

                $_SESSION['email'] = $email;

                header('Location: modifier-profil.php');
                exit;
            }
        }elseif (isset($_POST['form2'])) {
            $oldpsd = (string) trim($oldpsd);
            $psd = (string) trim($psd);
            $confpsd = (string) trim($confpsd);

            if (!isset($oldpsd)) {
                $valid = false;
                $err_password = "Ce champ ne peut pas être vide";
            }else{
                    $req = $DB->prepare("SELECT mdp
                    FROM utilisateurs
                    WHERE id = ?");

                    $req->execute([$_SESSION['id']]);

                    $req = $req->fetch();

                    if (isset($req['mdp'])) {
                        if (!password_verify($oldpsd, $req['mdp'])) {
                            $valid = false;
                            $err_password = "L'ancien mot de passe Incorrect";
                        }

                    }else{
                        $valid = false;
                        $err_password = "L'ancien mot de passe Incorrect";
                    }
                }

                if ($valid) {
                    if (empty($psd)) {
                        $valid = false;
                        $err_password = "Ce champ ne peut pas être vide";
                    }elseif ($psd <> $confpsd) {
                        $valid = false;
                        $err_password = "Ce mot de passe ne correspond pas au premier";
                    }
                }
                if ($valid) {

                    $crypt_password = password_hash($psd, PASSWORD_ARGON2ID);

                    $req = $DB->prepare('UPDATE utilisateurs SET mdp = ? WHERE id = ?');
                    $req->execute([$crypt_password, $_SESSION['id']]);

                    header('Location: modifier-profil.php');
                    exit;
                }
            }elseif (isset($_POST['form3'])) {
              $adresse = (string) trim($adresse);
              $cp = (string) trim($cp);


              if (empty($adresse)) {
                  $valid = false;
                  $err_adresse = "Le champ adresse ne peut pas être vide";
                }elseif (empty($cp)) {
                  $valid = false;
                  $err_adresse = "Le champ Code Postal ne peut pas être vide";
                }elseif (empty($ville)) {
                  $valid = false;
                  $err_adresse = "Le champ Ville ne peut pas être vide";
                }elseif (empty($tel)) {
                  $valid = false;
                  $err_tel = "Le champ téléphone ne peut pas être vide";
                }

                if ($valid) {

                    $req = $DB->prepare('UPDATE utilisateurs SET adresse = ? , cp = ? , ville = ?, tel = ? WHERE id = ?');
                    $req->execute([$adresse, $cp, $ville, $tel, $_SESSION['id']]);

                    $_SESSION['adresse'] = $adresse;
                    $_SESSION['cp'] = $cp;
                    $_SESSION['ville'] = $ville;
                    $_SESSION['tel'] = $tel;


                    header('Location: modifier-profil.php');
                    exit;
                }
              }
      }


    if (!isset($email)) {
        $email = $req_user['email'];
    }

    if (!isset($adresse)) {
        $adresse = $req_user['adresse'];
    }
    if (!isset($cp)) {
        $cp = $req_user['cp'];
    }
    if (!isset($ville)) {
        $ville = $req_user['ville'];
    }
    if (!isset($tel)) {
        $tel = $req_user['tel'];
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
    <title>Modifier mon Compte</title>
</head>
<body>
    <?php
        require_once'../_menu/menu.php';
    ?>
    <div class="container">
        <div class="row">
            <div class="col-1"></div>
                    <div class="col-10">
                        <h4>Modification des Informations</h4>

                        <form method="post">
                            <div class="mb-3">
                                <?php if (isset($err_email)) { echo '<div>' . $err_email . '</div>' ; } ?>
                                <input class="form-control" type="email" name="email" value="<?= $email ?>" placeholder="Email"/>
                            </div>
                            <div class="mb-3">
                            <input class="btn btn-warning" type="submit" name="form1" value="Modifier"/>
                            </div>
                        </form>
                        <br>
                        <form method="post">
                            <div class="mb-3">
                            <?php if (isset($err_password)) { echo '<div>' . $err_password . '</div>' ; } ?>
                                <input class="form-control" type="password" name="oldpsd" value="" placeholder="Mot de passe actuel"/>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="password" name="psd" value="" placeholder="Nouveau mot de passe"/>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="password" name="confpsd" value="" placeholder="Confirmation mot de passe"/>
                            </div>
                            <div class="mb-3">
                                <input class="btn btn-warning" type="submit" name="form2" value="Modifier"/>
                            </div>

                        </form>
                        <br>
                        <form method="post">
                          <div class="mb-3">
                            <?php if (isset($err_adresse)) { echo '<div>' . $err_adresse . '</div>' ; } ?>
                            <input class="form-control" type="text" name="adresse" value="<?= $adresse ?>" placeholder="Adresse postale"/>
                          </div>
                          <div class="mb-3">
                            <?php if (isset($err_cp)) { echo '<div>' . $err_cp . '</div>' ; } ?>
                            <input class="form-control" type="text" name="cp" value="<?= $cp ?>" placeholder="Code Postal"/>
                          </div>
                          <div class="mb-3">
                            <?php if (isset($err_ville)) { echo '<div>' . $err_ville . '</div>' ; } ?>
                            <input class="form-control" type="text" name="ville" value="<?= $ville?>" placeholder="Ville"/>
                          </div>
                          <br>
                          <div class="mb-3">
                            <?php if (isset($err_tel)) { echo '<div>' . $err_tel . '</div>' ; } ?>
                            <input class="form-control" type="text" name="tel" value="<?= $tel?>" placeholder="Télephone"/>
                          </div>
                          <div class="mb-3">
                              <input class="btn btn-warning" type="submit" name="form3" value="Modifier"/>
                          </div>
                        </form>
                    </div>
            </div>
        </div>

    <?php
        require_once'../_footer/footer.php';
    ?>
</body>
</html>
