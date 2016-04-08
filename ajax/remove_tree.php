<?php
    require_once '../includes/config.php';
    
    // Cas où on demande de retirer toutes les fôrets
    if($_POST['row'] == -1 && $_POST['column'] == -1){
        
        $query_PK_tree = "SELECT cost FROM asso_user_tree JOIN tree ON FK_tree = PK_tree WHERE FK_user = ".$_SESSION['PK_user'];
        $result_PK_tree = $bdd->query($query_PK_tree);
        
        
        // Si l'utilisateur a planté au moins 1 fôret
        if($result_PK_tree->rowCount() > 0){
        
            $money_to_give = 0;
            
            // On parcourt les fôrets de l'utilisateur pour savoir leurs valeurs
            while($row_PK_tree = $result_PK_tree->fetch(PDO::FETCH_ASSOC)){
                $money_to_give += $row_PK_tree['cost'];
            }
            
            // On recupère l'argent que l'utilisateur possède
            $query_user = "SELECT money FROM user WHERE PK_user = ".$_SESSION['PK_user'];
            $result_user = $bdd->query($query_user);
            $row_user = $result_user->fetch(PDO::FETCH_ASSOC);
            
            // On lui donne la valeur des fôrets détruites
            $query_money = "UPDATE user SET money = :money WHERE PK_user = ".$_SESSION['PK_user'];
            $result_money = $bdd->prepare($query_money);
            $result_money->execute(array(
            ':money' => $row_user['money']+$money_to_give));
            
            // On supprime toutes les fôrets de l'utilisateur
            $bdd->exec('DELETE FROM asso_user_tree WHERE FK_user = '.$_SESSION['PK_user']);
        }
        
        
        
    } else {
    
        $query_PK_tree = "SELECT FK_tree FROM asso_user_tree WHERE FK_user = ".$_SESSION['PK_user']." AND nb_row = ".$_POST['row']." AND nb_column = ".$_POST['column'];
        $result_PK_tree = $bdd->query($query_PK_tree);
        $row_PK_tree = $result_PK_tree->fetch(PDO::FETCH_ASSOC);

        $bdd->exec('DELETE FROM asso_user_tree WHERE FK_user = '.$_SESSION['PK_user'].' AND nb_row = '.$_POST['row'].' AND nb_column = '.$_POST['column']);

        $query_user = "SELECT money FROM user WHERE PK_user = ".$_SESSION['PK_user'];
        $result_user = $bdd->query($query_user);
        $row_user = $result_user->fetch(PDO::FETCH_ASSOC);

        $query_tree = "SELECT cost FROM tree WHERE PK_tree = ".$row_PK_tree['FK_tree'];
        $result_tree = $bdd->query($query_tree);
        $row_tree = $result_tree->fetch(PDO::FETCH_ASSOC);

        $query_money = "UPDATE user SET money = :money WHERE PK_user = ".$_SESSION['PK_user'];
        $result_money = $bdd->prepare($query_money);
        $result_money->execute(array(
        ':money' => $row_user['money']+$row_tree['cost']));
    }
    
?>