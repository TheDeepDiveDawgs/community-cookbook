import React from "react";
import Form from "react-bootstrap/Form";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faSearch} from "@fortawesome/free-solid-svg-icons";
// import FormControl from "react-bootstrap/FormControl";

export const SearchFormContent = ({setSearchTerm}) => {
		 const setSearch = (e) => {
		 	//check the input field for which characters are being entered and set them as the search term
		 	// console.log("hello recipe", e.target.value);
		 	setSearchTerm(e.target.value);
}

	return (
		<>
			<Form inline className="justify-content-center p-5">
				<Form.Control type="text"
					    placeholder="Search for recipe... "
						 id="search-text"
						 onChange={setSearch}
				/>
			</Form>
		</>
	);
};