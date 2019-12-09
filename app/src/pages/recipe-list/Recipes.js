import {useSelector, useDispatch} from "react-redux";
import React, {useEffect} from 'react';
import {getAllRecipe} from "../../shared/actions/recipeActions";
import {RecipeCard} from "./RecipeCard";

export const Recipes = (props) => {

	const recipes = useSelector(state => (state.recipe ? state.recipe : []));


	const dispatch = useDispatch();

	function sideEffects() {
		dispatch(getAllRecipe())
	}

	const sideEffectsInputs = [];
	console.log(recipes);

	useEffect(sideEffects, sideEffectsInputs);

	return (
		<>
			<main>
				<div>
					{recipes.map(recipe => <RecipeCard key={recipe.recipeId} recipe={recipe}/>
					)}
				</div>
			</main>
		</>
	)
};