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
}