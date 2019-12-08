import {httpConfig} from "./http-config";

export const handleSessionTimeout = () => {
	alert("Session inactive. Please log in again.");
	httpConfig.get("apis/signout/")
		.then(reply => {
			let {message, type} = reply;
			if(reply.status === 200) {
				window.localStorage.removeItem("jwt-token");
				console.log(reply);
				setTimeout(() => {
					window.location = "https://bootcamp-coders.cnm.edu/~dhernandez43/community-cookbook2/php/public_html/";
				}, 1000);
			}
		});
};