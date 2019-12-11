<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
use TheDeepDiveDawgs\CommunityCookbook\{Category, User, Recipe, Interaction};
/**
 * api for the Recipe class
 *
 * @author damian Arya <darya@cnm.edu>
 * @co-author floribella ponce <fponce2@cnm.edu>
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

	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cookbook.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize input
	$recipeId = filter_input(INPUT_GET, "recipeId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeUserId = filter_input(INPUT_GET, "recipeUserId", FILTER_SANITIZE_STRING,FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeCategoryId = filter_input(INPUT_GET, "recipeCategoryId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeDescription = filter_input(INPUT_GET, "recipeDescription", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeIngredients = filter_input(INPUT_GET, "recipeIngredients", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeMinutes = filter_input(INPUT_GET, "recipeMinutes", FILTER_VALIDATE_INT);
	$recipeName = filter_input(INPUT_GET, "recipeName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeNumberIngredients = filter_input(INPUT_GET, "recipeNumberIngredients", FILTER_VALIDATE_INT);
	$recipeNutrition = filter_input(INPUT_GET, "recipeNutrition", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeStep = filter_input(INPUT_GET, "recipeStep", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$recipeSearchTerm = filter_input(INPUT_GET, "recipeSearchTerm", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($recipeId) === true )) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 402));
	}
	// handle GET request - if id is present, that recipe is returned, otherwise all recipes are returned
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		//get a specific recipe or all recipes and update reply
		if(empty($recipeId) === false) {
			$reply->data = Recipe::getRecipeByRecipeId($pdo, $recipeId);
		} else if(empty($recipeUserId) === false) {
			// if the user is logged in grab all the recipes by that user based on who is logged in
			$reply->data = Recipe::getRecipeByRecipeUserId($pdo, $recipeUserId);
		} else if(empty($recipeSearchTerm) === false) {
			$reply->data = Recipe::getRecipeBySearchTerm($pdo, $recipeSearchTerm)->toArray();
		} else {
			$recipes = Recipe::getAllRecipe($pdo)->toArray();
			$recipeUsers = [];
			foreach($recipes as $recipe){
				$user =  User::getUserByUserId($pdo, $recipe->getRecipeUserId());
				$recipeUsers[] = (object)[
					"recipeId"=>$recipe->getRecipeId(),
					"recipeCategoryId"=>$recipe->getRecipeCategoryId(),
					"recipeUserId"=>$recipe->getRecipeUserId(),
					"recipeDescription"=>$recipe->getRecipeDescription(),
					"recipeImageUrl"=>$recipe->getRecipeImageUrl(),
					"recipeIngredients"=>json_decode($recipe->getRecipeIngredients()),
					"recipeMinutes"=>$recipe->getRecipeMinutes(),
					"recipeName"=>$recipe->getRecipeName(),
					"recipeNumberIngredients"=>$recipe->getRecipeNumberIngredients(),
					"recipeNutrition"=>$recipe->getRecipeNutrition(),
					"recipeStep"=>json_decode($recipe->getRecipeStep()),
					"recipeSubmissionDate"=>$recipe->getRecipeSubmissionDate()->format("Y-m-d H:i:s")
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
		$requestContents = file_get_contents("php://input");

		// Retrieves the JSON package that the front end sent, and stores it in $requestSearchTerm. Here we are using file_get_contents("php://input") to get the request from the front end. file_get_contents() is a PHP function that reads a file into a string. The argument for the function, here, is "php://input". This is a read only stream that allows raw data to be read from the front end request which is, in this case, a JSON package.
		$requestObject = json_decode($requestContents);

		// This Line Then decodes the JSON package and stores that result in $requestObject
		// make sure recipe date is accurate (optional field)
		if(empty($requestObject->recipeSubmissionDate) === true) {
			$requestObject->recipeSubmissionDate = null;
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

			if(empty($requestObject->recipeDescription) === true) {
				$requestObject->recipeDescription = $recipe->getRecipeDescription();
			}

			if(empty($requestObject->recipeImageUrl) === true) {
				$requestObject->recipeImageUrl = $recipe->getRecipeImageUrl();
			}

			if(empty($requestObject->recipeIngredients) === true) {
				$requestObject->recipeIngredients = $recipe->getRecipeIngredients();
			}

			if(empty($requestObject->recipeMinutes) === true) {
				$requestObject->recipeMinutes = $recipe->getRecipeMinutes();
			}

			if(empty($requestObject->recipeName) === true) {
				$requestObject->recipeName = $recipe->getRecipeName();
			}

			if(empty($requestObject->recipeNumberIngredients) === true) {
				$requestObject->recipeNumberIngredients = $recipe->getRecipeNumberIngredients();
			}

			if(empty($requestObject->recipeNutrition) === true) {
				$requestObject->recipeNutrition = $recipe->getRecipeNutrition();
			}

			if(empty($requestObject->recipeStep) === true) {
				$requestObject->recipeStep = $recipe->getRecipeStep();
			}

			// update all attributes
			$recipe->setRecipeDescription($requestObject->recipeDescription);
			$recipe->setRecipeImageUrl($requestObject->recipeImageUrl);
			$recipe->setRecipeIngredients($requestObject->recipeIngredients);
			$recipe->setRecipeMinutes($requestObject->recipeMinutes);
			$recipe->setRecipeName($requestObject->recipeName);
			$recipe->setRecipeNumberIngredients($requestObject->recipeNumberIngredients);
			$recipe->setRecipeNutrition($requestObject->recipeNutrition);
			$recipe->setRecipeStep($requestObject->recipeStep);
			$recipe->update($pdo);

			// update reply
			$reply->message = "Recipe updated OK";
		} else if($method === "POST") {

			//enforce that the end user has a XSRF token.
			verifyXsrf();

			// enforce the user is signed in
			if(empty($_SESSION["user"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to post recipes", 403));
			}

			//enforce the end user has a JWT token
			validateJwtHeader();

			// create new recipe and insert into the database
			$recipe = new Recipe(generateUuidV4(), $requestObject->recipeCategoryId, $_SESSION["user"]->getUserId(), $requestObject->recipeDescription,
				$requestObject->recipeImageUrl, json_encode($requestObject->recipeIngredients) , $requestObject->recipeMinutes, $requestObject->recipeName,
				$requestObject->recipeNumberIngredients, $requestObject->recipeNutrition, json_encode($requestObject->recipeStep), null);
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
			throw(new \InvalidArgumentException("You are not allowed to modify this recipe", 403));
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
header("Content-type: application/json");
if($reply->data === null){
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);