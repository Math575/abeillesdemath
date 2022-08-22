<?php

        session_start();

        include_once('_db/connexionDB.php');
        include_once('_class/inscription.php');
        include_once('_class/connexion.php');

        // Déclaration des classes sous forme de variables
        $_Inscription = new Inscription;
        $_Connexion = new Connexion; 
        
?>