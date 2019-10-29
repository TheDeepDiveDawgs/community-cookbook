<?php
//recipeId (primary key)
//recipeCategoryId (foreign key)
//recipeUserId (foreign key)
//recipeDescription
//recipeImageUrl
//recipeIngredients
//recipeMinutes
//recipeName
//recipeNumberIngredients
//recipeNutrition
//recipeSteps
//recipeSubmissionDate
/**
 *this is a doc block for the recipe Capstone, it needs lost.
 * 
 *recipeId (primary key) binary 16 not null
recipeCategoryId (foreign key) binary 16 not null
recipeUserId (foreign key)binary 16 not null
recipeDescription varchar 3000
recipeImageUrl varchar 255
recipeIngredients varchar 2000 not null
recipeMinutes small int not null
recipeName varchar 100 not null
recipeNumberIngredients big int 4 not null
recipeNutrition varchar 255
recipeSteps varchar 3000 not null
recipeSubmissionDate datetime not null
 * 
 * This is going to br the PDO getters and setters for recipes on our cookbook capstone.
 * @recipe Damian Arya <darya@cnm.edu>
 */
namespace Darya\recipesCapstone;

require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");
/** @recipe Damian Arya <darya@cnm.edu
 *@version (7.3)
 */

use DateTime;
use MongoDB\BSON\Binary;
use Ramsey\Uuid\Uuid;
/** docblock section of recipe setting up the classes for recipe section of PDO of capstone*/
class Recipe implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this recipe; this is the primary key
	 * @var  Binary $recipeId
	 **/
	private $recipeId;
	/**
	 *  to identify recipe type for sorting and searching purposes.
	 * @var Binary $recipecategoryId
	 **/
	private $recipeCategoryId;
	/**
	 * to identify recipe type for sorting and searching purposes.
	 * @var Binary $recipeUserId
	 **/
	private $recipeUserId;
	/**
	 * description for this recipe; this is a unique index
	 * @var string $recipeDescription
	 **/
	private $recipeDescription;
	/**
	 * imageUrl for recipe so as retrieve and display user supplies recipe images
	 * @var string $recipeImageUrl
	 **/
	private $recipeImageUrl;
	/**
	 * ingredients for this recipe
	 * @var string $recipeIngredients
	 **/
	private $recipeIngredients;
	/**
	 * minuets to make this dish
	 * @var string $recipeMinutes
	 */
	private $recipeMinutes;
	/**
	 * name or tittle of recipe
	 * @var string $recipeName
	 **/
	private $recipeName;
	/**
	 * number of ingredients for this recipe
	 * @var INT $recipeNumberIngredients
	 **/
	private $recipeNumberIngredients;
	/**
	 * nutritional info for this recipe
	 * @var string $recipeNutrition
	 **/
	private $recipeNutrition;
	/**
	 * steps to make this recipe
	 * @var string $recipeSteps
	 **/
	private $recipeSteps;
	/**
	 * date the recipe was submitted
	 * @var \DateTime $recipeSubmissionDate
	 **/
	private $recipeSubmissionDate;
	/**
	 * constructor for this recipe
	 * @param Binary $newRecipeId new user id
	 * @param Binary $newRecipecategoryId
	 * @param Binary $newRecipeUserId
	 * @param string $newRecipeDescription address
	 * @param string $newRecipeImageUrl new password
	 * @param string $newRecipeIngredients
	 * @param int    $newRecipeMinutes
	 * @param string $newRecipeName
	 * @param string $newRecipeNutrition
	 * @param INT $newRecipeNumberIngredients
	 * @param string $newRecipeSteps
	 * @param datetime $newRecipeSubmissionDate
	 * @trows \RangeException if data vales are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \InvalidArgumentException if data types are not valid
	 **/
	public function __construct($newRecipeId, $newRecipeCategoryId, $newRecipeUserId, $newRecipeDescription, $newRecipeImageUrl, $newRecipeIngredients, $newRecipeMinutes, $newRecipeName, $newRecipeNumberIngredients, $newRecipeNutrition, $newRecipeSteps, $newRecipeSubmissionDate) {
		try {
			$this->setRecipeId($newRecipeId);
			$this->setRecipecategoryId($newRecipeCategoryId);
			$this->setRecipeUserId($newRecipeUserId);
			$this->setRecipeDescription($newRecipeDescription);
			$this->setRecipeImageUrl($newRecipeImageUrl);
			$this->setRecipeIngredients($newRecipeIngredients);
			$this->setRecipeMinutes($newRecipeMinutes);
			$this->setRecipeName($newRecipeName);
			$this->setRecipeNumberIngredients($newRecipeNumberIngredients);
			$this->setRecipeNutrition($newRecipeNutrition);
			$this->setRecipeSteps($newRecipeSteps);
			$this->setRecipeSubmissionDate($newRecipeSubmissionDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 97, $exception));
		}
	}
	/**
	 * Specify data which should be serialized to JSON
	 * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */

	/**
	 * accessor method for recipe id
	 *
	 * @return  Uuid value of recipe id (or null if new recipe)
	 * */
	public function getRecipeId(): Uuid {
		return
		$this->recipeId;
	}

	/**
	 * mutator method for recipe id
	 *
	 * @param Uuid| string $newrecipeId value of new recipe id
	 * @throws \RangeException if $newrecipeId is not positive
	 * @throws \TypeError if the recipe Id is not
	 **/
	public function setRecipeId($newRecipeId): Uuid\ {
		try {
			$uuid = self::validateUuid($newRecipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the recipe id
		$this->recipeId = $uuid;
	}

	/**
	 * accessor method for recipeCategoryId
	 *
	 * @return string value of the recipeCategoryId
	 */
	public function getRecipeCategoryId(): Uuid {
		return ($this->recipeCategoryId);
	}

	/**
	 * mutator method for recipeCategoryId
	 *
	 * @param string $newRecipeCategoryId
	 * @throws \InvalidArgumentException  if the recipeCategoryId is not a string or insecure
	 * @throws \RangeException if the recipeCategoryId is not exactly 16 characters
	 * @throws \TypeError if the recipeCategoryId is not a string
	 */
	public function setRecipecategoryId(Uuid $newRecipecategoryId): Uuid {
		if($newRecipecategoryId === null) {
		return $this->recipecategoryId = null;
		}
		$newRecipeCategoryId = strtolower(trim($newRecipecategoryId));
		if(ctype_xdigit($newRecipecategoryId) === false) {
			throw(new\RangeException("recipe id is not valid"));
		}
		//make sure recipeCategoryId is only 16 characters
		if(strlen($newRecipecategoryId) !== 16) {
			throw(new\RangeException(" category type invalid"));
		}
		$this->recipecategoryId = $newRecipecategoryId;
	}

	/**
	 *
	 * accessor method for at recipeUserId
	 *
	 * @return string value of at recipeUserId
	 **/
	public function getRecipeUserId(): string {
	return $this->recipeUserId;
	}

	/**
	 * mutator method for recipeUserId
	 * 	 *
	 * @param string $newRecipeUserId new value of recipeUserId
	 * @throws \InvalidArgumentException if $newRecipeUserId is not a valid recipeUserId or insecure
	 * @throws \RangeException if $newRecipeUserId is > 16 characters
	 * @throws \TypeError if $newRecipeUserId is not a Uuid
	 *@return  string value of avatar or null
	 * */
	public function getRecipeUserId(): Uuid\ {
		return ($this->recipeUserId);
	}

	/**
	 * mutator method for recipe user id
	 *
	 * @throws \TypeError if $newAvatar is not a string
	 **/
	public function setRecipeUserId(string $newRecipeUserId): Uuid\ {
		// if $recipeUserId is null return it right away
		If($newRecipeUserId === null) {
			$this->recipeUserId = null;
			return;
		}
// verify the recipeUserId is secure
		$newRecipeUserId = trim($newRecipeUserId);
		$newRecipeUserId = filter_var($newRecipeUserId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeUserId) === true) {
			throw(new \InvalidArgumentException("Recipe URL is empty or insecure"));
		}
		// verify the avatar will fit in the database
		if(strlen($newRecipeUserId) > 16) {
			throw(new \RangeException("user id is incorrect"));
		}
		// store the Avatar
		$this->recipeUserId = $newRecipeUserId;
	}
		/**
		 *
		 * accessor method for Description
		 *
		 * @return string value of at Description
		 **/
	public function getRecipeDescription(): string {
	return $this->recipeDescription;
}

	/**
	 * mutator method for description
	 *
	 * @param string $newRecipeDescription new value of description
	 * @throws \InvalidArgumentException if $newDescription is not a valid description or insecure
	 * @throws \RangeException if $newDescription is > 3000 characters
	 * @throws \TypeError if $newDescription is not a string
	 **/
	public function setRecipeDescription(string $newRecipeDescription): string  {
		// verify the description is secure
		$newRecipeDescription = trim($newRecipeDescription);
		$newRecipeDescription = filter_var($newRecipeDescription, FILTER_VALIDATE_EMAIL);
		if(empty($newRecipeDescription) === true) {
			throw(new \InvalidArgumentException("recipe description is empty or insecure"));
		}
		// verify the description will fit in the database
		if(strlen($newRecipeDescription) > 3000) {
			throw(new \RangeException("recipe description is too large"));
		}
		// store the description
		$this->recipeDescription = $newRecipeDescription;
	}

	/**
	 * accessor method for recipeImageUrl
	 *
	 * @return string for recipeImageUrl
	 */
	public function getRecipeImageUrl(): string {
		return ($this->recipeImageUrl);
	}

	/**
	 * mutator method for recipe imageUrl
	 *
	 * @param string $newrecipeImageUrl vale of new recipe imageUrl
	 * @throws \InvalidArgumentException if the imageUrl is not secure
	 * @throws \RangeException if the recipeImageUrl is not 255 characters
	 * @throws \TypeError if recipeImageUrl is not a string
	 */
	public function setRecipeImageUrl(string $newRecipeImageUrl): string {
		//enforce that the imageUrl is properly formatted
		$newRecipeImageUrl = trim($newRecipeImageUrl);
		$newRecipeImageUrl = strtolower($newRecipeImageUrl);
		if(empty($newRecipeImageUrl) === true) {
			throw(new \InvalidArgumentException("image load issue"));
		}
		//enforce the imageUrl is string representation of a hexadecimal
		//$recipeImageUrlInfo = password_get_info($newRecipeImageUrl);
		if(!ctype_xdigit($newRecipeImageUrl)) {
			throw(new \InvalidArgumentException("recipe passphrase is empty or insecure"));
		}
		//enforce that the imageUrl is exactly 128 characters.
		if(strlen($newRecipeImageUrl) !== 128) {
			throw(new \RangeException("recipe imageUrl must be 128 characters"));
		}
		//store the imageUrl
		$this->recipeImageUrl = $newRecipeImageUrl;
	}

	/**
	 * accessor method for Ingredients
	 *
	 * @return string value of recipeIngredients
	 **/
	public function getRecipeIngredients(): string {
		return ($this->recipeIngredients);
	}

	/**
	 * mutator method for recipeIngredients
	 * @throws \InvalidArgumentException if the recipeIngredients is not secure
	 * @throws \RangeException if the recipeingredients is more then 2000 characters
	 * @throws \TypeError if recipeIngredients is not a string
	 *
	 * @param string $newRecipeIngredients
	 **/
	public function setRecipeIngredients(string $newRecipeIngredients): string {
		// verify the ingredients is secure
		$newRecipeIngredients = trim($newRecipeIngredients);
		$newRecipeIngredients = filter_var($newRecipeIngredients, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeIngredients) === true) {
			throw(new \InvalidArgumentException("Ingredients field is empty"));
		}
		// verify the at handle will fit in the database
		if(strlen($newRecipeIngredients) > 2000) {
			throw(new \RangeException("Ingredient name is too large"));
		}
		// store the Ingredients
		$this->recipeIngredients = $newRecipeIngredients;
	}

	/**
	 * accessor method for minutes
	 *
	 * @return string value of minutes
	 **/
	public function getRecipeMinutes(): int {
		return ($this->recipeMinutes);
	}

	/**
	 * mutator method for Minutes
	 *	 * @throws \InvalidArgumentException if the recipeMinutes is not secure
	 * @throws \RangeException if the recipeMinutes is not 4 characters
	 * @throws \TypeError if recipeMinutes imageUrl is not a string
	 * @param string $newRecipeMinutes
	 **/
	public function setRecipeMinutes(string $newRecipeMinutes): int {
		// verify the minutes is secure
		$newRecipeIngredients = trim($newRecipeMinutes);
		$newRecipeMinutes = filter_var($newRecipeMinutes, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeMinutes) === true) {
			throw(new \InvalidArgumentException("Minutes field is empty"));
		}
		// verify the at handle will fit in the database
		if(strlen($newRecipeMinutes) > 32) {
			throw(new \RangeException("Too many digits in minutes field"));
		}
		// store the Minutes
		$this->recipeMinutes = $newRecipeMinutes;
	}

	/**
	 * accessor method for name
	 *
	 * @return string value of recipeName
	 **/
	public function getRecipeName(): string {
		return ($this->recipeName);
	}

	/**
	 * mutator method for recipeName @throws \InvalidArgumentException if the recipeName is not secure
	 * @throws \RangeException if the recipeName is more then 100 characters
	 * @throws \TypeError if recipe recipeName is not a string
	 * @param string $newRecipeName
	 **/
	public function setRecipeName(string $newRecipeName): string {
		// verify the name is secure
		$newRecipeName = trim($newRecipeName);
		$newRecipeName = filter_var($newRecipeName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeName) === true) {
			throw(new \InvalidArgumentException("Recipe name field is empty"));
		}
		// verify the at handle will fit in the database
		if(strlen($newRecipeName) > 100) {
			throw(new \RangeException("Recipe name is too long"));
		}
		// store the name
		$this->recipeName = $newRecipeName;
	}

	/**
	 * accessor method for recipeNumberIngredients
	 *
	 * @return string value of recipeNumberIngredients
	 **/
	public function getRecipeNumberIngredients(): string {
		return ($this->recipeNumberIngredients);
	}

	/**
	 * mutator method for recipeNumberIngredients
	 *	 *	 * @throws \InvalidArgumentException if the recipeName is not secure
	 * @throws \RangeException if the recipeNumberIngredients is more then 32 characters
	 * @throws \TypeError if recipeNumberIngredients is not a string
	 * @param string $newrRecipeNumberIngredients
	 **/
	public function setRecipeNumberIngredients(string $newrRecipeNumberIngredients): string {
		// verify the name is secure
		$newrRecipeNumberIngredients = trim($newrRecipeNumberIngredients);
		$newrRecipeNumberIngredients = filter_var($newrRecipeNumberIngredients, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newrRecipeNumberIngredients) === true) {
			throw(new \InvalidArgumentException("number of ingredients field is empty"));
		}
		// verify the at handle will fit in the database
		if(strlen($newrRecipeNumberIngredients) > 32) {
			throw(new \RangeException("Too many ingredients"));
		}
		// store the number of ingredients
		$this->recipeNumberIngredients = $newrRecipeNumberIngredients;
	}

	/**
	 * accessor method for recipeNutrition
	 *
	 * @return string value of recipeNutrition
	 **/
	public function getRecipeNutrition(): string {
		return ($this->recipeNutrition);
	}

	/**
	 * mutator method for recipeNutrition
	 *	 *	 * @throws \InvalidArgumentException if the recipeNutrition is not secure
	 * @throws \RangeException if the recipeNutrition is not 128 characters
	 * @throws \TypeError if recipeNutrition is not a string
	 * @param string $newRecipeNutrition
	 **/
	public function setRecipeNutrition(string $newRecipeNutrition): string {
		// verify the nutrition data is secure
		$newRecipeNutrition = trim($newRecipeNutrition);
		$newRecipeNutrition = filter_var($newRecipeNutrition, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newrRecipeNutrition) === true) {
			throw(new \InvalidArgumentException("nutritional info field is empty"));
		}
		// verify the at handle will fit in the database
		if(strlen($newRecipeNutrition) > 255) {
			throw(new \RangeException("Nutrition info is too long"));
		}
		// store the nutritional facts
		$this->recipeNutrition = $newRecipeNutrition;
	}

	/**
	 * accessor method for recipeSteps
	 *
	 * @return string value of recipeSteps
	 **/
	public function getRecipeSteps(): string {
		return ($this->recipeSteps);
	}

	/**
	 * mutator method for recipeSteps
	 *	 *	 * @throws \InvalidArgumentException if the recipeSteps is not secure
	 * @throws \RangeException if the recipeSteps is not 128 characters
	 * @throws \TypeError if recipeSteps is not a string
	 * @param string $newrRecipeSteps
	 **/
	public function setRecipeSteps(string $newRecipeSteps): string {
		// verify the steps data is secure
		$newRecipeSteps = trim($newRecipeSteps);
		$newRecipeSteps = filter_var($newRecipeSteps, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeSteps) === true) {
			throw(new \InvalidArgumentException("steps must be added"));
		}
		// verify the at handle will fit in the database
		if(strlen($newRecipeSteps) > 3000) {
			throw(new \RangeException(" too many steps"));
		}
		// store the recipe steps
		$this->recipeSteps = $newRecipeSteps;
	}

	/**
	 * accessor method for recipeSubmissionDate
	 *
	 * @return string value of recipeSubmissionDate
	 **/
	public function getRecipeSubmissionDate(): datetime {
		return ($this->recipeSubmissionDate);
	}

	/**
	 * mutator method for recipeSubmissionDate
	 * @throws \InvalidArgumentException if the recipeSubmissionDate is not secure
	 * @throws \RangeException if the recipeSubmissionDate is not 128 characters
	 * @throws \TypeError if recipeSubmissionDate is not a string
	 * @param string $newrRecipeSubmissionDate
	 **/
	public function setRecipeSubmissionDate(string $newRecipeSubmissionDate): datetime {
		// verify the submission data is secure
		$newRecipeSubmissionDate = trim($newRecipeSubmissionDate);
		$newRecipeSubmissionDate = filter_var($newRecipeSubmissionDate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeSubmissionDate) === true) {
			throw(new \InvalidArgumentException("date time error"));
		}
		// verify the at handle will fit in the database
		if(strlen($newRecipeSubmissionDate) > 32) {
			throw(new \RangeException("date time error"));
		}
		// store the recipe submission date
		$this->recipeSubmissionDate = $newRecipeSubmissionDate;
	}

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["recipeId"] = $this->recipeId-> String();
		unset($fields["recipeImageUrl"]);
		return ($fields);
	}
}
