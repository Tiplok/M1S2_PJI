<?php
    require_once '../includes/config.php';
    
    if($_SESSION['current_PK_tree'] != 0){
    
        $query_user = "SELECT money FROM user WHERE PK_user = ".$_SESSION['PK_user'];
        $result_user = $bdd->query($query_user);
        $row_user = $result_user->fetch(PDO::FETCH_ASSOC);
        
        $query_tree = "SELECT cost FROM tree WHERE PK_tree = ".$_SESSION['current_PK_tree'];
        $result_tree = $bdd->query($query_tree);
        $row_tree = $result_tree->fetch(PDO::FETCH_ASSOC);
        
        if($row_user['money'] > $row_tree['cost']){
        
            $query_insert_user_tree = $bdd->prepare("INSERT INTO asso_user_tree (FK_user, nb_row, nb_column, FK_tree) VALUES (:FK_user, :nb_row, :nb_column, :FK_tree)");
            $query_insert_user_tree->execute(array(
                ':FK_user' => intval($_SESSION['PK_user']),
                ':nb_row' => intval($_POST['row']),
                ':nb_column' => intval($_POST['column']),
                ':FK_tree' => intval($_SESSION['current_PK_tree'])
            ));


            $query_money = "UPDATE user SET money = :money WHERE PK_user = ".$_SESSION['PK_user'];
            $result_money = $bdd->prepare($query_money);
            $result_money->execute(array(
            ':money' => $row_user['money']-$row_tree['cost']));
        } else {
            echo 'Vous n\'avez plus assez d\'argent pour planter cette fôret.';
        }
    }
    
    $_SESSION['current_PK_tree'] = 0;
?>