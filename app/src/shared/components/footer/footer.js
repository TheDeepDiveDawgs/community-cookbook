import React from "react";
import '../../../stylesheets/stylesheet.css';
import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faEnvelope, faSearch} from "@fortawesome/free-solid-svg-icons";
import {library} from '@fortawesome/fontawesome-svg-core';
import {faFacebookF, faTwitter, faTwitterSquare} from '@fortawesome/free-brands-svg-icons';

library.add(faFacebookF, faTwitter, faEnvelope, faTwitterSquare, faSearch);

export const Footer = () => (
	<>
		<footer className="page-footer footer-position">
			<Container className="container-fluid">
				<Row>
					<Col>
						<a href="https://www.facebook.com/abqcookbook">
							<h5 className="d-none d-lg-block" id="facebook">
								Like Us on Facebook
							</h5>
							<i className="d-lg-none float-left" id="faFb">
								<FontAwesomeIcon icon={faFacebookF} size="2x"/>
							</i>
						</a>
					</Col>

					<Col>
						<a href="https://twitter.com/CookBoo43086652">
							<h5 className="d-none d-lg-block" id="twitter">
								Follow Us on Twitter
							</h5>
							<i className="d-lg-none d-flex justify-content-center" id="faTweet">
								<FontAwesomeIcon icon={faTwitter} size="2x"/>
							</i>
						</a>
					</Col>

					<Col>
						<a href="mailto:abqcookbook@gmail.com" rel="noopener noreferrer" target="_blank">
							<h5 className="d-none d-lg-block" id="email">
								Contact Us
							</h5>
							<i className="d-lg-none float-right" id="faEmail">
								<FontAwesomeIcon icon={faEnvelope} size="2x"/>
							</i>
						</a>
					</Col>
				</Row>
			</Container>
		</footer>
	</>
);
