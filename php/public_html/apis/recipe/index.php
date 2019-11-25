<?php

require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/Uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use deepDiveDawgs\CommunityCookbook\{Search, User, Recipe};

/**
 * api for the Recipe class
 *
 * @author damian Arya <darya@cnm.edu>
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

	$secrets = new \Secrets("/etc/apache2/capstone-mysql/communityCookbook.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$recipeId = filter_input(INPUT_GET, "recipeId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeUserId = filter_input(INPUT_GET, "recipeUserId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeSearchTerm = filter_input(INPUT_GET, "recipeSearchTerm", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the recipe id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($recipeId) === true )) {
		throw(new InvalidArgumentException("recipe id cannot be empty or negative", 402));
	}

	// handle GET request - if  recipe id is present, that recipe is returned, otherwise all recipes are returned
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		//get a specific recipe or all recipes and update reply
		if(empty($recipeId) === false) {
			$reply->data = Recipe::getRecipeByRecipeId($pdo, $recipeId);
		} else if(empty($recipeUserId) === false) {

			// if the user is logged in grab all the recipes by that user based  on who is logged in
			$reply->data = Recipe::getRecipeByRecipeUserId($pdo, $recipeUserId);

		} else if(empty($recipeSearchTerm) === false) {
			$reply->data = Recipe::getRecipeByRecipeSearchTerm($pdo, $recipeSearchTerm)->toArray();

		} else {
			$recipes = Recipe::getAllRecipes($pdo)->toArray();
			$recipeUsers = [];
			foreach($recipes as $recipe){
				$user = 	User::getUserByUserId($pdo, $recipe->getRecipeUserId());
				$recipeUsers[] = (object)[
					"recipeId"=>$recipe->getRecipeId(),
					"recipeCategoryId"=>$recipe->getRecipeCategoryId(),
					"recipeUserId"=>$recipe->getRecipeUserId(),
					"recipeDescription"=>$recipe->getRecipeDescription(),
					"recipeImageUrl"=>$recipe->getRecipeImageUrl(),
					"recipeIngredients"=>$recipe->getRecipeIngredients(),
					"recipeMinutes"=>$recipe->getRecipeMinutes(),
					"recipeName"=>$recipe->getRecipeName(),
					"recipeNumberIngredients"=>$recipe->getRecipeNumberIngredients(),
					"recipeNutrition"=>$recipe->getRecipeNutrition(),
					"recipeSearchTerm"=>$recipe->getRecipeSearchTerm(),
					"recipeSteps"=>$recipe->getRecipeSteps(),
					"recipeSubmissionDate"=>$recipe->getRecipeSubmissionDate(),
				];
			}
			$reply->data = $recipeUsers;
		}
	} else if($method === "PUT" || $method === "POST") {

		// enforce the user has a XSRF token
		verifyXsrf();

		// enforce the user is signed in
		if(empty($_SESSION["user"]) === true) {
			throw(new \InvalidArgumentException("you must be logged in to post recipes", 401));
		}

		$requestSearchTerm = file_get_searchTerms("php://input");

		// Retrieves the JSON package that the front end sent, and stores it in $requestSearchTerm. Here we are using file_get_searchTerms("php://input") to get the request from the front end. file_get_searchTerms() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestSearchTerm);

		// This Line Then decodes the JSON package and stores that result in $requestObject

		//make sure recipe searchTerm is available (required field)
		if(empty($requestObject->recipeSearchTerm) === true) {
			throw(new \InvalidArgumentException ("No searchTerm for Recipe.", 405));
		}

		// make sure recipe date is accurate (optional field)
		if(empty($requestObject->recipeDate) === true) {
			$requestObject->recipeDate = null;
		}

		//perform the actual put or post
		if($method === "PUT") {

			// retrieve the recipe to update
			$recipe = Recipe::getRecipeByRecipeId($pdo, $recipeId);
			if($recipe === null) {
				throw(new RuntimeException("Recipe does not exist", 404));
			}

			//enforce the end user has a JWT token

			//enforce the user is signed in and only trying to edit their own recipe
			if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $recipe->getRecipeUserId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to edit this recipe", 403));
			}

			validateJwtHeader();

			// update all attributes

			//$recipe->setRecipeDate($requestObject->recipeDate);
			$recipe->setRecipeSearchTerm($requestObject->recipeSearchTerm);
			$recipe->update($pdo);

			// update reply
			$reply->message = "Recipe updated OK";

		} else if($method === "POST") {

			// enforce the user is signed in
			if(empty($_SESSION["user"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post recipes", 403));
			}

			//enforce the end user has a JWT token
			validateJwtHeader();

			// create new recipe and insert into the database
			$recipe = new Recipe(generateUuidV4(), $_SESSION["user"]->getUserId(), $requestObject->recipeSearchTerm, null);
			$recipe->insert($pdo);

			// update reply
			$reply->message = "Recipe created OK";
		}

	} else if($method === "DELETE") {

		//enforce that the end user has a XSRF token.
		verifyXsrf();

		// retrieve the Recipe to be deleted
		$recipe = Recipe::getRecipeByRecipeId($pdo, $recipeId);
		if($recipe === null) {
			throw(new RuntimeException("Recipe does not exist", 404));
		}

		//enforce the user is signed in and only trying to edit their own recipe
		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $recipe->getRecipeUserId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to delete this recipe", 403));
		}

		//enforce the end user has a JWT token
		validateJwtHeader();

		// delete recipe
		$recipe->delete($pdo);

		// update reply
		$reply->message = "Recipe deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request", 418));
	}

// update the $reply->status $reply->message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}

// encode and return reply to front end caller
header("SearchTerm-type: application/json");
echo json_encode($reply);