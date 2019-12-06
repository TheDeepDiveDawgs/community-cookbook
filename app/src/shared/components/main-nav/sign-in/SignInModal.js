import React, {useState} from "react";
import {Button} from "react-bootstrap";
import {Modal} from "react-bootstrap";
import {SignInForm} from "./SignInForm";


export const SignInModal = () => {
	const [show, setShow] = useState(false);

	const handleClose = () => setShow(false);
	const handleShow = () => setShow(true);

	return (
		<>
			<Button variant="light" className="px-4 py-2" onClick={handleShow}>
				Sign In
			</Button>

			<Modal show={show} onHide={handleClose} className="bg-modal">
				<Modal.Header closeButton>
					<Modal.Title>Sign In</Modal.Title>
				</Modal.Header>
				<Modal.Body>
					<SignInForm handleClose={handleClose}/>
				</Modal.Body>
			</Modal>
		</>
	);
};
