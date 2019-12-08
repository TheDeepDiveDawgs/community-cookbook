import React, {Component} from 'react';
import {RecipeCard} from "./RecipeCard";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";

export const Recipes = () => {
	return (
		<main>
			<Container>
				<Row>
					<Col>
						<RecipeCard/>
						<RecipeCard/>
						<RecipeCard/>
						<RecipeCard/>
						<RecipeCard/>
					</Col>
				</Row>
			</Container>
		</main>
	)
};
