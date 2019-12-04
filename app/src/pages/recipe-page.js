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
		const posts = recipePosts.posts ? [...recipePosts.posts] : [];
		const posts = recipePosts.posts ? [...recipePosts.posts] : [];
		const posts = recipePosts.posts ? [...recipePosts.posts] : [];
		const posts = recipePosts.posts ? [...recipePosts.posts] : [];
		const posts = recipePosts.posts ? [...recipePosts.posts] : [];
		const recipe = recipePosts.recipe ? {...recipePosts.recipe} : null;
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

		return (
			<>
				<main className="container">
					{recipe && (<h2>{recipe.name}</h2>)}
					<div className="card-group card-columns">
						{
							posts.map(post => <PostCard  key={recipe.recipeId} post={post} />)
						}
					</div>
				</main>
			</>
		)
	};

