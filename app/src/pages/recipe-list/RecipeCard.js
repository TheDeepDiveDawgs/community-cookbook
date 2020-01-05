import React from 'react';
import { Route } from 'react-router';
import Card from "react-bootstrap/Card";
import logo from "./cap-logo-4.png";

export const RecipeCard = ({recipe}) => {
	return (

//this gives form to the recipes in the list on DOM
<Route render={ ({history}) => (
		<Card className="my-5 mx-4" key={recipe.recipeId} onClick={() => {history.push(`recipe-page.js/${recipe.recipeId}`)}}>
		{/*<Card className="mb-4 mr-5">*/}
			<Card.Body className="row my-3 mx-3">
				<div className="col-12 col-lg-3">
					<Card.Img src={recipe.recipeImageUrl ? recipe.recipeImageUrl : logo} alt="placeholder"/>
				</div>
				<div className="col-12 col-lg-9" data-categoryId={recipe.recipeCategoryId}>
					<Card.Title className="m-3"> {recipe.recipeName}</Card.Title>
					<Card.Subtitle className="m-3" >Cook Time: {recipe.recipeMinutes} mins. Rating: {recipe.recipeRating}</Card.Subtitle>
					<Card.Text className="m-3">Description: {recipe.recipeDescription}</Card.Text>
				</div>
			</Card.Body>
		</Card>
	)}/>
	)
};