import React, {useEffect} from 'react';
import Form from "react-bootstrap/Form";
import './recipe-list-styles.css';

export const SearchBar = () => {
	return (
		<Form.Group>
			<div className="row">
				<div className="offset-md-1 col-9">
					<Form.Control type="text" name="search-keywords" placeholder="Search by recipe name (ex. enchiladas), ingredient (ex. chile, or instructions (ex. oven)."/>
				</div>
				<div className="onset-md-1 col-1">
					<button type="button">Search</button>
				</div>
			</div>
		</Form.Group>
	);
};
