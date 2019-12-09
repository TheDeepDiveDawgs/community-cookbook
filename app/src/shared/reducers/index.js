import {combineReducers} from "redux";
import RecipeReducer from "./RecipeReducer";
import UserReducer from "./UserReducer";
import interactionReducer from "./interactionReducer";

export default combineReducers({
	user:UserReducer,
	interactions: interactionReducer,
	recipes: RecipeReducer
})