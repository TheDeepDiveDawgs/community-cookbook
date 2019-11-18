<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";

use TheDeepDiveDawgs\CommunityCookbook\Category;

/**
 * API for the Category class
 *
 * @author Floribella Ponce <fponce2@cnm.edu>
 * @version 0.0.1
 */

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the MySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/Secrets.php");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$categoryName = filter_input(INPUT_GET, "categoryName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw (new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//GET method for Category class
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		// get a specific category bases on arguments or all the categories and update name
		if(empty($id) === false) {
			$reply->data = Category::getCategoryByCategoryId($pdo, $id);
		} else {
			$reply->data = Category::getAllCategories($pdo)->toArray();
		}

		// PUT and POST method for Category
	} else if($method === "PUT" || $method === "POST") {

		//enforce the user has a XSRF cookie
		verifyXsrf();

		//Retrieve the JSON package that the front end sent, and stores it in $requestContent. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestContent = file_get_contents("php://input");

		//Decode the JSON package and store the result in $requestObject
		$requestObject = json_decode($requestContent);

		//Retrieve te category to be updated
		$category = Category::getCategoryByCategoryId($pdo, $id);
		if($category === null) {
			throw(new \RuntimeException("Category does not exist", 404));
		}

		//category name
		if(empty($requestObject->categoryName) === true) {
			throw(new \InvalidArgumentException(("No category name present", 405));
		}

		$category->setCategoryName($requestObject->categoryName);
		$category->update($pdo);

		//update category
		$reply->message = "Category name updated";

	} elseif($method === "DELETE") {

		//verify the XSRF cookie
		verifyXsrf();

		//retrieve the category to be deleted
		$category = Category::getCategoryByCategoryId($pdo, $id);
		if($category === null) {
			throw(new RuntimeException("Category does not exist", 404));
		}

		//perform the actual delete
		$category->delete($pdo);

		//update the message
		$reply->message = "Category was successfully deleted";
	}

	// if any other HTTP request is sent throw an exception
} else {
	throw new \InvalidArgumentException("invalid http request", 400);
}
//catch any exceptions that is thrown and update the reply status and message
} catch (\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and return reply to front end called
echo json_encode($reply);


