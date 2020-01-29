import React, {useState} from "react";
import {httpConfig} from "../../utils/http-config"
import * as Yup from "yup";
import { Formik } from "formik";
import { InteractionComponent } from "./InteractionComponent";
import {FormDebugger} from "../FormDebugger";


export const RatingSubmit = (props) => {

    const rating = {
        interactionDate: "",
        interactionRating: "",
    }

    const validator = Yup.object().shape({
        interactionDate: Yup.date()
        .default(() => (new Date())),
        interactionRating: Yup.number()
        .max(999, "rating too long")
    })

    const [status, setStatus] = useState(null)

    const submitRating = (values, {resetForm, setStatus}) => {
        
        const headers = {
            'X-JWT-TOKEN': window.localStorage.getItem("jwt-token")
        };

        httpConfig.post("apis/interaction", values, {
            headers: headers})
            .then(reply => {
                let {message, type} = reply;
                if(reply.status === 200) {
                    resetForm();
                    window.location.reload();
                    console.log(reply)
                } setStatus({message, type});
            });
    };
    return (
        <>
            <Formik
                onClick={submitRating}
                initialValues={rating}
                validationSchema={validator}
            >
                <InteractionComponent/>
                <FormDebugger {...props}/>
            </Formik>
        </>
    )
};
