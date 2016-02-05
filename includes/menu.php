<?php
    echo '<div id="menu">';

    if(!is_logged()) {

?>
        <header>
            <nav id="nav_menu_nolog">
                <ul>
                    <li><a href="<?php echo $folder;?>index.php" title="Accueil">Accueil</a></li>
                    <li><a href="<?php echo $folder;?>about.php" title="Pour en savoir plus">A propos</a></li>
                </ul>
            </nav>
        </header>

<?php

    } else {

?>
        <header>
            <nav id="nav_menu">
                <ul>
                    <li><a href="<?php echo $folder;?>profile.php" title="Votre compte">Mon compte</a></li>
                    <li><a href="<?php echo $folder;?>message.php" title="Vos messages">Messagerie</a></li>
                    <li><a href="<?php echo $folder;?>about.php" title="Pour en savoir plus">A propos</a></li>
                    <li><a href="<?php echo $folder;?>logout.php" title="Se déconnecter">Déconnexion</a></li>
                </ul>
            </nav>
<?php 
                $auth_level = "SELECT auth_level FROM user WHERE username = ".$bdd->quote($_SESSION['username']);
                $req_auth_level = $bdd->query($auth_level);
                $row_auth_level = $req_auth_level->fetch(PDO::FETCH_ASSOC);
                
                // Partie administrateur
                if($row_auth_level['auth_level'] == 'admin') {
?>
                <ul>
                    <li><a href="<?php echo $folder;?>admin/admin_config.php" title="Configuration administrateur">Configuration administrateur</a></li>
                </ul>
<?php
                }
?>
            </nav>
        </header>
<?php

    }
    echo '</div>';

?>