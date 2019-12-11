import React, {useEffect} from 'react';
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
	//adds the array of ratings
	const reducer = (accumulator, interaction) => accumulator + interaction.interactionRating;
	// performs the math for avg rating
	const average = (interactions.length ? interactions.reduce(reducer, 0) / interactions.length : "0");

	return (
		<Card style={{width: '10rem',}}>
			<Card.Body>
				<Ratings
					rating={+average}
					widgetRatedColors="#F5FF38"
					changeRating={+average}
					widgetHoverColors="#F5FF38"
					widgetDimensions="1.2rem"
					widgetSpacings="1px"
				>
					<Ratings.Widget/>
					<Ratings.Widget/>
					<Ratings.Widget/>
					<Ratings.Widget/>
					<Ratings.Widget/>
				</Ratings>
			</Card.Body>
		</Card>
	)
};












