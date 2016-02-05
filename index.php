<?php
    require_once 'includes/config.php';
    $title_page = 'Accueil';
    require_once 'includes/head.php';
?>

<body>

<?php
    if(is_logged()) {
        header('Location: home.php');
        exit;
    }
    require_once 'includes/menu.php';

?>
    <div id="main">
        <h1>Accueil</h1>
    </div>

 <?php
    require_once 'includes/footer.php';

 ?>