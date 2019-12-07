import React, {useEffect} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {getAllInteractions} from "../../actions/interactionAction";
import Card from "react-bootstrap/Card";

export const InteractionComp = () => {

	const interactions = useSelector(state => state.interactions);
	const dispatch = useDispatch();

	const effects = () => {
		dispatch(getAllInteractions());
	};

	const inputs = [];

	useEffect(effects, inputs);

	return (
		<>

			{interactions.map(interaction => {
				return (
					<>
					<Card style={{width: '18rem'}}>
					<Card.Img/>
					<Card.Body>
						<Card.Text> Rating {interaction.rating}</Card.Text>
					</Card.Body>
					</Card>
					</>
				)

			})}
		</>
	)
};
