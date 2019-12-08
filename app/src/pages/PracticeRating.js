import React from "react";
import "../../src/stylesheets/stylesheet.css"
import Card from "react-bootstrap/Card";
import {CardColumns} from "react-bootstrap";


export const RatingStar = () => {
				return (
					<Card class="Container">
						<Card.Body className="row">
							<CardColumns>
								<Card.Text>Test</Card.Text>
							 </CardColumns>
						 </Card.Body>
					</Card> )
};
