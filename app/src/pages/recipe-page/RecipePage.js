import React, {useEffect} from 'react';
import './recipe-page-css.css';
import {Route} from 'react-router';
import {getRecipeByRecipeId} from "../../shared/actions/recipeActions";
import {useDispatch, useSelector} from "react-redux";

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
		<section>
			<div className="container-fluid bg-secondary py-5">
				<div className="row">
					<div className="col-md-9">
							<h3 id="recipeName">Recipe</h3>
							<p id="name">{recipe.recipeName}</p>
							<h3 id="recipeRating">rating</h3>
							<p id="rating">{recipe.recipeRating}</p>
							<h3 id="recipeDescription">Description</h3>
							<p id="description">{recipe.recipeDescription}</p>
							<h3 id="recipeNumberIngredients">how many ingredients</h3>
							<p id="numberIngredients">{recipe.recipeNumberIngredients}</p>
							<h3 id="recipeIngredients">Ingredients</h3>
							<p id="ingredients">{recipe.recipeIngredients}</p>
							<h3 id="recipeSteps">Steps</h3>
							<p id="steps">{recipe.recipeStep}</p>
							<h3 id="recipeNutrition">Nutrition</h3>
							<p id="nutrition">{recipe.recipeNutrition}</p>
							<h3 id="recipeMinutes">minutes to make</h3>
							<p id="minutes">{recipe.recipeMinutes}</p>
							<h3 id="recipeSubmissionDate">recipe submitted</h3>
							<p id="submissionDate">{recipe.recipeSubmissionDate}</p>
						<div className="col-md-3">
							<h3 id="recipeImageUrl">image</h3>
							<p id="imageUrl">{recipe.recipeImageUrl}</p>
						</div>
					</div>
				</div>
			</div>
		</section>
	)
};

//
//   return (
//
{/*<section>*/}
{/*	// <div className="container-fluid bg-secondary py-5">*/}
{/*	// <div className="row">*/}
{/*	// <div className="col-md-10">*/}
{/*	// <div className="">*/}
{/*	// <div className="recipe-card-size">*/}
{/*	// <div className="recipe-title">*/}
{/*	// <h1>recipe title</h1>*/}
{/*	// </div>*/}
{/*	// <br></br>*/}
{/*	// <div>*/}
{/*	// <strong>this is where rating will be placed</strong>*/}
{/*	// </div>*/}
{/*	// <br></br>*/}
{/*	// <div>*/}
{/*	// <p>concise recipe description gets populated here</p>*/}
{/*	// </div>*/}
{/*	// <div>*/}
{/*	// <strong>Ingredients</strong>*/}
{/*	// <ul>*/}
{/*	// <li>ingredient one</li>*/}
{/*	// <li>ingredient two</li>*/}
{/*	// <li>ingredient three</li>*/}
{/*	// </ul>*/}
{/*	// </div>*/}
{/*	// <div className="recipe-card-content">*/}
{/*	// <div>*/}
{/*	// <ul>*/}
{/*	// <strong>Steps</strong>*/}
{/*	// <li>step one</li>*/}
{/*	// <li>step two</li>*/}
{/*	// <li>step three</li>*/}
{/*	// </ul>*/}
{/*	// </div>*/}
{/*	// <div>*/}
{/*	// <strong>nutrition</strong>*/}
{/*	// <p>this is where the nutritional information will be populated</p>*/}
{/*	// </div>*/}
{/*	// <div>min to make recipe</div>*/}
{/*	// <br></br>*/}
{/*	// <div>recipe submission date will be auto populated here</div>*/}
{/*	// </div>*/}
{/*	// </div>*/}
{/*	// </div>*/}
{/*	// </div>*/}
{/*	// <div className="col-md-2">*/}
{/*	// <div>*/}
{/*	// <img src="cap-logo-5.png" alt="logo"/>*/}
{/*	// </div>*/}
{/*	// </div>*/}
{/*	// </div>*/}
{/*	// </div>*/}
{/*	// </section>*/}
{/*//   )*/}
{/*// };*/}

{/*<h1 id="title"><em>{recipe.recipeName}</em></h1>*/}
{/*<img className="card-img-top" id="cardImg"*/}
{/*src={recipe.recipeImageUrl ? recipe.recipeMedia : "./recipe-page/cap-logo-5.png"}*/}
{/*alt="logo image as default"/>*/}