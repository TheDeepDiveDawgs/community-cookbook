import React from 'react';
import ReactDOM from 'react-dom'
import './stylesheets/stylesheet.css';
import 'bootstrap/dist/css/bootstrap.css';
import {BrowserRouter} from "react-router-dom";
import {Route, Switch} from "react-router";
import {FourOhFour} from "./pages/FourOhFour";
import {Home} from "./pages/Home";
import {SignUpForm} from "./shared/components/main-nav/sign-up/sign-up-validation";
import {MainNav} from "./shared/components/main-nav/MainNav";
import {SignUpSuccess} from "./pages/SignUpSuccess";
import reducers from "./shared/reducers";
import {Provider} from "react-redux";
import {applyMiddleware, createStore} from "redux";
import thunk from "redux-thunk";
import {Footer} from "./shared/components/footer/footer"

const store = createStore(reducers, applyMiddleware(thunk));

const Routing = (store) => (
	<>
		<Provider store={store}>
				<BrowserRouter>
					<MainNav/>
					<Switch>
						<Route exact path="/" component={Home}/>
						<Route exact path="/sign-up" component={SignUpForm}/>
						<Route exact path="/sign-up-successful" component={SignUpSuccess}/>
						<Route component={FourOhFour}/>
					</Switch>
					<Footer/>
				</BrowserRouter>
		</Provider>
	</>
);
ReactDOM.render(Routing(store), document.querySelector('#root'));


