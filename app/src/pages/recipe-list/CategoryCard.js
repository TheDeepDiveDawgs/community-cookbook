import React from 'react';
import Card from "react-bootstrap/Card";
import ListGroup from "react-bootstrap/ListGroup";

export const CategoryCard = () => {
	return (
		<Card>
			<ListGroup variant="flush">
				<ListGroup.Item action variant="category" href="#">Category 1</ListGroup.Item>
				<ListGroup.Item action variant="category" href="#1">Category 2</ListGroup.Item>
				<ListGroup.Item action variant="category" href="#2">Category 3</ListGroup.Item>
				<ListGroup.Item action variant="category" href="#3">Category 4</ListGroup.Item>
			</ListGroup>
		</Card>
	);
};

