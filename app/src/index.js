import React from 'react';
import ReactDOM from 'react-dom'
import './stylesheets/stylesheet.css';
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/four-oh-four/FourOhFour";
import {Home} from "./pages/home/Home";
import {SignUpForm} from "./shared/components/main-nav/sign-up/sign-up-validation";
import {MainNav} from "./shared/components/main-nav/MainNav";
import {SignUpSuccess} from "./pages/SignUpSuccess";
import {RecipeList} from "./pages/recipe-list/RecipeList";
import {Activation} from "./pages/activation/Activation"
import reducers from "./shared/reducers/reducers";
import {Provider} from "react-redux";
import {applyMiddleware, createStore} from "redux";
import thunk from "redux-thunk";
import {Footer} from "./shared/components/footer/footer"
import {RecipePage} from "./pages/recipe-page/RecipePage";
import {SubmissionForm} from "./pages/recipe-submission/SubmissionForm";

import {faDove, faEnvelope, faKey, faSearch} from "@fortawesome/free-solid-svg-icons";
import {library} from '@fortawesome/fontawesome-svg-core';
import {faFacebookF, faGithubAlt, faTwitter, faTwitterSquare} from '@fortawesome/free-brands-svg-icons';

library.add(faFacebookF, faTwitter, faEnvelope, faTwitterSquare, faSearch, faGithubAlt, faKey, faDove);




const store = createStore(reducers, applyMiddleware(thunk));

const Routing = (store) => (
	<>
		<Provider store={store}>
				<BrowserRouter>
				  <MainNav/>
					<Switch>
						<Route exact path="/" component={Home}/>
						<Route exact path="/apis/activation/?activation=:userActivationToken" userActivationToken=":userActivationToken" component={Activation}/>
						<Route exact path="/recipe-submission" component={SubmissionForm}/>
						<Route exact path="/sign-up" component={SignUpForm}/>
						<Route exact path="/sign-up-successful" component={SignUpSuccess}/>
						<Route exact path="/recipe-list" component={RecipeList}/>
						<Route exact path="/recipe-page.js/:recipeId" component={RecipePage} recipeId=":recipeId"/>
						<Route component={FourOhFour}/>
					</Switch>
					<Footer className="mt-2"/>
				</BrowserRouter>
		</Provider>
	</>
);
ReactDOM.render(Routing(store), document.querySelector('#root'));


