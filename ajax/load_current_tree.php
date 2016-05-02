<?php
    require_once '../includes/config.php';
    
    if($_SESSION['current_PK_tree'] != $_POST['PK_tree']){
        $_SESSION['current_PK_tree'] = $_POST['PK_tree'];
        
    // On déselectionne la forêt ou le mode déforestation
    } else {
        $_SESSION['current_PK_tree'] = -1;
    }
?>