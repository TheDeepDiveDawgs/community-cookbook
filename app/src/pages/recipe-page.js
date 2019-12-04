import React from "react";
import {useSelector, useDispatch} from "react-redux";
import React, {useEffect} from 'react';
import {getRecipePosts} from "../../shared/actions/get-recipe-posts";
import {PostCard} from "./recipecard";


//postcard generic

	export const  PostCard = (props) => {
		
		const {post} = props;
		return (
			<div className="card text-white bg-dark mb-3">
				<div className="card-body">
					<h5 className="card-title">{post.title}</h5>
					<p className="card-text">{post.body}</p>
					<p className="card-text">
						<small className="text-muted">{post.recipePage}</small>
					</p>
				</div>
			</div>
		)
	};

// recipe post

	export const RecipePosts = ({match}) => {

		// Returns the the recipePosts store from redux and assigns it to the recipePosts variable.
		const recipePosts = useSelector(state => state.recipePost ? state.recipePost : []);

		// Since recipePost contains a collection of different data from the backend  each piece must be assigned to a new variable.
		const recipePage = recipeName.name ? [...recipeName.name] : [];
		const recipeRating = recipeRating.rating ? [...recipeRating.rating] : [];
		const recipeDescription = recipeDescription.description ? [...recipeDescription.description] : [];
		const recipeIngredients = recipeIngredients.ingredients ? [...recipeIngredients.ingredients] : [];
		const recipeNumberIngredients = recipeNumberIngredients.numberIngredients ? [...recipeNumberIngredients.numberIngredients] : [];
		const recipeSteps = recipeSteps.steps ? [...recipeSteps.steps] : [];
		const recipeReview = recipeReview.review ? [...recipeReview.review] : [];
		const recipeImageURL = recipeImageURL.imageURL ? [...recipeImageURL.imageURL] : [];
		const recipeNutrition = recipeNutrition.nutrition ? [...recipeNutrition.nutrition] : [];
		const recipeSubmissionDate = recipeSubmissionDate.submissionDate ? [...recipeSubmissionDate.SubmissionDate] : [];
		const recipeMinutes = recipeMinutes.minutes ? {...recipeMinutes.minutes} : [];
		const dispatch = useDispatch();
		const sideEffects = () => {

			// The dispatch function takes actions as arguments to make changes to the store/redux.
			dispatch(getRecipePosts(match.params.recipeId))
		};

		// Declare any inputs that will be used by functions that are declared in sideEffects.
		const sideEffectInputs = [match.params.recipeId];


		/**
		 * Pass both sideEffects and sideEffectInputs to useEffect.
		 * useEffect is what handles rerendering of components when sideEffects resolve.
		 * E.g when a network request to an api has completed and there is new data to display on the dom.
		 **/
		useEffect(sideEffects, sideEffectInputs);
//have not gotten to this yet
		return (
			<>
				<main className="container">
					{recipe && (<h2>{recipe.name}</h2>)}
					<div className="card-group card-columns">
						{
							posts.map(post => <PostCard  key={recipe.recipeId} recipe={recipe} />)
						}
					</div>
				</main>
			</>
		)
	};

