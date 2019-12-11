import React from "react"
// import {ButtonGroup} from "react-bootstrap";
import {UseJwt, UseJwtUserHandle} from "../../../utils/JwtHelpers";
import Dropdown from 'react-bootstrap/Dropdown'
// import DropdownButton from "react-bootstrap/DropdownButton";
import {httpConfig} from "../../../utils/http-config";
import NavDropdown from "react-bootstrap/NavDropdown";

export const UserMenu = (props) => {


	const jwt = UseJwt();
	const userHandle = UseJwtUserHandle();
	console.log(jwt);

	const signOut = () => {
		httpConfig.get("apis/sign-out/")
			.then(reply => {
				if (reply.status === 200) {
					window.localStorage.removeItem("jwt-token");
					console.log(reply);
					setTimeout(() => {
						window.location.reload();
					}, 1500);
				}
			});
	};

	return (
		<>
			{jwt !== null && (
				<NavDropdown 	alignRight
								className="mr-5 my-3 d-none d-lg-inline-block"
								title={"Hello, " + userHandle.toUpperCase() + "!"}
								id="collasible-nav-dropdown"
								>
					<NavDropdown.Item>Create Recipe</NavDropdown.Item>
					<Dropdown.Item>My Recipes</Dropdown.Item>
					<Dropdown.Item>Account Settings</Dropdown.Item>
					<div className="dropdown-divider" />
					<Dropdown.Item onClick={signOut}>Sign Out</Dropdown.Item>
				</NavDropdown>
			)}
		</>
	)
};