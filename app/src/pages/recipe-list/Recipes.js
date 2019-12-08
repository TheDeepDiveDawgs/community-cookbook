import React, {Component} from 'react';
import {RecipeCard} from "./RecipeCard";
import Card from "react-bootstrap/Card";
import Col from "react-bootstrap/Col";

export const Recipes = () => {
	return (
		<Card>
				<Card.Body>
						<RecipeCard/>
						<RecipeCard/>
						<RecipeCard/>
						<RecipeCard/>
						<RecipeCard/>
				</Card.Body>
		</Card>
	)
};
