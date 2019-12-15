import React from "react";
import '../../../stylesheets/stylesheet.css';
import Col from "react-bootstrap/Col";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {faFacebookF, faGithubAlt, faTwitter} from "@fortawesome/free-brands-svg-icons";


export const Footer = () => (
	<>
		<footer className="page-footer footer-position">
			<Container className="container-fluid">
				<Row className="text-center text-white">
					<Col>
						<a href="https://www.facebook.com/abqcookbook"  rel="noopener noreferrer" target="_blank">
							<h5 className="d-none d-lg-block" id="footerIcons">
								Like us on Facebook
							</h5>
							<i className="d-lg-none d-inline-block" id="footerIcons">
								<FontAwesomeIcon icon={faFacebookF} size="2x"/>
							</i>
						</a>
					</Col>

					<Col>
						<a href="https://twitter.com/CookBoo43086652"  rel="noopener noreferrer" target="_blank">
							<h5 className="d-none d-lg-block" id="footerIcons">
								Follow us on Twitter
							</h5>
							<i className="d-lg-none d-inline-block" id="footerIcons">
								<FontAwesomeIcon icon={faTwitter} size="2x"/>
							</i>
						</a>
					</Col>

					<Col>
						<a href="mailto:abqcookbook@gmail.com" rel="noopener noreferrer" target="_blank" >
							<h5 className="d-none d-lg-block" id="footerIcons">
								Contact us
							</h5>
							<i className="d-lg-none d-inline-block" id="footerIcons">
								<FontAwesomeIcon icon={"envelope"} size="2x"/>
							</i>
						</a>
					</Col>

					<Col>
						<a href="https://github.com/TheDeepDiveDawgs/community-cookbook" rel="noopener noreferrer" target="_blank" >
							<h5 className="d-none d-lg-block" id="footerIcons">
								GitHub
							</h5>
							<i className="d-lg-none d-inline-block" id="footerIcons">
								<FontAwesomeIcon icon={faGithubAlt} size="2x"/>
							</i>
						</a>
					</Col>
				</Row>
			</Container>
		</footer>
	</>
);
