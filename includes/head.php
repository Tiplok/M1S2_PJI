<!DOCTYPE html>

<html lang="fr">
<head>
    <meta charset="utf-8">
    <title><?php echo $title_project ?> - <?php echo $title_page ?></title>

    <!-- Pour utiliser les fonctions prototype -->
    <script type="text/javascript" src="<?php echo $folder;?>utilities/prototype/prototype_1.7.3.0.js"></script>
    
    <!-- Pour utiliser jQuery -->
    <script type="text/javascript" src="<?php echo $folder;?>utilities/jquery/jquery-1.12.0.js"></script>
    
    <script>jQuery.noConflict();</script>
    
    <!-- Pour utiliser le plugin jQuery qTip -->
    <script type="text/javascript" src="<?php echo $folder;?>utilities/tooltip/jquery.qtip.js"></script>

    <!-- Pour utiliser la classe JavaScript gridCase -->
    <script type="text/javascript" src="<?php echo $folder;?>utilities/case.js"></script>
    
    <!-- Pour utiliser les fonctions JavaScript -->
    <script type="text/javascript" src="<?php echo $folder;?>utilities/fonctions.js"></script>
    
    <!-- Lien vers le fichier css pour les tooltips qTip -->
    <link rel="stylesheet" type="text/css" href="<?php echo $folder;?>styles/jquery.qtip.css"/>
    
    <!-- Lien vers le fichier css général -->
    <link rel="stylesheet" type="text/css" href="<?php echo $folder;?>styles/style.css"/>
    
    <!-- Lien vers le favicon -->
    <link rel="icon" type="image/png" href="styles/images/favicon.png"/>
    
    <!-- Notification d'utilisation des cookies -->
    <script type="text/javascript">window.cookieconsent_options = {"message":"En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de Cookies.","dismiss":"Ok, j'ai compris !","learnmore":"Plus d'infos.","link":null,"theme":"dark-top"};</script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>
</head>