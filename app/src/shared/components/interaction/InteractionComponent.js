import React, {useEffect, useState} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {httpConfig} from "../../utils/http-config";
import {UseJwtUserId} from "../../utils/JwtHelpers";
import {UseJwt} from "../../utils/JwtHelpers";
import {UseJwtUserHandle} from "../../utils/JwtHelpers";
import {handleSessionTimeout} from "../../../shared/misc/handle-session-timeout"
import _ from "lodash";
import Card from "react-bootstrap/Card";

export const Rating = ({userId, recipeId}) => {
	//grab the JWT token for logged in users
	const jwt =UseJwt();

	/*
	The isRated state variable sets stars to red whether or not the user has rated the recipe
	"active" is a bootstrap class  that will be added later to the star rating
	 */
	const [isRated, setIsRated] = useState(null);
	const [ratingCount, setRatingCount] = useState(0);

	//return all ratings from the redux store
	const ratings = useSelector(state => (state.ratings ? state.ratings : []));

	const effects = () => {
		initializeRatings(userId);
		countRatings(recipeId);
	};

	/* add ratings to inputs - informs react that ratings are being updated from Redux
	ensures proper component rendering
	 */
	const inputs = [ratings, userId, recipeId];
	useEffect(effects, inputs);
};









	return (
		<>

			{interactions.map(interaction => {
				return (
					<>
					<Card style={{width: '18rem'}}>
					<Card.Img/>
					<Card.Body>
						<Card.Text> Rating </Card.Text>
					</Card.Body>
					</Card>
					</>
				)

			})}
		</>
	)
};
