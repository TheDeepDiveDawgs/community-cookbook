import React from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
// import {SignUpModal} from "./sign-up/SignUpModal";
//import {SignInModal} from "./sign-in/SigninModal";

export const MainNav = (props) => {
	return(
		<Navbar bg="dark" variant="dark">
			<img src={"./images/cap-logo.png"} />
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
