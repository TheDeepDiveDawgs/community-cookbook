{/*<Figure>*/}
{/*	<Figure.Image*/}
{/*		// i need to put recipe image from database here?*/}
{/*		width={1000}*/}
{/*		height={1000}*/}
{/*		alt="171x180"*/}
{/*		src="file/image"*/}
{/*	/>*/}
{/*	<Figure.Caption>*/}
{/*		/!*I need to put the recipe info form database here*!/*/}
{/*	</Figure.Caption>*/}
{/*</Figure>*/}
// add in recipe rating
// also need to add css to style side by side

// examples for data design

export default (state = [], action) => {
// 	switch(action.type) {
// 		case "GET_ALL_TWEETS":
// 			return action.payload;
// 		default:
// 			return state;
// 	}
// }

	// export default (state = [], action) => {
	// 	switch(action.type) {
	// 		case "GET_ALL_TWEETS":
	// 			return action.payload;
	// 		default:
	// 			return state;
	// 	}
	// }

//postcard generic

	// import React from "react";
	//
	// export const  PostCard = (props) => {
	// 	const {post} = props;
	// 	return (
	// 		<div className="card text-white bg-dark mb-3">
	// 			<div className="card-body">
	// 				<h5 className="card-title">{post.title}</h5>
	// 				<p className="card-text">{post.body}</p>
	// 				<p className="card-text">
	// 					<small className="text-muted">{post.username}</small>
	// 				</p>
	// 			</div>
	// 		</div>
	// 	)
	// };

//userpost
//
// 	import {useSelector, useDispatch} from "react-redux";
// 	import React, {useEffect} from 'react';
// 	import {getUserPosts} from "../../shared/actions/get-user-posts";
// 	import {PostCard} from "./PostCard";
//
// 	export const UserPosts = ({match}) => {
//
// 		// Returns the the userPosts store from redux and assigns it to the userPosts variable.
// 		const userPosts = useSelector(state => state.userPosts ? state.userPosts : []);
//
// 		// Since userPosts contains a collection of different data from the backend  each piece must be assigned to a new variable.
// 		const posts = userPosts.posts ? [...userPosts.posts] : [];
// 		const user = userPosts.user ? {...userPosts.user} : null;
// 		const dispatch = useDispatch();
// 		const sideEffects = () => {
//
// 			// The dispatch function takes actions as arguments to make changes to the store/redux.
// 			dispatch(getUserPosts(match.params.userId))
// 		};
//
// 		// Declare any inputs that will be used by functions that are declared in sideEffects.
// 		const sideEffectInputs = [match.params.userId];
//
//
// 		/**
// 		 * Pass both sideEffects and sideEffectInputs to useEffect.
// 		 * useEffect is what handles rerendering of components when sideEffects resolve.
// 		 * E.g when a network request to an api has completed and there is new data to display on the dom.
// 		 **/
// 		useEffect(sideEffects, sideEffectInputs);
//
// 		return (
// 			<>
// 				<main className="container">
// 					{user && (<h2>{user.name}</h2>)}
// 					<div className="card-group card-columns">
// 						{
// 							posts.map(post => <PostCard  key={post.postId} post={post} />)
// 						}
// 					</div>
// 				</main>
// 			</>
// 		)
// 	};