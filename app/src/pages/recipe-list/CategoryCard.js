import React from 'react';
import ListGroup from "react-bootstrap/ListGroup";

export const CategoryCard = ({category}) => {
	return (
		<div className="text-right row float-right float-lg-none justify-content-lg-center my-3 mx-auto">
			<ListGroup className="col-12" variant="flush">
				<ListGroup.Item className="p-4 border border-warning" action variant="category" href="">{category.categoryName}</ListGroup.Item>
			</ListGroup>
		</div>
	);
};

