import {useSelector, useDispatch} from "react-redux";
import React, {useEffect} from 'react';
import {getAllRecipe} from "../../shared/actions/recipeActions";
import {RecipeCard} from "./RecipeCard";

export const Recipes = ({searchTerm}) => {

	console.log("RECIPE SEARCH TERM = ", searchTerm);

	// const recipes = filteredRecipes, dispatch = useDispatch();

	const recipes = useSelector(state => (state.recipe ? state.recipe : []));

	const dispatch = useDispatch();

	//this is where the filter is executed
	const filteredRecipes = recipes.filter(recipe=>recipe.recipeName.includes(searchTerm) || recipe.recipeDescription.includes(searchTerm));

	function sideEffects() {
		dispatch(getAllRecipe())
	}


	const sideEffectsInputs = [];

	useEffect(sideEffects, sideEffectsInputs);

	return (
		<>
				<div>
					{filteredRecipes.map(recipe => <RecipeCard key={recipe.recipeId} recipe={recipe}/>
					)}
				</div>
		</>
	)
};