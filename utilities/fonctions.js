// Cases : Vide    = E (Empty)
//         Ville   = T (Town)
//         Rivière = R (River)
//         Arbre   = A (Tree)

function loadContentBoard(){
    $.post('ajax/content_board.php', {
    }, function(data) {
        document.getElementById('main').innerHTML = data;
        processTooltip();
    });
}

function loadCurrentTree(PK_tree){
    $.post('ajax/load_current_tree.php', {
        PK_tree: PK_tree
    }, function() {
        loadContentBoard();
    });
}

function plantCurrentTree(row, column){
    $.post('ajax/plant_current_tree.php', {
        row: row,
        column: column
    }, function(data) {
        if(data){
            alert(data);
        }
        loadContentBoard();
    });
}

function removeTree(row, column){
    if(confirm('Êtes-vous sûr de vouloir retirer cette fôret ?')){
        $.post('ajax/remove_tree.php', {
            row: row,
            column: column
        }, function() {
            loadContentBoard();
        });
    }
}

$(document).ready(processTooltip);

function processTooltip(){
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
}

// En réalité, le nombre de lignes est de 9 et le nombre de colonnes est de 16, il faut changer et le schéma se retrouve tourner à 90° vers la droite (sens horaire)
var nbRow = 16;
var nbCol = 9;

//var case = new Object();

var grid = [
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
]

var tree_types = {
    chene : {oxygen:20, cost:9000, water_need: 200},
    pin : {oxygen:18, cost:8000, water_need: 180},
    hetre : {oxygen:16, cost:7000, water_need: 160},
    epicea : {oxygen:22, cost:10000, water_need: 220}
};