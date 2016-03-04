<?php
    require_once 'includes/config.php';
    $title_page = 'Plateau du jeu';
    require_once 'includes/head.php';
?>

<body>

<?php
    require_once 'includes/menu.php';

    $query_list_tree = "SELECT name, image FROM tree";
    $result_list_tree = $bdd->query($query_list_tree);
?>
    <div id="main">
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

                        for($j=0;$j<9;$j++){
                            echo '<tr>';
                            for($i=0;$i<16;$i++){
                                if($i%2 == 0){
                                    echo '<td><img height="64px" width="64px" src="styles/images/board_icons/river.png" alt="river" /></td>';
                                } elseif($i%3) {
                                    echo '<td><img height="64px" width="64px" src="styles/images/board_icons/oak.png" alt="tree" /></td>';
                                } elseif($i%5) {
                                    echo '<td><img height="64px" width="64px" src="styles/images/board_icons/city.png" alt="city" /></td>';
                                } else {
                                    echo '<td class="empty_td"><img height="64px" width="64px" src="styles/images/board_icons/empty.png" alt="empty" /></td>';
                                }
                                
                            }
                            echo '</tr>';
                        }
                ?>
            </table>
        </div>
        
        <div id="div_trees_select">
            <table id="table_trees_select">
                <tr>
                    <th colspan="2">Selection des arbres</th>
                </tr>
                <?php 
                    while($row_list_tree = $result_list_tree->fetch(PDO::FETCH_ASSOC)){
                ?>
                <tr>
                    <td class="td_tree_img">
                        <img src="styles/images/board_icons/<?php echo $row_list_tree['image']; ?>" alt="" height="64px" width="64px;"/>
                    </td>
                    <td class="td_tree_text"><?php echo $row_list_tree['name']; ?></td>
                </tr>
                <?php
                    }
                ?>
            </table>
        </div>
        
        <div style="clear: both"></div>
    </div>

 <?php
    require_once 'includes/footer.php';

?>