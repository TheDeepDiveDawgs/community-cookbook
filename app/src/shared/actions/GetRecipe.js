import {httpConfig} from "../utils/http-config";

export const getRecipeByRecipeId = (recipeId) => async dispatch => {
    const {data} = await httpConfig('apis/recipe/');
    dispatch({type: "GET_RECIPE_BY_RECIPE_ID", payload: data})
};

export const getAllRecipe = () => async dispatch => {
    const {data} = await httpConfig('apis/recipe/');
    dispatch({type: "GET_ALL_RECIPE", payload: data})
};
