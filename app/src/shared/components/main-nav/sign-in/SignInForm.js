import React from 'react';
import {httpConfig} from "../../../utils/http-config";
import {Formik} from "formik/dist/index";
import * as Yup from "yup";
import {SignInFormContent} from "./SignInFormContent";
// import {useHistory} from "react-router";



export const SignInForm = ({handleClose}) => {

		//the initial values object defines what the request payload is.
		const signIn = {
			userEmail: "",
			userPassword: ""
		};

		//declare history variable and use the axios hook useHistory
		// const history = useHistory();


		//validate the inputs for the initial values
		const validator = Yup.object().shape({
			userEmail: Yup.string()
				.email("email must be a valid email")
				.required('email is required'),
			userPassword: Yup.string()
				.required("Password is required")
				.min(8, "Password must be at least eight characters")
		});



		// respond with a response on submit
		const submitSignIn = (values, {resetForm, setStatus}) => {
			httpConfig.post("/apis/sign-in/", values)
				.then(reply => {
					let {message, type} = reply;
					setStatus({message, type});
					if(reply.status === 200 && reply.headers["x-jwt-token"]) {
						window.localStorage.removeItem("jwt-token");
						window.localStorage.setItem("jwt-token", reply.headers["x-jwt-token"]);
						resetForm();
						handleClose();
						window.location.reload();
					} setStatus({message, type});
				});
		};

		return (
			<>
				<Formik
					initialValues={signIn}
					onSubmit={submitSignIn}
					validationSchema={validator}
				>
					{SignInFormContent}
				</Formik>
			</>
		)
};
