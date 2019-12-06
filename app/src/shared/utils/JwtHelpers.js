import React, {useState, useEffect} from "react";
import * as jwtDecode from "jwt-decode";

	// custom hooks to grab the jwt and decode jwt data for logged in user
	// @author ginovillalpando@outlook.com

export const UseJwt = () => {
		const [jwt, setJwt] = useState(null);

		useEffect(() => {
			setJwt(window.localStorage.getItem("jwt-token"));
		});
	return jwt;
};

export const UseJwtUserHandle = () => {
		const[userHandle, setUserHandle] = useState(null);

		useEffect(() => {
			const token = window.localStorage.getItem("jwt-token");
			if(token !== null) {
				const decodeJwt = jwtDecode(token);
				setUserHandle(decodeJwt.auth.userHandle);
			}
		});
		return userHandle;
};

export const UseJwtUserId = () => {
		const [userId, setUserId] = useState(null);

		useEffect(() => {
			const token = window.localStorage.getItem("jwt-token");
			if(token !== null) {
				const decodeJwt = jwtDecode(token);
				setUserId(decodeJwt.auth.userId);
			}
		});
		return userId;
};