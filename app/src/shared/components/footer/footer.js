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

import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faEnvelope} from "@fortawesome/free-solid-svg-icons";
import {library} from '@fortawesome/fontawesome-svg-core';
import {faFacebookF, faTwitter, faTwitterSquare} from '@fortawesome/free-brands-svg-icons';

library.add(faFacebookF, faTwitter, faEnvelope, faTwitterSquare);

export const Footer = () => (
	<>
		<footer className="page-footer bg-dark fixed-bottom">
			<Container className="container-fluid">
				<Row>
					<Col>
						<a href="https://https://www.facebook.com/cook.book.3705157">
							<h5 className="d-none d-lg-block float-left">
								Like Us on Facebook
							</h5>
							<i className="d-lg-none float-left">
								<FontAwesomeIcon icon={faFacebookF} size="2x" color="yellow" />
							</i>
						</a>
					</Col>

					<Col>
						<a href="https://twitter.com/CookBoo43086652">
							<h5 className="d-none d-lg-block float-right">
								Follow Us on Twitter
							</h5>
							<i className="d-lg-none d-flex justify-content-center">
								<FontAwesomeIcon icon={faTwitter} size="2x" color="yellow" />
							</i>
						</a>
					</Col>

					<Col>
						<a href="mailto:abqcookbook@gmail.com" target="_blank">
							<h5 className="d-none d-lg-block float-right">
								Contact Us
							</h5>
							<i className="d-lg-none float-right">
								<FontAwesomeIcon icon={faEnvelope} size="2x" color="yellow" />
							</i>
						</a>
					</Col>
				</Row>
			</Container>
		</footer>
	</>
);

