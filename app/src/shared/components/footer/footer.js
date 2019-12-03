import React from "react";

// import {Link} from "react-router-dom";

import '../../../index.css';

import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import logo from "./images/logo.png";
import logo2 from "./images/abqLogo.png";

// import{FontAwesomeIcon} from "@fortawesome/react-fontawesome";

export const Footer = () => (
	<>
		<footer className="page-footer bg-dark variant=dark fixed-bottom">
			<Container className="container-fluid">
				<Row>
					<Col>
						<p>Like Us on Facebook</p>
					</Col>
					<Col></Col>
					<Col></Col>
					<Col></Col>
					<Col></Col>
					<Col>
						<img className="abqLogo.png" alt="logo"
						src={logo2}
						height="50"/>
					</Col>
					<Col></Col>
					<Col></Col>
					<Col></Col>
					<Col></Col>
					<Col></Col>
					<Col>
						<img className="logo.png" alt="logo"
							  src={logo}
							  width="50"
							  height="50"/>
					</Col>
				</Row>
			</Container>
		</footer>
	</>
);

