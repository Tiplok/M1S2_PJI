/*class Case {
	// Type Cases : Vide    = E (Empty)
	//         		Ville   = T (Town)
	//        		Rivière = R (River)
	//        		Arbre   = A (Tree)
	var type;
	// Peut contenir eau fournie, oxygène requis/produit, ... selon type de case
	var data;

	constructor(type, data){
		this.type = type;
		this.data = data;
	}

	case_score(){
		// Itération sur la grille
		for(var row = 0; row < nbRow; row++){
			for(var col = 0; col < nbCol; col++){
				console.log(grid[row][col]);

				if(this.type != "R"){
					// Il faut itérer sur les cases aux alentour pour récupérer les valeurs permettant 
					// de calculer le score de la case
					var rowDep = get_in_grid_bounds(row - 1, nbRow);
					var rowEnd = get_in_grid_bounds(row + 1, nbRow);
					var colDep = get_in_grid_bounds(row - 1, nbCol);
					var colEnd = get_in_grid_bounds(row + 1, nbCol);

					var oxygen = 0;
					var water = 0;
					var water_need = (this.data.water_need === undefined || this.data.water_need == null) 
										? 0 
										: this.data.water_need;

					for(var i = rowDep; i < rowEnd; i++){
						for(var j = colDep; j < colEnd; j++){
							switch(this.type){
								case "R"
							}
						}
					}
				}

			}
		}
	}

	get_in_grid_bounds(nb, limit){
		if(nb >= 0 && nb <= limit){
			return nb;
		}else{
			if(nb < 0)
				return 0;
			else
				return limit;
		}
	}

	get_positive(nb){
		return (nb >= 0) ? nb : 0;
	}
}*/