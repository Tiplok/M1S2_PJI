<?php
    require_once 'includes/config.php';
    $title_page = 'Plateau du jeu';
    if(!is_logged()) {
        header('Location: index.php');
        exit;
    }
    require_once 'includes/head.php';
    
    $encoded_array = json_encode($array_init_board_for_js);
    $encoded_array = str_replace('"', '\'', $encoded_array);
?>

<body onload="sendInitBoard(<?php echo $encoded_array; ?>);loadContentBoard();">

<?php
    require_once 'includes/menu.php';
?>
    <div id="main">
        
    </div>

 <?php
    require_once 'includes/footer.php';

?>