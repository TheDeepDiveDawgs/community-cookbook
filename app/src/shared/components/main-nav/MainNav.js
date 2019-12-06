import React, {useEffect} from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
import {UseJwt} from "../../utils/JwtHelpers";
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModal";
import logo from "./images/nav-icon.png";
import {httpConfig} from "../../utils/http-config";
import {UserMenu} from "./user-menu/UserMenu";


export const MainNav = (props) => {

	const jwt = UseJwt();


	useEffect( () =>{
		httpConfig.get("./apis/sessionAPI/")
	});


	return(
		<Navbar className="nav-style" expand="lg">
			<LinkContainer exact to="/">
				<img alt="ABQCOOKBOOK Icon"
					 src= {logo}
					 id="nav-image"
					 className="d-inline-block align-top"
				/>
			</LinkContainer>

			<Navbar.Toggle aria-controls="basic-navbar-nav"/>
			<Navbar.Collapse id="basic-navbar-nav">
				<Nav className="ml-auto">
					<SignUpModal/>
					{jwt !== null ? (
						<UserMenu/>
					) : (
						<SignInModal/>
					)}
				</Nav>
			</Navbar.Collapse>
		</Navbar>
	)
};
