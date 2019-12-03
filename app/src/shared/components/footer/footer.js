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
		<footer className="page-footer bg-dark variant=dark container-fluid">
			<Container>
				<Row>
					<ul>
					<Col class="col-1">
						<img className="logo.png" alt="logo"
						src={logo}
						width="70"
						height="70"
						/>
					</Col>
					<Col class="col-10">
					</Col>
					<Col class="col-1">
						<img className="logo.png" alt="logo"
							  src={logo}
							  width="70"
							  height="70"/>
					</Col>
					</ul>
				</Row>
			</Container>
		</footer>
	</>
);

