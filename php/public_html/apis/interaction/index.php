<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
use TheDeepDiveDawgs\CommunityCookbook\Interaction;

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
	$interactionUserId = $id = filter_input(INPUT_GET, "interactionUserId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$interactionRecipeId = $id = filter_input(INPUT_GET, "interactionRecipeId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

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
				throw (new \invalidArgumentException("No User linked to Interaction", 405));
		}
		if(empty($requestObject->interactionRecipeId) === true) {
			throw (new \invalidArgumentException("No Recipe linked to Interaction", 405));
		}
	}
}