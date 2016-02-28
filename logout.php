<?php 
    session_start();
    
    if(isset($_SESSION['username'])) {
        $_SESSION = array(); //On efface toutes les variables de la session
        session_destroy(); //Puis on détruit la session
    }
	
    header('Location: index.php');
?>