import React, {useEffect, useState} from 'react';
import {useSelector, useDispatch} from "react-redux";
import Card from "react-bootstrap/Card";
import {getRecipeInteractions} from "../../actions/interactionAction";
import Ratings from "react-ratings-declarative";
import {httpConfig} from "../../utils/http-config"




export const InteractionComponent = (props) => {

	const [status, setStatus] = useState(null)

	const {recipeId} = props;
	//returns the user(s) from redux and assigns it to the users variable
	const interactions = useSelector(state => state.interaction ? state.interaction : []);
	//assigns useDispatch reference to the dispatch variable for late use
	const dispatch = useDispatch();
	//define the side effects that will occur in app
	//E.G. Code that handles dispatches to redux , api requests, or times
	function sideEffects() {
		//dispatch function takes actions as arguments to make changes to the store/redux
		dispatch(getRecipeInteractions(recipeId))
	}

	const sideEffectsInputs = [recipeId, setStatus];

	useEffect(sideEffects, sideEffectsInputs);
	//adds the array of ratings
	const reducer = (accumulator, interaction) => accumulator + interaction.interactionRating;
	// performs the math for avg rating
	const average = (interactions.length ? interactions.reduce(reducer, 0) / interactions.length : .01);

const submitRating = (values, setStatus) => {
        
        const headers = {
            'X-JWT-TOKEN': window.localStorage.getItem("jwt-token")
        };

        httpConfig.post("../apis/interaction", values, {
            headers: headers})
            .then(reply => {
				let {message, type} = reply;
				setStatus({message, type});
                if(reply.status === 200) {
                    window.location.reload();
                    console.log(reply)
                };
            });
    };

	return (
		<>
			<Ratings
				rating={interactions.interactionRating}
				widgetRatedColors="#F5FF38"
				changeRating={submitRating}
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
				
		</>
	)
};












