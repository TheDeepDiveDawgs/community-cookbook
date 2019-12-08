import React from 'react';
import './recipe-page-css.css';

export const RecipePage = () => {

	return (
		<section>
			<div className="container-fluid bg-secondary py-5">
				<div className="row">
					<div className="col-md-10">
						<div className="">
							<div className="recipe-card-size">
								<div className="recipe-title">
									<h1>recipe title</h1>
								</div>
								<br></br>
								<div>
									<strong>this is where rating will be placed</strong>
								</div>
								<br></br>
								<div>
									<p>concise recipe description gets populated here</p>
								</div>
								<div>
									<strong>Ingredients</strong>
									<ul>
										<li>ingredient one</li>
										<li>ingredient two</li>
										<li>ingredient three</li>
									</ul>
								</div>
								<div className="recipe-card-content">
									<div>
										<ul>
											<strong>Steps</strong>
											<li>step one</li>
											<li>step two</li>
											<li>step three</li>
										</ul>
									</div>
									<div>
										<strong>nutrition</strong>
										<p>this is where the nutritional information will be populated</p>
									</div>
									<div>min to make recipe</div>
									<br></br>
									<div>recipe submission date will be auto populated here</div>
								</div>
							</div>
						</div>
					</div>
					<div className="col-md-2">
						<div>
							<img src="cap-logo-5.png" alt="logo"/>
						</div>
					</div>
				</div>
			</div>
		</section>
	)
};
