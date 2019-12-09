import React, {useEffect} from "react";
import {getAllRecipe, getRecipeByRecipeId} from "../shared/actions/GetRecipe";
import {connect} from "react-redux";

const RecipeComponent = (props) => {
    const {match, getAllRecipe, recipes} = props;
    useEffect(() => {
        getAllRecipe()
    }, [getAllRecipe]);

    const filterRecipe = recipes.filter(recipe => recipe.recipeId === match.params.recipeId);
    const recipe = {...filterRecipe[0]};

    return (
        <>
            <section>
                <div className="card" id="myCard">
                    <h1 id="title"><em>{recipe.recipeName}</em></h1>
                    <h3 id="descriptionTitle">Description</h3>
                    <p id="description">{recipe.recipeDescription}</p>
                    <h3 id="ingredientsTitle">Ingredients</h3>
                    <p id="ingredients">{recipe.recipeIngredients}</p>
                    <h3 id="stepsTitle">Steps</h3>
                    <p id="steps">{recipe.recipeStep}</p>
                </div>
            </section>
        </>
    )
};

const mapStateToProps = ({recipes}) => {
    return {recipes: recipes};
};

export const Recipe = connect(mapStateToProps, {getAllRecipe})(RecipeComponent);