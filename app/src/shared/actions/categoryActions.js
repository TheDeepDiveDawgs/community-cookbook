import {httpConfig} from "../utils/http-config";

export const getCategoryByCategoryId = (id) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/category/${id}`);
	dispatch({type: "GET_CATEGORY_BY_CATEGORY_ID", payload: data})
};

export const getCategoryByCategoryName = (name) => async (dispatch) => {
	const {data} = await httpConfig(`/apis/category/${name}`);
	dispatch({type: "GET_CATEGORY_BY_CATEGORY_NAME", payload: data})
};

export const getAllCategories= () => async (dispatch) => {
	const {data} = await httpConfig(`/apis/category/`);
	dispatch({type: "GET_ALL_CATEGORIES", payload: data})
};

