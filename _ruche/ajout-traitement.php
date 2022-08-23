<?php

  require_once'../include.php';

  if (!in_array($_SESSION['role'], [1])) {
      header('Location: /');
      exit;
  }

  $req = $DB->prepare("SELECT *
  FROM ruches");

  $req->execute();

  $req_ruche = $req->fetchAll();

  if(!empty($_POST)) {
    extract($_POST);

    $valid = true;

    if (isset($_POST['form'])) {
      $id_ruche = (int) $id_ruche;
      $produit = (string) ucfirst(trim($produit));

      if(empty($date_debut)){
        $valid = false;
        $err_date_debut = "La date doit être rempli";
      }elseif (empty($produit)) {
        $valid = false;
        $err_produit = "Le champ produit doit être rempli";
      }

      if ($valid) {

        $date_debut = Date('Y-m-d H:i:s');

        $req = $DB->prepare("INSERT INTO traitement(id_ruche, date_debut, produit, apiculteur) VALUES (?, ?, ?, '$_SESSION[prenom]') ");

        $req->execute(array($id_ruche, $date_debut, $produit));
        header('Location: ../_admin/dashboard.php');
        exit;
      }
    }
  }

 ?>

 <!DOCTYPE html>
 <html lang="fr" dir="ltr">
   <head>
       <?php
           require_once'../_head/meta.php';
           require_once'../_head/link.php';
           require_once'../_head/script.php';
           require_once'../_head/style.php';
       ?>
       <title>Tâches</title>
   </head>
   <body>
     <?php
         require_once'../_menu/menu.php';
     ?>
     <div class="container">
       <div class="d-flex justify-content-center">
         <h2>Traitement</h2>
       </div>
       <form method="POST">
         <div class="mb-3">
             <label class="form-label">Ruche</label>
             <select class="form-select" name="id_ruche">
               <?php
               foreach ($req_ruche as $rr) {
               ?>
               <option value="<?= $rr['0'] ?>"><?= $rr['1'] ?></option>
               <?php
               }
               ?>
             </select>
         </div>
         <div class="mb-3">
             <?php if (isset($err_date_debut)) { echo '<div class="text-danger">' . $err_date_debut . '</div>' ; } ?>
             <label class="form-label">Date visite</label>
             <input class="form-control" type="date" name="date_debut" value="">
         </div>
         <div class="mb-3">
             <?php if (isset($err_produit)) { echo '<div class="text-danger">' . $err_produit . '</div>' ; } ?>
             <label class="form-label">Description</label>
             <textarea class="form-control" name="produit" aria-label=""></textarea>
         </div>
         <div class="mb-3">
             <button type="submit" name="form" class="btn btn-primary">Ajouter</button>
         </div>
       </form>
     </div>
   </body>
 </html>
