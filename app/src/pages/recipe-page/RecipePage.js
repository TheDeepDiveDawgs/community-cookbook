import React, {useEffect} from 'react';
import {connect} from "react-redux";
import './recipe-page-css.css';
import {getRecipeByRecipeId} from "../../shared/actions/recipeActions";
import {useDispatch, useSelector} from "react-redux";
import logo from "./cap-logo-5.png";
import {InteractionComponent} from "../../shared/components/interaction/InteractionComponent";


export const RecipePage = (props) => {
	const {match} = props;
	const recipes = useSelector(state => (state.recipe));

	const dispatch = useDispatch();
	const effects = () => {
		dispatch(getRecipeByRecipeId(match.params.recipeId));
	};
	const inputs = [match.params.recipeId];
	useEffect(effects, inputs);

	const filterRecipe = recipes.filter(recipe => recipe.recipeId === match.params.recipeId);
	const recipe = {...filterRecipe[0]};

	let weHaveData = (!(Object.entries(recipe).length === 0 && recipe.constructor === Object));

	//this section determines where everything lines up in the recipe DOM and pulls the corresponding info into the correct fields.
	return (
		<>
		<section className="margin">
			<div className="container-fluid py-5">
				<div className="row">
					<div className="col-md-9">
						<h2><strong><p id="name">{recipe.recipeName}</p></strong></h2>
						<div className="row">
							<div className="col-md-4">
								<h4 id="recipeRating">Rating</h4>
							</div>

							<div className="col-md-4">
								<h4 id="recipeNumberIngredients"># Of Ingredients</h4>
								<p id="numberIngredients">{recipe.recipeNumberIngredients}</p>
							</div>
							<div className="col-md-4">
								<h4 id="recipeMinutes">Cook Time<small> (minutes)</small></h4>
								<p id="minutes">{recipe.recipeMinutes}</p>
							</div>
						</div>
						<div className="ingred">
							<h4 id="recipeDescription">Description</h4>
							<p id="description">{recipe.recipeDescription}</p>
							<div className="ul">
								<h4 id="recipeIngredients">Ingredients</h4>
{/*this allows us to form the data as a list in the DOM*/}
								<ul>
									{weHaveData && recipe.recipeIngredients.map(ingredient => <li> {ingredient} </li>)}
								</ul>
							</div>
							<h4 id="recipeSteps">Steps</h4>
							<ol id="steps">
								{weHaveData && recipe.recipeStep.map(step => <li> {step} </li>)}
							</ol>
							<h4 id="recipeNutrition">Nutrition</h4>
							<p id="nutrition">{recipe.recipeNutrition}</p>
							<h5 id="recipeSubmissionDate">Recipe Submitted</h5>
							<p id="submissionDate">{recipe.recipeSubmissionDate}</p>
						</div>
					</div>

{/*this allows users to add pics of there recipe or will default to cookbook logo*/}
					<div className="col-md-3">
						<p id="imageUrl">{recipe.recipeImageUrl}</p>
						<img className="card-img-top" id="cardImg" src={recipe.recipeImageUrl ? recipe.recipeImageUrl : logo}
							  alt="recipe image"/>
					</div>
				</div>
			</div>
		</section>
		</>
	)
};