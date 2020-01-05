import React from 'react';
import ListGroup from "react-bootstrap/ListGroup";

export const CategoryCard = ({category}) => {
	return (
		<div className="text-center row float-right float-lg-none justify-content-lg-center my-3 mr-3">
			<ListGroup variant="flush">
				<ListGroup.Item action variant="category" href="">{category.categoryName}</ListGroup.Item>
			</ListGroup>
		</div>
	);
};

