import React from 'react';
import ReactDOM from 'react-dom'
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {Home} from "./pages/Home";
import {SignUpForm} from "./shared/components/main-nav/sign-up/sign-up-validation";
import {MainNav} from "./shared/components/main-nav/MainNav";
import './shared/components/main-nav/nav-style.css';





import {Footer} from "./shared/components/footer/footer"


const Routing = () => (
	<>
		<BrowserRouter>
			<MainNav/>
			<Switch>
				<Route exact path="/" component={Home}/>
				<Route exact path="/sign-up" component={SignUpForm}/>
				<Route component={FourOhFour}/>
			</Switch>
			<Footer/>
		</BrowserRouter>
	</>
);
ReactDOM.render(<Routing/>, document.querySelector('#root'));


