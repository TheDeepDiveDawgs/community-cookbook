import React from 'react';
import {Categories} from "./Categories";
import {SearchBar} from "./SearchBar";
import {Recipes} from "./Recipes";
import './recipe-list-styles.css';

export const RecipeList = () => {
	return (
		<main>
			<div className="search-bar">
				<SearchBar/>
			</div>
			<div>
				<div className="row">
					<div className="col-3">
						<Categories/>
					</div>
					<div className="col-9">
						<Recipes/>
					</div>
				</div>
			</div>
		</main>
	)
};
