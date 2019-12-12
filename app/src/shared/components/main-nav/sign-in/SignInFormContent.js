import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
// import {FormDebugger} from "../../FormDebugger";
import React from "react";

export const SignInFormContent = (props) => {
	const {
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
	return (
		<>
			<form onSubmit={handleSubmit}>
				{/*controlId must match what is passed to the initialValues prop*/}
				<div className="form-group">
					<label htmlFor="userEmail">Email Address</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon="envelope"/>
							</div>
						</div>
						<input
							className="form-control"
							id="userEmail"
							type="email"
							value={values.userEmail}
							placeholder="Enter email"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.userEmail && touched.userEmail && (
							<div className="alert alert-danger">
								{errors.userEmail}
							</div>
						)

					}
				</div>
				{/*controlId must match what is defined by the initialValues object*/}
				<div className="form-group">
					<label htmlFor="userPassword">Password</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon="key"/>
							</div>
						</div>
						<input
							id="userPassword"
							className="form-control"
							type="password"
							placeholder="Password"
							value={values.userPassword}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.userPassword && touched.userPassword && (
						<div className="alert alert-danger">{errors.userPassword}</div>
					)}
				</div>

				<div className="form-group">

					<button className="btn btn-dark mx-2 mb-2"
							type="submit"
					>Submit
					</button>

					<button
						className="btn btn-warning text-white mb-2"
						onClick={handleReset}
						disabled={!dirty || isSubmitting}
					>Cancel
					</button>

				</div>
				{/*<FormDebugger {...props} />*/}
			</form>
			{status && (<div className={status.type}>{status.message}</div>)}
		</>
	)
};