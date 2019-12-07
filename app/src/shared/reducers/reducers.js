import {combineReducers} from "redux";
import UserReducer from "./UserReducer";
import interactionReducer from "./interactionReducer";
import categoryReducer from "./categoryReducer";
import recipeReducer from "./recipeReducer";

export default combineReducers({
	user:UserReducer,
	interactions: interactionReducer,
	category: categoryReducer,
	recipe: recipeReducer,
})