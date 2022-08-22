<?php
    require_once'include.php';
    // if (isset($_SESSION['id'])) {
    //    $var = '<h1 class="d-flex justify-content-end m-2">Bonjour ' . $_SESSION['prenom'] . '</h1>';
    // }else {
    //     $var = "<h1 class='d-flex justify-content-center m-2'>Site de suivi ruche
    //     <br>
    //     Les Abeilles de Math
    //     </h1>";
    // }
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
    <title>Accueil</title>
</head>
<body>
    <?php
        require_once'_menu/menu.php';
    ?>
    <!-- <?= $var ?> -->
    <div class="container">
        <h1>Site de SUIVI Ruche</h1>
        <a class="btn btn-success" href="connexion.php"><i class="bi bi-power"></i> Connexion</a>
    </div>
    <?php
        require_once'_footer/footer.php';
    ?>
</body>
</html>
