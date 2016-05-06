// Use Prototype 1.6.0
var gridCase = Class.create({
	initialize: function(type, abs, ord, data){
		// Type Cases : Vide    = E (Empty)
		//         		Ville   = T (Town)
		//        		Rivière = R (River)
		//        		Arbre   = A (Tree)
        this.data = {};
        
        /*console.log(type);*/

		switch(type.toUpperCase()){
			case "EMPTY" :
				this.type = "E";
				this.data.oxygen_need = parseInt(data.oxygen_need);
				this.data.water_give = parseInt(data.water_give);
				this.data.oxygen_received = parseInt(data.oxygen_received) || 0;
				break;
			case "TOWN" :
				this.type = "T";
				this.data.oxygen_need = parseInt(data.oxygen_need);
				this.data.oxygen_received = parseInt(data.oxygen_received) || 0;
				break;
			case "RIVER" :
				this.type = "R";
				this.data.water_give = parseInt(data.water_give);
				break;
			case "TREE" :
				this.type = "A";
				this.data.default_oxygen_give = parseInt(data.default_oxygen_give);
				this.data.water_need = parseInt(data.water_need);
				this.data.oxygen_received = parseInt(data.oxygen_received) || 0;
				this.data.image = data.image;
				break;
			default :
				this.type = "E";
		}
		this.abs = parseInt(abs);
		this.ord = parseInt(ord);
		this.score = parseInt(data.score) || 0;
	},

	// Cette fonction permet d'obtenir les limites d'un parcours autour d'une case en fonction des limites de la grille.
	get_in_grid_bounds: function(nb, limit){
		if(nb >= 0 && nb < limit){
			return nb;
		}else{
			if(nb < 0)
				return 0;
			else
				return limit - 1;
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
		this.data.water_received = (this.data.water_give === undefined || this.data.water_give == null) 
							? 0
							: this.data.water_give;

		//console.log(rowDep, colDep);
		//console.log(rowEnd, colEnd);

		// Calcul de l'eau fournie
		for(var i = rowDep; i <= rowEnd; i++)
			for(var j = colDep; j <= colEnd; j++)
				if(grid[i][j].type == "R")
					this.data.water_received += grid[i][j].data.water_give;

		this.data.oxygen_give = parseInt(tree.default_oxygen_give) * 
								((this.data.water_received > parseInt(tree.water_need)) 
								? parseInt(tree.water_need) / this.data.water_received
								: this.data.water_received / parseInt(tree.water_need));

		this.data.score_modif = 0;

		// Parcours des cases alentours pour affecter le score (et oxygen_received).
        // Toverify : Modification temporaire pour pouvoir poser des forêts dans la dernière colonne : rowEnd-1 et colEnd-1 au lieu de rowEnd et colEnd
		for(var i = rowDep; i <= rowEnd; i++){
			for(var j = colDep; j <= colEnd; j++){
				if(grid[i][j].type != "R"){
					grid[i][j].data.oxygen_received += this.data.oxygen_give;
					this.data.score_modif += -grid[i][j].score + grid[i][j].case_score();
				}
			}
		}

		// Passer les valeurs de l'arbre à la case et actualiser les types. (case.type & case.data.tree_type)
		this.type = "A";
		this.data.default_oxygen_give = parseInt(tree.default_oxygen_give);
		this.data.cost = parseInt(tree.cost);
		this.data.tree_type = tree.tree_type;
		this.data.water_need = parseInt(tree.water_need);
		this.data.image = tree.image;

		//console.log("addTree", this.data.score_modif);

		return this;
	},

	// ATTENTION : Fonction de déforestation
	// Retire un arbre d'une case et redonne les valeurs par défaut de la case vide. La fonction est appelée sur un arbre.
	remove_tree: function(grid){
		var nbRow = grid.length;
		var nbCol = grid[0].length;

		var rowDep = this.get_in_grid_bounds(this.abs - 1, nbRow);
		var rowEnd = this.get_in_grid_bounds(this.abs + 1, nbRow);
		var colDep = this.get_in_grid_bounds(this.ord - 1, nbCol);
		var colEnd = this.get_in_grid_bounds(this.ord + 1, nbCol);

		this.data.score_modif = 0;

		// Parcours des cases alentours pour actualiser le score ainsi que oxygen_received.
		for(var i = rowDep; i <= rowEnd; i++){
			for(var j = colDep; j <= colEnd; j++){
				if(grid[i][j].type != "R"){
					grid[i][j].data.oxygen_received -= this.data.oxygen_give;
					var diffScore = grid[i][j].score - grid[i][j].case_score();
					//console.log("diffScore", diffScore);
					this.data.score_modif -= diffScore;
				}
			}
		}

		//console.log("removeTree", this.data.score_modif);

		// Variables à réinitialiser
		this.type = "E";
		this.data.default_oxygen_give = 0;
		this.data.cost = 0;
		this.data.tree_type = "";
		this.data.water_need = 0;
		this.data.oxygen_give = 0;
		this.data.water_received = 0;

		return this;
	},

	// ATTENTION : Fonction de déforestation massive
	// Retire TOUS les arbres de la grille et redonne les valeurs par défaut de la case vide. La fonction est appelée sur un arbre.
	clean_trees: function(grid){
		var nbRow = grid.length;
		var nbCol = grid[0].length;

		// Permet au PHP de gérer la déforestation
		var fakeCase = {
			data : {
				score_modif : 0
			}
		};

		// Parcours des cases alentours pour actualiser le score ainsi que oxygen_received.
		for(var i = 0; i < nbRow; i++){
			for(var j = 0; j < nbCol; j++){
				if(grid[i][j].type == "A")
					fakeCase.data.score_modif += (grid[i][j].remove_tree(grid)).data.score_modif;
				else // Au cas ou
					grid[i][j].score = 0;
			}
		}

		return fakeCase;
	},

	// Score d'une case : Oxygène requis - Excédant (en trop ou en manque) d'oxygène + oxygène efficace
	// Excédant d'oxygène = Valeur absolue de l'oxygène fourni - requis
	// Oxygène efficace = Oxygène fourni jusqu'à la limite de l'oxygène requis
	case_score: function(){
		var eff_oxygen = (this.data.oxygen_received < this.data.oxygen_need)
						? this.data.oxygen_received
						: this.data.oxygen_need;

		var exc_oxygen = Math.abs(this.data.oxygen_received - this.data.oxygen_need);

		this.score = this.data.oxygen_need - exc_oxygen + eff_oxygen;

		//console.log("caseScore", this.score);

		return this.score;
	}
});