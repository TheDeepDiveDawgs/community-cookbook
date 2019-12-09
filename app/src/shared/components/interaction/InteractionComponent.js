import React, {useEffect, useState} from 'react';
import {useSelector, useDispatch} from "react-redux";
import Card from "react-bootstrap/Card";
import {getRecipeInteractions} from "../../actions/interactionAction";
import Ratings from 'react-ratings-declarative';

export const InteractionComponent = (props) => {
	const {recipeId} = props;
	//returns the user(s) from redux and assigns it to the users variable
	const interactions = useSelector(state => state.interactions ? state.interactions : []);
	//assigns useDispatch reference to the dispatch variable for late use
	const dispatch = useDispatch();
	//define the side effects that will occur in app
	//E.G. Code that handles dispatches to redux , api requests, or times
	function sideEffects() {
		//dispatch function takes actions as arguments to make changes to the store/redux
		dispatch(getRecipeInteractions(recipeId))
	}
	const sideEffectsInputs = [recipeId];

	useEffect(sideEffects, sideEffectsInputs);

	console.log(interactions.length);

	const reducer = (accumulator, interaction) => accumulator.interactionRating + interaction.interactionRating;
	 // console.log(interactions.reduce(reducer));

	const average = (interactions.length ? interactions.reduce(reducer)/interactions.length : "No Interactions yet");

	return (


						<Card style={{width: '18rem'}} >
							<Card.Img/>
							<Card.Body>
								<Card.Text> Rating {average} </Card.Text>
							</Card.Body>
						</Card>




	)
};












