export default (state = [], action) => {
    switch(action.type) {
        case "GET_RECIPE_BY_RECIPE_ID":
            return action.payload;
        case "GET_ALL_RECIPE":
            return action.payload;
        default:
            return state;
    }
}