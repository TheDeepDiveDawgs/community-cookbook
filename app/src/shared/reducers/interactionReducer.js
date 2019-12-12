export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_INTERACTIONS":
			return action.payload;
		case "GET_RECIPE_INTERACTIONS":
			return action.payload;
		case "GET_USER_INTERACTIONS":
			return action.payload;
		default:
			return state;
	}
}



