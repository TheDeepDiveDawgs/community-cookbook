import React from 'react';
import { Route } from 'react-router';
import Card from "react-bootstrap/Card";
import logo from "./cap-logo-4.png";

export const RecipeCard = ({recipe}) => {
	return (


<Route render={ ({history}) => (

		<Card>
			<Card.Body className="row my-3 mx-3" key={recipe.recipeId} onClick={() => {history.push(`recipe-page.js/${recipe.recipeId}`)}}>
				<div className="col-3">
					<Card.Img src={recipe.recipeImageUrl ? recipe.recipeImageUrl : logo} alt="placeholder"/>
				</div>
				<div className="col-9" data-categoryId={recipe.recipeCategoryId}>
					<Card.Title> {recipe.recipeName}</Card.Title>
					<Card.Subtitle>Cook Time: {recipe.recipeMinutes} mins. Rating: {recipe.recipeRating}</Card.Subtitle>
					<Card.Text>Description: {recipe.recipeDescription}</Card.Text>
				</div>
			</Card.Body>
		</Card>
	)}/>
	)
};