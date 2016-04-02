<?php
    require_once '../includes/config.php';
    
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
    
?>