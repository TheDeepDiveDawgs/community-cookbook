import React, {useState} from "react";
// import {Button} from "react-bootstrap";
import {Modal} from "react-bootstrap";
import {SignUpForm} from "./sign-up-validation";


export const SignUpModal = () => {
	const [show, setShow] = useState(false);

	const handleClose = () => setShow(false);
	const handleShow = () => setShow(true);

	return (
		<>
			<label className="py-4"  onClick={handleShow} id="sign-up-label">
				SIGN UP
			</label>

			<Modal show={show} onHide={handleClose} className="bg-modal" centered>
				<Modal.Header closeButton>
					<Modal.Title>Sign Up</Modal.Title>
				</Modal.Header>
				<Modal.Body>
					<SignUpForm handleClose={handleClose}/>
				</Modal.Body>
			</Modal>
		</>
	);
};