<?php

namespace TheDeepDiveDawgs\communitycookbook;

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
	 * @param string|Uuid $newInteractionUserId user id of this interaction  or null if new interaction
	 * @param string|Uuid $newInteractionRecipeId recipe id of this interaction or null if new interaction
	 * @param \DateTime|string|null $newInteractionDate date and time of interaction was submitted or null if set to current date and time
	 * @param \int $newInteractionRating rating of interaction
	 * @throws \InvalidArgumentException if data types not Invalid
	 * @throws \RangeException if data values are out of bounds
	 * @throws \TypeError if data violates type hints
	 * @throws \Exception if some other Exception occurs
	 */

	public function __construct($newInteractionUserId, $newInteractionRecipeId, $newInteractionDate, $newInteractionRating = null) {
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

	/**accessor method for interactionUserId
	 * @return Uuid value of interactionUserId
	 **/
	public function getInteractionUserId(): Uuid {
		return ($this->interactionUserId);
	}

	/**
	 * mutator method for interactionUserId
	 * @param uuid | string $newInteractionUserId value of new interaction user id
	 * @throws \RangeException if the $interactionUserId is not positive
	 * @throws \TypeError if $interactionUserId is not positive
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
	 * @throws \RangeException if the $interactionRecipeId is not positive
	 * @throws \TypeError if $interactionRecipeId is not positive
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

	public function setInteractionDate($newInteractionDate = null): void {
		//base case: if the date is null,  use the current date and time
		if($newInteractionDate === null) {
			$this->interactionDate = new \DateTime();
			return;
		}
		//store the interaction date using the ValidateDate trait
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

	public function getInteractionRating(): int {
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

	public function setInteractionRating(int $newInteractionRating): void {
		//verifies int interaction rating is secure
		$newInteractionRating = filter_var($newInteractionRating, FILTER_VALIDATE_INT);
		if(empty($newInteractionRating) === true) {
			throw(new \InvalidArgumentException("Rating is empty or insecure"));
		}

		if($newInteractionRating <=0 or $newInteractionRating >5) {
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
		$query = "INSERT INTO interaction (interactionUserId, interactionRecipeId, interactionDateId, interactionRatingId)
		VALUES (:interactionUserId, :interactionRecipeId, :interactionDateId, :interactionRatingId)";
		$statement = $pdo->prepare($query);

		//bind the member variables to the place holders in the template
		$parameters = ["interactionUserId" => $this->interactionUserId, "interactionRecipeId" => $this->interactionRecipeId, "interactionDate" => $this->interactionDate, "interactionRating" => $this->interactionRating];
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
		$query = "DELETE FROM interaction WHERE interactionUserId = :interactionUserId";
		$parameters = ["interactionUserId" => $this->interactionUserId->getBytes()];
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
		$query ="UPDATE interaction SET interactionUserId = :interactionUserId, interactionRecipeId = :interactionRecipeId, interactionDateId = :interactionDateId, interactionRatingId = :interactionRatingId WHERE interactionUserId = :interactionUserId";
		$statement = $pdo->prepare($query);

		$parameters = ["interactionUserId" => $this->interactionUserId->getBytes(),
			"interactionRecipeId" => $this->interactionRecipeId, "interactionDate, => $this->interactionDate"]
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/


	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["interactionUserId"] = $this->interactionUserId->toString();
		return ($fields);
	}

}