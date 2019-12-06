import React from "react";
import Button from 'react-bootstrap/Button'
import Form from "react-bootstrap/Form";
import FormControl from "react-bootstrap/FormControl";


export const SearchFormContent = () => {

	return (
		<>
			<Form inline className="ml-auto">
				<FormControl type="text" placeholder="Search" id="search-text"/>
				<Button className="btn btn-dark mx-4 px-4 py-2 text-white" variant="outline-dark" id="search-button">Search</Button>
			</Form>
		</>
	)
};