import React from "react"
import {ButtonGroup} from "react-bootstrap";
import DropdownButton from "react-bootstrap/DropdownButton";

export const UserSettings = () => {
	return (
		<>
			<DropdownButton as={ButtonGroup} variant="dark">Hi, {this.state.userHandle}</DropdownButton>
		</>
	)
};