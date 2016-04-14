<?php
    require_once 'includes/config.php';
    $title_page = 'Profil';
    if(!is_logged()) {
        header('Location: index.php');
        exit;
    }
    require_once 'includes/head.php';
?>

<body>

<?php
    
    require_once 'includes/menu.php';
    
    $new_password = htmlspecialchars(filter_input(INPUT_POST, 'new_password'));
    $form_reply = '';
    
    $query_info_username = "SELECT username, password, date_register FROM user WHERE username = '".$_SESSION['username']."'";
    $result_info_username = $bdd->query($query_info_username);
    $row_info_username = $result_info_username->fetch(PDO::FETCH_ASSOC);
    
    if(isset($_POST['submit'])) {
        if($row_info_username['password'] == hash_password($_POST['password'])) {

            if(!empty($_POST['new_password'])) {
                if(strlen($new_password) < 5 || strlen($new_password) > 20) {
                    $form_reply .= 'Votre nouveau mot de passe doit contenir entre 5 et 20 caractères.<br>';
                } else {
                    if(($_POST['new_password']) != $_POST['new_password_verif']) {
                        $form_reply .= 'Les mots de passes saisis doivent être identiques.';
                    } else {
                        $send_new_password = $bdd->prepare('UPDATE user SET password= :password WHERE username= :username');
                        $send_new_password->execute(array(
                        ':password' => hash_password($new_password),
                        ':username' => $_SESSION['username']));
                    }
                }
            }

            if(isset($_POST['delete_account'])) {
                $set_del_account = $bdd->prepare('UPDATE user SET auth_level= :auth_level WHERE username= :username');
                $set_del_account->execute(array(
                ':auth_level' => 'del',
                ':username' => $_SESSION['username']));
                
                header('Location: logout.php');
            }

            if((empty($_POST['new_password'])) && empty($_POST['delete_account'])) {
                $form_reply .= 'Veuillez modifier au moins un champ.';
            }

        } else {
            $form_reply .= 'Le mot de passe actuel saisi est incorrect.';
        }
    }
    

?>
    <div id="main">
        
        <h1>Mon compte</h1>
        
        <form action="profile.php" method="post">
            <table id="table_profile">
                <tr>
                    <td class="label_profile">Nom d'utilisateur : </td>
                    <td class="input_profile"><input type="text" name="username" value="<?php echo $row_info_username['username'];?>" disabled="disabled"></td>
                </tr>
                <tr>
                    <td class="label_profile">Mot de passe : </td>
                    <td class="input_profile"><input type="password" name="password" id="password"></td>
                </tr>
                <tr>
                    <td class="label_profile">Nouveau mot de passe : </td>
                    <td class="input_profile"><input type="password" name="new_password" id="new_password"></td>
                </tr>
                <tr>
                    <td class="label_profile">Confirmation du mot de passe : </td>
                    <td class="input_profile"><input type="password" name="new_password_verif" id="new_password_verif"></td>
                </tr>
                <tr>
                    <td class="label_profile">Date d'inscription : </td>
                    <td class="input_profile"><input type="text" name="date_register" id="date_register" value="<?php echo $row_info_username['date_register'];?>" disabled="disabled"></td>
                </tr>
                <tr>
                    <td class="label_profile">Supprimer votre compte : </td>
                    <td class="input_profile"><input type="checkbox" name="delete_account"></td>
                </tr>
                <tr>
                    <td colspan="2" class="valid_profile"><input type="submit" name="submit" value="Valider"></td>
                </tr>
            </table>
        </form>
        
        <?php 
            echo $form_reply;
        ?>
    </div>

 <?php
    require_once 'includes/footer.php';

?>