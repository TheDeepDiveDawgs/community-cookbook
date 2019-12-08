import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {FormDebugger} from "../../FormDebugger";
import React from "react";

export const SignUpFormContent = (props) => {
	const {
		submitStatus,
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
					<label htmlFor="userPasswordConfirm">Confirm Your Password</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon="key"/>
							</div>
						</div>
						<input

							className="form-control"
							type="password"
							id="userPasswordConfirm"
							placeholder="Password Confirm"
							value={values.userPasswordConfirm}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.userPasswordConfirm && touched.userPasswordConfirm && (
						<div className="alert alert-danger">{errors.userPasswordConfirm}</div>
					)}
				</div>


				<div className="form-group">
					<label htmlFor="userHandle">Username</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon="dove"/>
							</div>
						</div>
						<input
							className="form-control"
							id="userHandle"
							type="text"
							value={values.userHandle}
							placeholder="Username"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.userHandle && touched.userHandle && (
							<div className="alert alert-danger">
								{errors.userHandle}
							</div>
						)
					}
				</div>

				<div className="form-group">
					<label htmlFor="userFullName">Full Name</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<FontAwesomeIcon icon="dove"/>
							</div>
						</div>
						<input
							className="form-control"
							id="userFullName"
							type="text"
							value={values.userFullName}
							placeholder="Full Name"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.userFullName && touched.userFullName && (
							<div className="alert alert-danger">
								{errors.userFullName}
							</div>
						)
					}
				</div>


				<div className="form-group">
					<button className="btn btn-primary mb-2"
							  onSubmit={({ setSubmitting }) => {
								  alert("Form is validated! Submitting the form...");
								  setSubmitting(false);
							  }}
							  type="submit"
							  disabled={isSubmitting}>
						{isSubmitting ? "Submitting..." : "Submit"}
					</button>

					<button
						className="btn btn-danger mb-2"
						onClick={handleReset}
						disabled={!dirty || isSubmitting}>
						Reset
					</button>
				</div>


				{/*<FormDebugger {...props} />*/}
			</form>
			{console.log(
				submitStatus
			)}
			{
				submitStatus && (<div className={submitStatus.type}>{submitStatus.message}</div>)
			}
		</>


	)
};