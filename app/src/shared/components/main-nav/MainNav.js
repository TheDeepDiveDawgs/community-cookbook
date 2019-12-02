import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
// import {SignUpModal} from "./sign-up/SignUpModal";
//import {SignInModal} from "./sign-in/SigninModal";
import logo from "./images/logo.png";

export const MainNav = (props) => {
	return(
		<Navbar bg="dark" variant="dark">
			<Navbar.Brand href="/">
				<img className="cap-logo-4.png"
					  src= {logo}
					  width="80"
					  height="80"
					  className="d-inline-block align-top"
				/>
			</Navbar.Brand>

			<LinkContainer exact to="/" >
				<Navbar.Brand>ABQ Cookbook</Navbar.Brand>
			</LinkContainer>
			<Nav className="mr-auto">
				<LinkContainer exact to="/profile">
					<Nav.Link>search</Nav.Link>
				</LinkContainer>
				{/*<SignUpModal/>*/}
				{/*<SignInModal/>*/}
				<LinkContainer exact to="/image"
				><Nav.Link>image</Nav.Link>
				</LinkContainer>
			</Nav>
		</Navbar>
	)
};
