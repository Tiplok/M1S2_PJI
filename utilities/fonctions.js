// Cases : Vide    = E (Empty)
//         Ville   = T (Town)
//         Rivière = R (River)
//         Arbre   = A (Tree)

function sendInitBoard(arrayBoard){
    createGrid(arrayBoard);
	// On récupère le tableau :)
	/*console.log(arrayBoard);
	console.log(arrayBoard.length);
	console.log(arrayBoard[0].length);
	console.log(arrayBoard[0][0].type.toUpperCase());*/
}

function loadContentBoard(){
    jQuery(function ($) {
        $.post('ajax/content_board.php', {
        }, function(data) {
            document.getElementById('main').innerHTML = data;
            processTooltip();
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
            if(data){
                alert(data);
            }
            loadContentBoard();
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
                                PK_table: $(this).attr('data-PK_table'), 
                                table: $(this).attr('data-table'),
                                info: $(this).attr('data-info')
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

	var grid = new Array(nbRow);
	for (var i = 0; i < nbRow; i++) {
		grid[i] = new Array(nbCol);
		for(var j = 0; j < nbCol; j++){
			grid[i][j] = new gridCase(arrayBoard[i][j].type, i, j, arrayBoard[i][j]);
		}
	}

	/*var grid = [
		["E", "E", "E", "E", "E", "E", "E", "E", "E"], // L1
		["R", "R", "E", "E", "E", "E", "E", "E", "E"], // L2
		["E", "R", "R", "R", "R", "T", "E", "T", "T"], // L3
		["E", "T", "T", "E", "R", "T", "E", "E", "E"], // L4
		["E", "T", "T", "E", "R", "E", "E", "E", "E"], // L5
		["E", "E", "E", "E", "R", "E", "E", "E", "E"], // L6
		["E", "E", "E", "E", "R", "E", "E", "E", "E"], // L7
		["T", "E", "E", "E", "R", "T", "E", "E", "E"], // L8
		["E", "E", "R", "R", "R", "E", "E", "T", "T"], // L9
		["E", "E", "R", "E", "E", "E", "E", "R", "R"], // L10
		["E", "T", "R", "E", "E", "E", "E", "R", "E"], // L11
		["E", "T", "R", "E", "E", "T", "T", "R", "E"], // L12
		["E", "E", "R", "E", "E", "T", "T", "R", "E"], // L13
		["E", "E", "R", "R", "R", "R", "R", "R", "T"], // L14
		["E", "E", "E", "E", "E", "E", "E", "E", "E"], // L15
		["T", "E", "E", "E", "E", "E", "E", "E", "E"]  // L16
	]*/
}

// Should get from BDD
var trees = {
	hetre : {tree_type:"hetre", default_oxygen_give:16, water_need: 160, cost:7000},
	pin : {tree_type:"pin", default_oxygen_give:18, water_need: 180, cost:8000},
	chene : {tree_type:"chene", default_oxygen_give:20, water_need: 200, cost:9000},
	epicea : {tree_type:"epicea", default_oxygen_give:22, water_need: 220, cost:10000}
};