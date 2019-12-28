	<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/jwt.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
use TheDeepDiveDawgs\CommunityCookbook\User;

/**
 * API for updating User
 *
 * @author Community Cookbook
 * @version 1.0
 */

//verify the session, if it is not active start it
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

	// sanitize input
	$userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userFullName = filter_input(INPUT_GET, "userFullName", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userHandle = filter_input(INPUT_GET, "userHandle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$userEmail = filter_input(INPUT_GET, "userEmail", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

	// make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($userId) === true)) {
		throw(new InvalidArgumentException("ID cannot be empty or negative", 405));
	}
	if($method === "GET") {

		//set XSRF cookie
		setXsrfCookie();

		//gets a post by content
		if(empty($userId) === false) {
			$reply->data = User::getUserByUserId($pdo, $userId);
		} else if(empty($userHandle) === false) {
			$reply->data = User::getUserByUserHandle($pdo, $userHandle);
		} else if(empty($userEmail) === false) {
			$reply->data = User::getUserByUserEmail($pdo, $userEmail);
		}
	} elseif($method === "PUT") {

		//enforce that the XSRF token is present in the header
		verifyXsrf();

		//enforce the end user has a JWT token
		//validateJwtHeader();
		//enforce the user is signed in and only trying to edit their own user
		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $userId) {
			throw(new \InvalidArgumentException("You are not allowed to access this user", 403));
		}
		validateJwtHeader();

		//decode the response from the front end
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);

		//retrieve the user to be updated
		$user = User::getUserByUserId($pdo, $userId);
		if($user === null) {
			throw(new RuntimeException("User does not exist", 404));
		}


		//user email | if null use the user email that is in the database
		if(empty($requestObject->userEmail) === true) {
			$requestObject->userEmail = $user->getUserEmail();
		}

		//user full name | if null use the user full name that is in the database
		if(empty($requestObject->userFullName) === true) {
			$requestObject->userFullName = $user->getUserFullName();
		}

		//user at handle
		if(empty($requestObject->userHandle) === true) {
			$requestObject->userHandle = $user->getUserHandle();
		}

		//


		$user->setUserEmail($requestObject->userEmail);
		$user->setUserFullName($requestObject->userFullName);
		$user->setuserHandle($requestObject->userHandle);
		$user->update($pdo);

		// update reply
		$reply->message = "User information updated";
	} elseif($method === "DELETE") {

		//verify the XSRF Token
		verifyXsrf();

		//enforce the end user has a JWT token
		//validateJwtHeader();
		$user = User::getUserByUserId($pdo, $userId);
		if($user === null) {
			throw (new RuntimeException("User does not exist"));
		}

		//enforce the user is signed in and only trying to edit their own user
		if(empty($_SESSION["user"]) === true || $_SESSION["user"]->getUserId()->toString() !== $user->getUserId()->toString()) {
			throw(new \InvalidArgumentException("You are not allowed to access this user", 403));
		}
		validateJwtHeader();

		//delete the post from the database
		$user->delete($pdo);
		$reply->message = "User Deleted";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP request", 400));
	}

	// catch any exceptions that were thrown and update the status and message state variable fields
} catch
(\Exception | \TypeError $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
}
header("Content-type: application/json");
if($reply->data === null) {
	unset($reply->data);
}

// encode and return reply to front end caller
echo json_encode($reply);