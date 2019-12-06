import {combineReducers} from "redux";
import interactionReducer from "./interactionReducer";



export const combinedReducers = combineReducers({
	interactions: interactionReducer,
});