import React from 'react';
import Card from "react-bootstrap/Card";
import logo from "./cap-logo-4.png";

export const RecipeCard = ({recipe}) => {
	return (
		<Card>
			<Card.Body className="row">
				<div className="col-3">
					<Card.Img src={recipe.receipeImageUrl ? recipe.receipeImageUrl : logo} alt="placeholder"/>
				</div>
				<div className="col-9">
					<Card.Title id="recipeName"> {recipe.recipeName}</Card.Title>
					<Card.Subtitle>Cooktime: {recipe.recipeMinutes} min</Card.Subtitle>
					<Card.Text>Description: {recipe.recipeDescription}</Card.Text>
				</div>
			</Card.Body>
		</Card>
	);
};