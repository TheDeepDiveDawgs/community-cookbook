import {useSelector, useDispatch} from "react-redux";
import React, {useEffect} from 'react';
import {getAllCategories} from "../../shared/actions/categoryActions";
import {CategoryCard} from "./CategoryCard";

export const Categories = (props) => {

	const categories = useSelector(state => (state.category ? state.category : []));


	const dispatch = useDispatch();

	function sideEffects() {
		dispatch(getAllCategories())
	}

	const sideEffectsInputs = [];
	console.log(categories);

	useEffect(sideEffects, sideEffectsInputs);

	return (
		<>
			<main>
				<div>
					{categories.map(category => <CategoryCard key={category.categoryId} category={category}/>
					)}
				</div>
			</main>
		</>
	)
};