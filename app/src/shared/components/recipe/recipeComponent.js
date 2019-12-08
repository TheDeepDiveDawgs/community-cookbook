import React, {useEffect} from "react";
import {useSelector, useDispatch} from "react-redux";
import {getAllRecipes} from "../../actions/doWeNeedThis";
import  Card from "react-bootstrap/Card";

return (
	<>
		{recipes.map(recipes => {
			return (
				<>
					<Card	style={{width: '18rem'}}>
						<Card.Img/>
						<Card.Body>
							<Card.Text> recipe text {recipes.recipe}</Card.Text>
						</Card.Body>
					</Card>
				</>
			)
		})}
	</>
)
};export const RecipeComp = () => {

	const recipes = useSelector(state => state.recipes);
	const dispatch = useDispatch();

	const effects = () => {
		dispatch(getAllRecipes());
	};

	const inputs = [];

	useEffect(effects, inputs);

