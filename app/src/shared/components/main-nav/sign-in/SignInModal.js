import React, {useState} from "react";
// import {Button} from "react-bootstrap";
import {Modal} from "react-bootstrap";
import {SignInForm} from "./SignInForm";


export const SignInModal = () => {
	const [show, setShow] = useState(false);

	const handleClose = () => setShow(false);
	const handleShow = () => setShow(true);

	return (
		<>
			<label className="py-4" id="sign-in-label" onClick={handleShow}>
				Sign In
			</label>

			<Modal show={show}
				   onHide={handleClose}
				   className="bg-modal"
				   centered
			>
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
