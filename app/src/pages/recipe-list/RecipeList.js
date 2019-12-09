import React, {Component} from 'react';
import {CategoryCard} from "./CategoryCard";
import {SearchBar} from "./SearchBar";
import {Recipes} from "./Recipe";
import {RecipeCard} from "./RecipeCard";


export const RecipeList = () => {
	return (
		<main>
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
