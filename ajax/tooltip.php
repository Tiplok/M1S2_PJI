<?php
    require_once '../includes/config.php';
    
    $PK_table = filter_input(INPUT_POST, 'PK_table');
    $table = filter_input(INPUT_POST, 'table');
    $info = filter_input(INPUT_POST, 'info');
    
    
    if($table == 'tree'){
        
        // On récupère les informations de la fôret
        $query_tree = "SELECT * FROM tree WHERE PK_tree = ".$PK_table;
        $result_tree = $bdd->query($query_tree);
        $row_tree = $result_tree->fetch(PDO::FETCH_ASSOC);
        
        // Cas d'une fôret sur le plateau
        if($info == 'planted'){
            
            // On récupère la position de la fôret plantée
            $query_tree_position = "SELECT nb_row, nb_column FROM tree JOIN asso_user_tree ON PK_tree = FK_tree WHERE PK_tree = ".$PK_table;
            $result_tree_position = $bdd->query($query_tree_position);
            $row_tree_position = $result_tree_position->fetch(PDO::FETCH_ASSOC);
            
            // Avec cette position, on récupère les informations de la case vide où est plantée la fôret
            $query_element = "SELECT oxygen, water FROM board_element WHERE nb_row = ".$row_tree_position['nb_row'].' AND nb_column = '.$row_tree_position['nb_column'];
            $result_element = $bdd->query($query_element);
            $row_element = $result_element->fetch(PDO::FETCH_ASSOC);
?>

            <table id="table_tooltip">
                <caption>Fôret</caption>
                <tr>
                    <td>Type</td>
                    <td><?php echo $row_tree['tree_type'] ?></td>
                </tr>
                <tr>
                    <td>Oxygène produit</td>
                    <td>PH / <?php echo $row_tree['default_oxygen_give'] ?></td>
                </tr>
                <tr>
                    <td>Eau nécessaire</td>
                    <td>PH / <?php echo $row_tree['water_need'] ?></td>
                </tr>
            </table>


            <table id="table_tooltip">
                <caption>Case</caption>
                <tr>
                    <td>Oxygène requis</td>
                    <td>PH / <?php echo $row_element['oxygen'] ?></td>
                </tr>
                <tr>
                    <td>Eau fournie</td>
                    <td><?php echo $row_element['water'] ?></td>
                </tr>
            </table>

<?php
    
        // Cas d'une fôret dans la liste de séléction
        } else {
            
?>

            <table id="table_tooltip">
                <tr>
                    <td>Type</td>
                    <td><?php echo $row_tree['tree_type'] ?></td>
                </tr>
                <tr>
                    <td>Oxygène produit (max)</td>
                    <td><?php echo $row_tree['default_oxygen_give'] ?></td>
                </tr>
                <tr>
                    <td>Eau nécessaire</td>
                    <td><?php echo $row_tree['water_need'] ?></td>
                </tr>
            </table>

<?php
    
        }
        
    // Cas d'une ville
    } elseif($table == 'town') {
        if(is_numeric($PK_table)){
            
            $query_element = "SELECT oxygen FROM board_element WHERE PK_board_element = ".$PK_table;
            $result_element = $bdd->query($query_element);
            $row_element = $result_element->fetch(PDO::FETCH_ASSOC);
            
?>

            <table id="table_tooltip">
                <caption>Ville</caption>
                <tr>
                    <td>Population</td>
                    <td><?php echo number_format($row_element['oxygen']/700, 0, ',', ' ') ?></td>
                </tr>
                <tr>
                    <td>Oxygène nécessaire</td>
                    <td>PH / <?php echo number_format($row_element['oxygen'], 0, ',', ' ') ?></td>
                </tr>
            </table>

<?php  
            
        } else {
            echo 'Ville [informations indisponibles]';
        }
        
        
        
    // Cas d'une rivière
    } elseif($table == 'river'){
        
        if(is_numeric($PK_table)){
            
            $query_element = "SELECT water FROM board_element WHERE PK_board_element = ".$PK_table;
            $result_element = $bdd->query($query_element);
            $row_element = $result_element->fetch(PDO::FETCH_ASSOC);
            
?>

            <table id="table_tooltip">
                <caption>Rivière</caption>
                <tr>
                    <td>Eau fournie bonus</td>
                    <td><?php echo number_format($row_element['water'], 0, ',', ' ') ?></td>
                </tr>
            </table>

<?php  
            
        } else {
            echo 'Rivière [informations indisponibles]';
        }
        
    // Cas d'une case vide
    } elseif($table == 'empty'){
        if(is_numeric($PK_table)){
            
            $query_element = "SELECT oxygen, water FROM board_element WHERE PK_board_element = ".$PK_table;
            $result_element = $bdd->query($query_element);
            $row_element = $result_element->fetch(PDO::FETCH_ASSOC);
            
?>

            <table id="table_tooltip">
                <caption>Case</caption>
                <tr>
                    <td>Oxygène requis</td>
                    <td>PH / <?php echo number_format($row_element['oxygen'], 0, ',', ' ') ?></td>
                </tr>
                <tr>
                    <td>Eau fournie</td>
                    <td><?php echo number_format($row_element['water'], 0, ',', ' ') ?></td>
                </tr>
            </table>

<?php  
    
        } else {
            echo 'Vide [informations indisponibles]';
        }
    }
    
    
?>