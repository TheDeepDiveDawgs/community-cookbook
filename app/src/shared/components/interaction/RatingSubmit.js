import React, {useState} from "react";
import {httpConfig} from "../../utils/http-config"


export const RatingSubmit = () => {

    const [setStatus] = useState(null)

    const submitRating = (values, {setStatus}) => {
        
        const headers = {
            'X-JWT-TOKEN': window.localStorage.getItem("jwt-token")
        };

        httpConfig.post("apis/interaction", values, {
            headers: headers})
            .then(reply => {
                let {message, type} = reply;
                setStatus({message, type});
                if(reply.status === 200) {
                    window.location.reload();
                    console.log(reply)
                }
            });
    };
};