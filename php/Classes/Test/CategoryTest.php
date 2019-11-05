<?php

namespace TheDeepDiveDawgs\CommunityCookbook;
use TheDeepDiveDawgs\CommunityCookbook\{User, Category, Recipe, Interaction};

//grab the calss under scrutiny
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
	 *valid category name
	 */
}