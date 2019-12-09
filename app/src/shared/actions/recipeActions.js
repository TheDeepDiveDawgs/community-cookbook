import {httpConfig} from "../utils/http-config";

export const getRecipeByRecipeId = (recipeId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/recipe/${id}`);
	dispatch({type: "GET_RECIPE_BY_RECIPE_ID", payload: data})
};

export const getRecipeByRecipeUserId = (userId) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/recipe/?recipeUserId=${userId}`);
	dispatch({type: "GET_RECIPE_BY_RECIPE_USER_ID", payload: data})
};

export const getRecipeBySearchTerm = () => async (dispatch) => {
	const {data} = await httpConfig(`/apis/recipe/`);
	dispatch({type: "GET_RECIPE_BY_SEARCH_TERM", payload: data})
};

export const getAllRecipe = () => async (dispatch) => {
	const {data} = await httpConfig(`/apis/recipe/`);
	dispatch({type: "GET_ALL_RECIPE", payload: data})
};

