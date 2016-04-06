<?php
    require_once 'includes/config.php';
    $title_page = 'Classement';
    require_once 'includes/head.php';
?>

<body>

<?php
    require_once 'includes/menu.php';

?>
    <div id="main">
        <h1>Classement</h1>
        
        <?php
            $query_user = "SELECT username, best_score FROM user ORDER BY best_score DESC";
            $result_user = $bdd->query($query_user);
        ?>
        
        <table id="table_leaderboard">
            <tr>
                <th>
                    Position
                </th>
                <th>
                    Nom du joueur
                </th>
                <th>
                    Meilleur score
                </th>
            </tr>

<?php
        $rank = 1;
        while($row_user = $result_user->fetch(PDO::FETCH_ASSOC)) {
?>

            <tr>
                <?php if(isset($_SESSION['username']) && $row_user['username'] == $_SESSION['username']) { echo '<td class="myrank">'.$rank.'</td>'; } else { echo '<td>'.$rank.'</td>'; } ?>
                
                <?php if(isset($_SESSION['username']) && $row_user['username'] == $_SESSION['username']) { echo '<td class="myrank">'.$row_user['username'].'</td>'; } else { echo '<td>'.$row_user['username'].'</td>'; } ?>
                
                <?php if(isset($_SESSION['username']) && $row_user['username'] == $_SESSION['username']) { echo '<td class="myrank">'.display_nb($row_user['best_score']).'</td>'; } else { echo '<td>'.display_nb($row_user['best_score']).'</td>'; } ?>
                
            </tr>

<?php
            $rank++;
        }
?>

        </table>
    </div>

 <?php
    require_once 'includes/footer.php';

?>