import React from "react"
// import {ButtonGroup} from "react-bootstrap";
import {UseJwt, UseJwtUserHandle, UseJwtUserEmail} from "../../../utils/JwtHelpers";
import Dropdown from 'react-bootstrap/Dropdown'
// import DropdownButton from "react-bootstrap/DropdownButton";
import {httpConfig} from "../../../utils/http-config";
import NavDropdown from "react-bootstrap/NavDropdown";
import { getUserByUserHandle } from "../../../actions/GetUser";

export const UserMenu = () => {


	const jwt = UseJwt();
	const userHandle = UseJwtUserHandle();

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
								title={"Hello, " + userHandle.toUpperCase() + "!" }
								id="collasible-nav-dropdown"
								>
					<Dropdown.Item href="/recipe-submission">Create Recipe</Dropdown.Item>
					<Dropdown.Item>My Recipes</Dropdown.Item>
					<Dropdown.Item>Account Settings</Dropdown.Item>
					<div className="dropdown-divider" />
					<Dropdown.Item onClick={signOut}>Sign Out</Dropdown.Item>
				</NavDropdown>
			)}
		</>
	)
};