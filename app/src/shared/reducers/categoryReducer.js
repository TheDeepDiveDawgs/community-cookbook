export default (state = [], action) => {
	switch(action.type) {
		case "GET_CATEGORY_BY_CATEGORY_ID":
			return action.payload;
		case "GET_CATEGORY_BY_CATEGORY_NAME":
			return [...state, action.payload];
		case "GET_ALL_CATEGORIES":
			return action.payload;
		default:
			return state;
	}
}