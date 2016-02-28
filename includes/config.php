<?php

    //Démarre une nouvelle session ou reprend une session existante
    session_start();

    //Démarre le calcul du temps de génération des scripts
    $time_start = microtime(true);
    
    $folder = '';
    if(substr($_SERVER['PHP_SELF'], 0, strrpos($_SERVER['PHP_SELF'], '/')) == '/admin'){
        $folder = '../';
    }

    //
    // =============================== BASE DE DONNEE ===============================
    //

    try {
        $bdd = new PDO('mysql:host=localhost;dbname=pji;charset=utf8', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    //
    // ============================ CONFIGURATION DE BASE ============================
    //

    //Définit le décalage horaire par défaut de toutes les fonctions date/heure
    date_default_timezone_set('Europe/Paris');

    //------------------
    //Variables globales
    
    $title_project = 'Breathing Forests';
    $version_project = '0.1';
    
    $array_username_forbidden = array('admin', 'bot');
    
    //Récupère le fichier des fonctions php
    if(strstr($_SERVER["DOCUMENT_ROOT"], 'pji')){
        require_once $_SERVER["DOCUMENT_ROOT"].'/M1S2_PJI/utilities/fonctions.php';
    } else {
        require_once $_SERVER["DOCUMENT_ROOT"].'/pji/M1S2_PJI/utilities/fonctions.php';
    }
    

?>
