import React from 'react';
import {httpConfig} from "../../../utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";
import {useHistory} from "react-router-dom"

import {SignUpFormContent} from "./sign-up-form";


export const SignUpForm = ({handleClose}) => {
	const history = useHistory();
	const signUp = {
		userEmail: "",
		userHandle: "",
		userFullName: "",
		userPassword: "",
		userPasswordConfirm: "",
	};


	const validator = Yup.object().shape({
		userEmail: Yup.string()
			.email("email must be a valid email")
			.required('email is required'),
		userHandle: Yup.string()
			.required("user handle is required"),
		userFullName: Yup.string()
			.required("user's full name is required"),
		userPassword: Yup.string()
			.required("Password is required")
			.min(8, "Password must be at least eight characters"),
		userPasswordConfirm: Yup.string()
			.required("Password Confirm is required")
			.min(8, "Password must be at least eight characters"),
	});

	const submitSignUp = (values, {resetForm, setStatus}) => {
		httpConfig.post("./apis/sign-up/", values)
			.then(reply => {
					let {message, type} = reply;
					if(reply.status === 200) {
						resetForm();
						handleClose();
						history.push("/sign-up-successful")
					} setStatus({message, type});
				}
			)
			.catch(reply => {
				let {message, type} = reply;
				if(reply.status !== 200) {
					handleClose();
					alert("You may already have an account or this information has already been used.");
				} setStatus({message, type});
			});
	};


	return (

		<Formik
			initialValues={signUp}
			onSubmit={submitSignUp}
			validationSchema={validator}
		>
			{SignUpFormContent}
		</Formik>

	)
};