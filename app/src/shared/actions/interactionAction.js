import {httpConfig} from "../../../src/shared/utils/http-config";

export const getAllInteractions = () => async (dispatch) => {
	const payload = await httpConfig.get(`/apis/interaction/`);
	dispatch({type: "GET_ALL_INTERACTIONS", payload: payload.data});
};

export const getRecipeInteractions = (recipeId) => async dispatch => {
	const {data} = await httpConfig(`/apis/interaction/?interactionRecipeId=${recipeId}`);
	dispatch({type: "GET_RECIPE_INTERACTIONS", payload: data})
};

export const getUserInteractions = (userId) => async dispatch => {
	const {data} = await httpConfig(`/apis/recipe/?interactionUserId=${userId}`);
	dispatch({type: "GET_USER_INTERACTIONS", payload: data})
};
