<?php
require_once dirname(__DIR__, 3) . "/vendor/autoload.php";
require_once dirname(__DIR__, 3) . "/Classes/autoload.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require_once dirname(__DIR__, 3) . "/lib/xsrf.php";
require_once dirname(__DIR__, 3) . "/lib/uuid.php";
require_once("/etc/apache2/capstone-mysql/Secrets.php");

use TheDeepDiveDawgs\CommunityCookbook\User;
use Mailgun\Mailgun;

/**
 * api for signing up to Community Cookbook
 *
 * @author Community Cookbook
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
	$secrets = new \Secrets("/etc/apache2/capstone-mysql/cookbook.ini");
	$pdo = $secrets->getPdoObject();

	//Add: grab mailgun api keys from secrets
	$mailgunConfig = $secrets->getSecret("mailgun");


	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	if($method === "POST") {
		//decode the json and turn it into a php object
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//user at handle is a required field
		if(empty($requestObject->userHandle) === true) {
			throw(new \InvalidArgumentException ("No user @handle", 405));
		}
		//user email is a required field
		if(empty($requestObject->userEmail) === true) {
			throw(new \InvalidArgumentException ("No user email present", 405));
		}
		//user Full Name is a required field
		if(empty($requestObject->userFullName) === true) {
			throw(new \InvalidArgumentException("no user Full Name", 405));
		}

		//verify that user password is present
		if(empty($requestObject->userPassword) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}

		//verify that the confirm password is present
		if(empty($requestObject->userPasswordConfirm) === true) {
			throw(new \InvalidArgumentException ("Must input valid password", 405));
		}
//
////if phone is empty set it too null
//		if(empty($requestObject->userPhone) === true) {
//			$requestObject->userPhone = null;
//		}

		//make sure the password and confirm password match
		if($requestObject->userPassword !== $requestObject->userPasswordConfirm) {
			throw(new \InvalidArgumentException("passwords do not match"));
		}
		$hash = password_hash($requestObject->userPassword, PASSWORD_ARGON2I, ["time_cost" => 7]);
		$userActivationToken = bin2hex(random_bytes(16));

		//create the user object and prepare to insert into the database
		$user = new User(generateUuidV4(), $userActivationToken, $requestObject->userEmail, $requestObject->userFullName, $requestObject->userHandle, $hash);

		//insert the user into the database
		$user->insert($pdo);

		//compose the email message to send with th activation token
		$messageSubject = "One step closer to AbqCookBook -- Account Activation";

		//building the activation link that can travel to another server and still work. This is the link that will be clicked to confirm the account.
		//make sure URL is /public_html/api/activation/$activation
		$basePath = dirname($_SERVER["SCRIPT_NAME"], 3);

		//create the path
		$urlglue = $basePath . "/apis/activation/?activation=" . $userActivationToken;

		//create the redirect link
		$confirmLink = "https://" . $_SERVER["SERVER_NAME"] . $urlglue;

		//compose message to send with email
		$message = <<< EOF
<h2>Welcome to Abq CookBook</h2>
<p>In order to start posting your own recipes you must confirm your account </p>
<p><a href="$confirmLink">$confirmLink</a></p>
EOF;

		//create swift email
		$swiftMessage = new Swift_Message();

		// attach the sender to the message
		// this takes the form of an associative array where the email is the key to a real name
		$swiftMessage->setFrom(["abqcookbook@gmail.com" => "AbqCookBook"]);

		/**
		 * attach recipients to the message
		 * notice this is an array that can include or omit the recipient's name
		 * use the recipient's real name where possible;
		 * this reduces the probability of the email is marked as spam
		 */

		//define who the recipient is
		$recipients = [$requestObject->userEmail];

		//set the recipient to the swift message
		$swiftMessage->setTo($recipients);

		//attach the subject line to the email message
		$swiftMessage->setSubject($messageSubject);

		/**
		 * Attach the actual message to the message.
		 *
		 * Here we set two versions of the message: the HTML formatted message and a
		 * special filter_var()'d version of the message that generates a plain text
		 * version of the HTML content.
		 *
		 * Notice one tactic used is to display the entire $confirmLink to plain text;
		 * this lets users who aren't viewing HTML content in Emails still access your
		 * links.
		 **/
		$swiftMessage->setBody($message, "text/html");
		$swiftMessage->addPart(html_entity_decode($message), "text/plain");

		//Instantiate the mailgun api with your api credentials
		$mailgun = Mailgun::create($mailgunConfig->apikey);
		

		//configure the mailgun object and send the email
		$mailgun->messages()->sendMime($mailgunConfig->domain, [$requestObject->userEmail], $swiftMessage->toString(), []);

		//update reply
		$reply->message = "Thanks you for creating a profile with ABQCookbook. Please sign in to your account above.";
	} else {
		throw (new InvalidArgumentException("invalid http request"));
	}
	} catch(\Exception |\TypeError $exception) {
		$reply->status = $exception->getCode();
		$reply->message = $exception->getMessage();
		$reply->trace = $exception->getTraceAsString();
	}
	header("Content-type: application/json");
	echo json_encode($reply);