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
 *recipeId (primary key)
recipeCategoryId (foreign key)
recipeUserId (foreign key)
recipeDescription
recipeImageUrl
recipeIngredients
recipeMinutes...next
recipeName
recipeNumberIngredients
recipeNutrition
recipeSteps
recipeSubmissionDate
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
use Ramsey\Uuid\Uuid;
/** docblock section of recipe setting up the classes for recipe section of PDO*/
class Recipe implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this recipe; this is the primary key
	 * @var  Uuid $recipeId
	 **/
	private $recipeId;
	/**
	 * at Ingredients for this recipe; this is a unique index
	 * @var string $recipeId
	 **/
	private $recipecategoryId;
	/**
	 * to identify recpie type for sorting and searching purposes.
	 *v@var $recipecategoryId
	 **/
	private $recipeUserId;
	/**
	 * description for this recipe; this is a unique index
	 * @var string $recipeDescription
	 **/
	private $recipeDescription;
	/**
	 * imageUrl for recipe so as retrive and display user suplyed recipe images
	 * @var $recipeImageUrl
	 **/
	private $recipeImageUrl;
	/**
	 * ingredients for this recipe
	 * @var string $recipeIngredients
	 **/
	private $recipeIngredients;
	/**
	 * @var string $recipeMinutes
	 */
	private $recipeMinutes;
	/**
	 * name or tittle of recipe
	 * @var $recipeName
	 **/
	private $recipeName;
	/**
	 * phone number for this recipe
	 * @var string $recipePhone
	 **/
	private $recipeIngredients;

	/**
	 * constructor for this recipe
	 * @param Uuid | string $newRecipeId new user id
	 * @param string $newRecipecategoryId
	 * @param string $newRecipeUserId
	 * @param string $newRecipeDescription address
	 * @param string $newRecipeImageUrl new password
	 * @param string $newRecipeIngredients
	 * @trows \RangeException if data vales are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \InvalidArgumentException if data types are not valid
	 **/
	public function __construct($newRecipeId, $newRecipecategoryId, $newRecipeUserId, $newRecipeDescription, $newRecipeImageUrl, $newRecipeIngredients) {
		try {
			$this->setRecipeId($newRecipeId);
			$this->setRecipecategoryId($newRecipecategoryId);
			$this->setRecipeUserId($newRecipeUserId);
			$this->setRecipeDescription($newRecipeDescription);
			$this->setRecipeImageUrl($newRecipeImageUrl);
			$this->setRecipeIngredients($newRecipeIngredients);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {

			//deturmine what exeption type was thrown
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
		return ($this->recipeId);
	}

	/**
	 * mutator method for recipe id
	 *
	 * @param Uuid| string $newrecipeId value of new recipe id
	 * @throws \RangeException if $newrecipeId is not positive
	 * @throws \TypeError if the recipe Id is not
	 **/
	public function setRecipeId($newRecipeId): string {
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
	 * accessor method for account activation token
	 *
	 * @return string value of the activation token
	 */
	public function getRecipeCategoryId(): string {
		return ($this->recipecategoryId);
	}

	/**
	 * mutator method for account activation token
	 *
	 * @param string $newRecipecategoryId
	 * @throws \InvalidArgumentException  if the token is not a string or insecure
	 * @throws \RangeException if the token is not exactly 32 characters
	 * @throws \TypeError if the activation token is not a string
	 */
	public function setRecipecategoryId(string $newRecipecategoryId): string {
		if($newRecipecategoryId === null) {
			$this->recipecategoryId = null;
			return;
		}
		$newRecipecategoryId = strtolower(trim($newRecipecategoryId));
		if(ctype_xdigit($newRecipecategoryId) === false) {
			throw(new\RangeException("recipe id is not valid"));
		}
		//make sure user activation token is only 32 characters
		if(strlen($newRecipecategoryId) !== 32) {
			throw(new\RangeException("user activation token has to be 32"));
		}
		$this->recipecategoryId = $newRecipecategoryId;
	}

	/**
	 *
	 * accessor method for at Description
	 *
	 * @return string value of at Description
	 **/
	public function getRecipeDescription(): string {
		return $this->recipeDescription;
	}

	/**
	 * mutator method for at avatar
	 *
	 * @return  string value of avatar or null
	 * */
	public function getRecipeUserId(): string {
		return ($this->recipeUserId);
	}

	/**
	 * mutator method for recipe user id
	 *
	 * @param string $newRecipeUserId new value of avatar
	 * @throws \InvalidArgumentException if $newAvatar is not a string or insecure
	 * @throws \RangeException if $newAvatar is > 32 characters
	 * @throws \TypeError if $newAvatar is not a string
	 **/
	public function setRecipeUserId(string $newRecipeUserId): string {
		// if $recipeUserId is null return it right away
		If($newRecipeUserId === null) {
			$this->recipeUserId = null;
			return;
		}
// verify the avatar is secure
		$newRecipeUserId = trim($newRecipeUserId);
		$newRecipeUserId = filter_var($newRecipeUserId, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeUserId) === true) {
			throw(new \InvalidArgumentException("Recipe URL is empty or insecure"));
		}
		// verify the avatar will fit in the database
		if(strlen($newRecipeUserId) > 255) {
			throw(new \RangeException("Avatar is too large"));
		}
		// store the Avatar
		$this->recipeUserId = $newRecipeUserId;
	}

	/**
	 * mutator method for description
	 *
	 * @param string $newRecipeDescription new value of description
	 * @throws \InvalidArgumentException if $newDescription is not a valid description or insecure
	 * @throws \RangeException if $newDescription is > 128 characters
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
		if(strlen($newRecipeDescription) > 128) {
			throw(new \RangeException("recipe description is too large"));
		}
		// store the description
		$this->recipeDescription = $newRecipeDescription;
	}

	/**
	 * accessor method for recipeImageUrl
	 *
	 * @return string for recipeImageUrl imageUrl password
	 */
	public function getRecipeImageUrl(): string {
		return ($this->recipeImageUrl);
	}

	/**
	 * mutator method for recipe imageUrl
	 *
	 * @param string $newrecipeImageUrl vale of new recipe imageUrl
	 * @throws \InvalidArgumentException if the imageUrl is not secure
	 * @throws \RangeException if the imageUrl is not 128 characters
	 * @throws \TypeError if recipe imageUrl is not a string
	 */
	public function setRecipeImageUrl(string $newRecipeImageUrl): string {
		//enforce that the imageUrl is properly formatted
		$newRecipeImageUrl = trim($newRecipeImageUrl);
		$newRecipeImageUrl = strtolower($newRecipeImageUrl);
		if(empty($newRecipeImageUrl) === true) {
			throw(new \InvalidArgumentException("recipe password imageUrl empty or insecure"));
		}
		//enforce the imageUrl is string represention of a hexadecimal
		//$recipeImageUrlInfo = password_get_info($newrecipeImageUrl);
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
	 * @return string value of Ingredients
	 **/
	public function getRecipeIngredients(): string {
		return ($this->recipeIngredients);
	}

	/**
	 * mutator method for Ingredients
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
		if(strlen($newRecipeIngredients) > 32) {
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
	public function getRecipeMinutes(): string {
		return ($this->recipeMinutes);
	}

	/**
	 * mutator method for Minutes
	 *
	 * @param string $newMinutes
	 **/
	public function setRecipeMinutes(string $newRecipeMinutes): string {
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
	 * @return string value of name
	 **/
	public function getRecipeName(): string {
		return ($this->recipeName);
	}

	/**
	 * mutator method for recipeName
	 *
	 * @param string $newName
	 **/
	public function setRecipeName(string $newRecipeName): string {
		// verify the name is secure
		$newRecipeName = trim($newRecipeName);
		$newRecipeName = filter_var($newRecipeName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeName) === true) {
			throw(new \InvalidArgumentException("name field is empty"));
		}
		// verify the at handle will fit in the database
		if(strlen($newRecipeName) > 32) {
			throw(new \RangeException("Name or recpie is too long"));
		}
		// store the name
		$this->recipeName = $newRecipeName;
	}

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["recipeId"] = $this->recipeId->toString();
		unset($fields["recipeImageUrl"]);
		return ($fields);
	}
}
