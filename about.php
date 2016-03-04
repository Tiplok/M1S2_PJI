<?php
    require_once 'includes/config.php';
    $title_page = 'A propos';
    require_once 'includes/head.php';
?>

<body>

<?php
    require_once 'includes/menu.php';

?>
    <div id="main">
        <h1>A propos</h1>
        
        <p>
            <?php echo $title_project ?> est un projet développé dans le cadre d'un master informatique.<br>
            Ce site est développé par Nicolas Vasseur et Valentin Ramecourt.<br><br>
            Vous pouvez retrouver le git du projet à <a href="https://github.com/Tiplok/M1S2_PJI">cette adresse</a>.<br>
            Retrouvez <a href="https://github.com/Tiplok/M1S2_PJI/wiki/R%C3%A8gles-du-jeu">ici</a> le détail des règles du jeu.<br>
        </p>
    </div>

 <?php
    require_once 'includes/footer.php';

?>