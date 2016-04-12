// Use Prototype 1.6.0
var gridCase = Class.create({
	initialize: function(type, abs, ord, data){
		// Type Cases : Vide    = E (Empty)
		//         		Ville   = T (Town)
		//        		Rivière = R (River)
		//        		Arbre   = A (Tree)
		switch(type.toUpperCase()){
			case "EMPTY" :
				this.type = "E";
				this.data.oxygen_need = data.oxygen;
				this.data.water_give = data.water;
				break;
			case "TOWN" :
				this.type = "T";
				this.data.oxygen_need = data.oxygen;
				break;
			case "RIVER" :
				this.type = "R";
				this.data.water_give = data.water;
				break;
			case "TREE" :
				this.type = "A";
				this.data.default_oxygen_give = data.oxygen;
				this.data.water_need = data.water;
				break;
			default :
				this.type = "E";
		}
		this.abs = abs;
		this.ord = ord;
		this.score = score || 0;
	},

	// Calcul du score de la grille, from scratch
	grid_score: function(grid){
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

					/*// Il faut itérer sur les cases aux alentour pour récupérer les valeurs permettant 
					// de calculer le score de la case
					var rowDep = get_in_grid_bounds(row - 1, nbRow);
					var rowEnd = get_in_grid_bounds(row + 1, nbRow);
					var colDep = get_in_grid_bounds(col - 1, nbCol);
					var colEnd = get_in_grid_bounds(col + 1, nbCol);

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
					}*/
				}

			}
		}

		return totalScore;
	},

	// Place un arbre sur une case et calcule le score des cases alentours. La fonction est appelée sur un arbre.
	// tree est l'arbre a placé qui contient :
	//  - data.tree_type : Le type d'arbre (Épicéa/ Chêne/ Pin/ Hêtre)
	//  - data.cost : Le coût de l'arbre (10000/ 9000/ 8000/ 7000)
	//  - data.default_oxygen_give : L'oxygène donné par défault (22/ 20/ 18/ 16)
	//  - data.water_need : Le besoin en eau (220/ 200/ 180 160)
	place_tree: function(grid, tree){
		var nbRow = grid.length;
		var nbCol = grid[0].length;

		var rowDep = get_in_grid_bounds(this.abs - 1, nbRow);
		var rowEnd = get_in_grid_bounds(this.abs + 1, nbRow);
		var colDep = get_in_grid_bounds(this.ord - 1, nbCol);
		var colEnd = get_in_grid_bounds(this.ord + 1, nbCol);

		// To be calculated : this.data.water_give + cases alentours
		// Variable à garder ou non ?
		var water_given = 0;

		// Calcul de l'eau fournie
		for(var i = rowDep; i < rowEnd; i++)
			for(var j = colDep; j < colEnd; j++)
				if(grid[i][j].type == "R")
					water_given += grid[i][j].data.water_give;

		this.data.oxygen_give = tree.default_oxygen_give * 
								((water_given > tree.water_need) 
								? tree.water_need / water_given
								: water_given / tree.water_need);

		// Parcours des cases alentours pour affecter le score (et oxygen_received).
		for(var i = rowDep; i < rowEnd; i++){
			for(var j = colDep; j < colEnd; j++){
				if(grid[i][j].type != "R"){
					grid[i][j].data.oxygen_received += this.data.oxygen_give;
					case_score(grid[i][j]);
				}
			}
		}

		// Passer les valeurs de l'arbre à la case et actualiser les types. (case.type & case.data.tree_type)
		this.type = "T";
		this.data.default_oxygen_give = tree.default_oxygen_give;
		this.data.cost = tree.cost;
		this.data.tree_type = tree.tree_type;
		this.data.water_need = tree.water_need;
	},

	// ATTENTION : Fonction de déforestation
	// Retire un arbre d'une case et redonne les valeurs par défaut de la case vide. La fonction est appelée sur un arbre.
	remove_tree: function(grid){
		var nbRow = grid.length;
		var nbCol = grid[0].length;

		var rowDep = get_in_grid_bounds(this.abs - 1, nbRow);
		var rowEnd = get_in_grid_bounds(this.abs + 1, nbRow);
		var colDep = get_in_grid_bounds(this.ord - 1, nbCol);
		var colEnd = get_in_grid_bounds(this.ord + 1, nbCol);

		// Parcours des cases alentours pour actualiser le score ainsi que oxygen_received.
		for(var i = rowDep; i < rowEnd; i++){
			for(var j = colDep; j < colEnd; j++){
				if(grid[i][j].type != "R"){
					grid[i][j].data.oxygen_received -= this.data.oxygen_give;
					case_score(grid[i][j]);
				}
			}
		}
		
		// Variables à réinitialiser
		this.type = "E";
		// On enlève l'oxygène que donnait l'arbre courant à la case vide sur laquelle il était
		this.data.oxygen_received -= this.data.oxygen_give;
		this.data.default_oxygen_give = 0;
		this.data.cost = 0;
		this.data.tree_type = "";
		this.data.water_need = 0;
		this.data.oxygen_give = 0;
	},

	// ATTENTION : Fonction de déforestation massive
	// Retire TOUS les arbres de la grille et redonne les valeurs par défaut de la case vide. La fonction est appelée sur un arbre.
	clean_trees: function(grid){
		var nbRow = grid.length;
		var nbCol = grid[0].length;

		// Parcours des cases alentours pour actualiser le score ainsi que oxygen_received.
		for(var row = 0; row < nbRow; row++){
			for(var col = 0; col < nbCol; col++){
				if(grid[i][j].type == "T")
					grid[i][j].remove_tree(grid);
				else // Au cas ou
					grid[i][j].score = 0;
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

		gridCase.score = gridCase.data.oxygen_need - exc_oxygen + eff_oxygen;

		return gridCase.score;
	},

	// Cette fonction permet d'obtenir les limites de la grille.
	get_in_grid_bounds: function(nb, limit){
		if(nb >= 0 && nb < limit){
			return nb;
		}else{
			if(nb < 0)
				return 0;
			else
				return limit;
		}
	}
});