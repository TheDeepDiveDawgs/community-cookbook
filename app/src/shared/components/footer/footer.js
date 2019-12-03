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
						<a href="https://facebook.com/">
						<h6>Like Us on Facebook</h6>
						</a>
					</Col>
					<Col></Col>
					<Col>
						<a href="https://twitter.com/?lang=en">
							<h6> Follow Us on Twitter </h6>
						</a>
					</Col>
					<Col></Col>
					<Col>
						<a href="mailto:abqcookbook@gmail.com" target="_blank">
							<h6> Contact Us </h6>
						</a>
					</Col>
					<Col></Col>
				</Row>
			</Container>
		</footer>
	</>
);

