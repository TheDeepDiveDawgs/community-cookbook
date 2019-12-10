import React from "react";
// import Button from 'react-bootstrap/Button'
// import Form from "react-bootstrap/Form";
// // import {getRecipeBySearchTerm} from "../../../actions/recipeActions";
// import FormControl from "react-bootstrap/FormControl";
import {httpConfig} from "../../../utils/http-config";
import {useHistory} from "react-router";
import {getRecipeBySearchTerm} from "../../../actions/recipeActions";


export const SearchFormContent = () => {

	const history = useHistory();

	const searchTerm = () => {
		httpConfig.get('apis/recipe/')
			.then( reply => {
				if (reply.status === 200) {
					console.log(reply);
					history.push("/recipe-list?recipeSearchTerm=${recipeIngredients}")
				}
			})
	};

	const searchValue = getRecipeBySearchTerm();



	return (
		<>
			<form  className="ml-auto" id="search-box">
				<input type="text"
					   placeholder="Search for recipe"
					   id="search-text"
					   value={searchValue}
					   onChange={searchTerm}
				/>
				<button className="btn btn-dark mx-4 px-4 py-2 text-white"
						id="search-button"
						type="reset"
						onSubmit={searchTerm}
				>
					Search</button>
			</form>
		</>
	)
};