import React, {Component} from 'react';
import {Categories} from "./Categories";
import {SearchBar} from "./SearchBar";
import {Recipes} from "./Recipes";

export const RecipeList = () => {
	return (
		<main>
			<div>
				<SearchBar/>
			</div>
			<div className="container">
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
