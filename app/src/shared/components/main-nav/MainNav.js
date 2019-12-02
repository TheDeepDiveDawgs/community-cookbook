import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
import {SignUpModal} from "./sign-up/SignUpModal";
import {SearchFormContent} from "./search/SearchForm";
import AbqCookBookLogo from "./images/abqcookbook-logo.png"


export const MainNav = (props) => {
	return(
		<Navbar className="bg-nav p-4" variant="dark">
			<LinkContainer exact to="/" >
				<Navbar.Brand>
					<img
						alt="ABQCOOKBOOK"
						src={AbqCookBookLogo}
						className="d-inline-block align-top"
						/>{' '}
						<h1 className="mx-4 d-inline-block justify-content-center">ABQCOOKBOOK</h1>
				</Navbar.Brand>
			</LinkContainer>
			<Nav className="ml-auto">
				<SearchFormContent/>
				<SignUpModal/>
			</Nav>
		</Navbar>
	)
};