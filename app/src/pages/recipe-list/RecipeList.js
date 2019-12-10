import React from 'react';
import {CategoryCard} from "./CategoryCard";
import {SearchBar} from "./SearchBar";
import {Recipes} from "./Recipe";
// import {RecipeCard} from "./RecipeCard";


export const RecipeList = () => {
	return (
		<main className="mt-5 pt-5">
			<div>
				<SearchBar/>
			</div>
			<div className="container">
				<div className="row">
					<div className="col-3">
						<CategoryCard/>
					</div>
					<div className="col-9">
						<Recipes/>
					</div>
				</div>
			</div>
		</main>
	)
};
