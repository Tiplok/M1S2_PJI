// Cases : Vide    = E (Empty)
//         Ville   = T (Town)
//         Rivière = R (River)
//         Arbre   = A (Tree)

var grid = new Array();
var trees_score = 0;

function sendInitBoard(arrayBoard){
    createGrid(arrayBoard);
}

function loadContentBoard(score_modif = 0){
    /*var score_modif = score_modif || 0;*/
    if(score_modif){
        trees_score += score_modif;
    }
    /*var current_money = parseInt((document.getElementById('current_money').value).replace(' ', ''));*/
    jQuery(function ($) {
        $.post('ajax/get_current_money.php', {
        }, function(data) {
            var current_money = parseInt(data);
            var total_score = current_money * 0.1 + trees_score;
            $.post('ajax/content_board.php', {
                total_score: total_score
            }, function(data) {
                document.getElementById('main').innerHTML = data;
                processTooltip();
            });
        });
    });
}

function loadCurrentTree(PK_tree){
    jQuery(function ($) {
        $.post('ajax/load_current_tree.php', {
            PK_tree: PK_tree
        }, function() {
            loadContentBoard();
        });
    });
}

function plantCurrentTree(row, column){
    jQuery(function ($) {
        $.post('ajax/plant_current_tree.php', {
            row: row,
            column: column
        }, function(data) {
            if(data.indexOf('{') == -1){
                alert(data);
            }else{
                var tree = JSON.parse(data);
                var score_modif = grid[row][column].place_tree(grid, tree);
            }
            loadContentBoard(score_modif);
        });
    });
}

function removeTree(row, column, deforestation){
    jQuery(function ($) {
        // Cas où on demande de retirer toutes les fôrets
        if(row == -1 && column == -1){
            if(confirm('Êtes-vous sûr de vouloir retirer TOUTES les fôrets ?')){
                $.post('ajax/remove_tree.php', {
                    row: row,
                    column: column
                }, function() {
                    loadContentBoard();
                });
            }
        } else {

            // Si on est en mode déforestation, pas de message de confirmation
            if(deforestation){
                $.post('ajax/remove_tree.php', {
                    row: row,
                    column: column
                }, function() {
                    loadContentBoard();
                });
            } else {
                if(confirm('Êtes-vous sûr de vouloir retirer cette fôret ?')){
                    $.post('ajax/remove_tree.php', {
                        row: row,
                        column: column
                    }, function() {
                        loadContentBoard();
                    });
                }
            }
        }
    });
}

jQuery(function ($) {
    $(document).ready(processTooltip);
});

function processTooltip(){
    jQuery(function ($) {
        $('.tooltip').each(function () {
            $(this).qtip({
                content: {
                    text: function (event, api) {
                        $.ajax({
                            url: "ajax/tooltip.php", // Use href attribute as URL
                            method: "POST",
                            data: {
                                array: $(this).attr('data-array')
                            }
                        }).then(function (content) {
                            // Set the tooltip content upon successful retrieval
                            api.set('content.text', content);
                        }, function (xhr, status, error) {
                            // Upon failure... set the tooltip content to error
                            api.set('content.text', status + ': ' + error);
                        });

                        return 'Chargement...'; // Set some initial text
                    }
                },
                position: {
                    viewport: $(window)
                },
                style: 'qtip-wiki',
                    show: {
                        solo: true, // Hide other when opening
                        delay: 0 // Show delay
                    },
                    hide: {
                        hide: false, // Hide other when opening
                        fixed: true, // Stay visible when mousing onto tooltip
                        delay: 0 // Hide delay (ms)
                    }
            });
        });
    });
}

function createGrid(arrayBoard){
	var nbRow = arrayBoard.length;
	var nbCol = arrayBoard[0].length;

	grid = new Array(nbRow);
	for (var i = 0; i < nbRow; i++) {
		grid[i] = new Array(nbCol);
		for(var j = 0; j < nbCol; j++){
			grid[i][j] = new gridCase(arrayBoard[i][j].type, i, j, arrayBoard[i][j]);
            if(grid[i][j].type == "T"){}
                //
		}
	}

    trees_score = gridScore(grid);
}

// Calcul du score de la grille, from scratch
function gridScore(grid){
    var nbRow = grid.length;
    var nbCol = grid[0].length;
    var totalScore = 0;

    // Itération sur la grille
    for(var row = 0; row < nbRow; row++){
        for(var col = 0; col < nbCol; col++){
            console.log(grid[row][col]);

            if(grid[row][col].type != "R"){
                // Il faudra ajouter un bouton d'enregistrement de l'état de la grille pour 
                // permettre de stocker les valeurs intéressantes en base de donnée et 
                // ainsi d'aditionner simplement le score des cases Vides, Villes et Arbres (car extension de Vide)
                totalScore += grid[row][col].score;
            }

        }
    }

    return totalScore;
}

// Should get from BDD
var trees = {
	hetre : {tree_type:"hetre", default_oxygen_give:16, water_need: 160, cost:7000},
	pin : {tree_type:"pin", default_oxygen_give:18, water_need: 180, cost:8000},
	chene : {tree_type:"chene", default_oxygen_give:20, water_need: 200, cost:9000},
	epicea : {tree_type:"epicea", default_oxygen_give:22, water_need: 220, cost:10000}
};