import React from "react";
import {UseJwt} from "../../shared/utils/JwtHelpers";
import Button from "react-bootstrap/Button";
import {Link} from "react-router-dom";

export const SubmitButton = () => {

    const jwt = UseJwt();

    return (
        <>
            {/*button won't show unless a user is signed in with jwt token*/}
            {jwt !== null &&

                <Link to="/recipe-submission" id="submission-form-button">
                    <Button
                        variant="warning"
                        type="submit"
                        className="mt-5 font-weight-bold p-4"
                    >
                        Create Recipe
                    </Button>
                </Link>
            }
        </>
    )
}