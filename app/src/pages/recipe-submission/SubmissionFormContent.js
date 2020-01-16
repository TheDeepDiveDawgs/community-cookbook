import React from "react";

import {FormDebugger} from "../../shared/components/FormDebugger";

import {Form, FormText} from "react-bootstrap";
import {InputGroup} from "react-bootstrap";
import {FormControl} from "react-bootstrap";
import Button from "react-bootstrap/Button";
import Card from "react-bootstrap/Card";
import {CategoriesDropdown} from "./CategoriesDropdown";
import { FieldArray } from "formik";



export const SubmissionFormContent = (props) => {


    //props that will be passed to the JSX elements
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




// JSX that contains the form which is being used in SubmissionForm.js to validate the values being entered
             return(
                 <>
                     <Card bg="light" className="subcard-margin pt-5 col-12 col-lg-6 text-center text-dark mx-auto">
                         <Card.Header class="text-dark"><h2 class="display-4">Submit Recipe</h2></Card.Header>
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

                                 <Form.Group controlId="recipeCategoryId">
                                     <Form.Label className="sr-only">Category</Form.Label>
                                     <InputGroup>
                                         <FormControl
                                             onChange={handleChange}
                                             as="select"
                                             type="text"
                                             value={values.recipeCategoryId}
                                         >
                                             <option>*Categories...</option>
                                         <CategoriesDropdown/>
                                         </FormControl>
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
                                            placeholder="*How many minutes to cook..."
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


                             <FieldArray name="recipeIngredients">
                                {arrayHelpers => (
                                    <div>
                                        <Button className="d-block m-3 btn btn-dark row" onClick={() =>
                                            arrayHelpers.push(
                                                ""
                                            )
                                    }
                                    >
                                        Add ingredient
                                    </Button>
                                    {values.recipeIngredients.map((recipe, index) => {
                                        return(
                                            <div className="row m-3" key={recipe.recipeId}>
                                                <FormControl placeholder="ingredient" 
                                                             name={`recipeIngredients.${index}`}
                                                             value={values.recipeIngredients.pop[0]}
                                                             onBlur={handleBlur}
                                                             onChange={handleChange}
                                                             className="col-11"
                                                />
                                                <Button className="col-1 btn btn-dark" onClick={() => arrayHelpers.remove(index)}>
                                                    x
                                                </Button>
                                                {
                                                    errors.recipeIngredients && touched.recipeIngredients && (
                                                        <div className="alert alert-danger">
                                                            {errors.recipeIngredients}
                                                        </div>
                                                    )
                                                }
                                            </div>
                                        );
                                    })}
                                    </div>
                                )}
                             </FieldArray>

                             <FieldArray name="recipeStep">
                                {arrayHelpers => (
                                    <div>
                                        <Button className="d-block m-3 btn btn-warning row" onClick={() =>
                                            arrayHelpers.push(
                                                ""
                                            )
                                    }
                                    >
                                        Add cooking steps
                                    </Button>
                                    {values.recipeStep.map((recipe, index) => {
                                        return(
                                            <div className="row m-3" key={recipe.recipeId}>
                                                <FormControl placeholder="Steps" 
                                                             name={`recipeStep.${index}`}
                                                             value={values.recipeStep.pop[0]}
                                                             onBlur={handleBlur}
                                                             onChange={handleChange}
                                                             className="col-11"
                                                />
                                                <Button className="col-1 btn btn-dark" onClick={() => arrayHelpers.remove(index)}>
                                                    x
                                                </Button>
                                                {
                                                    errors.recipeStep && touched.recipeStep && (
                                                        <div className="alert alert-danger">
                                                            {errors.recipeStep}
                                                        </div>
                                                    )
                                                }
                                            </div>
                                        );
                                    })}
                                    </div>
                                )}
                             </FieldArray>

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

                                 <Form.Group className="row d-block m-3">
                                     <input type="file" onChange={handleChange} id="recipeImageUrl" value={values.recipeImageUrl}/>
                                 </Form.Group>

                                 <Form.Group className="row d-block m-3">
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


{/*form that shows how the values are being validated and what errors you're getting*/}
                            <FormDebugger {...props}/>


                             </Form>
                         </Card.Body>
                     </Card>

                     {/*check status of the submit*/}
                     {console.log(submitStatus)}
                     {status && (<div className={status.type}>{status.message}</div>)}

                 </>
             )

};
