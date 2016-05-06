<?php
    require_once '../includes/config.php';
    
    $array_element = filter_input(INPUT_POST, 'array');
    
    // On recupère un PK_table au lieu d'un array si c'est un arbre de la liste de selection
    $PK_table = filter_input(INPUT_POST, 'PK_table');
    
    $array_element = str_replace('\'', '"', $array_element);
    $array_element = json_decode($array_element, true);
    
    // Cas d'une fôret sur le plateau
    if($array_element['type'] == 'A'){
            
        // On récupère la position de la fôret plantée
        /*$query_tree_position = "SELECT nb_row, nb_column FROM tree JOIN asso_user_tree ON PK_tree = FK_tree WHERE PK_tree = ".$PK_table;
        $result_tree_position = $bdd->query($query_tree_position);
        $row_tree_position = $result_tree_position->fetch(PDO::FETCH_ASSOC);*/

        // Avec cette position, on récupère les informations de la case vide où est plantée la fôret
        /*$query_element = "SELECT oxygen, water FROM board_element WHERE nb_row = ".$row_tree_position['nb_row'].' AND nb_column = '.$row_tree_position['nb_column'];
        $result_element = $bdd->query($query_element);
        $row_element = $result_element->fetch(PDO::FETCH_ASSOC);*/
?>

        <table id="table_tooltip">
            <caption>Fôret</caption>
            <tr>
                <td>Type</td>
                <td><?php echo $array_element['data']['tree_type'] ?></td>
            </tr>
            <tr>
                <td>Oxygène produit</td>
                <td><?php echo round($array_element['data']['oxygen_give']) ?> / <?php echo $array_element['data']['default_oxygen_give'] ?></td>
            </tr>
            <tr>
                <td>Eau nécessaire</td>
                <td><?php echo $array_element['data']['water_received'] ?> / <?php echo $array_element['data']['water_need'] ?></td>
            </tr>
        </table>


        <table id="table_tooltip">
            <caption>Case</caption>
            <tr>
                <td>Oxygène requis</td>
                <td><?php echo round($array_element['data']['oxygen_received']) ?> / <?php echo $array_element['data']['oxygen_need'] ?></td>
            </tr>
            <tr>
                <td>Eau fournie</td>
                <td><?php echo ($array_element['data']['water_received'] == 0) ? $array_element['data']['water_give'] : $array_element['data']['water_received'] ?></td>
            </tr>
        </table>

<?php
    
    // Cas d'une fôret dans la liste de séléction
    } elseif($array_element == null){ 

        // On récupère les informations de la fôret
        $query_tree = "SELECT * FROM tree WHERE PK_tree = ".$PK_table;
        $result_tree = $bdd->query($query_tree);
        $row_tree = $result_tree->fetch(PDO::FETCH_ASSOC);
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
        
    // Cas d'une ville
    } elseif($array_element['type'] == 'T') {
            
?>

            <table id="table_tooltip">
                <caption>Ville</caption>
                <tr>
                    <td>Population</td>
                    <td><?php echo number_format($array_element['data']['oxygen_need']/70, 0, ',', ' ') ?></td>
                </tr>
                <tr>
                    <td>Oxygène nécessaire</td>
                    <td><?php echo round($array_element['data']['oxygen_received']) ?> / <?php echo number_format($array_element['data']['oxygen_need'], 0, ',', ' ') ?></td>
                </tr>
            </table>

<?php  
        
        
        
    // Cas d'une rivière
    } elseif($array_element['type'] == 'R'){
        
?>

            <table id="table_tooltip">
                <caption>Rivière</caption>
                <tr>
                    <td>Eau fournie bonus</td>
                    <td><?php echo number_format($array_element['data']['water_give'], 0, ',', ' ') ?></td>
                </tr>
            </table>

<?php  
        
    // Cas d'une case vide
    } elseif($array_element['type'] == 'E'){
            
?>

            <table id="table_tooltip">
                <caption>Case</caption>
                <tr>
                    <td>Oxygène requis</td>
                    <td><?php echo round($array_element['data']['oxygen_received']) ?> / <?php echo number_format($array_element['data']['oxygen_need'], 0, ',', ' ') ?></td>
                </tr>
                <tr>
                    <td>Eau fournie</td>
                    <td><?php echo number_format($array_element['data']['water_give'], 0, ',', ' ') ?></td>
                </tr>
            </table>

<?php  
    }
    
    
?>