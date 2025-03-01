import React, {useState} from "react";
import {httpConfig} from "../../shared/utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {SubmissionFormContent} from "./SubmissionFormContent";
import {handleSessionTimeout} from "../../shared/misc/handle-session-timeout";
import {useHistory} from "react-router";

export const SubmissionForm = () => {

	const [status, setStatus] = useState(null);

	// declare variable that checks the enter fields for the values
	const recipe = {
		recipeName: "",
		recipeCategoryId: "",
		recipeNumberIngredients: "",
		recipeMinutes: "",
		recipeDescription: "",
		recipeImageUrl: "",
		recipeIngredients: "",
		recipeStep: "",
		recipeNutrition: "",
		recipeSubmissionDate: ""
	};

// validate the entered values and check if it matches what we want
	const validator = Yup.object().shape({
		recipeName: Yup.string()
			.required("This recipe needs a name!")
			.max(100, "Name is too long"),
		recipeCategoryId: Yup.string()
			.required("This recipe needs a category!"),
		recipeNumberIngredients: Yup.number()
			.required("This recipe needs a number of ingredients!")
			.max(999, "Recipe is too long"),
		recipeMinutes: Yup.number()
			.required("This recipe needs an amount of time to cook")
			.max(999, "Recipe takes too long to cook"),
		recipeDescription: Yup.string()
			.required("This recipe needs a description")
			.max(500, "This description is too long"),
		recipeImageUrl: Yup.string()
			.max(255, "this Url is too long"),
		recipeIngredients: Yup.string()
			.required("This recipe needs ingredients")
			.max(300, "This ingredient is too long"),
		recipeStep: Yup.string()
			.required("This recipe needs steps")
			.max(1000, "These steps are too long"),
		recipeNutrition: Yup.string()
			.max(255, "This nutrition info is too long"),
		recipeSubmissionDate: Yup.date()
			.default(() => (new Date()))
	});
//useHistory hook that retrieves data from index.js
	const history = useHistory();

	//declare function that checks if user is signed in with jwt token and then uses a POST http request method to post
	// the values that was entered
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