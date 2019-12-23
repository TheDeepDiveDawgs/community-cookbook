import {useSelector, useDispatch} from "react-redux";
import React, {useEffect} from 'react';
import {getAllCategories} from "../../shared/actions/categoryActions";

// export and create component CategoriesDropdown
export const CategoriesDropdown = (props) => {

    //set category value to extract category data from redux
    // if there is not category then return an empty array
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
            {/*Transformed categories array into other arrays per individual category by category id.
					 Array is inserted into a category card. */}
            {categories.map(category => <option key={category.categoryId}>{category.categoryName}</option>
            )}
        </>
    )
};