<?php

namespace TheDeepDiveDawgs\CommunityCookbook;

use TheDeepDiveDawgs\CommunityCookbook\{User, Category, Recipe, Interaction};

//grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

//grab the uuid generator
require_once(dirname(__DIR__) . "/lib/uuid.php");

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
	 * @var $VALID_CATEGORY_NAME
	 */
	protected $VALID_CATEGORY_NAME;

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

	public function testGetValidCategoryByCategoryId() {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");

		//create a new category and insert into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORY_NAME);
		$category->insert($this->getPDO());

		//grab the data from mySQL
		$results = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));

		// enforce no other objects are bleeding into category
		$this->assertContainsOnlyInstancesOf("TheDeepDiveDawgs\CommunityCookbook", $results);

		//enforce the results meet expectations
		$pdoCategory = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORY_NAME);
	}

}