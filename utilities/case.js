// Use Prototype 1.6.0
var gridCase = Class.create({
	initialize: function(type, data){
		// Type Cases : Vide    = E (Empty)
		//         		Ville   = T (Town)
		//        		Rivière = R (River)
		//        		Arbre   = A (Tree)
		this.type = type || "E";
		// Peut contenir eau fournie, oxygène requis/produit, ... selon type de case
		this.data = data || {};
		this.score = score || 0;
	},

	// Calcul du score de la grille, from scratch
	grid_score: function(grid){
		// Itération sur la grille
		for(var row = 0; row < grid.nbRow; row++){
			for(var col = 0; col < grid.nbCol; col++){
				console.log(grid[row][col]);

				if(this.type != "R"){
					// Il faut itérer sur les cases aux alentour pour récupérer les valeurs permettant 
					// de calculer le score de la case
					var rowDep = get_in_grid_bounds(row - 1, grid.nbRow);
					var rowEnd = get_in_grid_bounds(row + 1, grid.nbRow);
					var colDep = get_in_grid_bounds(col - 1, grid.nbCol);
					var colEnd = get_in_grid_bounds(col + 1, grid.nbCol);

					var oxygen_give = 0;
					this.data.oxygen_need = (this.data.oxygen_need === undefined || this.data.oxygen_need == null) 
										? 0 
										: this.data.oxygen_need;
					var water_give = 0;
					this.data.water_need = (this.data.water_need === undefined || this.data.water_need == null) 
										? 0 
										: this.data.water_need;

					for(var i = rowDep; i < rowEnd; i++){
						for(var j = colDep; j < colEnd; j++){
							switch(grid[i][j].type){
								case "R" :
									water_give += grid[i][j].data.water_give;
									break;
								case "A" :
									oxygen_give += grid[i][j].data.oxygen_give;
									break;
								case "V" :
									break;
								case "E" :
									break;
							}
						}
					}
				}

			}
		}
	},

	// Place un arbre et calcule le score des cases alentours.
	// tree est l'arbre a placé qui contient :
	//  - data.tree_type : Le type d'arbre (Épicéa/ Chêne/ Pin/ Hêtre)
	//  - data.cost : Le coût de l'arbre (10000/ 9000/ 8000/ 7000)
	//  - data.default_oxygen_give : L'oxygène donné par défault (22/ 20/ 18/ 16)
	//  - data.water_need : Le besoin en eau (220/ 200/ 180 160)
	// abs et ord sont les coordonnées de la case :
	//  - abs : L'abscisse de la case 
	//  - ord : L'ordonné de la case 
	place_tree: function(grid, tree, abs, ord){
		var rowDep = get_in_grid_bounds(abs - 1, grid.nbRow);
		var rowEnd = get_in_grid_bounds(abs + 1, grid.nbRow);
		var colDep = get_in_grid_bounds(ord - 1, grid.nbCol);
		var colEnd = get_in_grid_bounds(ord + 1, grid.nbCol);

		// To be calculated : this.data.water_give + cases alentours
		var water_given = (this.data.water_give === undefined || this.data.water_give == null) 
						? 0 
						: this.data.water_give;

		// Calcul de l'eau fournie
		for(var i = rowDep; i < rowEnd; i++)
			for(var j = colDep; j < colEnd; j++)
				if(grid[i][j].type == "R")
					water_given += grid[i][j].data.water_give;

		this.data.oxygen_give = tree.default_oxygen_give * 
								((water_given > tree.water_need) 
								? tree.water_need / water_given
								: water_given / tree.water_need);

		// Parcours des cases alentours pour affecter le score.
		for(var i = rowDep; i < rowEnd; i++){
			for(var j = colDep; j < colEnd; j++){
				if(grid[i][j].type != "R"){
					grid[i][j].data.oxygen_received += this.data.oxygen_give;
					case_score(grid[i][j]);
				}
			}
		}
	},

	// Score d'une case : Oxygène requis - Excédant (en trop ou en manque) d'oxygène + oxygène efficace
	// Excédant d'oxygène = Valeur absolue de l'oxygène fourni - requis
	// Oxygène efficace = Oxygène fourni jusqu'à la limite de l'oxygène requis
	case_score: function(gridCase){
		var eff_oxygen = (gridCase.data.oxygen_received < gridCase.data.oxygen_need)
						? gridCase.data.oxygen_received
						: gridCase.data.oxygen_need;

		var exc_oxygen = Math.abs(gridCase.data.oxygen_received - gridCase.data.oxygen_need);

		gridCase.data.score = gridCase.data.oxygen_need - exc_oxygen + eff_oxygen;
	},

	// Cette fonction permet d'obtenir les limites de la grille.
	get_in_grid_bounds: function(nb, limit){
		if(nb >= 0 && nb <= limit){
			return nb;
		}else{
			if(nb < 0)
				return 0;
			else
				return limit;
		}
	}
});