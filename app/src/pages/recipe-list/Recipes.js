import {useSelector, useDispatch} from "react-redux";
import React, {useEffect} from 'react';
import {getAllRecipe} from "../../shared/actions/recipeActions";
import {RecipeCard} from "./RecipeCard";

// destructuring searchTerm from the props that this component receives
export const Recipes = ({searchTerm}) => {

	// assigning value of filtered recipes to recipes
	const recipes = useSelector(state => (state.recipe ? state.recipe : []));

	const dispatch = useDispatch();

	// assigning value of filtered recipes to recipes
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