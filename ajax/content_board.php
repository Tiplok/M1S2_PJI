<?php
    require_once '../includes/config.php';

    $array_board = $array_init_board;
    
    $query_user_tree = "SELECT * FROM asso_user_tree WHERE FK_user = ".$_SESSION['PK_user'];
    $result_user_tree = $bdd->query($query_user_tree);
    while($row_user_tree = $result_user_tree->fetch(PDO::FETCH_ASSOC)){
    
        $array_board[$row_user_tree['nb_row']][$row_user_tree['nb_column']] = $row_user_tree['FK_tree'];
    }
    
    
    $query_list_tree = "SELECT PK_tree, name, cost, image FROM tree";
    $result_list_tree = $bdd->query($query_list_tree);
?>

<h1>Plateau du jeu</h1>

<div id="div_score">
    Score : 0
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

                        // Si on trouve un nombre dans le tableau du plateau, alors il s'agit d'un arbre, sinon c'est soit vide, une ville ou une rivière.
                        if(is_numeric($array_board[$nb_row][$nb_column])){

                            // On récupère l'image de l'arbre en question
                            $query_img_tree = "SELECT image FROM tree WHERE PK_tree = ".$array_board[$nb_row][$nb_column];
                            $result_img_tree = $bdd->query($query_img_tree);
                            $row_img_tree = $result_img_tree->fetch(PDO::FETCH_ASSOC);

                            echo '<td><img height="64px" width="64px" src="styles/images/board_icons/'.$row_img_tree['image'].'" alt="tree" onclick="removeTree('.$nb_row.', '.$nb_column.')"/></td>';
                        } elseif($array_board[$nb_row][$nb_column] == 'E') {
                            // On affiche une case vide
                            echo '<td class="empty_td"><img height="64px" width="64px" src="styles/images/board_icons/empty.png" alt="empty" onclick="plantCurrentTree('.$nb_row.', '.$nb_column.')"/></td>';
                        } else {
                            // On affiche l'image correspondant soit à une ville ou une rivière
                            echo $array_display[$array_board[$nb_row][$nb_column]];
                        }
                    }
                    echo '</tr>';
                }
        ?>
    </table>
</div>

<?php
    $query_user = "SELECT money FROM user WHERE PK_user = ".$_SESSION['PK_user'];
    $result_user = $bdd->query($query_user);
    $row_user = $result_user->fetch(PDO::FETCH_ASSOC);

    echo 'Argent disponible : '.number_format($row_user['money'], 0, ',', ' '). ' €.';

?>

<div id="div_trees_select">
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
                <img src="styles/images/board_icons/<?php echo $row_list_tree['image']; ?>" alt="tree" <?php if($_SESSION['current_PK_tree'] == $row_list_tree['PK_tree']) { echo 'style="border:solid 3px white;"'; } ?> height="64px" width="64px;" onclick="loadCurrentTree(<?php echo $row_list_tree['PK_tree']; ?>)"/>
            </td>
            <td class="td_tree_text"><?php echo $row_list_tree['name']; ?></td>
            <td class="td_tree_text"><?php echo number_format($row_list_tree['cost'], 0, ',', ' '); ?></td>
        </tr>
        <?php
            }
        ?>
    </table>
</div>

<div style="clear: both"></div>