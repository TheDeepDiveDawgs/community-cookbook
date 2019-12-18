import React, {useState} from "react";
import {httpConfig} from "../../shared/utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {SubmissionFormContent} from "./SubmissionFormContent";
import {handleSessionTimeout} from "../../shared/misc/handle-session-timeout";
import {useHistory} from "react-router";

export const SubmissionForm = () => {

	const [status, setStatus] = useState(null);

	const recipe = {
		recipeName: "",
		recipeNumberIngredients: "",
		recipeMinutes: "",
		recipeDescription: "",
		recipeIngredients: "",
		recipeStep: "",
		recipeNutrition: ""
	};

	const validator = Yup.object().shape({
		recipeName: Yup.string()
			.required("This recipe needs a name!")
			.max(100, "Name is too long"),
		recipeNumberIngredients: Yup.number()
			.required("This recipe needs a number of ingredients!")
			.max(999, "Recipe is too long"),
		recipeMinutes: Yup.number()
			.required("This recipe needs an amount of time to cook")
			.max(999, "Recipe takes too long to cook"),
		recipeDescription: Yup.string()
			.required("This recipe needs a description")
			.max(500, "This description is too long"),
		recipeIngredients: Yup.string()
			.required("This recipe needs ingredients")
			.max(300, "This ingredient is too long"),
		recipeStep: Yup.string()
			.required("This recipe needs steps")
			.max(1000, "These steps are too long"),
		recipeNutrition: Yup.string()
			.max(255, "This nutrition info is too long")
	});

	const history = useHistory();

	const submitRecipe = (values, {resetForm, setStatus}) => {
		//grab jwt token to pass in headers on post request
		const headers = {
			'X-JWT-TOKEN': window.localStorage.getItem("jwt-token")
		};

		httpConfig.post("apis/recipe/", values, {
			headers: headers})
			.then(reply => {
				let {message, type} = reply;
				setStatus({message, type});
				if(reply.status === 200) {
					resetForm();
					setStatus({message, type});
					setTimeout(() => {
						history.push("/recipe-list");
					}, 1500);
				}
				if(reply.status === 401) {
					handleSessionTimeout();
				}
			});
		};

		return (
			<>
				<Formik
					onSubmit={submitRecipe}
					initialValues={recipe}
					validationSchema={validator}
				>
					{SubmissionFormContent}
				</Formik>
			</>
		)
};