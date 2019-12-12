import {useSelector, useDispatch} from "react-redux";
import React, {useEffect} from 'react';
import {getAllRecipe} from "../../shared/actions/recipeActions";
import {RecipeCard} from "./RecipeCard";

// destructuring searchTerm from the props that this component receives
export const Recipes = ({searchTerm}) => {

	// assigning value of filtered recipes to recipes
	const recipesState = useSelector(state => (state.recipe ? state.recipe : []));

	//this created the filter
	// commented out filtering through recipe steps since full step needs to be searched. To prevent affecting UX the recipe steps have been commented out
	const filteredRecipes = recipesState.filter(recipe => recipe.recipeName.includes(searchTerm) ||  recipe.recipeDescription.includes(searchTerm) || recipe.recipeIngredients.includes(searchTerm)/*|| recipe.recipeStep.includes(searchTerm)*/);

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
					{recipes.map(recipe => <RecipeCard key={recipe.recipeId} recipe={recipe}/>
					)}
		</>
	)
};