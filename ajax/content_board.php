<?php
    require_once '../includes/config.php';
    $array_board = json_decode(filter_input(INPUT_POST, 'array_board'), true);
    $total_score = filter_input(INPUT_POST, 'total_score');
    $gridCase = filter_input(INPUT_POST, 'gridCase');
    //var_dump($array_board);

    /*$array_board = $array_init_board_for_js;
    
    $query_user_tree = "SELECT * FROM asso_user_tree JOIN tree ON FK_tree = PK_tree WHERE FK_user = ".$_SESSION['PK_user'];
    $result_user_tree = $bdd->query($query_user_tree);
    while($row_user_tree = $result_user_tree->fetch(PDO::FETCH_ASSOC)){
        $array_board[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['type'] = 'tree';
        $array_board[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['PK_tree'] = $row_user_tree['PK_tree'];
        $array_board[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['image'] = $row_user_tree['image'];
        $array_board[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['tree_type'] = $row_user_tree['tree_type'];
        $array_board[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['water_need'] = $row_user_tree['water_need'];
        $array_board[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['default_oxygen_give'] = $row_user_tree['default_oxygen_give'];
        $array_board[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['cost'] = $row_user_tree['cost'];
        if(!empty($gridCase) && $gridCase['abs'] == $row_user_tree['nb_row'] && $gridCase['ord'] == $row_user_tree['nb_column']){
            $array_board[$row_user_tree['nb_row']][$row_user_tree['nb_column']]['data']['water_received'] = $gridCase['data']['water_received'];
            var_dump($gridCase['data']['water_received']);
        }
    }*/
    
    /*$query_board_element = "SELECT * FROM board_element";
    $result_board_element = $bdd->query($query_board_element);
    $array_board_element = array();
    while($row_board_element = $result_board_element->fetch(PDO::FETCH_ASSOC)){
        
        // Création d'un tableau à 2 dimensions (row et column) avec le PK concernant les éléments fixes du plateau
        $array_board_element[$row_board_element['nb_row']][$row_board_element['nb_column']]['PK_board_element'] = $row_board_element['PK_board_element'];
    }*/
    
    
    $query_list_tree = "SELECT PK_tree, tree_type, cost, image FROM tree";
    $result_list_tree = $bdd->query($query_list_tree);
    
    // On recupère l'argent et le meilleur score de l'utilisateur
    $query_user = "SELECT money, best_score FROM user WHERE PK_user = ".$_SESSION['PK_user'];
    $result_user = $bdd->query($query_user);
    $row_user = $result_user->fetch(PDO::FETCH_ASSOC);
    
    // Si il y a un score, on met à jour le score dans la BDD
    if($total_score){
        $total_score = round($total_score);
        
        $query_money = "UPDATE user SET actual_score = :actual_score WHERE PK_user = ".$_SESSION['PK_user'];
        $result_money = $bdd->prepare($query_money);
        $result_money->execute(array(
        ':actual_score' => $total_score));

        if($row_user['best_score'] < $total_score){
            $query_money = "UPDATE user SET best_score = :best_score WHERE PK_user = ".$_SESSION['PK_user'];
            $result_money = $bdd->prepare($query_money);
            $result_money->execute(array(
            ':best_score' => $total_score));
        }
    }
?>

<h1>Plateau du jeu</h1>

<div id="div_score">
    Score actuel : <?php echo $total_score?display_nb($total_score):0; ?> (Meilleur score : <?php echo display_nb($row_user['best_score']); ?>)
</div>

<br>

<div id="div_board">
    <table id="table_board">
        <tr>
            <th colspan="16">
                Plateau
            </th>
        </tr>
        <?php
                for($nb_row=0;$nb_row<9;$nb_row++){
                    echo '<tr>';
                    for($nb_column=0;$nb_column<16;$nb_column++){
                        // Cas d'un arbre
                        if($array_board[$nb_row][$nb_column]['type'] == 'A'){
                            echo '<td><img class="tooltip" data-array="'.str_replace('"', '\'',html_entity_decode(json_encode($array_board[$nb_row][$nb_column]))).
                                '" height="100%" width="100%" src="styles/images/board_icons/'.
                                $array_board[$nb_row][$nb_column]['data']['image'].'" alt="tree" onclick="removeTree('.$nb_row.', '.$nb_column.
                                ', '.(isset($_SESSION['current_PK_tree'])&&$_SESSION['current_PK_tree']==0?'true':'false').')"/></td>';
                            
                        // Autres cas
                        } else {
                            echo '<td><img class="tooltip" data-array="'.str_replace('"', '\'',html_entity_decode(json_encode($array_board[$nb_row][$nb_column]))).
                                '" height="100%" width="100%" src="styles/images/board_icons/'.$array_board[$nb_row][$nb_column]['type'].
                                '.png" alt="'.$array_board[$nb_row][$nb_column]['type'].'" '.
                                (($array_board[$nb_row][$nb_column]['type'] == 'E') ? 'onclick="plantCurrentTree('.$nb_row.', '.$nb_column.', '.$_SESSION['current_PK_tree'].')"/></td>' : '/></td>');
                        }
                    }
                    echo '</tr>';
                }
        ?>
        
    </table>
</div>

<div id="div_trees_select">
    
<?php

    echo 'Argent disponible : <span id="current_money">'.number_format($row_user['money'], 0, ',', ' ').'</span>'. ' €.';

?>

    <table id="table_trees_select">
        <tr>
            <th colspan="3">Selection des fôrets</th>
        </tr>
        <?php 

            // On liste les différents arbres disponibles
            while($row_list_tree = $result_list_tree->fetch(PDO::FETCH_ASSOC)){
        ?>
        <tr>
            <td class="td_tree_img">
                <img class="tooltip" data-PK_table="<?php echo $row_list_tree['PK_tree']; ?>" data-table="tree" src="styles/images/board_icons/<?php echo $row_list_tree['image']; ?>" alt="tree" <?php if($_SESSION['current_PK_tree'] == $row_list_tree['PK_tree']) { echo 'style="border:solid 3px white;"'; } ?> height="100%" width="100%" onclick="loadCurrentTree(<?php echo $row_list_tree['PK_tree']; ?>)"/>
            </td>
            <td class="td_tree_text"><?php echo $row_list_tree['tree_type']; ?></td>
            <td class="td_tree_text"><?php echo number_format($row_list_tree['cost'], 0, ',', ' '); ?> €</td>
        </tr>
        <?php
            }
        ?>
        <tr>
            <td colspan="3">
                <span <?php if($_SESSION['current_PK_tree'] == 0) { echo 'style="border:solid 5px red;"'; } ?>>
                        <input type="button" value="Mode déforestation" onclick="loadCurrentTree(0)" />
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <input type="button" value="Retirer toutes les fôrets" onclick="removeTree(-1,-1, false)" />
            </td>
        </tr>
    </table>
</div>

<div style="clear: both"></div>