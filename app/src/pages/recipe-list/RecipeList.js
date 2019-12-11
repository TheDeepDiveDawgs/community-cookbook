import React, {useState} from 'react';
import {Categories} from "./Categories";
import {SearchBar} from "./SearchBar";
import {Recipes} from "./Recipes";
import './recipe-list-styles.css';


export const RecipeList = () => {

	const [searchTerm, setSearchTerm] = useState('');
	console.log("RESULT = ", searchTerm);

	return (
		<main>
			<div className="search-bar">
				<SearchBar searchTerm={searchTerm} setSearchTerm={setSearchTerm} />
			</div>
			<div>
				<div className="row">
					<div className="col-3">
						<Categories/>
					</div>
					<div className="col-9">
						<Recipes searchTerm={searchTerm}/>
					</div>
				</div>
			</div>
		</main>
	)
};
