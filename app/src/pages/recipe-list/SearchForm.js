import React from "react";
import Form from "react-bootstrap/Form";

// import FormControl from "react-bootstrap/FormControl";

export const SearchFormContent = ({setSearchTerm}) => {
		 const setSearch = (e) => {
		 	e.preventDefault();
		 	//check the input field for which characters are being entered and set them as the search term
		 	setSearchTerm(e.target.value);
};

	return (
		<>
			<Form inline className="justify-content-center p-5">
				<Form.Control type="text"
					    placeholder="Search for recipe... "
						 id="search-text"
						 onChange={setSearch}
						 onSubmit={setSearch}
				/>	
			</Form>
		</>
	);
};