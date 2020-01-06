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

                <Link to="/recipe-submission" className="row">
                    <Button
                        variant="warning"
                        type="submit"
                        className="mx-auto font-weight-bold p-4"
                    >
                        Create Recipe
                    </Button>
                </Link>
            }
        </>
    )
};