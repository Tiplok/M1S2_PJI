<?php
    $query_user = "SELECT money FROM user WHERE PK_user = ".$_SESSION['PK_user'];
    $result_user = $bdd->query($query_user);
    $row_user = $result_user->fetch(PDO::FETCH_ASSOC);

    echo $row_user['money'];
?>