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
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this recipe; this is the primary key
	 * @var  Binary $recipeId
	 **/
	private $recipeId;
	/**
	 *  to identify recipe type for sorting and searching purposes.
	 * @var Binary $recipeCategoryId
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
	 * @param Binary $newRecipeCategoryId
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
	public function __construct($newRecipeId,string $newRecipeCategoryId,string $newRecipeUserId,string $newRecipeDescription,string $newRecipeImageUrl,string $newRecipeIngredients,string $newRecipeMinutes,string $newRecipeName,string $newRecipeNumberIngredients,string $newRecipeNutrition,string $newRecipeSteps,string $newRecipeSubmissionDate) {
		try {
			$this->setRecipeId($newRecipeId);
			$this->setRecipeCategoryId($newRecipeCategoryId);
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
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
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
	public function getRecipeId(): void {
		return $this->recipeId;
	}

	/**
	 * mutator method for recipe id
	 *
	 * @param void| string $newrecipeId value of new recipe id
	 * @throws \RangeException if $newrecipeId is not positive
	 * @throws \TypeError if the recipe Id is not
	 **/
	public function setRecipeId($newRecipeId): void {
		try {
			$uuid = self::validateUuid($newRecipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class ($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the recipe id
		$this->recipeId = $newRecipeId;
	}

	/**
	 * accessor method for recipeCategoryId
	 *
	 * @return string value of the recipeCategoryId
	 */
	public function getRecipeCategoryId(): void {
		return $this->recipeCategoryId;
	}

	/**
	 * mutator method for recipeCategoryId
	 *
	 * @param void| string $newrecipeCategoryId value of new recipe id
	 * @throws \RangeException if $newRecipeCategoryId is not positive
	 * @throws \TypeError if the recipeCategoryId is not
	 **/
	public function setRecipeCategoryId($newRecipeCategoryId): void {
		try {
			$uuid = self::validateUuid($newRecipeCategoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class ($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the recipeCategoryId
		$this->recipeCategoryId = $newRecipeCategoryId;
	}

	/**
	 *
	 * accessor method for at recipeUserId
	 *
	 * @return void value of at recipeUserId
	 **/
	public function getRecipeUserId(): void {
	return $this->recipeUserId;
	}

	/**
	 * mutator method for recipeUserId
	 *
	 * @param void| string $newrecipeUserId value of new recipeUserId
	 * @throws \RangeException if $newRecipeUserId is not positive
	 * @throws \TypeError if the recipeUserId is not valid
	 **/
	public function setRecipeUserId($newRecipeUserId): void {
		try {
			$uuid = self::validateUuid($newRecipeUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class ($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the recipeUserId
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
		$newRecipeDescription = filter_var($newRecipeDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
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
		return $this->recipeImageUrl;
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
		return $this->recipeIngredients;
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
	 * @return int value of minutes
	 **/
	public function getRecipeMinutes(): int {
		return $this->recipeMinutes;
	}

	/**
	 * mutator method for Minutes
	 *
	 * * @param integer $newRecipeMinutes new value of minutes
	 *	 * @throws \InvalidArgumentException if  $recipeMinutes is not a interger or insecure
	 * @throws \RangeException if the $recipeMinutes is not a integer
	 * @throws \TypeError if $recipeMinutes is not a integer
	 *
	 **/
	public function setRecipeMinutes(int $newRecipeMinutes): void {
		// verify the minutes is secure
		$newRecipeMinutes = filter_var($newRecipeMinutes, FILTER_VALIDATE_INT);
		if(empty($newRecipeMinutes) === true) {
			throw(new \InvalidArgumentException("Minutes field is empty"));
		}
		// verify the at handle will fit in the database
		if($newRecipeMinutes <=0 or $newRecipeMinutes =>1000) {
			throw(new \RangeException("Minutes entered invalid, negative or too many"));
		}
		// store the minutes
		$this->recipeMinutes = $newRecipeMinutes;
	}

	/**
	 * accessor method for name
	 *
	 * @return string value of recipeName
	 **/
	public function getRecipeName(): string {
		return $this->recipeName;
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
	 * @return int value of recipeNumberIngredients
	 **/
	public function getRecipeNumberIngredients(): int {
		return $this->recipeNumberIngredients;
	}

	/**
	 * mutator method for recipeNumberIngredients
	 *  @param integer $newrRecipeNumberIngredients new value of recipeNumberIngredients
	 * @throws \InvalidArgumentException if $recipeNumberIngredients is not a integer or insecure
	 * @throws \RangeException if $recipeNumberIngredients is  les then one or more then 40 characters
	 * @throws \TypeError if $recipeNumberIngredients is not a integer
	 **/
	public function setRecipeNumberIngredients(int $newRecipeNumberIngredients): int {
		// verify the number of ingredients is secure
		$newRecipeNumberIngredients = filter_var($newRecipeNumberIngredients, FILTER_VALIDATE_INT);
		if(empty($newRecipeNumberIngredients) === true) {
			throw(new \InvalidArgumentException("number of ingredients field is empty"));
		}
		// verify the at handle will fit in the database
		if($newRecipeNumberIngredients <=0 or $newRecipeNumberIngredients =>40) {
			throw(new \RangeException("Too many ingredients"));
		}
		// store the number of ingredients
		$this->recipeNumberIngredients = $newRecipeNumberIngredients;
	}

	/**
	 * accessor method for recipeNutrition
	 *
	 * @return string value of recipeNutrition
	 **/
	public function getRecipeNutrition(): string {
		return $this->recipeNutrition;
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
		return $this->recipeSteps;
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
	 * @return \DateTime value of recipeSubmissionDate
	 **/
	public function getRecipeSubmissionDate(): datetime {
		return $this->recipeSubmissionDate;
	}

	/**
	 * mutator method for recipeSubmissionDate
	 *
	 * @param \DateTime |string|null $newrRecipeSubmissionDate interaction date as a datetime object or string (or null tp load current)
	 * @throws \InvalidArgumentException if $recipeSubmissionDate is not a valid object or string
	 * @throws \RangeException if the $recipeSubmissionDate is a date that does not exist
	 **/

	public function setRecipeSubmissionDate($newRecipeSubmissionDate = null): void {
		// if date is null, use the current date and time
		if($newRecipeSubmissionDate === null) {
			$this->recipeSubmissionDate = new \DateTime();
			return;
		}
		// store the submission date with ValidateDate trait
		try {
			$newRecipeSubmissionDate = self::validateDate($newRecipeSubmissionDate);
		}	catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw (new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// store the recipe submission date
		$this->recipeSubmissionDate = $newRecipeSubmissionDate;
	}
// THIS IS WHERE TO ADD THE PDO STUFF

	/**
	 * inserts recipe into mysql
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOExceptionwhen mysql related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */

	public  function insert(\PDO $pdo): void {
		//creates query template
		$query = "INSERT INTO recipe(recipeId, recipeCategoryId, recipeUserId, recipeDescription, recipeImageUrl, recipeIngredients, recipeMinutes, recipeName, recipeNumberIngredients, recipeNutrition, recipeSteps, recipeSummitionDate) VALUES (:recipeId, :recipeCategoryId, :recipeUserId, :recipeDescription, :recipeImageUrl, :recipeIngredients, :recipeMinutes, :recipeName, :recipeNumberIngredients, :recipeNutrition, :recipeSteps, :recipeSubmissionDate)";
		$statement = $pdo->prepare($query);
		// this creates relationship between php state variables and pdo/mysql variables
		$parameters = [
			"recipeId" => $this->recipeId->getBytes(),
			"recipeCategoryId" => $this->recipeCategoryId,
			"recipeUserId" => $this->recipeUserId,
			"recipeDescription" => $this->recipeDescription,
			"recipeImageUrl" => $this->recipeImageUrl,
			"recipeIngredients" =>$this->recipeIngredients,
			"recipeMinutes" =>$this->recipeMinutes,
			"recipeName" =>$this->recipeName,
			"recipeNumberIngredients" =>$this->recipeNumberIngredients,
			"recipeNutrition" =>$this->recipeNutrition,
			"recipeSteps" =>$this->recipeSteps,
			"recipeSubmissionDate" =>$this->recipeSubmissionDate,];
		$statement->execute($parameters);
	}

	/**
	 * deletes recipe from mysql database
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mysql related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 */
	public function delete(\PDO $pdo): void {
		//creates query template
		$query = "DELETE FROM recipe WHERE recipeId = :recipeId";
		$statement = $pdo->prepare($query);

		//creates relationship between php state variables and PDO/mysql variables
		$parameters = ["recipeID" => $this->recipeId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * update recipe in mysql database
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param $thisRecipeId
	 */
	public function  update(\PDO $pdo, $thisRecipeId): void {
		//create query template
		$query = "UPDATE recipe SET recipeId = :recipeId, recipeCategoryId = :recipeCategoryId, recipeUserId = :recipeUserId, recipeDescription = :recipeDescription, recipeImageUrl = :recipeImageUrl, recipeIngredients = :recipeIngredients, recipeMinutes = :recipeMinutes, recipeName = :recipeName, recipeNumberIngredients = :recipeNumberIngredients, recipeNutrition = :recipeNutrition, recipeSteps = :recipeSteps, recipeSubmissionDate = :recipeSubmissionDate WHERE recipeId = :recipeId";
		$statement = $pdo->prepare($query);
		//creates relationship between php state variables and pdo/mysql variables
		$parameters = [
			"recipeId" => $this->recipeId->getBytes(),
			"recipeCategoryId" => $this->recipeCategoryId,
			"recipeUserId" => $this->recipeUserId,
			"recipeDescription" => $this->recipeDescription,
			"recipeImageUrl" => $this->recipeImageUrl,
			"recipeIngredients" =>$this->recipeIngredients,
			"recipeMinutes" =>$this->recipeMinutes,
			"recipeName" =>$this->recipeName,
			"recipeNumberIngredients" =>$this->recipeNumberIngredients,
			"recipeNutrition" =>$this->recipeNutrition,
			"recipeSteps" =>$this->recipeSteps,
			"recipeSubmissionDate" =>$this->recipeSubmissionDate,];
		$statement->execute($parameters);
	}

	/**
	 * gets all Recipes
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of recipe found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllRecipe(\PDO $pdo) : \SPLFixedArray {
		// create query template
		$query = "SELECT recipeId, recipeCategoryId, recipeUserId, recipeDescription, recipeImageUrl, recipeIngredients, recipeMinutes, recipeName, recipeNumberIngredients, recipeNutrition, recipeSteps, recipeSubmissionDate FROM recipe";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of recipes
		$recipe = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$recipe = new Recipe($row["recipeId"], $row["recipeCategoryId"], $row["recipeUserId"], $row["recipeDescription"], $row["recipeImageUrl"], $row["recipeIngredients"], $row["recipeMinutes"], $row["recipeName"], $row["recipeNumberIngredients"], $row["recipeNutrition"], $row["recipeSteps"], $row["recipeSubmissionDate"]);
				$recipe[$recipe->key()] = $recipe;
				$recipe->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($recipe);
	}

	/**
	 * formats the state variables for Json serializable
	 *
	 * @return array resulting state variables to serialize
	 */
	public function jsonSerialize(): array {
		//this collects all state variables
		$fields = get_object_vars($this);
		//turns Uuid into string
		$fields["recipeId"] = $this->recipeId->toString();
		unset($fields["recipeDescription"]);
		return ($fields);
	}

	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["recipeId"] = $this->recipeId-> Uuid();
		unset($fields["recipeImageUrl"]);
		return ($fields);
	}
}
