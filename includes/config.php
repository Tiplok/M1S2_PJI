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
    
    
    $array_init_board_for_js = array();
    
    $query_board = "SELECT * FROM board_element";
    $result_board = $bdd->query($query_board);
    while($row_board = $result_board->fetch(PDO::FETCH_ASSOC)){
        // Création d'un tableau pour l'envoyer en javascript avec $arr[nb_row][nb_column] = type, oxygen, water
        switch(strtoupper($row_board['type'])){
            case 'EMPTY':
                $oxygen = 'oxygen_need';
                $water = 'water_give';
                break;
            case 'TOWN' :
                $oxygen = 'oxygen_need';
                break;
            case 'RIVER' :
                $water = 'water_give';
                break;
            default :
                break;
        }

        $array_init_board_for_js[$row_board['nb_row']][$row_board['nb_column']] = array();
        $array_init_board_for_js[$row_board['nb_row']][$row_board['nb_column']]['type'] = $row_board['type'];
        if(isset($oxygen))
            $array_init_board_for_js[$row_board['nb_row']][$row_board['nb_column']]['data'][$oxygen] = $row_board['oxygen'];
        if(isset($water))
            $array_init_board_for_js[$row_board['nb_row']][$row_board['nb_column']]['data'][$water] = $row_board['water'];
    }
    
    if(isset($_SESSION['PK_user'])){
        $query_user_tree = "SELECT * FROM asso_user_tree JOIN tree ON FK_tree = PK_tree WHERE FK_user = ".$_SESSION['PK_user'];
        $result_user_tree = $bdd->query($query_user_tree);
        while($row_user_tree = $result_user_tree->fetch(PDO::FETCH_ASSOC)){
            $array_init_board_for_js[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['type'] = 'tree';
            $array_init_board_for_js[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['PK_tree'] = $row_user_tree['PK_tree'];
            $array_init_board_for_js[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['image'] = $row_user_tree['image'];
            $array_init_board_for_js[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['tree_type'] = $row_user_tree['tree_type'];
            $array_init_board_for_js[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['water_need'] = $row_user_tree['water_need'];
            $array_init_board_for_js[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['default_oxygen_give'] = $row_user_tree['default_oxygen_give'];
            $array_init_board_for_js[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['cost'] = $row_user_tree['cost'];
        }
    }
    
    
    /*$array_init_board = array(
        array('T','E','E','E','E','E','E','E','T','E','E','E','E','E','R','E'),
        array('E','E','E','E','T','T','E','E','E','E','E','T','T','R','R','E'),
        array('E','E','R','R','R','R','R','R','E','E','E','T','T','R','E','E'),
        array('E','E','R','E','E','E','E','R','E','E','E','E','E','R','E','E'),
        array('E','E','R','E','E','E','E','R','R','R','R','R','R','R','E','E'),
        array('E','E','R','T','T','E','E','E','T','E','E','E','T','T','E','E'),
        array('E','E','R','T','T','E','E','E','E','E','E','E','E','E','E','E'),
        array('E','E','R','R','R','R','R','T','E','E','E','E','E','T','E','E'),
        array('E','E','T','E','E','E','R','T','E','E','E','E','E','T','E','E')
    );*/
    
    /* Script pour insérer les éléments du plateau */
    /*for($i = 0; $i < count($array_init_board); $i++){
        for($j = 0; $j < count($array_init_board[$i]); $j++){
            $query_insert_user_tree = $bdd->prepare("INSERT INTO board_element (type, nb_row, nb_column) VALUES (:type, :nb_row, :nb_column)");
            $query_insert_user_tree->execute(array(
                ':type' => $array_init_board[$i][$j],
                ':nb_row' => $i,
                ':nb_column' => $j
            ));
        }
    }*/
    
    /* Requêtes pour changer les valeurs des éléments du plateau */
    "UPDATE board_element SET oxygen = 3000 WHERE type = 'empty'";
    "UPDATE board_element SET water = 100 WHERE type = 'empty'";
    
    "UPDATE board_element SET water = 200 WHERE type = 'river'";
    
    "UPDATE board_element SET oxygen = 7000 WHERE type = 'town'";
    
    
    //Récupère le fichier des fonctions php
    if(strstr($_SERVER["DOCUMENT_ROOT"], 'pji')){
        require_once $_SERVER["DOCUMENT_ROOT"].'/M1S2_PJI/utilities/fonctions.php';
    } else {
        require_once $_SERVER["DOCUMENT_ROOT"].'/pji/M1S2_PJI/utilities/fonctions.php';
    }
    

?>
