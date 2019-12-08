import React, {useEffect, useState} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {httpConfig} from "../../utils/http-config";
import {UseJwtUserId} from "../../utils/JwtHelpers";
import {UseJwt} from "../../utils/JwtHelpers";
import {UseJwtUserHandle} from "../../utils/JwtHelpers";
import {handleSessionTimeout} from "../../../shared/misc/handle-session-timeout"
import _ from "lodash";
import Card from "react-bootstrap/Card";

export const Rating = ({userId, RecipeId}) => {
	//grab the JWT token for logged in users
	const jwt =UseJwt();

	/*
	The isRated state variable sets button to red whether or not the user has rated the recipe
	"active" is a bootstrap class  that will be added later to the star rating
	 */
	const [isRated, setIsRated] = useState(null);

	//return all ratings from the redux store
	const ratings = useSelector(state => (state.ratings ? state.ratings : []));

	const effects = () => {
		initializeRatings(userId);

	}
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
