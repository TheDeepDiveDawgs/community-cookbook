<?php


namespace TheDeepDiveDawgs\CommunityCookbook;

require_once("autoload.php");
require_once(dirname(__DIR__, 1) . "/vendor/autoload.php");

/** recipe class by Damian Arya darya@cnm.edu
 * @version (7.3)
 */

use Ramsey\Uuid\Uuid;

/** docblock section of recipe setting up the Classes for recipe section of PDO of capstone*/
class Recipe implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;
	/**
	 * id for this recipe; this is the primary key
	 * @var  Uuid $recipeId
	 **/
	private $recipeId;
	/**
	 *  to identify recipe type for sorting and searching purposes.
	 * @var Uuid $recipeCategoryId
	 **/
	private $recipeCategoryId;
	/**
	 * to identify recipe type for sorting and searching purposes.
	 * @var Uuid $recipeUserId
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
	 * Step to make this recipe
	 * @var string $recipeStep
	 **/
	private $recipeStep;
	/**
	 * date the recipe was submitted
	 * @var \DateTime $recipeSubmissionDate
	 **/
	private $recipeSubmissionDate;

	/**
	 * constructor for this recipe
	 * @param Uuid for $newRecipeId new user id
	 * @param Uuid for $newRecipeCategoryId
	 * @param Uuid for $newRecipeUserId
	 * @param string $newRecipeDescription address
	 * @param string $newRecipeImageUrl new password
	 * @param string $newRecipeIngredients
	 * @param string $newRecipeMinutes
	 * @param string $newRecipeName
	 * @param string $newRecipeNutrition
	 * @param string $newRecipeNumberIngredients
	 * @param string $newRecipeStep
	 * @param \DateTime $newRecipeSubmissionDate
	 * @trows \RangeException if data vales are out of bounds
	 * @throws \TypeError if data types violate type hints
	 * @throws \InvalidArgumentException if data types are not valid
	 **/
	public function __construct($newRecipeId, $newRecipeCategoryId, $newRecipeUserId, string $newRecipeDescription, string $newRecipeImageUrl, string $newRecipeIngredients, string $newRecipeMinutes, string $newRecipeName, string $newRecipeNumberIngredients, string $newRecipeNutrition, string $newRecipeStep, $newRecipeSubmissionDate = null) {
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
			$this->setRecipeStep($newRecipeStep);
			$this->setRecipeSubmissionDate($newRecipeSubmissionDate);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			//determine what exception type was thrown
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	public static function getRecipeByRecipeDescription(\PDO $getPDO, string $getRecipeDescription) {
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
	 * @return Uuid value of recipe id
	 * */
	public function getRecipeId(): Uuid {
		return ($this->recipeId);
	}

	/**
	 * mutator method for recipe id
	 *
	 * @param void| string $newRecipeId value of new recipe id
	 * @throws \RangeException if $newRecipeId is not positive
	 * @throws \TypeError if the recipe Id is not
	 **/
	public function setRecipeId($newRecipeId): void {
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
	 * @return Uuid value of the recipeCategoryId
	 */
	public function getRecipeCategoryId(): Uuid {
		return ($this->recipeCategoryId);
	}

	/**
	 * mutator method for recipeCategoryId
	 *
	 * @param void | string $newRecipeCategoryId value of new recipe id
	 * @throws \RangeException if $newRecipeCategoryId is not positive
	 * @throws \TypeError if the recipeCategoryId is not
	 **/
	public function setRecipeCategoryId($newRecipeCategoryId): void {
		try {
			$uuid = self::validateUuid($newRecipeCategoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the recipeCategoryId
		$this->recipeCategoryId = $uuid;
	}

	/**
	 *
	 * accessor method for at recipeUserId
	 *
	 * @return Uuid value of at recipeUserId
	 **/
	public function getRecipeUserId(): Uuid {
		return ($this->recipeUserId);
	}

	/**
	 * mutator method for recipeUserId
	 *
	 * @param void| string $newRecipeUserId value of new recipeUserId
	 * @throws \RangeException if $newRecipeUserId is not positive
	 * @throws \TypeError if the recipeUserId is not valid
	 **/
	public function setRecipeUserId($newRecipeUserId): void {
		try {
			$uuid = self::validateUuid($newRecipeUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the recipeUserId
		$this->recipeUserId = $uuid;
	}

	/**
	 *
	 * accessor method for Description
	 *
	 * @return string value of at Description
	 **/
	public function getRecipeDescription(): string {
		return ($this->recipeDescription);
	}

	/**
	 * mutator method for description
	 *
	 * @param string $newRecipeDescription new value of description
	 * @return string for $newRecipeDescription
	 **@throws \RangeException if $newDescription is > 3000 characters
	 * @throws \TypeError if $newDescription is not a string
	 * @throws \InvalidArgumentException if $newDescription is not a valid description or insecure
	 */
	public function setRecipeDescription(string $newRecipeDescription): void {
		// verify the description is secure
		$newRecipeDescription = trim($newRecipeDescription);
		$newRecipeDescription = filter_var($newRecipeDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeDescription) === true) {
			throw(new \InvalidArgumentException("recipe description is empty or insecure"));
		}
		// verify the description will fit in the database
		if(strlen($newRecipeDescription) > 500) {
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
	 * @param string $newRecipeImageUrl vale of new recipe imageUrl
	 * @return string of url for image
	 * @throws \InvalidArgumentException if the imageUrl is not secure
	 * @throws \RangeException if the recipeImageUrl is not 255 characters
	 * @throws \TypeError if recipeImageUrl is not a string
	 */
	public function setRecipeImageUrl(string $newRecipeImageUrl): void {

		//enforce that the imageUrl content is secure
		$newRecipeImageUrl = filter_var($newRecipeImageUrl, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeImageUrl) === true) {
			throw(new \InvalidArgumentException("image url is empty or insecure"));
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
	 * @param string $newRecipeIngredients
	 **@return string
	 * @throws \RangeException if the recipeIngredients is more then 2000 characters
	 * @throws \TypeError if recipeIngredients is not a string
	 * @throws \InvalidArgumentException if the recipeIngredients is not secure
	 */
	public function setRecipeIngredients(string $newRecipeIngredients): void {

		// verify the ingredients is secure
		$newRecipeIngredients = trim($newRecipeIngredients);
		$newRecipeIngredients = filter_var($newRecipeIngredients, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeIngredients) === true) {
			throw(new \InvalidArgumentException("Ingredients field is empty"));
		}
		// verify the at handle will fit in the database
		if(strlen($newRecipeIngredients) > 300) {
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
		return ($this->recipeMinutes);
	}

	/**
	 * mutator method for Minutes
	 *
	 * @param integer $newRecipeMinutes new value of minutes
	 * @throws \InvalidArgumentException if  $recipeMinutes is not a int or insecure
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
		if($newRecipeMinutes < 0 or $newRecipeMinutes > 999) {
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
		return ($this->recipeName);
	}

	/**
	 * mutator method for recipeName*@param string $newRecipeName
	 * @return string name for recipe
	 * @throws \RangeException if the recipeName is more then 100 characters
	 * @throws \TypeError if recipe recipeName is not a string
	 * @throws \InvalidArgumentException if the recipeName is not secure
	 */
	public function setRecipeName(string $newRecipeName): void {
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
		return ($this->recipeNumberIngredients);
	}

	/**
	 * mutator method for recipeNumberIngredients
	 * @param int $newRecipeNumberIngredients
	 * @return int for number of recipe ingredients
	 */
	public function setRecipeNumberIngredients(int $newRecipeNumberIngredients): void {
		// verify the number of ingredients is secure
		$newRecipeNumberIngredients = filter_var($newRecipeNumberIngredients, FILTER_VALIDATE_INT);
		if(empty($newRecipeNumberIngredients) === true) {
			throw(new \InvalidArgumentException("number of ingredients field is empty"));
		}
		// verify the at handle will fit in the database
		if($newRecipeNumberIngredients < 0 or $newRecipeNumberIngredients > 99) {
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
		return ($this->recipeNutrition);
	}

	/**
	 * mutator method for recipeNutrition
	 * @param string $newRecipeNutrition
	 * @return string of nutrition for the recipe
	 * @throws \RangeException if the recipeNutrition is not 128 characters
	 * @throws \TypeError if recipeNutrition is not a string
	 * @throws \InvalidArgumentException if the recipeNutrition is not secure
	 */
	public function setRecipeNutrition(string $newRecipeNutrition): void {
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
	 * accessor method for recipeStep
	 *
	 * @return string value of recipeStep
	 **/
	public function getRecipeStep(): string {
		return ($this->recipeStep);
	}

	/**
	 * mutator method for recipeStep
	 *    *    **@param string $newRecipeStep
	 **@return string
	 * @throws \RangeException if the recipeStep is not 128 characters
	 * @throws \TypeError if recipeStep is not a string
	 * @throws \InvalidArgumentException if the recipeStep is not secure
	 */
	public function setRecipeStep(string $newRecipeStep): void {
		// verify the Step data is secure
		$newRecipeStep = trim($newRecipeStep);
		$newRecipeStep = filter_var($newRecipeStep, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newRecipeStep) === true) {
			throw(new \InvalidArgumentException("Step must be added"));
		}
		// verify the at handle will fit in the database
		if(strlen($newRecipeStep) > 1000) {
			throw(new \RangeException(" too many Step"));
		}
		// store the recipe Step
		$this->recipeStep = $newRecipeStep;
	}

	/**
	 * accessor method for recipeSubmissionDate
	 *
	 * @return \DateTime value of recipeSubmissionDate
	 **/
	public function getRecipeSubmissionDate(): \DateTime {
		return ($this->recipeSubmissionDate);
	}

	/**
	 * mutator method for recipeSubmissionDate
	 * @param \DateTime |string|null $newRecipeSubmissionDate interaction date as a datetime object or string (or null tp load current)
	 * @throws \InvalidArgumentException if $recipeSubmissionDate is not a valid object or string
	 * @throws \RangeException if the $recipeSubmissionDate is a date that does not exist
	 * @throws \Exception
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
		} catch(\InvalidArgumentException | \RangeException $exception) {
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

	public function insert(\PDO $pdo): void {
		//creates query template
		$query = "INSERT INTO recipe(recipeId, recipeCategoryId, recipeUserId, recipeDescription, recipeImageUrl, recipeIngredients, recipeMinutes, recipeName, recipeNumberIngredients, recipeNutrition, recipeStep, recipeSubmissionDate) VALUES (:recipeId, :recipeCategoryId, :recipeUserId, :recipeDescription, :recipeImageUrl, :recipeIngredients, :recipeMinutes, :recipeName, :recipeNumberIngredients, :recipeNutrition, :recipeStep, :recipeSubmissionDate)";
		$statement = $pdo->prepare($query);
		// this creates relationship between php state variables and pdo/mysql variables
		$parameters = [
			"recipeId" => $this->recipeId->getBytes(),
			"recipeCategoryId" => $this->recipeCategoryId,
			"recipeUserId" => $this->recipeUserId,
			"recipeDescription" => $this->recipeDescription,
			"recipeImageUrl" => $this->recipeImageUrl,
			"recipeIngredients" => $this->recipeIngredients,
			"recipeMinutes" => $this->recipeMinutes,
			"recipeName" => $this->recipeName,
			"recipeNumberIngredients" => $this->recipeNumberIngredients,
			"recipeNutrition" => $this->recipeNutrition,
			"recipeStep" => $this->recipeStep,
			"recipeSubmissionDate" => $this->recipeSubmissionDate,];
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
		$parameters = ["recipeId" => $this->recipeId->getBytes()];
		$statement->execute($parameters);
	}

	/**
	 * update recipe in mysql database
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param \PDOexception when MySQL errors occur
	 */
	public function update(\PDO $pdo): void {
		//create query template
		$query = "UPDATE recipe SET recipeCategoryId = :recipeCategoryId, recipeDescription = :recipeDescription, recipeImageUrl = :recipeImageUrl, recipeIngredients = :recipeIngredients, recipeMinutes = :recipeMinutes, recipeName = :recipeName, recipeNumberIngredients = :recipeNumberIngredients, recipeNutrition = :recipeNutrition, recipeStep = :recipeStep, recipeSubmissionDate = :recipeSubmissionDate WHERE recipeId = :recipeId";
		$statement = $pdo->prepare($query);
		//creates relationship between php state variables and pdo/mysql variables
		$parameters = [
			"recipeId" => $this->recipeId->getBytes(),
			"recipeCategoryId" => $this->recipeCategoryId,
			"recipeUserId" => $this->recipeUserId,
			"recipeDescription" => $this->recipeDescription,
			"recipeImageUrl" => $this->recipeImageUrl,
			"recipeIngredients" => $this->recipeIngredients,
			"recipeMinutes" => $this->recipeMinutes,
			"recipeName" => $this->recipeName,
			"recipeNumberIngredients" => $this->recipeNumberIngredients,
			"recipeNutrition" => $this->recipeNutrition,
			"recipeStep" => $this->recipeStep,
			"recipeSubmissionDate" => $this->recipeSubmissionDate,];
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
	public static function getAllRecipe(\PDO $pdo): \SPLFixedArray {
		// create query template
		$query = "SELECT recipeId, recipeCategoryId, recipeUserId, recipeDescription, recipeImageUrl, recipeIngredients, recipeMinutes, recipeName, recipeNumberIngredients, recipeNutrition, recipeStep, recipeSubmissionDate FROM recipe";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of recipes
		$recipe = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$recipes = new Recipe($row["recipeId"], $row["recipeCategoryId"], $row["recipeUserId"], $row["recipeDescription"], $row["recipeImageUrl"], $row["recipeIngredients"], $row["recipeMinutes"], $row["recipeName"], $row["recipeNumberIngredients"], $row["recipeNutrition"], $row["recipeStep"], $row["recipeSubmissionDate"]);
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
	 * gets Recipe by recipe user id for the my recipe pages
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid for $recipeUserId
	 * @return \SplFixedArray SplFixedArray of getRecipeByRecipeUserId found or null if not found
	 */
	public static function getRecipeByRecipeUserId(\PDO $pdo, $recipeUserId): \SPLFixedArray {

		try {
			$recipeUserId = self::validateUuid($recipeUserId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT recipeId, recipeCategoryId, recipeUserId, recipeDescription, recipeImageUrl, recipeIngredients, recipeMinutes, recipeName, recipeNumberIngredients, recipeNutrition, recipeStep, recipeSubmissionDate FROM recipe WHERE recipeUserId = :recipeUserId";
		$statement = $pdo->prepare($query);
		//bind the recipe user id to the place holder in the template
		$parameters = ["recipeUserId" => $recipeUserId->getBytes()];
		$statement->execute($parameters);


		// build an array of recipes
		$recipes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$recipe = new Recipe($row["recipeId"], $row["recipeCategoryId"], $row["recipeUserId"], $row["recipeDescription"], $row["recipeImageUrl"], $row["recipeIngredients"], $row["recipeMinutes"], $row["recipeName"], $row["recipeNumberIngredients"], $row["recipeNutrition"], $row["recipeStep"], $row["recipeSubmissionDate"]);
				$recipes[$recipes->key()] = $recipe;
				$recipes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($recipes);
	}

	// this is the divide between foo by bar array and normal foo by bar//

	public function getRecipeByCategoryId(\PDO $pdo, $recipeCategoryId): Recipe {
		//sanitize the recipeCategoryId before searching
		try {
			$recipeCategoryId = self::validateUuid($recipeCategoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT recipeId, recipeCategoryId, recipeUserId, recipeDescription, recipeImageUrl,
    		recipeIngredients, recipeMinutes, recipeName, recipeNumberIngredients, recipeNutrition, recipeStep,
    		recipeSubmissionDate FROM recipe WHERE recipeCategoryId = :recipeCategoryId";
		$statement = $pdo->prepare($query);
		//bind the category id to the place holder in the template
		$parameters = ["recipeCategoryId" => $recipeCategoryId->getBytes()];
		$statement->execute($parameters);
		//grab the recipeCategoryId from mySQL
		try {
			$recipe = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$recipe = new Recipe($row["recipeId"], $row["recipeCategoryId"], $row["recipeUserId"], $row["recipeDescription"], $row["recipeImageUrl"], $row["recipeIngredients"],
					$row["recipeMinutes"], $row["recipeName"], $row["recipeNumberIngredients"], $row["recipeNutrition"], $row["recipeStep"], $row["recipeSubmissionDate"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($recipe);
	}

	//** this is where get recipe by recipe id begins **//

	public function getRecipeByRecipeId(\PDO $pdo, $recipeId): Recipe {
		//sanitize the recipeId before searching
		try {
			$recipeId = self::validateUuid($recipeId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}

		//create query template
		$query = "SELECT recipeId, recipeCategoryId, recipeUserId, recipeDescription, recipeImageUrl,
    recipeIngredients, recipeMinutes, recipeName, recipeNumberIngredients, recipeNutrition, recipeStep,
    recipeSubmissionDate FROM recipe WHERE recipeId = :recipeId";
		$statement = $pdo->prepare($query);

		// bind the recipe id to the place holder in the template
		$parameters = ["recipeId" => $recipeId->getBytes()];
		$statement->execute($parameters);

		//grab the recipe from mySQL
		try {
			$recipe = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$recipe = new Recipe($row["recipeId"], $row["recipeCategoryId"], $row["recipeUserId"], $row["recipeDescription"], $row["recipeImageUrl"], $row["recipeIngredients"],
					$row["recipeMinutes"], $row["recipeName"], $row["recipeNumberIngredients"], $row["recipeNutrition"], $row["recipeStep"], $row["recipeSubmissionDate"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($recipe);
	}
	
	//this is where foo by bar get recipe by search term begins
	public function getRecipeBySearchTerm (\PDO $pdo, $recipeIngredients, $recipeName, $recipeStep) : \SplFixedArray {
		// sanitize the search term in recipe ingredients before searching
		$recipeIngredients = trim($recipeIngredients);
		$recipeIngredients= filter_var($recipeIngredients, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($recipeIngredients) === true) {
			throw(new \PDOException("Recipe ingredient  is invalid"));
		}
		// sanitize the search term in recipe name before searching
		$recipeName = trim($recipeName);
		$recipeName= filter_var($recipeName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($recipeName) === true) {
			throw(new \PDOException("Recipe name is invalid"));
		}
		// sanitize the search term  in recipe step before searching
		$recipeStep = trim($recipeStep);
		$recipeStep= filter_var($recipeStep, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($recipeStep) === true) {
			throw(new \PDOException("Recipe step is invalid"));
		}

		// escape any mySQL wild cards
		$recipeIngredients = str_replace("_", "\\_", str_replace("%", "\\%", $recipeIngredients));
		$recipeName = str_replace("_", "\\_", str_replace("%", "\\%", $recipeName));
		$recipeStep = str_replace("_", "\\_", str_replace("%", "\\%", $recipeStep));

		//create query template
		$query = "SELECT recipeId, recipeCategoryId, recipeUserId, recipeDescription, recipeImageUrl,
    recipeIngredients, recipeMinutes, recipeName, recipeNumberIngredients, recipeNutrition, recipeStep,
    recipeSubmissionDate FROM recipe WHERE recipeIngredients LIKE :recipeIngredients OR recipeName LIKE :recipeName OR 
    recipeStep LIKE :recipeStep";
		$statement = $pdo - prepare($query);

		// bind the recipe ingredients to the place holder in the template
		$recipeIngredients = "%$recipeIngredients%";
		$parameters = ["recipeIngredients" => $recipeIngredients];
		$statement->execute($parameters);

		// bind the recipe name to the place holder in the template
		$recipeName = "%$recipeName%";
		$parameters = ["recipeName" => $recipeName];
		$statement->execute($parameters);

		// bind the recipe steps to the place holder in the template
		$recipeStep = "%$recipeStep%";
		$parameters = ["recipeStep" => $recipeStep];
		$statement->execute($parameters);


		// build an array of recipes
		$recipes = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$recipe = new Recipe($row["recipeId"], $row["recipeCategoryId"], $row["recipeUserId"], $row["recipeDescription"],
					$row["recipeImageUrl"], $row["recipeIngredients"], $row["recipeMinutes"], $row["recipeName"], $row["recipeNumberIngredients"],
					$row["recipeNutrition"], $row["recipeStep"], $row["recipeSubmissionDate"]);
				$recipes[$recipes->key()] = $recipe;
				$recipes->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($recipes);
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
		$fields["recipeCategoryId"] = $this->recipeCategoryId->toString();
		$fields["recipeUserId"] = $this->recipeUserId->toString();
		unset($fields["recipeDescription"]);
		return ($fields);
	}
}