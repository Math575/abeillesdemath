<?php

    require_once'../include.php';

    if (isset($_GET['id'])) {
        $id=$_GET['id'];
        $req = $DB->prepare("DELETE FROM type_visite WHERE id_type_visite = ?");
        $req->execute(array($id));
        if ($req) {
          header('Location: list-type-visite.php');
        }
    }
?>
