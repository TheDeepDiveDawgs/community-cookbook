import React, {Component} from 'react';
import Form from "react-bootstrap/Form";

export const SearchBar = () => {
	return (
		<Form.Group controlId="formBasicEmail" className="container">
			<div className="row">
				<div className="col-9">
					<Form.Control type="text" placeholder="Search by recipe name (ex. enchiladas), ingredient (ex. chile, or instructions (ex. oven)."/>
				</div>
				<div className="col-3">
					<button type="button">Search</button>
				</div>
			</div>
		</Form.Group>
	);
};
