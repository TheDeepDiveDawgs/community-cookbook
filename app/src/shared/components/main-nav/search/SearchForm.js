import React from "react";
import Button from 'react-bootstrap/Button'
import Form from "react-bootstrap/Form";
import FormControl from "react-bootstrap/FormControl";
import {httpConfig} from "../../../utils/http-config";


export const SearchFormContent = () => {

	const searchTerm = () => {
		httpConfig.get('apis/recipe/')
			.then(reply => {
				let {message, type} = reply;
				if (reply.status === 200) {
					console.log(reply);
					window.location = "/recipe-list";
				}
			})
	};

	return (
		<>
			<Form inline className="ml-auto" id="search-box">
				<FormControl type="text" placeholder="Search for recipe" id="search-text"/>
				<Button className="btn btn-dark mx-4 px-4 py-2 text-white"
						variant="outline-dark"
						id="search-button"
						type="submit"
						onSubmit={searchTerm}
				>
					Search</Button>
			</Form>
		</>
	)
};