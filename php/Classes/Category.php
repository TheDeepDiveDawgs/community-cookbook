<?php
namespace TheDeepDiveDawgs\CommunityCookbook;
require_once("autoload.php");
require_once (dirname(__DIR__) . "/vendor/autoload.php");

use Ramsey\Uuid\Uuid;

/**
 * This is the information that is stored for a category.
 *
 * @author Floribella Ponce <fponce2@cnm.edu
 * @version 0.0.1
 */

class Category implements \JsonSerializable {
	use ValidateUuid;

	/**
	 * id for the category, this is the primary key.
	 * @var Uuid $categoryId
	 */

	private $categoryId;

	/**
	 * name for the category.
	 * @var string $categoryName
	 */

	private $categoryName;

	/**
	 * constructor for this category
	 *
	 * @param string|Uuid $newCategoryId string containing new category Id
	 * @param string $newCategoryName string containing new category name
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if a data type violates a data hint
	 * @throws \Exception if some other exception occurs
	 */

	public function __construct($newCategoryId, string $newCategoryName) {
		try {
			$this->setCategoryId($newCategoryId);
			$this->setCategoryName($newCategoryName);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for category id.
	 *
	 * @return Uuid value of category id.
	 */

	public function getCategoryId(): Uuid {
		return($this->categoryId);
	}

	/**
	 * mutator for category id
	 *
	 * @param Uuid | string $newCategoryId new value for category id
	 * @throws \RangeException if $newCategoryId is not positive
	 * @throws \TypeError if Category Id is not a uuid or string
	 */

	public function setCategoryId($newCategoryId): void {
		try {
			$uuid = self::validateUuid($newCategoryId);
		} catch(\InvalidArgumentException |\RangeException |\Exception |\TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->categoryId = $uuid;
	}

	/**
	 * accessor method for category name
	 *
	 * @return string value for category name
	 */

	public function getCategoryName() : string {
		return ($this->categoryName);
	}

	/**
	 * mutator method for category name
	 *
	 * @param string $newCategoryName new value for category name
	 * @throws \InvalidArgumentException if $newCategoryName is not a BadQueryStringException
	 * @throws \RangeException if the $newCategoryName is > 24 characters
	 * @throws \TypeError if $newCategoryName is not a string
	 */

	public function setCategoryName(string $newCategoryName): void {
		$newCategoryName = trim($newCategoryName);
		$newCategoryName = filter_var($newCategoryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCategoryName) === true) {
			throw (new\InvalidArgumentException("category name is empty or insecure"));
		}
		$this->categoryName = $newCategoryName;
	}

	/**insert this category into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param \PDOException when mySQL related errors occur
	 * @throws \TypeError if the $pdo is not a PDO connection object
	 */
	public function insert(\PDO $pdo) : void {
		$query = "INSERT INTO category(categoryId, categoryName) VALUES(:categoryId, :categoryName)";
		$statement = $pdo->prepare($query);

		$parameters = ["categoryId" => $this->categoryId->getBytes(), "categoryName" => $this->categoryName];
		$statement->execute($parameters);
	}

	/**
	 * updates category in MySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param \PDOException when mySQL related errors occur
	 * @throws \TypeError if the $pdo is not a PDO connection object
	 */
	public function update(\PDO $pdo) : void {
		$query = "UPDATE category SET categoryName=:categoryName WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);

		$parameters = ["categoryId"=> $this->categoryId->getBytes(), "categoryName" => $this->categoryName];
		$statement->execute($parameters);
	}

	/**
	 * deletes category from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param \PDOException when mySQL related errors occur
	 * @throws \TypeError if the $pdo is not a PDO connection object
	 */

	public function delete(\PDO $pdo) : void {
		$query = "DELETE FROM category WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);

		$parameters = ["categoryId" => $this->categoryId->getBytes()];
	}

	/**
	 * get category by category id
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $categoryId category id to search for
	 * @param \PDOException when mySQL related errors occur
	 * @throws \TypeError if the $pdo is not a PDO connection object
	 */
	public function getCategoryByCategoryId(\PDO $pdo, $categoryId): Category {
		// sanitize the categoryId before searching
		try {
			$categoryId = self::validateUuid($categoryId);
		} catch(\InvalidArgumentException | \ RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//query template
		$query = "SELECT categoryId, categoryName FROM category WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);
		// bind the category id to the sql query
		$parameters = ["categoryId" => $categoryId->getBytes()];
		$statement->execute($parameters);

		//grab the category from mySQL
		try {
			$category = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$category = new Category($row["categoryId"], $row["categoryName"]);
			}
		} catch(\Exception $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($category);
	}


	/**
	 * get all Categories
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Categories found or null if not found
	 * @param \PDOException when mySQL related errors occur
	 * @throws \TypeError if the $pdo is not a PDO connection object
	 */
	public static function getAllCategories(\PDO $pdo) : \SplFixedArray {
		//create query template
		$query = "SELECT categoryId, categoryName FROM category";
		$statement = $pdo->prepare($query);
		$statement->execute();

		// build an array of categories
		$categories = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$category = new Category($row["categoryId"], $row["categoryName"]);
				$categories[$categories->key()] = $category;
				$categories->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($categories);
	}

	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 */

	public function jsonSerialize() : array {
		$fields = get_object_vars($this);

		$fields["categoryId"] = $this->categoryId-> toString();
		return ($fields);
	}
}


