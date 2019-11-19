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
	$interactionRecipeId = $id = filter_input(INPUT_GET, "interactionRecipeId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES0);

	if($method === "GET") {
	//set xsrf cookie
		setXsrfCookie();

		//gets  a specific interaction associated based on its composite key
	}
}