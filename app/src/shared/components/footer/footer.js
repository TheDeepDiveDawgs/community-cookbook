import React from "react";

// import {Link} from "react-router-dom";

import '../../../index.css';

import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import logo from "./images/logo.png";
import logo2 from "./images/abqLogo.png";
import fbLogo from "./images/fbLogoTransparent.jpg";

import{FontAwesomeIcon} from "@fortawesome/react-fontawesome";

export const Footer = () => (
	<>
		<footer className="page-footer bg-black fixed-bottom">
			<Container className="container-fluid">
				<Row>
					<Col>
						<a href="https://https://www.facebook.com/cook.book.3705157">
						<h5>Like Us on Facebook</h5>
						</a>
					</Col>
					<Col></Col>
					<Col>
						<a href="https://twitter.com/CookBoo43086652">
							<h5> Follow Us on Twitter </h5>
						</a>
					</Col>
					<Col></Col>
					<Col>
						<a href="mailto:abqcookbook@gmail.com" target="_blank">
							<h5> Contact Us </h5>
						</a>
					</Col>
				</Row>
			</Container>
		</footer>
	</>
);

