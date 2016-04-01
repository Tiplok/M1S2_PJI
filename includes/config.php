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
    
    $array_init_board = array(
        array('T','E','E','E','E','E','E','E','T','E','E','E','E','E','R','E'),
        array('E','E','E','E','T','T','E','E','E','E','E','T','T','R','R','E'),
        array('E','E','R','R','R','R','R','R','E','E','E','T','T','R','E','E'),
        array('E','E','R','E','E','E','E','R','E','E','E','E','E','R','E','E'),
        array('E','E','R','E','E','E','E','R','R','R','R','R','R','R','E','E'),
        array('E','E','R','T','T','E','E','E','T','E','E','E','T','T','E','E'),
        array('E','E','R','T','T','E','E','E','E','E','E','E','E','E','E','E'),
        array('E','E','R','R','R','R','R','T','E','E','E','E','E','T','E','E'),
        array('E','E','T','E','E','E','R','T','E','E','E','E','E','T','E','E')
    );
    
    $array_display = array(
        'R' => '<td><img height="64px" width="64px" src="styles/images/board_icons/river.png" alt="river" /></td>',
        'T' => '<td><img height="64px" width="64px" src="styles/images/board_icons/city.png" alt="city" /></td>'
    );
    
    //Récupère le fichier des fonctions php
    if(strstr($_SERVER["DOCUMENT_ROOT"], 'pji')){
        require_once $_SERVER["DOCUMENT_ROOT"].'/M1S2_PJI/utilities/fonctions.php';
    } else {
        require_once $_SERVER["DOCUMENT_ROOT"].'/pji/M1S2_PJI/utilities/fonctions.php';
    }
    

?>
