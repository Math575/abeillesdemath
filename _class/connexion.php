<?php
    class Connexion {

        private $valid;

        private $err_nom;
        private $err_password;

        public function verification_connexion($nom, $password){

            global $DB;

            $nom = ucfirst(trim($nom));
            $password = trim($password);

            $this->valid = (boolean) true;

            if (empty($nom)) {
                $this->valid = false;
                $this->err_nom = "Ce champ ne peut pas être vide";
            }

            if (empty($password)) {
                $this->valid = false;
                $this->err_password = "Ce champ ne peut pas être vide";
            }

            if ($this->valid) {
                $req = $DB->prepare("SELECT mdp
                    FROM utilisateurs
                    WHERE nom = ?");

                $req->execute(array($nom));

                $req = $req->fetch();

                if (isset($req['mdp'])) {
                    if (!password_verify($password, $req['mdp'])) {
                        $this->valid = false;
                        $this->err_nom = "Nom / Mot de passe Incorrect";
                    }
                }else {
                    $this->valid = false;
                    $this->err_nom = "Nom / Mot de passe Incorrect";
                }
            }

            if ($this->valid) {

                $req = $DB->prepare("SELECT *
                    FROM utilisateurs
                    WHERE nom = ?");

                $req->execute(array($nom));

                $req_user = $req->fetch();

                if (isset($req_user['id'])) {
                    $date_connexion = Date('Y-m-d H:i:s');

                    $req = $DB->prepare("UPDATE utilisateurs SET date_connexion = ? WHERE id = ? ");
                    $req->execute(array($date_connexion, $req_user['id']));

                    $_SESSION['id'] = $req_user['id'];
                    $_SESSION['nom'] = $req_user['nom'];
                    $_SESSION['prenom'] = $req_user['prenom'];
                    $_SESSION['email'] = $req_user['email'];
                    $_SESSION['role'] = $req_user['role'];

                    header('Location: _admin/dashboard.php');
                    exit;
                }else {
                    $this->valid = false;
                    $this->err_nom = "Nom / Mot de passe Incorrect";
                }
            }

            return [$this->err_nom, $this->err_password];
        }
    }
?>
