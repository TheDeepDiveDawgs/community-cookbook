import React from "react";
import Jumbotron from "react-bootstrap/Jumbotron";
import {Link} from "react-router-dom";

export const Home = () => {
	return (
		<>
			<Jumbotron fluid className="mt-3 jumbo-Image">
				<div className="row-fluid mt-5">
					<div className="col-xs-6 col-md-3 text-center p-0 pl-lg-5 mr-auto">
						<div className="container py-5 text-bg text-white">
							<Link to="/recipe-list"
								  className="display-4 text-white"
								  id="browseRecipes"
							>Browse Recipes</Link>
						</div>
					</div>
				</div>
				<div className="row-fluid mt-5">
					<div className="mb-0 p-0 landingText-position col-xs-6 col-md-3 text-right mr-5 ml-auto">
						<div className="container py-5 text-bg text-white">
							<ul className="text-white text-landing mb-0 home-list"
							   id="browseRecipes"
							>
								<li>Look for your favorite recipe!</li><br/>
								<li>Post your own recipe in our collective!</li><br/>
								<li>Enjoy New Mexican cultural foods!</li>
							</ul>
						</div>
					</div>
				</div>
			</Jumbotron>
		</>
	)
};