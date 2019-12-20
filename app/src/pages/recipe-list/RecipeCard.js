import React from 'react';
import { Route } from 'react-router';
import Card from "react-bootstrap/Card";
import logo from "./cap-logo-4.png";

export const RecipeCard = ({recipe}) => {
	return (

//this gives form to the recipes in the list on DOM
<Route render={ ({history}) => (
		<Card className="mb-4 mr-3" key={recipe.recipeId} onClick={() => {history.push(`recipe-page.js/${recipe.recipeId}`)}}>
		{/*<Card className="mb-4 mr-5">*/}
			<Card.Body className="row">
				<div className="col-md-3 d-none d-sm-block">
					<Card.Img src={recipe.recipeImageUrl ? recipe.recipeImageUrl : logo} alt="placeholder"/>
				</div>
				<div className="col-md-9" data-categoryId={recipe.recipeCategoryId}>
					<Card.Title> {recipe.recipeName}</Card.Title>
					<Card.Subtitle>Cook Time: {recipe.recipeMinutes} mins. Rating: {recipe.recipeRating}</Card.Subtitle>
					<Card.Text>Description: {recipe.recipeDescription}</Card.Text>
				</div>
			</Card.Body>
		</Card>
	)}/>
	)
};