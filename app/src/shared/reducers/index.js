import {combineReducers} from "redux";
import UserReducer from "./UserReducer";
import interactionReducer from "./interactionReducer";

export default combineReducers({
	user:UserReducer,
	interactions: interactionReducer,
})