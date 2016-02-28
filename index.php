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
    
    
    $register = filter_input(INPUT_POST, 'register');
    $register_reply = '';
    $login = filter_input(INPUT_POST, 'login');
    $login_error = '';
    
    // Dans le cas de l'inscription
    if($register){
        $register_username = htmlspecialchars(filter_input(INPUT_POST, 'username'));
        $password = htmlspecialchars(filter_input(INPUT_POST, 'password'));
        $password_verif = htmlspecialchars(filter_input(INPUT_POST, 'password_verif'));
        
        //Si tous les champs sont remplis
        if($register_username && $password && $password_verif) {

            //Vérification de la taille de l'username
            if(strlen($register_username) < 3 || strlen($register_username) > 20) {
                $register_reply .= 'Votre nom d\'utilisateur doit contenir entre 3 et 20 caractères.<br>';
            }

            //Vérification si des espaces sont présents
            if(preg_match("/ /", $register_username)) {
                $register_reply .= 'Votre nom d\'utilisateur ne peut pas contenir d\'espaces.<br>';
            }

            //Vérification des caractères de l'username
            if(!preg_match("/^[A-Za-z0-9]+$/", $register_username)) {
                $register_reply .= 'Votre nom d\'utilisateur ne peut contenir que des caractères alphanumériques (A-Z, a-z, 0-9).<br>';
            }

            //Vérification si l'username est interdit
            if(in_array(strtolower($register_username), $array_username_forbidden)) {
                $register_reply .= 'Votre nom d\'utilisateur n\'est pas autorisé.<br>';
            }

            //Vérification si l'username est déjà pris
            $query_username = "SELECT username FROM user WHERE username = ".$bdd->quote($register_username);
            $result_username = $bdd->query($query_username);
            if($result_username->rowCount() > 0) {
                $register_reply .= 'Votre nom d\'utilisateur n\'est pas disponible.<br>';
            }

            //Vérification de la taille du mot de passe
            if(strlen($password) < 5 || strlen($password) > 20) {
                $register_reply .= 'Votre mot de passe doit contenir entre 5 et 20 caractères.<br>';
            }

            //Vérification de la confirmation du mot de passe
            if($password != $password_verif) {
                $register_reply .= 'Les mots de passe saisis sont différents.<br>';
            }

            //Aucune erreur de saisie
            if($register_reply == '') {

                $query_insert_user = $bdd->prepare("INSERT INTO user (username, password) VALUES (:username, :password)");
                $query_insert_user->execute(array(
                        ':username' => $register_username,
                        ':password' => hash_password($password)
                ));

                $register_reply = '<b>Inscription réussie !</b><br><br>';
            } else {
                $register_reply .= '<br>';
            }

        } else {
                $register_reply = 'Veuillez remplir tous les champs.<br><br>';
        }
    }
    
    // Dans le cas de la connexion
    if($login){
        $login_username = htmlspecialchars(filter_input(INPUT_POST, 'username'));
        $password = htmlspecialchars(filter_input(INPUT_POST, 'password'));
        
        if($login_username && $password) {

            //Authentification
            $query_username = "SELECT username FROM user WHERE username = ".$bdd->quote($login_username)." AND password = '".hash_password($password)."'";
            $result_username = $bdd->query($query_username);

            //Si on trouve l'utilisateur
            if($result_username->rowCount() == 1) {
                
                $info_username = "SELECT auth_level, date_last_login FROM user WHERE username = ".$bdd->quote($login_username);
                $result_info_username = $bdd->query($info_username);
                $row_info_username = $result_info_username->fetch(PDO::FETCH_ASSOC);
                
                if($row_info_username['auth_level'] == 'del' OR $row_info_username['auth_level'] == 'ban') {
                    $login_error .= 'Ce compte est désactivé.<br><br>';
                } else {

                    $row_username = $result_username->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['username'] = $row_username['username'];

                    //On met à jour la date de la dernière connexion
                    $query_update_user = $bdd->prepare("UPDATE user SET date_last_login = :date_last_login WHERE username = ". $bdd->quote($_SESSION['username']));
                    $query_update_user->execute(array(
                        ':date_last_login' => date('Y-m-d H:i:s')
                    ));

                    header('Location: home.php');
                    exit;
                }

            } else {
                $login_error = 'Les informations saisies sont incorrectes.<br><br>';
            }

        } else {
            $login_error = 'Veuillez remplir tous les champs.<br><br>';
        }
    }

?>
    <div id="main">
        <h1>Accueil</h1>
        
        <p>Bienvenue sur <?php echo $title_project; ?> !</p>
        
        <div id="div_login">
            <h2>Connexion</h2>

                <form action="index.php" method="post">
                    Nom d'utilisateur :<br>
                    <input type="text" name="username" value="<?php echo isset($login_username)?$login_username:'' ?>"><br>

                    Mot de passe :<br>
                    <input type="password" name="password" value=""><br>

                    <?php
                        echo '<br>'.$login_error;
                    ?>
                    <input type="submit" name="login" value="Se connecter">
                </form>
        </div>
        <div id="div_register">
            <h2>Inscription</h2>

            <form action="index.php" method="post">
                Nom d'utilisateur :<br>
                <input type="text" name="username" value="<?php echo isset($register_username)?$register_username:''; ?>"><br>

                Mot de passe :<br>
                <input type="password" name="password" value=""><br>

                Vérification du mot de passe :<br>
                <input type="password" name="password_verif" value=""><br>

                <?php
                    echo '<br>'.$register_reply;
                ?>
                
                <input type="submit" name="register" value="Valider" >
            </form>
        </div>
        <div style="clear: both"></div>
    </div>

 <?php
    require_once 'includes/footer.php';

 ?>