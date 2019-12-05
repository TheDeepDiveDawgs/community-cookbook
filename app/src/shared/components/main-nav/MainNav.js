import React, {useEffect} from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModal";
import logo from "./images/nav-icon.png";
import {httpConfig} from "../../utils/http-config";


export const MainNav = (props) => {

	useEffect( () =>{
		httpConfig.get("./apis/sessionAPI/")
	});

	return(
		<Navbar className="nav-style" expand="lg">
			<LinkContainer exact to="/">
				<img alt="ABQCOOKBOOK Icon"
					  src= {logo}
					  className="d-inline-block align-top"
				/>
			</LinkContainer>

			<Navbar.Toggle aria-controls="basic-navbar-nav"/>
			<Navbar.Collapse id="basic-navbar-nav">
				<Nav className="ml-auto">
					<SignUpModal/>
					<SignInModal/>
				</Nav>
			</Navbar.Collapse>
		</Navbar>
	)
};
