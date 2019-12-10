import React, {useEffect} from 'react';
import './recipe-page-css.css';
import {getRecipeByRecipeId} from "../../shared/actions/recipeActions";
import {useDispatch, useSelector} from "react-redux";
import logo from "./cap-logo-5.png"

export const RecipePage = (props) => {
	const {match} = props;
	const dispatch = useDispatch();
	const recipes = useSelector(state => state.recipe);
	useEffect(() => {
		dispatch(getRecipeByRecipeId(match.params.recipeId))
	}, [match.params.recipeId]);
	const filterRecipe = recipes.filter(recipe => recipe.recipeId === match.params.recipeId);
	const recipe = {...filterRecipe[0]};

	return (
		<section className="margin">
			<div className="container-fluid py-5">
				<div className="row">
					<div className="col-md-9">
							<h2><strong><p id="name">{recipe.recipeName}</p></strong></h2>
						<div className="row">
							<div className="col-md-4">
							<h4 id="recipeRating">rating</h4>
							<p id="rating">{recipe.recipeRating}</p>
							{/*<h4 id="recipeInteraction">interaction</h4>*/}
							{/*<p id="interaction">{recipe.recipeInteraction}</p>*/}
				{/*need to add danny's rating above*/}
							</div>
							<div className="col-md-4">
							<h4 id="recipeNumberIngredients"># of ingredients</h4>
							<p id="numberIngredients">{recipe.recipeNumberIngredients}</p>
							</div>
							<div className="col-md-4">
							<h4 id="recipeMinutes">cook time <small>(minutes)</small></h4>
							<p id="minutes">{recipe.recipeMinutes}</p>
							</div>
						</div>
					<div className="ingred">
							<h4 id="recipeDescription">Description</h4>
							<p id="description">{recipe.recipeDescription}</p>
						<div className="ul">
							<h4 id="recipeIngredients">Ingredients</h4>
							<p id="ingredients">{recipe.recipeIngredients}</p>
						</div>
							<h4 id="recipeSteps">Steps</h4>
							<p id="steps">{recipe.recipeStep}</p>
							<h4 id="recipeNutrition">Nutrition</h4>
							<p id="nutrition">{recipe.recipeNutrition}</p>
							<h5 id="recipeSubmissionDate">recipe submitted</h5>
							<p id="submissionDate">{recipe.recipeSubmissionDate}</p>
					</div>
					</div>
					<div className="col-md-3">
						<h3 id="recipeImageUrl">image</h3>
						<p id="imageUrl">{recipe.recipeImageUrl}</p>
						<img className="card-img-top" id="cardImg" src={recipe.recipeImageUrl ? recipe.recipeImageUrl : logo} alt="recipe image"/>
					</div>
				</div>
			</div>
		</section>
	)
};

{/*<img className="card-img-top" id="cardImg"*/}
{/*src={recipe.recipeImageUrl ? recipe.recipeMedia : "./recipe-page/cap-logo-5.png"}*/}
{/*alt="logo image as default"/>*/}