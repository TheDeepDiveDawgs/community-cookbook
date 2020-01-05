import React from 'react';
import ListGroup from "react-bootstrap/ListGroup";

export const CategoryCard = ({category}) => {
	return (
		<div className="text-center row justify-content-center">
			<ListGroup variant="flush">
				<ListGroup.Item action variant="category" href="">{category.categoryName}</ListGroup.Item>
			</ListGroup>
		</div>
	);
};

