import React, {useEffect} from "react";

import {FormDebugger} from "../../shared/components/FormDebugger";

import {Form} from "react-bootstrap";
import {InputGroup} from "react-bootstrap";
import {FormControl} from "react-bootstrap";
import Button from "react-bootstrap/Button";
import Card from "react-bootstrap/Card";
import {useDispatch, useSelector} from "react-redux";
import {getAllCategories} from "../../shared/actions/categoryActions";
import {CategoryCard} from "../recipe-list/CategoryCard";


export const SubmissionFormContent = (props, {category}) => {

             const {
                 submitStatus,
                 status,
                 values,
                 errors,
                 touched,
                 dirty,
                 isSubmitting,
                 handleChange,
                 handleBlur,
                 handleSubmit,
                 handleReset
             } = props;

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

             return(
                 <>
                     <Card bg="light" className="mt-5 pt-5 col-6 text-center text-white mx-auto">
                         <Card.Body>
                             <Form onSubmit={handleSubmit}>

                                 <Form.Group>
                                     <Form.Label className="sr-only">Recipe title</Form.Label>
                                     <InputGroup>
                                         <FormControl
                                             id="recipeName"
                                             onChange={handleChange}
                                             onBlur={handleBlur}
                                             placeholder="*Recipe title..."
                                             type="text"
                                             value={values.recipeName}
                                         />
                                     </InputGroup>
                                     {
                                         errors.recipeName && touched.recipeName && (
                                             <div className="alert alert-danger">
                                                 {errors.recipeName}
                                             </div>
                                         )
                                     }
                                 </Form.Group>

                                 <Form.Group>
                                     <Form.Label className="sr-only">Category</Form.Label>
                                     <InputGroup>
                                         <FormControl
                                             as="select"
                                         />
                                         {categories.map(category => <option key={category.categoryId}>{category.categoryName}</option>
                                         )}
                                     </InputGroup>
                                     {
                                         errors.recipeCategoryId && touched.recipeCategoryId && (
                                             <div className="alert alert-danger">
                                                 {errors.recipeCategoryId}
                                             </div>
                                         )
                                     }
                                 </Form.Group>

                                 <Form.Group>
                                     <Form.Label className="sr-only">Number of Ingredients</Form.Label>
                                     <InputGroup>
                                         <FormControl
                                             id="recipeNumberIngredients"
                                             onChange={handleChange}
                                             onBlur={handleBlur}
                                             placeholder="*How many ingredients..."
                                             type="integer"
                                             value={values.recipeNumberIngredients}
                                         />
                                     </InputGroup>
                                     {
                                         errors.recipeNumberIngredients && touched.recipeNumberIngredients && (
                                             <div className="alert alert-danger">
                                                 {errors.recipeNumberIngredients}
                                             </div>
                                         )
                                     }
                                 </Form.Group>

                                 <Form.Group>
                                     <Form.Label className="sr-only">Cook Time</Form.Label>
                                     <InputGroup>
                                         <FormControl
                                            id="recipeMinutes"
                                            onChange={handleChange}
                                            onBlur={handleBlur}
                                            placeholder="*How long is the cook time..."
                                            type="integer"
                                            value={values.recipeMinutes}
                                            />
                                     </InputGroup>
                                     {
                                         errors.recipeMinutes && touched.recipeMinutes && (
                                            <div className="alert alert-danger">
                                                {errors.recipeMinutes}
                                            </div>
                                         )
                                     }
                                 </Form.Group>

                                 <Form.Group>
                                     <Form.Label className="sr-only">Description</Form.Label>
                                     <InputGroup>
                                         <FormControl
                                            as="textarea"
                                            rows="5"
                                            id="recipeDescription"
                                            onChange={handleChange}
                                            onBlur={handleBlur}
                                            placeholder="*Description of recipe..."
                                            type="text"
                                            value={values.recipeDescription}
                                         />
                                     </InputGroup>
                                     {
                                         errors.recipeDescription && touched.recipeDescription && (
                                            <div className="alert alert-danger">
                                                {errors.recipeDescription}
                                            </div>
                                         )
                                     }
                                 </Form.Group>

                             <Form.Group>
                                 <Form.Label className="sr-only">Ingredients</Form.Label>
                                 <InputGroup>
                                     <FormControl
                                        id="recipeIngredients"
                                        onChange={handleChange}
                                        onBlur={handleBlur}
                                        placeholder="*Ingredients of recipe..."
                                        type="text"
                                        value={values.recipeIngredients}
                                     />
                                 </InputGroup>
                                 {
                                     errors.recipeDescription && touched.recipeDescription && (
                                        <div className="alert alert-danger">
                                            {errors.recipeDescription}
                                        </div>
                                     )
                                 }
                             </Form.Group>

                             <Form.Group>
                                 <Form.Label className="sr-only">Steps</Form.Label>
                                 <InputGroup>
                                     <FormControl
                                        id="recipeStep"
                                        onChange={handleChange}
                                        onBlur={handleBlur}
                                        placeholder="*Cooking steps for recipe..."
                                        type="text"
                                        value={values.recipeStep}
                                     />
                                 </InputGroup>
                                 {
                                     errors.recipeStep && touched.recipeStep && (
                                        <div className="alert alert-danger">
                                            {errors.recipeDescription}
                                        </div>
                                     )
                                 }
                             </Form.Group>

                             <Form.Group>
                                 <Form.Label className="sr-only">Nutrition</Form.Label>
                                 <InputGroup>
                                     <FormControl
                                        id="recipeNutrition"
                                        onChange={handleChange}
                                        onBlur={handleBlur}
                                        placeholder="Nutrition info for recipe..."
                                        type="text"
                                        value={values.recipeNutrition}
                                     />
                                 </InputGroup>
                                 {
                                     errors.recipeNutrition && touched.recipeNutrition && (
                                        <div className="alert alert-danger">
                                            {errors.recipeNutrition}
                                        </div>
                                     )
                                 }
                             </Form.Group>

                                 <Form.Group>
                                     <Button variant="dark"
                                             type="submit"
                                             className="mr-2"
                                             onClick={submitStatus}
                                     >
                                         {isSubmitting ? "Submitting..." : "Submit recipe"}
                                     </Button>
                                     <Button variant="warning"
                                             type="reset"
                                             onClick={handleReset}
                                             disabled={!dirty || isSubmitting}
                                     >
                                         reset form
                                     </Button>
                                 </Form.Group>

                             <FormDebugger {...props}/>


                             </Form>
                         </Card.Body>
                     </Card>

                     {console.log(submitStatus)}
                     {status && (<div className={status.type}>{status.message}</div>)}

                 </>
             )

};
