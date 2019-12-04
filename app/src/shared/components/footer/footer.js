import React from "react";
import {Link} from "react-router-dom";
import ReactDom from 'react-dom';
import '../../../index.css';

import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import logo from "./images/logo.png";
import logo2 from "./images/abqLogo.png";
import fbLogo from "./images/fbLogoTransparent.jpg";

import{FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import { faHome } from "@fortawesome/free-solid-svg-icons";
import { library } from '@fortawesome/fontawesome-svg-core'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { faCheckSquare, faCoffee } from '@fortawesome/free-solid-svg-icons'

export const Footer = () => (
	<>
		<footer className="page-footer bg-dark fixed-bottom">
			<Container className="container-fluid">
				<Row>
					<Col>
						<a href="https://https://www.facebook.com/cook.book.3705157">
						<h5>Like Us on Facebook</h5> <FontAwesomeIcon icon={faHome}/>
						<FontAwesomeIcon icon={fab fa-facebook-f}/>
						</a>
					</Col>
					<Col>

					</Col>
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

