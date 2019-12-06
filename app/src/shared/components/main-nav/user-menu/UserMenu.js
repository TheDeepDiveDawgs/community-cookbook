import React from "react"
import {ButtonGroup} from "react-bootstrap";
import {UseJwt, UseJwtUserHandle} from "../../../utils/JwtHelpers";
import Dropdown from 'react-bootstrap/Dropdown'
import DropdownButton from "react-bootstrap/DropdownButton";
import {httpConfig} from "../../../utils/http-config";

export const UserMenu = (props) => {


	const jwt = UseJwt();
	const userHandle = UseJwtUserHandle();
	console.log(jwt);

	const signOut = ({handleClose}) => {
		httpConfig.get("apis/sign-out/")
			.then(reply => {
				let {message, type} = reply;
				if (reply.status === 200) {
					window.localStorage.removeItem("jwt-token");
					console.log(reply);
					setTimeout(() => {
						window.location = "/";
					}, 1500);
				}
			});
	};

	return (
		<>
			{jwt !== null && (
				<DropdownButton as={ButtonGroup}
								alignRight
								title={"Hi, " + userHandle.toUpperCase() + "!"}
								variant="dark"
								id="dropdown-basic-button"
								>
					<Dropdown.Item>Create Recipe</Dropdown.Item>
					<Dropdown.Item>My Recipes</Dropdown.Item>
					<Dropdown.Item>Account Settings</Dropdown.Item>
					<div className="dropdown-divider" />
					<Dropdown.Item onClick={signOut}>Sign Out</Dropdown.Item>
				</DropdownButton>
			)}
		</>
	)
};