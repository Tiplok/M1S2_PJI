// Cases : Vide    = E (Empty)
//         Ville   = T (Town)
//         Rivière = R (River)
//         Arbre   = A (Tree)

var nbRow = 16;
var nbCol = 9;

var case = new Object();

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