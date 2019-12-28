import {useSelector, useDispatch} from "react-redux";
import React, {useEffect} from 'react';
import {getAllCategories} from "../../shared/actions/categoryActions";

// export and create component CategoriesDropdown
export const CategoriesDropdown = (props) => {

    //declare categories variable and use the useSelector hook to retrieve state from category data
    const categories = useSelector(state => (state.category ? state.category : []));

    // declared dispatch function to dispatch information from the redux store
    const dispatch = useDispatch();

    //declared the sideEffect function to dispatch the data from getAllCategories and input into the array
    function sideEffects() {
        dispatch(getAllCategories())
    }


    //input sideEffectsInputs into an array
    const sideEffectsInputs = [];

    //encapsulates sideEffects and sideEffectsInputs into code
    useEffect(sideEffects, sideEffectsInputs);

    //return what the virtual DOM should look like
    return (
        <>
            {/*iterate through the category array and create a option for each category row*/}
            {categories.map(category => <option value={category.categoryId} key={category.categoryId}>{category.categoryName}</option>
            )}
        </>
    )
};