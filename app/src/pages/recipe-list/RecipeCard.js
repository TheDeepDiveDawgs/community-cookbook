import React from 'react';
import { Route } from 'react-router';
import Card from "react-bootstrap/Card";
import logo from "./../images/recipe-placeholder.jpg";
import {InteractionComponent} from "../../shared/components/interaction/InteractionComponent"

export const RecipeCard = ({recipe}) => {
	return (

//this gives form to the recipes in the list on DOM
<Route render={ ({history}) => (
		<Card className="my-5 alternate-bg mx-4" key={recipe.recipeId}>
		{/*<Card className="mb-4 mr-5">*/}
			<Card.Body className="row my-3 mx-3">
				<div className="col-12 col-lg-3">
					<Card.Img id="hover-image" src={recipe.recipeImageUrl ? recipe.recipeImageUrl : logo} alt="placeholder" onClick={() => {history.push(`recipe-page.js/${recipe.recipeId}`)}}/>
				</div>
				<div className="col-12 col-lg-9" data-categoryId={recipe.recipeCategoryId}>
					<Card.Title className="m-3 display-4" id="recipe-card-title" onClick={() => {history.push(`recipe-page.js/${recipe.recipeId}`)}}> {recipe.recipeName}</Card.Title>
					<Card.Subtitle className="m-3" >Cook Time: {recipe.recipeMinutes} mins.
						<div className="my-3"> 
							Rating: <InteractionComponent recipeId={recipe.recipeId}/>
						</div>
					</Card.Subtitle>
					<Card.Text className="m-3"><strong>Description:</strong> {recipe.recipeDescription}</Card.Text>
				</div>
			</Card.Body>
		</Card>
	)}/>
	)
};