import React, {useEffect} from "react";
import Navbar from "react-bootstrap/Navbar";
import Nav from "react-bootstrap/Nav";
import {LinkContainer} from "react-router-bootstrap"
import {UseJwt} from "../../utils/JwtHelpers";
import {SignUpModal} from "./sign-up/SignUpModal";
import {SignInModal} from "./sign-in/SignInModal";
import logo from "./images/nav-icon.png";
import smallLogo from "./images/nav-icon-sm.png"
import {httpConfig} from "../../utils/http-config";
import {UserMenu} from "./user-menu/UserMenu";
import {SearchFormContent} from "./search/SearchForm";


export const MainNav = (props) => {

	const jwt = UseJwt();


	useEffect( () =>{
		httpConfig.get("./apis/sessionAPI/")
	});


	return(
		<Navbar className="nav-style" variant="dark" expand="lg">
			<LinkContainer exact to="/">
				<img alt="ABQCOOKBOOK Icon"
					 src= {logo}
					 id="nav-image"
					 className="d-none d-lg-inline-block align-top"
				/>
			</LinkContainer>

			<LinkContainer exact to="/">
				<img alt="ABQCOOKBOOK Icon"
					  src={smallLogo}
					  id="nav-image-small"
					  className="d-lg-none d-inline-block align-top"
				/>
			</LinkContainer>


			<Navbar.Toggle aria-controls="responsive-navbar-nav" />
			<Navbar.Collapse id="responsive-navbar-nav">
				<Nav className="ml-auto text-right">
						<SearchFormContent/>
						<SignUpModal/>
					{jwt !== null ?
						<UserMenu/>
					 :
						<SignInModal/>
					}
				</Nav>
			</Navbar.Collapse>
		</Navbar>
	)
};
