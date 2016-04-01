<?php
    require_once '../includes/config.php';
    
    if($_SESSION['current_PK_tree'] != 0){
    
        $query_insert_user_tree = $bdd->prepare("INSERT INTO asso_user_tree (FK_user, nb_row, nb_column, FK_tree) VALUES (:FK_user, :nb_row, :nb_column, :FK_tree)");
        $query_insert_user_tree->execute(array(
            ':FK_user' => intval($_SESSION['PK_user']),
            ':nb_row' => intval($_POST['row']),
            ':nb_column' => intval($_POST['column']),
            ':FK_tree' => intval($_SESSION['current_PK_tree'])
        ));
        
        $query_insert_user = $bdd->prepare("INSERT INTO user (FK_perso, username, password, email, ip_register) VALUES (:FK_perso, :username, :password, :email, :ip_register)");
        $query_insert_user->execute(array(
            ':FK_perso' => $PK_perso,
            ':username' => $username,
            ':password' => hash_password($password),
            ':email' => $email,
            ':ip_register' => get_ip()
        ));
    }
    
    $_SESSION['current_PK_tree'] = 0;
?>