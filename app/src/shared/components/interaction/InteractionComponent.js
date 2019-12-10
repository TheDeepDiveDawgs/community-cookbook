import React, {useEffect, useState} from 'react';
import {useSelector, useDispatch} from "react-redux";
import Card from "react-bootstrap/Card";
import {getRecipeInteractions} from "../../actions/interactionAction";
import Ratings from 'react-ratings-declarative';


// class Foo extends Component {
// 	changeRating( newRating ) {
// 		this.setState({
// 			rating: newRating
// 		});
// 	}

	// render() {
	// 	return (
	// 		<Ratings
	// 			rating={this.state.rating}
	// 			widgetRatedColors="blue"
	// 			changeRating={this.changeRating}
	// 		>
	// 			<Ratings.Widget />
	// 			<Ratings.Widget />
	// 			<Ratings.Widget
	// 				widgetDimension="60px"
	// 				svgIconViewBox="0 0 5 5"
	// 				svgIconPath="M2 1 h1 v1 h1 v1 h-1 v1 h-1 v-1 h-1 v-1 h1 z"
	// 			/>
	// 			<Ratings.Widget widgetHoverColor="black" />
	// 			<Ratings.Widget />
	// 		</Ratings>
	// 	);
	// }
// }


// class Bar extends Component {
// 	render() {
// 		return (
// 			<Ratings
// 				rating={3.403}
// 				widgetDimensions="40px"
// 				widgetSpacings="15px"
// 			>
// 				<Ratings.Widget widgetRatedColor="green" />
// 				<Ratings.Widget widgetSpacing="30px" widgetDimension="15px" />
// 				<Ratings.Widget widgetRatedColor="black" />
// 				<Ratings.Widget widgetRatedColor="rebeccapurple" />
// 				<Ratings.Widget />
// 			</Ratings>
// 		);
// 	}
// }


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

	const average = (interactions.length ? interactions.reduce(reducer)/interactions.length : "0");


		return (

			<Card style={{width: '12rem',}}>
				<Card.Body >
					<Ratings
									rating={+average}
									widgetRatedColors="#F5FF38"
									changeRating={+average}
									widgetHoverColors="#F5FF38"
									widgetDimensions="1rem"
								>
						 			<Ratings.Widget  />
						 			<Ratings.Widget  />
						 			<Ratings.Widget

										// svgIconViewBox="0 0 5 5"
										// svgIconPath="M2 1 h1 v1 h1 v1 h-1 v1 h-1 v-1 h-1 v-1 h1 z"
									/>
						 			<Ratings.Widget  />
						 			<Ratings.Widget  />
						 		</Ratings>


				</Card.Body>
			</Card>
		)

};












