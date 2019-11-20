<?php

//core structure

// we determine if we have a GET request. If so, we then process the request.
if($method === "GET") {


// If it is not a GET request, we then proceed here to determine if we have a PUT or POST request.
} else if($method === "PUT" || $method === "POST") {

	//do setup that is needed for both PUT and POST requests

	//perform the actual put or post
	if($method === "PUT") {
		// determines if we have a PUT request. If so we process the request.
		// process PUT requests here


	} else if($method === "POST") {

		// process the POST request  here

	}


	// if the above requests are neither a PUT or POST delete below
} else if($method === "DELETE") {

	// process DELETE requests here

}

//setup
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/php/classes/autoload.php";
require_once dirname(__DIR__, 3) . "/php/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/php/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use TheDeepDiveDawgs\CommunityCookbook\{
	Recipe,
	// we only use the profile class for testing purposes
	User
};


/**
 * api for the Recipe class
 *
 * @author {} <theDeepDiveDawgs>
 * @coauthor Damian Arya <darya@cnm.edu>
 **/

//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {
	//grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/communityCookbook.com");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeUserId = filter_input(INPUT_POST, "recipeUserId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeSearchTerm = filter_input(INPUT_GET, "recipeSearchTerm", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($id) === true)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}

//get

	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();

		//get a specific recipe based on arguments provided or all the recipes and update reply
		if(empty($id) === false) {
			$reply->data = Recipe::getRecipeByRecipeId($pdo, $id);
		} else if(empty($recipeUserId) === false) {
			$reply->data = Recipe::getRecipeByRecipeUserId($pdo, $recipeUserId)->toArray();
		} else if(empty($recipeSearchTerm) === false) {
			$reply->data = Recipe::getRecipeByRecipeSearchTerm($pdo, $recipeSearchTerm)->toArray();
		} else {
			$reply->data = Recipe::getAllRecipes($pdo)->toArray();
		}
	}

//put and post


	else if($method === "PUT" || $method === "POST") {

		// enforce the user has a XSRF token
		verifyXsrf();

		//  Retrieves the JSON package that the front end sent, and stores it in $requestSearchTerm. Here we are using file_get_searchTerms("php://input") to get the request from the front end. file_get_searchTerms() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestSearchTerm = file_get_searchTerms("php://input");

		// This Line Then decodes the JSON package and stores that result in $requestObject
		$requestObject = json_decode($requestSearchTerm);

		//make sure recipe searchTerm is available (required field)
		if(empty($requestObject->recipeSearchTerm) === true) {
			throw(new \InvalidArgumentException ("No searchTerm for Recipe.", 405));
		}

		// make sure recipe date is accurate (optional field)
		if(empty($requestObject->recipeDate) === true) {
			$requestObject->recipeDate = null;
		} else {
			// if the date exists, Angular's milliseconds since the beginning of time MUST be converted
			$recipeDate = DateTime::createFromFormat("U.u", $requestObject->recipeDate / 1000);
			if($recipeDate === false) {
				throw(new RuntimeException("invalid recipe date", 400));
			}
			$requestObject->recipeDate = $recipeDate;
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the recipe to update
			$recipe = Recipe::getRecipeByRecipeId($pdo, $id);
			if($recipe === null) {
				throw(new RuntimeException("Recipe does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own recipe
			if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $recipe->getRecipeUserId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this recipe", 403));
			}

			// update all attributes
			$recipe->setRecipeDate($requestObject->recipeDate);
			$recipe->setRecipeSearchTerm($requestObject->recipeSearchTerm);
			$recipe->update($pdo);

			// update reply
			$reply->message = "Recipe updated OK";

		} else if($method === "POST") {

			// enforce the user is signed in
			if(empty($_SESSION["user"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post recipes", 403));
			}

			// create new recipe and insert into the database
			$recipe = new Recipe(generateUuidV4(), $_SESSION["user"]->getUserId, $requestObject->recipeSearchTerm, null);
			$recipe->insert($pdo);

			// update reply
			$reply->message = "Recipe created";
		}

	}


//delete
	else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Recipe to be deleted
		$recipe = Recipe::getRecipeByRecipeId($pdo, $id);
		if($recipe === null) {
			throw(new RuntimeException("Recipe does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own recipe
		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId() !== $recipe->getRecipeUserId()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this recipe", 403));
		}

		// delete recipe
		$recipe->delete($pdo);
		// update reply
		$reply->message = "Recipe deleted";

//finishing up
// update the $reply->status $reply->message
	} catch(\Exception | \TypeError $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
	}

// encode and return reply to front end caller
header("SearchTerm-type: application/json");
echo json_encode($reply);