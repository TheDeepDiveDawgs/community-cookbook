import React, {useEffect, useState} from 'react';
import {useSelector, useDispatch} from "react-redux";
import {httpConfig} from "../../utils/http-config";
import {UseJwtUserId} from "../../utils/JwtHelpers";
import {UseJwt} from "../../utils/JwtHelpers";
import {UseJwtUserHandle} from "../../utils/JwtHelpers";
import {handleSessionTimeout} from "../../../shared/misc/handle-session-timeout"
import _ from "lodash";
import Card from "react-bootstrap/Card";

export const InteractionComp = () => {










	return (
		<>

			{interactions.map(interaction => {
				return (
					<>
					<Card style={{width: '18rem'}}>
					<Card.Img/>
					<Card.Body>
						<Card.Text> Rating </Card.Text>
					</Card.Body>
					</Card>
					</>
				)

			})}
		</>
	)
};
