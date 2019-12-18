import React, {useState} from "react";
import {httpConfig} from "../../shared/utils/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {SubmissionFormContent} from "./SubmissionFormContent";
import {handleSessionTimeout} from "../../shared/misc/handle-session-timeout";

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
			.max(2, "Recipe is too long"),
		recipeMinutes: Yup.number()


	})

}