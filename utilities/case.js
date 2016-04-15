// Use Prototype 1.6.0
var gridCase = Class.create({
	initialize: function(type, abs, ord, data){
		// Type Cases : Vide    = E (Empty)
		//         		Ville   = T (Town)
		//        		Rivière = R (River)
		//        		Arbre   = A (Tree)
        this.data = {};
        
		switch(type.toUpperCase()){
			case "EMPTY" :
				this.type = "E";
				this.data.oxygen_need = parseInt(data.oxygen);
				this.data.water_give = parseInt(data.water);
				this.data.oxygen_received = parseInt(data.oxygen_received) || 0;
				break;
			case "TOWN" :
				this.type = "T";
				this.data.oxygen_need = parseInt(data.oxygen);
				this.data.oxygen_received = parseInt(data.oxygen_received) || 0;
				break;
			case "RIVER" :
				this.type = "R";
				this.data.water_give = parseInt(data.water);
				break;
			case "TREE" :
				this.type = "A";
				this.data.default_oxygen_give = parseInt(data.oxygen);
				this.data.water_need = parseInt(data.water);
				this.data.oxygen_received = parseInt(data.oxygen_received) || 0;
				break;
			default :
				this.type = "E";
		}
		this.abs = abs;
		this.ord = ord;
		this.score = parseInt(data.score) || 0;
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

		var rowDep = this.get_in_grid_bounds(this.abs - 1, nbRow);
		var rowEnd = this.get_in_grid_bounds(this.abs + 1, nbRow);
		var colDep = this.get_in_grid_bounds(this.ord - 1, nbCol);
		var colEnd = this.get_in_grid_bounds(this.ord + 1, nbCol);

		// To be calculated : this.data.water_give + cases alentours
		// Variable à garder ou non ?
		var water_given = (this.data.water_give === undefined || this.data.water_give == null) 
							? 0 
							: this.data.water_give;

		console.log(rowDep, colDep);
		console.log(rowEnd, colEnd);

		// Calcul de l'eau fournie
		for(var i = rowDep; i < rowEnd; i++)
			for(var j = colDep; j < colEnd; j++)
				if(grid[i][j].type == "R")
					water_given += grid[i][j].data.water_give;

		this.data.oxygen_give = parseInt(parseInt(tree.default_oxygen_give)) * 
								((water_given > parseInt(tree.water_need)) 
								? parseInt(tree.water_need) / water_given
								: water_given / parseInt(tree.water_need));

		var score_modif = 0;

		console.log(this);

		// Parcours des cases alentours pour affecter le score (et oxygen_received).
		for(var i = rowDep; i <= rowEnd; i++){
			for(var j = colDep; j <= colEnd; j++){
				console.log(i, j);
				if(grid[i][j].type != "R"){
					grid[i][j].data.oxygen_received += this.data.oxygen_give;
					score_modif += grid[i][j].case_score();
				}
			}
		}

		// Passer les valeurs de l'arbre à la case et actualiser les types. (case.type & case.data.tree_type)
		this.type = "T";
		this.data.default_oxygen_give = parseInt(tree.default_oxygen_give);
		this.data.cost = parseInt(tree.cost);
		this.data.tree_type = parseInt(tree.tree_type);
		this.data.water_need = parseInt(tree.water_need);

		return score_modif;
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
					grid[i][j].case_score();
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
	case_score: function(){
		console.log(this);
		var eff_oxygen = (this.data.oxygen_received < this.data.oxygen_need)
						? this.data.oxygen_received
						: this.data.oxygen_need;

		var exc_oxygen = Math.abs(this.data.oxygen_received - this.data.oxygen_need);

		this.score = this.data.oxygen_need - exc_oxygen + eff_oxygen;

		return this.score;
	}
});