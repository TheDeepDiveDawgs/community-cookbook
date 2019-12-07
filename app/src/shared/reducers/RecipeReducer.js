export default (state = [], action) => {
	switch(action.type) {
		case "GET_ALL_RECIPES":
			return action.payload;
		default:
			return state;
	}
}

