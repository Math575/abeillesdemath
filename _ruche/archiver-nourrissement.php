<?php

    require_once'../include.php';

    if (!in_array($_SESSION['role'], [1])) {
        header('Location: /');
        exit;
    }

    if (isset($_GET['id'])) {
        $id=$_GET['id'];
        $req = $DB->prepare("UPDATE nourrissement SET statut = '1' WHERE id = ?");
        $req->execute(array($id));
        if ($req) {
            header('Location: list-nourrissement.php');
        }
    }
?>
