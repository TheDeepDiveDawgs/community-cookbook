import React, { Component } from 'react';
import Card from "react-bootstrap/Card";

export const RecipeCard = () => {
		return (
			<Card class="container">
				<Card.Body className="row">
					<div className="col-3">
					<Card.Img src="cap-logo-4.png" alt="placeholder"/>
					</div>
					<div className="col-9">
					<Card.Title> Recipe </Card.Title>
					<Card.Subtitle>Rating, Cooktime, Ingredients </Card.Subtitle>
					<Card.Text>Description of recipe</Card.Text>
					</div>
				</Card.Body>
			</Card>
		);
};

