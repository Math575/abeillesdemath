<?php

    require_once'../include.php';

    if (isset($_GET['id'])) {
        $id=$_GET['id'];
        $req = $DB->prepare("DELETE FROM ruches WHERE id_ruche = ?");
        $req->execute(array($id));
        if ($req) {
          header('Location: list-ruche.php');
        }
    }
?>
