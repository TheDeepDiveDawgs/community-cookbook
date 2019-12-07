import {httpConfig} from "../utils/http-config";

export const getAllRecipes = () => async (dispatch) => {
	const payload = await  httpConfig.get("/apis/recipe/");
	dispatch({type: "GET_ALL_RECIPES", payload : payload.data});
};