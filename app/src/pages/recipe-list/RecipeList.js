import React, {useState} from 'react'; //declaring useState in order to use state hooks in this component
import {Categories} from "./Categories";
// import {SearchBar} from "./SearchBar";
import {Recipes} from "./Recipes";
import './recipe-list-styles.css';
import {SearchFormContent} from "./SearchForm";


export const RecipeList = () => {

	// declared state element called search term and initializing it to an empty string
	// declaring setter function so the value can be set
	const [searchTerm, setSearchTerm] = useState('');

	return (
		<main>
			<div className="search-bar">
{/* passing search term and set search term so the search bar can interact with the state*/}
				<SearchFormContent searchTerm={searchTerm} setSearchTerm={setSearchTerm} />
			</div>
				<div className="row">
					<div className="col-4">
						<Categories/>
					</div>
					<div className="col-8">
{/* passing down search term in order for recipes to be searched by it */}
						<Recipes searchTerm={searchTerm}/>
					</div>
				</div>
		</main>
	)
};
