<?php
namespace TheDeepDiveDawgs\communitycookbook;
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

	public function jsonSerialize() : array {
		$fields = get_obeject_vars($this);
		$fields["categoryId"] = $this->categoryId-> toString();
		$fields["categoryName"] = $this->categoryName->toString();
	}
}