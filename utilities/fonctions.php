<?php

    /**
    * Vérifie si l'utilisateur est connecté (ou pas banni)
    */
    function is_logged() {
        if(isset($_SESSION['username'])) {
            global $bdd;
            $info_username = "SELECT auth_level FROM user WHERE username = ".$bdd->quote($_SESSION['username']);
            $result_info_username = $bdd->query($info_username);
            $row_info_username = $result_info_username->fetch(PDO::FETCH_ASSOC);

            if($row_info_username['auth_level'] == 'ban' OR $row_info_username['auth_level'] == 'del') {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
    
    function hash_password($password) {
        return crypt($password, '$65egh@5+2-f');
    }