<?php
    class Inscription {

        private $valid;

        private $err_nom;
        private $err_prenom;
        private $err_email;
        private $err_password;

        public function verification_inscription($nom, $prenom, $email, $confemail, $password, $confpassword){

            global $DB;

            $nom = (string) ucfirst(trim($nom));
            $prenom = (string) ucfirst(trim($prenom));
            $email = (string) trim($email);
            $confemail = (string) trim($confemail);
            $password = (string) trim($password);
            $confpassword = (string) trim($confpassword);

            $this->err_nom = (string) '';
            $this->err_prenom = (string) '';
            $this->err_email = (string) '';
            $this->err_password = (string) '';
            $this->valid = (boolean) true;

            $this->vericification_nom($nom);
            $this->vericification_prenom($prenom);          
            $this->vericification_email($email, $confemail);
            $this->vericification_password($password, $confpassword);

            if ($this->valid) {

                $crypt_password = password_hash($password, PASSWORD_ARGON2ID);
                $date_creation = date('Y-m-d H:i:s');

                $req = $DB->prepare("INSERT INTO utilisateurs(nom, prenom, email, mdp, date_creation, date_connexion) VALUES (?,?,?,?,?,?)");
                $req->execute(array($nom, $prenom, $email, $crypt_password, $date_creation, $date_creation));
                
                header('Location: connexion.php');
                exit;
            }

            return [$this->err_nom,$this->err_prenom, $this->err_email, $this->err_password];
        }

        private function vericification_nom($nom){
            
            global $DB;

            if (empty($nom)) {
                $this->valid = false;
                $this->err_nom = "Ce champ ne peut pas être vide";
            }elseif(grapheme_strlen($nom) < 4) {
                $this->valid = false;
                $this->err_nom = "Le nom doit avoir au moin 3 caractères";
            }elseif(grapheme_strlen($nom) > 20) {
                $this->valid = false;
                $this->err_nom = "Le nom ne peut pas avoir plus de 20 caractères(" . grapheme_strlen($nom) . "/20)";
            }else {
                $req = $DB->prepare("SELECT id
                    FROM utilisateurs
                    WHERE nom = ?");
                
                $req->execute(array($nom));

                $req = $req->fetch();

                if (isset($req['id'])) {
                    $this->valid = false;
                    $this->err_nom = "Ce prenom est déjà pris";
                }
            }
        }
        private function vericification_prenom($prenom){
            
            global $DB;

            if (empty($prenom)) {
                $this->valid = false;
                $this->err_prenom = "Ce champ ne peut pas être vide";
            }elseif (grapheme_strlen($prenom) < 4) {
                $this->valid = false;
                $this->err_prenom = "Le prénom doit avoir au moin 3 caractères";
            }elseif (grapheme_strlen($prenom) > 20) {
                $this->valid = false;
                $this->err_prenom = "Le prénom ne peut pas avoir plus de 20 caractères(" . grapheme_strlen($prenom) . "/20)";
            }else {
                $req = $DB->prepare("SELECT id
                    FROM utilisateurs
                    WHERE prenom = ?");
                
                $req->execute(array($prenom));

                $req = $req->fetch();

            }
        }
        private function vericification_email($email, $confemail){
            
            global $DB;

            if (empty($email)) {
                $this->valid = false;
                $this->err_email = "Ce champ ne peut pas être vide";
            }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->valid = false;
                $this->err_email = "Format Invalide";
            }elseif ($email <> $confemail) {
                $this->valid = false;
                $this->err_email = "Ce mail ne correspond pas au premier";
            }else {
                $req = $DB->prepare("SELECT id
                    FROM utilisateurs
                    WHERE email = ?");
                
                $req->execute(array($email));

                $req = $req->fetch();

                if (isset($req['id'])) {
                    $this->valid = false;
                    $this->err_email = "Ce mail est déjà pris";
                }
            }
        }
        private function vericification_password($password, $confpassword){
            
            if (empty($password)) {
                $this->valid = false;
                $this->err_password = "Ce champ ne peut pas être vide";
            }elseif ($password <> $confpassword) {
                $this->valid = false;
                $this->err_password = "Ce mot de passe ne correspond pas au premier";
            }
        }
    }
?>