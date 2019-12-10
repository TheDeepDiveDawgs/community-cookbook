import React, { Component } from 'react';
import Card from "react-bootstrap/Card";
import ListGroup from "react-bootstrap/ListGroup";

export const CategoryCard = ({category}) => {
	return (
		<div>
			<ListGroup variant="flush">
				<ListGroup.Item action variant="category" href="#">{category.categoryName}</ListGroup.Item>
			</ListGroup>
		</div>
	);
};

