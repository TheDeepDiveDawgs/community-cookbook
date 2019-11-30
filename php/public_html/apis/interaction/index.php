<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";

use TheDeepDiveDawgs\CommunityCookbook\{Interaction, User, Recipe, Category};


/**
 * API for updating Interaction
 *
 * @author Community Cookbook
 * @version 1.0
 */

//verify session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;

try {

	//grab the mySQL connection
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cookbook.ini");
	$pdo = $secrets->getPdoObject();

	//determine which HTTP method was used
	$method = $_SERVER["HTTP_X_HTTP_METHOD"] ?? $_SERVER["REQUEST_METHOD"];

	//sanitize search parameters
	$interactionUserId = $userId = filter_input(INPUT_GET, "interactionUserId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$interactionRecipeId = $recipeId = filter_input(INPUT_GET, "interactionRecipeId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$interactionRating = filter_input(INPUT_GET, "interactionRating", FILTER_VALIDATE_INT);

	if($method === "GET") {
		//set xsrf cookie
		setXsrfCookie();

		//gets  a specific interaction associated based on its composite key
		if ($interactionUserId !== null && $interactionRecipeId !== null) {
			$interaction = Interaction::getInteractionByInteractionRecipeIdAndInteractionUserId($pdo, $interactionUserId, $interactionRecipeId);

			if($interaction!== null) {
				$reply->data = $interaction;
			}
			//if none of the search parameters are met throw exception
		} else if(empty($interactionUserId) === false) {
			$reply->data = Interaction::getInteractionByInteractionUserId($pdo, $interactionUserId)->toArray();
			//get all the interactions associated with recipeId
		} else if(empty($interactionRecipeId) === false) {
			$reply->data = Interaction::getInteractionByInteractionRecipeId($pdo, $interactionRecipeId)->toArray();
		} else {
			throw new InvalidArgumentException("incorrect search parameters", 404);
		}

	} else if($method === "POST" || $method === "PUT") {
		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		if(empty($requestObject->interactionUserId) === true) {
			throw (new \InvalidArgumentException("No User linked to Interaction", 405));
		}
		if(empty($requestObject->interactionRecipeId) === true) {
			throw (new \InvalidArgumentException("No Recipe linked to Interaction", 405));
		}


		if($method === "POST") {
			//enforce that the end user has a XSRF token.
			verifyXsrf();

			//enforce the end user JWT token
			//validate JWT header
			validateJwtHeader();

			//enforce the user signed in
			if(empty($_SESSION["user"]) === true) {
				throw(new \InvalidArgumentException("you must be logged in to interact", 403));
			}


			$interaction = new Interaction($_SESSION["user"]->getUserId(), $requestObject->interactionRecipeId, null, $requestObject->interactionRating);

			$interaction->insert($pdo);
			$reply->message = "interaction rating successful";

		} else if($method === "PUT") {
			//enforce the end user  has a xsrf token
			verifyXsrf();



			//grab the interaction by its composite key
			// retrieve the recipe to update
			$interaction = Interaction::getInteractionByInteractionRecipeIdAndInteractionUserId($pdo, $interactionRecipeId, $interactionUserId);
			if($interaction === null) {
				throw(new RuntimeException("Interaction does not exist", 404));
			}

			//enforce the user is signed in and only trying to edit their own interaction
			if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $interaction->getInteractionUserId()->toString()) {
				throw(new \InvalidArgumentException("You are not allowed to update this interaction.", 403));
			}

			//enforce the end user has a jwt token
			validateJwtHeader();

			if(empty($requestObject->interactionRating) === true) {
				$requestObject->interactionRating = $interaction->getInteractionRating();
			}

			$interaction->setInteractionRating($requestObject->interactionRating);

			//perform the actual update
			$interaction->update($pdo);

			//update the message
			$reply->message = "Interaction successfully updated";
		}
		//if any other HTTP request is sent throw an exception
	}   else {
		throw new \InvalidArgumentException("invalid http request, 400");
	}
	// catch any exceptions that is thrown and update the reply status message
} catch(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message =$exception->getMessage();
}

header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

//encode and return reply to front end caller
echo json_encode($reply);