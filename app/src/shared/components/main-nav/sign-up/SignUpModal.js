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
			<label className="mx-5 px-4 py-2"  onClick={handleShow} id="sign-up-label">
				Sign Up
			</label>

			<Modal show={show} onHide={handleClose} className="bg-modal">
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