// // import React from "react";
// import {useSelector, useDispatch} from "react-redux";
// import React, {useEffect} from 'react';
// import {getRecipePosts} from "../../shared/actions/get-recipe-posts";
// import {PostCard} from "./recipecard";
// import {not} from "rxjs";
//
//
// //postcard for recipe page
//
// 	export const  PostCard = (props) => {
//
// 		const {post} = props;
// 		return (
// 			<div className="card text-white bg-dark mb-3">
// 				<div className="card-body">
// 					<h5 className="card-title">{recipe.title}</h5>
// 					<p className="card-text">{recipe.body}</p>
// 					<p className="card-text">
// 						<small className="text-muted">{post.recipePage}</small>
// 					</p>
// 				</div>
// 			</div>
// 		)
// 	};
//
// // recipe post
// 	export const RecipeId = ({match}) => {
//
// 		// Returns the the recipeId store from redux and assigns it to the recipePosts variable.
// 		const recipeId = useSelector(state => state.recipeId ? state.recipeId : []);
//
// 		// Since recipePost contains a collection of different data from the backend  each piece must be assigned to a new variable.
// 		const recipeName = recipeName.name ? [...recipeName.name] : varchar[100];
// 		const recipeRating = recipeRating.rating ? [...recipeRating.rating] : INT[1];
// 		const recipeDescription = recipeDescription.description ? [...recipeDescription.description] : varchar[1000];
// 		const recipeIngredients = recipeIngredients.ingredients ? [...recipeIngredients.ingredients] : varchar[300];
// 		const recipeNumberIngredients = recipeNumberIngredients.numberIngredients ? [...recipeNumberIngredients.numberIngredients] : INT[2];
// 		const recipeSteps = recipeSteps.steps ? [...recipeSteps.steps] : varchar[1500];
// 		const recipeReview = recipeReview.review ? [...recipeReview.review] : varchar[2000];
// 		const recipeImageURL = recipeImageURL.imageURL ? [...recipeImageURL.imageURL] : varchar[255];
// 		const recipeNutrition = recipeNutrition.nutrition ? [...recipeNutrition.nutrition] : varchar[255];
// 		const recipeSubmissionDate = recipeSubmissionDate.submissionDate ? [...recipeSubmissionDate.SubmissionDate] : datetime[6];
// 		const recipeMinutes = recipeMinutes.minutes ? {...recipeMinutes.minutes} : INT[3];
// 		const dispatch = useDispatch();
// 		const sideEffects = () => {
//
// 			// The dispatch function takes actions as arguments to make changes to the store/redux.
// 			dispatch(getRecipePosts(match.params.recipeId))
// 		};
//
// 		// Declare any inputs that will be used by functions that are declared in sideEffects.
// 		const sideEffectInputs = [match.params.recipeId];
//
// 		/**
// 		 * Pass both sideEffects and sideEffectInputs to useEffect.
// 		 * useEffect is what handles rerendering of components when sideEffects resolve.
// 		 * E.g when a network request to an api has completed and there is new data to display on the dom.
// 		 **/
//
// 		useEffect(sideEffects, sideEffectInputs);
//
// 		return (
// 			<>
// 				<main className="container">
// 					{recipe && (<h2>{recipe.name}</h2>)}
// 					<div className="card-group card-columns">
// 						{
// 							posts.map(post => <PostCard  key={recipe.recipeId} recipe={recipe} />)
// 						}
// 					</div>
// 				</main>
// 			</>
// 		)
// 	};

//lets see if this works better then the above

import React, {Component} from 'react';
import PropTypes from 'prop-types';
import './stylesheet.css';

class Recipe extends Component {
	static propTypes = {
		title: PropTypes.string.isRequired,
		ingredients: PropTypes.arrayOf(PropTypes.string).isRequired,
		instructions: PropTypes.string.isRequired,
		img: PropTypes.string.isRequired,
		id: PropTypes.number.isRequired,
: PropTypes.func.isRequired
}

render() {
	const ingredients = this.props.ingredients.map((ing, index) => (
		<li key={index}>{ing}</li>
	));
	return (
		<div className="recipe-card">
			<div className="recipe-card-img">
				<img src={img} alt={title} />
			</div>
			<div className="recipe-card-content">
				<h3 className="recipe-title">{title}</h3>
				<h4>Ingredients:</h4>
				<ul>
					{ingredients}
				</ul>
				<h4>Instructions:</h4>
				<p>{instructions}</p>
			</div>
		</div>
	);
}
}