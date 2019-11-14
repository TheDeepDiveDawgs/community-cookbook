<?php

namespace TheDeepDiveDawgs\CommunityCookbook;

require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * cross section of of interaction class
 *
 * @author Daniel Hernandez
 * @version 0.0.1
 **/
class Interaction implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/**foreign key
	 * @var Uuid $interactionUserId
	 **/
	private $interactionUserId;

	/**foreign key
	 * @var Uuid $interactionRecipeId
	 **/
	private $interactionRecipeId;

	/**Date and time interaction takes place, in a php datetime object
	 * @var \DateTime $interactionDate
	 **/
	private $interactionDate;

	/**user rating of recipe
	 * @var int $interactionRating
	 **/
	private $interactionRating;

	/**
	 * constructor for interaction
	 *
	 * @param string|Uuid $newInteractionUserId user id of this interaction
	 * @param string|Uuid $newInteractionRecipeId recipe id of this interaction
	 * @param \DateTime|string|null $newInteractionDate date and time of interaction was submitted or null if set to current date and time
	 * @param \int $newInteractionRating rating of interaction
	 * @throws \InvalidArgumentException if data types not Invalid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data violates type hints
	 * @throws \Exception if some other Exception occurs
	 */

	public function __construct($newInteractionUserId, $newInteractionRecipeId, $newInteractionDate = null, $newInteractionRating = null) {
		try {
			$this->setInteractionUserId($newInteractionUserId);
			$this->setInteractionRecipeId($newInteractionRecipeId);
			$this->setInteractionDate($newInteractionDate);
			$this->setInteractionRating($newInteractionRating);
		} //determine what exception type is thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**accessor method for
	 *
	 * @return Uuid value of interactionUserId
	 **/
	public function getInteractionUserId(): Uuid {
		return ($this->interactionUserId);
	}

	/**
	 * mutator method for interactionUserId
	 * @param uuid | string $newInteractionUserId value of new interaction user id
	 * @throws \RangeException if the $newInteractionUserId is not positive
	 * @throws \TypeError if $newInteractionUserId is not positive
	 * */

	public function setInteractionUserId($newInteractionUserId): void {
		try {
			$uuid = self::validateUuid($newInteractionUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store interactionUserId
		$this->interactionUserId = $uuid;

	}

	/**
	 * accessor method for interactionRecipeId
	 * @returns Uuid value of interactionRecipeId
	 */

	public function getInteractionRecipeId(): Uuid {
		return ($this->interactionRecipeId);
	}

	/**
	 * mutator method for interactionRecipeId
	 * @param uuid | string $newInteractionRecipeId value of new interaction user id
	 * @throws \RangeException if the $newInteractionRecipeId is not positive
	 * @throws \TypeError if $newInteractionRecipeId is not positive
	 * */

	public function setInteractionRecipeId($newInteractionRecipeId): void {
		try {
			$uuid = self::validateUuid($newInteractionRecipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		//convert and store interactionRecipeId
		$this->interactionRecipeId = $uuid;

	}

	/**
	 * accessor method for interaction date
	 *
	 * @return \DateTime value of interaction date
	 */

	public function getInteractionDate(): \DateTime {
		return ($this->interactionDate);
	}

	/**
	 *mutator method for interaction date
	 *
	 * @param \DateTime|string|null $newInteractionDate interaction date as  a datetime object or string ( or null to load to current)
	 * @throws \InvalidArgumentException if $newInteractionDate is not a valid object or string
	 * @throws \RangeException if $newInteractionDate is a date that does not exist
	 */

	public function setInteractionDate($newInteractionDate): void {

		//base case: if the date is null,  use the current date and time
		if($newInteractionDate === null) {
			$this->interactionDate = new \DateTime();
			return;
		}

		//store the interaction date using the validateDateTime trait
		try {
			$newInteractionDate = self::validateDateTime($newInteractionDate);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->interactionDate = $newInteractionDate;
	}

	/**
	 * accessor method for interaction rating
	 *
	 * @return int value of interaction rating
	 */

	public function getInteractionRating(): ?int {
		return ($this->interactionRating);
	}

	/**
	 * mutator method for interaction rating
	 *
	 * @param integer $newInteractionRating new value of interaction rating
	 * @throws \InvalidArgumentException if $newInteractionRating is not a integer or insecure
	 * @throws \TypeError if $newInteractionRating is not a integer
	 * @throws \RangeException if less than 1 or greater than 5
	 *
	 **/

	public function setInteractionRating(?int $newInteractionRating): void {
		//verifies int interaction rating is secure
		$newInteractionRating = filter_var($newInteractionRating, FILTER_VALIDATE_INT);
		if(empty($newInteractionRating) === true) {
			throw(new \InvalidArgumentException("Rating is empty or insecure"));
		}

		if($newInteractionRating <= 0 or $newInteractionRating > 5) {
			throw(new \RangeException("Integer needs to be a value 1 thru 5"));
		}

		//store the interaction rating
		$this->interactionRating = $newInteractionRating;

	}


	/**
	 * inserts this interaction in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL has a failed connection
	 * @throws \TypeError if $pdo is not a PDO connection subject
	 */


	public function insert(\PDO $pdo): void {
		//create query template
		$query = "INSERT INTO interaction (interactionUserId, interactionRecipeId, interactionDate, interactionRating)
		VALUES (:interactionUserId, :interactionRecipeId, :interactionDate, :interactionRating)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template

		$formattedDate = $this->interactionDate->format("Y-m-d H:i:s.u");
		$parameters = ["interactionUserId" => $this->interactionUserId->getBytes(), "interactionRecipeId" => $this->interactionRecipeId->getBytes(),
			"interactionDate" => $formattedDate, "interactionRating" => $this->interactionRating];
		$statement->execute($parameters);

	}

	/**
	 * deletes this interaction from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */


	public function delete(\PDO $pdo): void {
		//create query template
		$query = "DELETE FROM interaction WHERE interactionUserId = :interactionUserId AND interactionRecipeId =:interactionRecipeId";
		$statement = $pdo->prepare($query);
		$parameters = ["interactionUserId" => $this->interactionUserId->getBytes(), "interactionRecipeId" => $this->interactionRecipeId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * updates this interaction in mySQL
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */


	public function update(\PDO $pdo): void {

		//creates query template
		$query = "UPDATE interaction SET interactionRating = :interactionRating WHERE interactionUserId = :interactionUserId and interactionRecipeId = :interactionRecipeId";
		$statement = $pdo->prepare($query);

		$parameters = ["interactionUserId" => $this->interactionUserId->getBytes(), "interactionRecipeId" => $this->interactionRecipeId->getBytes(),
			"interactionDate" => $this->interactionDate, "interactionRating" => $this->interactionRating];
		$statement->execute($parameters);
	}

	/**
	 * gets interaction by interactionRecipeId and interactionUserId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $interactionRecipeId recipe Id to search for
	 * @param Uuid|string $interactionUserId user id to search for
	 * @return User|null interaction found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable are not the correct data type
	 */

	public static function getInteractionByInteractionRecipeIdAndInteractionUserId(\PDO $pdo, string $interactionRecipeId, string $interactionUserId):
	?Interaction {
		//sanitize the interactionRecipeIdAndInteractionUserId before searching
		try {
			$interactionRecipeId = self::validateUuid($interactionRecipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		try {
			$interactionUserId = self::validateUuid($interactionUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template

		$query = "SELECT interactionUserId, interactionRecipeId, interactionDate, interactionRating 
					FROM interaction WHERE interactionRecipeId = :interactionRecipeId AND interactionUserId = :interactionUserId";
		$statement = $pdo->prepare($query);

		//bind the interaction recipe id and user id to the place holder in the template
		$parameters = ["interactionRecipeId" => $interactionRecipeId->getBytes(), "interactionUserId" => $interactionUserId->getBytes()];
		$statement->execute($parameters);

		//grab the interaction from mySQL
		try {
			$interaction = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$interaction = new Interaction($row["interactionUserId"], $row["interactionRecipeId"], $row["interactionDate"], $row["interactionRating"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($interaction);
	}


	/**
	 * gets the Interaction by userId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $interactionUserId interaction user id to search for
	 * @return \SplFixedArray array of Interactions found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getInteractionByInteractionUserId(\PDO $pdo, string $interactionUserId): \SplFixedArray {
		try {
			$interactionUserId = self::validateUuid($interactionUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT interactionUserId, interactionRecipeId, interactionDate, interactionRating FROM interaction WHERE interactionUserId = :interactionUserId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["interactionUserId" => $interactionUserId->getBytes()];
		$statement->execute($parameters);
		// build the array of likes
		$interactions = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$interaction = new Interaction($row["interactionUserId"], $row["interactionRecipeId"], $row["interactionDate"], $row["interactionRating"]);
				$interactions[$interactions->key()] = $interaction;
				$interactions->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($interactions);
	}

	/**
	 * gets the Interaction by recipe id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param string $interactionRecipeId interaction Recipe id to search for
	 * @return \SplFixedArray array of Interactions found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getInteractionByInteractionRecipeId(\PDO $pdo, string $interactionRecipeId): \SplFixedArray {
		try {
			$interactionRecipeId = self::validateUuid($interactionRecipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		// create query template
		$query = "SELECT interactionUserId, interactionRecipeId, interactionDate, interactionRating FROM interaction WHERE interactionRecipeId = :interactionRecipeId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$parameters = ["interactionRecipeId" => $interactionRecipeId->getBytes()];
		$statement->execute($parameters);
		// build the array of likes
		$interactions = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$interaction = new Interaction($row["interactionUserId"], $row["interactionRecipeId"], $row["interactionDate"], $row["interactionRating"]);
				$interactions[$interactions->key()] = $interaction;
				$interactions->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($interactions);
	}


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/


	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["interactionUserId"] = $this->interactionUserId->toString();
		$fields["interactionRecipeId"] = $this->interactionRecipeId->toString();
		return ($fields);
	}

}