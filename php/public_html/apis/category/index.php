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
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cookbook.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize category input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw (new InvalidArgumentException("id cannot be empty or negative", 405));
	}

	//GET method for Category class
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		// get a specific category based on arguments or all the categories
		if(empty($id) === false) {
			// get category by Id
			$reply->data = Category::getCategoryByCategoryId($pdo, $id);
		} else {
			// get all categories if no category id is specified
			$reply->data = Category::getAllCategories($pdo)->toArray();
		}
	}

} catch
(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and return reply to front end caller
echo json_encode($reply);


