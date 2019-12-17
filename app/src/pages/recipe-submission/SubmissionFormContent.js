import React from "react";

import {FormDebugger} from "../../shared/components/FormDebugger";

import {Form} from "react-bootstrap/Form";
import inputGroup from "react-bootstrap/InputGroup";
import FormControl from "react-bootstrap/es/FormControl";
import Button from "react-bootstrap/Button";
import Card from "react-bootstrap/Card";

export const SubmissionFormContent = (props) => {

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

             return(
                 <>
                     <Card bg="dark" className="mb-3 text-white">
                         <Card.Body>
                             <Form onSubmit={handleSubmit}>

                                 <Form.Group>
                                     <Form.Label className="sr-only">Recipe title</Form.Label>
                                     <InputGroup>
                                         <FormControl
                                             id="recipeName"
                                             onChange={handleChange}
                                             onBlur={handleBlur}
                                             placeholder="Recipe title..."
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
                                     <Form.Label className="sr-only">Number of Ingredients</Form.Label>
                                     <InputGroup>
                                         <FormControl
                                             id="recipeNumberIngredients"
                                         />
                                     </InputGroup>
                                 </Form.Group>

                             </Form>
                         </Card.Body>
                     </Card>
                 </>
             )

}
