import {useSelector, useDispatch} from "react-redux";
import React, {useEffect} from 'react';
import {getAllRecipe} from "../../shared/actions/recipeActions";
import {RecipeCard} from "./RecipeCard";

export const Recipes = ({searchTerm}) => {

	const recipesState = useSelector(state => (state.recipe ? state.recipe : []));

	const filteredRecipes = recipesState.filter(recipe=>recipe.recipeName.includes(searchTerm) || recipe.recipeIngredients.includes(searchTerm));

	// check if recipe search term is coming back with a value
	// console.log("recipe search term = ", searchTerm);

	const recipes = filteredRecipes, dispatch = useDispatch();

	function sideEffects() {
		dispatch(getAllRecipe());
	}


	const sideEffectsInputs = [];

	useEffect(sideEffects, sideEffectsInputs);

	return (
		<>
				<div>
					{recipes.map(recipe => <RecipeCard key={recipe.recipeId} recipe={recipe}/>
					)}
				</div>
		</>
	)
};