<?php
    require_once 'includes/config.php';
    $title_page = 'Accueil';
    require_once 'includes/head.php';
?>

<body>

<?php
    if(!is_logged()) {
        header('Location: index.php');
        exit;
    }
    require_once 'includes/menu.php';
?>

    <div id="main">
        <h1>Accueil</h1>

        Bienvenue dans <?php echo $title_project ?> !<br>
        Vous êtes désormais connecté <span id="bold"><?php echo $_SESSION['username'] ?></span> !<br><br>
    </div>

<?php
    require_once 'includes/footer.php';
?>