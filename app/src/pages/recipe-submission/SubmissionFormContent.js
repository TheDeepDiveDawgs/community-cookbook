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

                             {/* <Form.Group>
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
                                     errors.recipeIngredients && touched.recipeIngredients && (
                                        <div className="alert alert-danger">
                                            {errors.recipeIngredients}
                                        </div>
                                     )
                                 }
                             </Form.Group> */}

                             <FieldArray name="recipeIngredients">
                                {arrayHelpers => (
                                    <div>
                                        <Button onClick={() =>
                                            arrayHelpers.push(
                                                ""
                                            )
                                    }
                                    >
                                        add ingredient
                                    </Button>
                                    {values.recipeIngredients.map((recipe, index) => {
                                        return(
                                            <div key={recipe.recipeId}>
                                                <FormControl placeholder="ingredient" 
                                                             name={`recipeIngredients.${index}`}
                                                             value={values.recipeIngredients.push}
                                                             onBlur={handleBlur}
                                                             type="text"
                                                             onChange={handleChange}
                                                />
                                                <Button onClick={() => arrayHelpers.remove(index)}>
                                                    x
                                                </Button>
                                            </div>
                                        );
                                    })}
                                    </div>
                                )}
                             </FieldArray>

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

                                 <Form.Group className="row float-right">
                                     <input type="file" onChange={handleChange} id="recipeImageUrl" value={values.recipeImageUrl}/>
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
