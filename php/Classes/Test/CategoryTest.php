<?php

namespace TheDeepDiveDawgs\CommunityCookbook\Test;

use TheDeepDiveDawgs\CommunityCookbook\{User, Category, Recipe, Interaction};

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

//grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Category class
 *
 * This is a complete PHPUnit test of the Category class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see \TheDeepDiveDawgs\CommunityCookbook\Category
 * @author Floribella Ponce <fponce2@cnm.edu>
 **/
class CategoryTest extends CommunityCookbookTest {
	/**
	 *valid category name to create the category
	 * @var string $VALID_CATEGORY_NAME
	 */
	protected $VALID_CATEGORY_NAME = "Test";

	/**
	 *test inserting a valid category and verifying that the actual mySQL data matches
	 */
	public function testInsertValidCategory(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORY_NAME);
		$category->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORY_NAME);
	}

	/**
	 * test inserting a category, editing it, and then updating it
	 */
	public function testUpdateValidCategory(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORY_NAME);
		$category->insert($this->getPDO());

		// edit the category and update it in mySQL
		$category->setCategoryName($this->VALID_CATEGORY_NAME);
		$category->update($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORY_NAME);
	}

	/**
	 * test creating a category and then deleting it
	 */

	public function testDeleteValidCategory(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORY_NAME);
		$category->insert($this->getPDO());

		//delete the category from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$category->delete($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertNull($pdoCategory);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("category"));
	}

	/**
	 * test inserting a category and regrabbing it from mySQL
	 */

	public function testGetValidCategoryByCategoryId(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORY_NAME);
		$category->insert($this->getPDO());

		//grab the data from mySQL and enforce the results meet expectations
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORY_NAME);
	}

	/**
	 * test grabbing a category that does not exist
	 */
	public function testGetInvalidCategoryByCategoryId() {
		//grab a category id that exceeds the maximum allowable category id
		$fakeCategoryId = generateUuidV4();
		$category = Category::getCategoryByCategoryId($this->getPDO(), $fakeCategoryId);
		$this->assertNull($category);
	}

	/**
	 * test grabbing a category by category name
	 */
	public function testGetValidCategoryByCategoryName(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into MySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORY_NAME);
		$category->insert($this->getPDO());

		$pdoCategory = Category::getCategoryByCategoryName($this->getPDO(), $category->getCategoryName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORY_NAME);

	}

	/**
	 * test grabbing a category that does not exist
	 */
	public function testGetInvalidCategoryByCategoryName() {
		//grab a category id that exceeds the maximum allowable category id
		$category = Category::getCategoryByCategoryName($this->getPDO(), "fake category");
		$this->assertNull($category);
	}

	/**
	 * test grabbing all Categories
	 */

	public function testGetAllValidCategories(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORY_NAME);
		$category->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$results = Category::getAllCategories($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("TheDeepDiveDawgs\CommunityCookbook\Category", $results);

		// grab the result from the array and validate it
		$pdoCategory = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORY_NAME);
	}
}