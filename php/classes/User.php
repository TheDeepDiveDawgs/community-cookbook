<?php
namespace TheDeepDiveDawgs\CommunityCookbook;

require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 * Cross section of a user
 *
 * This is a cross section of what is probably stored about a user. this entity is a top level entity that
 * holds the keys to the other entities
 */
class User implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this user; this is the primary key
	 * @var Uuid $userId
	 */
	private $userId;
	/**
	 * token handed out to verify the user is valid and not malicious.
	 * @var string $userActivationToken
	 */
	private $userActivationToken;
	/**
	 * email for this user; this is a unique identifier
	 * @var string $userEmail
	 */
	private $userEmail;
	/**
	 * full name for user
	 * @var string $userFullName
	 */
	private $userFullName;
	/**
	 * Username Handle for this user; this is a unique identifier
	 * @var string $userHandle
	 */
	private $userHandle;
	/**
	 * hash for user's password
	 * @var string $userHash
	 */
	private $userHash;

	/**
	 * constructor for this user
	 *
	 * @param string | Uuid $newUserId of this user or null if a new user
	 * @param string $newUserActivationToken string containing Activation Token
	 * @param string $newUserEmail of this user's email
	 * @param string $newUserFullName of this user or null if a new user
	 * @param string $newUserHandle Username for this user
	 * @param string $newUserHash hashed password for this user
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings are too long, negative int)
	 * @throws \TypeError if  data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @documentation https://php.net/manual/en/language.oop5.decon.php
	 */
	public function __construct($newUserId, ?string $newUserActivationToken, string $newUserEmail, string $newUserFullName, string $newUserHandle, string $newUserHash) {
		try {
			$this->setUserId($newUserId);
			$this->setUserActivationToken($newUserActivationToken);
			$this->setUserEmail($newUserEmail);
			$this->setUserFullName($newUserFullName);
			$this->setUserHandle($newUserHandle);
			$this->setUserHash($newUserHash);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for user id
	 *
	 * @return Uuid value of user id
	 *
	 **/
	public function getUserId(): Uuid {
		return $this->userId;
	}

	/**
	 * mutator method for user Id
	 *
	 * @param Uuid | string $newUserId value of new user id
	 * @throws \RangeException if $newUserId is not positive
	 * @throws \TypeError if the user Id is not uuid or string
	 */
	public function setUserId($newUserId): void {
		try {
			$uuid = self::validateUuid($newUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the user id
		$this->userId = $uuid;
	}

	/**
	 * accessor method for userActivationToken
	 * @return string value of the activation token
	 */
	public function getUserActivationToken(): string {
		return $this->userActivationToken;
	}

	/**
	 * mutator method for account activation token
	 *
	 * @param string $newUserActivationToken
	 * @throws \InvalidArgumentException if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setUserActivationToken(?string $newUserActivationToken): void {
		if($newUserActivationToken === null) {
			$this->userActivationToken = null;
			return;
		}
		$newUserActivationToken = strtolower(trim($newUserActivationToken));
		if(ctype_xdigit($newUserActivationToken) === false) {
			throw(new \RangeException("user activation is not a valid activation token"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newUserActivationToken) !== 32) {
			throw(new \RangeException("user activation token has to be 32 characters"));
		}
		$this->userActivationToken = $newUserActivationToken;
	}

	/**
	 * accessor method for email
	 *
	 * @return string value of email
	 */
	public function getUserEmail(): string {
		return $this->userEmail;
	}

	/**
	 * mutator method for email
	 *
	 * @param string $newUserEmail new value of email
	 * @throws \InvalidArgumentException if $newUserEmail is not a valid email or insecure
	 * @throws \RangeException if $newUserEmail is > 128 characters
	 * @throws \TypeError if $newUserEmail is not a string
	 */
	public function setUserEmail(string $newUserEmail): void {
		// verify the email is secure
		$newUserEmail = trim($newUserEmail);
		$newUserEmail = filter_var($newUserEmail, FILTER_VALIDATE_EMAIL);
		if(empty($newUserEmail) === true) {
			throw(new \InvalidArgumentException("User email is empty or insecure"));
		}
		// verify the email will fit in the database
		if(strlen($newUserEmail) > 128) {
			throw(new \RangeException("User email is too large"));
		}
		// store the email
		$this->userEmail = $newUserEmail;
	}

	/**
	 * accessor method for Full Name
	 *
	 * @return string for user name
	 */
	public function getUserFullName(): string {
		return $this->userFullName;
	}

	/*
	 * mutator method for Full Name
	 *
	 * @throws \InvalidArgumentException if $newUserFullName is not a valid name or insecure
	 * @throws \RangeException if $newUserEmail is > 97 characters
	 * @throws \TypeError if $newUserFullName is not a string
	 * @param string $newUserFullName
	 */
	public function setUserFullName(string $newUserFullName): void {
		//verify the Handle is secure
		$newUserFullName = trim($newUserFullName);
		$newUserFullName = filter_var($newUserFullName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserFullName) === true) {
			throw(new \InvalidArgumentException("User Handle is empty or insecure"));
		}
		//verify the Handle will fit in the database
		if(strlen($newUserFullName) > 255) {
			throw(new \RangeException("User Handle is too large"));
		}
		//store the Handle
		$this->userFullName = $newUserFullName;
	}

	/**
	 * accessor method for user Handle
	 * @return string value of Handle
	 */
	/**
	 * @return string
	 */
	public function getUserHandle(): string {
		return $this->userHandle;
	}
	/**
	 * mutator method for Handle
	 *
	 * @param string $newUserHandle
	 */
	/**
	 * @param string $newUserHandle
	 */
	public function setUserHandle(string $newUserHandle): void {
		//verify the Handle is secure
		$newUserHandle = trim($newUserHandle);
		$newUserHandle = filter_var($newUserHandle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newUserHandle) === true) {
			throw(new \InvalidArgumentException("User Handle is empty or insecure"));
		}
		//verify the Handle will fit in the database
		if(strlen($newUserHandle) > 32) {
			throw(new \RangeException("User Handle is too large"));
		}
		//store the Handle
		$this->userHandle = $newUserHandle;
	}

	/**
	 * accessor method for userHash
	 *
	 * @return string for userHash hashed password
	 */
	public function getUserHash(): string {
		return $this->userHash;
	}

	/**
	 * mutator method for user hash
	 *
	 * @param string $newUserHash value of new user hashed password
	 * @throws \InvalidArgumentException if password is empty or insecure
	 * @throws \InvalidArgumentException if user hash is not a valid hash
	 * @throws \RangeException if user hash is not 97 characters
	 */
	public function setUserHash(string $newUserHash): void {
		//enforce that the hash is properly formatted
		$newUserHash = trim($newUserHash);
		if(empty($newUserHash) === true) {
			throw(new \InvalidArgumentException("User password hash empty or insecure"));
		}
		//enforce the hash is really an Argon hash
		$userHashInfo = password_get_info($newUserHash);
		if($userHashInfo["algoName"] !== "argon2i") {
			throw(new \InvalidArgumentException("User hash is not a valid hash"));
		}
		//enforce that the hash is exactly 97 characters.
		if(strlen($newUserHash) !== 97) {
			throw(new \RangeException("User hash must be 97 characters"));
		}
		//store the hash
		$this->userHash = $newUserHash;
	}
	/**
	 * inserts this user into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL has a failed connection
	 * @throws \TypeError if $pdo is not a PDO connection subject
	 */
	public function insert(\PDO $pdo): void {
		//create query template
		$query = "INSERT INTO user (userId, userActivationToken, userEmail, userFullName, userHandle, userHash)
		VALUES (:userId, :userActivationToken, :userEmail, :userFullName, :userHash, :userHandle)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["userId" => $this->userId->getBytes(),
			"userActivationToken" => $this->userActivationToken, "userEmail" => $this->userEmail, "userFullName" => $this->userFullName, "userHash" => $this->userHash,
			"userHandle" => $this->userHandle];
		$statement->execute($parameters);
	}

	/**
	 * deletes this user from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occure
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		//create query template
		$query = "DELETE FROM user WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holder in the template
		$parameters = ["userId" => $this->userId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this user in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {

		// create query template
		$query = "UPDATE user SET userActivationToken = :userActivationToken, userEmail = :userEmail, userFullName = :userFullName, userHandle = :userHandle, userHash = :userHash WHERE userId = :userId";
		$statement = $pdo->prepare($query);

		$parameters = ["userId" => $this->userId->getBytes(),
			"userActivationToken" => $this->userActivationToken, "userEmail" => $this->userEmail, "userFullName" => $this->userFullName, "userHandle" => $this->userHandle,
			"userHash" => $this->userHash];
		$statement->execute($parameters);
	}

	/**
	 * gets the user by user Id
	 * @param \PDO $pdo PDO connection to object
	 * @param Uuid for $userId
	 * @return User | null User found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable is not the correct data type
	 */
	public static function getUserByUserId(\PDO $pdo, $userId) : ?User {
		//sanitize the userId before searching
		try{
			$userId = self::validateUuid($userId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw (new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT userId, userActivationToken, userEmail, userFullName, userHandle, userHash FROM user WHERE userId = :userId";
		$statement = $pdo->prepare($query);
	}

	public function jsonSerialize(): array {
		$fields = get_object_vars($this);

		$fields["userId"] = $this->userId->toString();
		$fields["userActivationToken"] = $this->userActivationToken->toString();
	}
}