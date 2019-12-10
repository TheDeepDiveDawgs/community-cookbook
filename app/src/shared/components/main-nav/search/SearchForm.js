import React, {useEffect} from "react";
import {useSelector, useDispatch} from "react-redux";
// import Button from 'react-bootstrap/Button'
// import Form from "react-bootstrap/Form";
// // import {getRecipeBySearchTerm} from "../../../actions/recipeActions";
// import FormControl from "react-bootstrap/FormControl";
import {httpConfig} from "../../../utils/http-config";
import {useHistory} from "react-router";
import {getRecipeBySearchTerm} from "../../../actions/recipeActions";



export const SearchFormContent = ({match}) => {

	const recipes = useSelector(state => (state.recipe ? state.recipe : []));
	const dispatch = useDispatch();
	const history = useHistory();
	// const recipeList = getRecipeBySearchTerm();
	//
	// const effects = () => {
	// 	dispatch(recipeList);
	// };


	// useEffect(effects);


	const searchTerm = () => {
		httpConfig.get('apis/recipe/')
			.then( reply => {
				if (reply.status === 200) {
					// recipes.filter();
					console.log(reply);
					history.push("/recipe-list")
				}
			})
	};




	return (
		<>
			<form  className="search-margin" id="search-box">
				<input type="text"
					   placeholder="Search for recipe"
					   id="search-text"
				/>
				<button className="btn btn-dark mx-4 px-4 py-2 text-white"
						id="search-button"
						type="reset"
						onClick={searchTerm}
						onSubmit={searchTerm}
				>
					Search</button>
			</form>
		</>
	)
};