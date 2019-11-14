<?php

namespace TheDeepDiveDawgs\CommunityCookbook\Test;

use TheDeepDiveDawgs\CommunityCookbook\{User, Category, Recipe, Interaction};

// grab the class under scrutiny
require_once(dirname(__DIR__, 1) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit test for the Recipe class
 *
 * This is a complete PHPUnit test of the Recipe class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see Recipe
 * @author Damian Arya <darya@cnm.edu>
 **/
class RecipeTest extends CommunityCookbookTest {

	/**
	 * Category associated to the Recipe; this is for foreign key relations
	 * @var string $category
	 **/

	protected $category = null;

	/**
	 * User that created the Recipe; this is for foreign key relations
	 * @var string $user
	 **/

	protected $user = null;

	/**
	 * valid user has to create the user object to own the test
	 * @var $VALID_USER_HASH
	 */

	protected $VALID_USER_HASH;

	/**
	 * Valid Recipe description
	 * @var string $VALID_RECIPE_DESCRIPTION
	 */

	protected $VALID_RECIPE_DESCRIPTION = "this is a recipe description, food is great";

	/**
	 * Valid Recipe image url
	 * @var string $VALID_RECIPE_IMAGE_URL
	 */

	protected $VALID_RECIPE_IMAGE_URL = "https://tacobell.co.jp/wp-content/uploads/2015/02/tbi-logo-150px-300x300.png";

	/**
	 * Valid Recipe ingredients
	 * @var string $VALID_RECIPE_INGREDIENTS
	 */

	protected $VALID_RECIPE_INGREDIENTS = "recipe ingredients, veggies, fries, meat";


	/**
	 * Valid Recipe minutes
	 * @var string $VALID_RECIPE_MINUTES
	 */

	protected $VALID_RECIPE_MINUTES = "20";


	/**
	 * Valid Recipe name
	 * @var string $VALID_RECIPE_NAME
	 */

	protected $VALID_RECIPE_NAME = "yummy vegan dish";


	/**
	 * Valid Recipe number of ingredients
	 * @var string $VALID_RECIPE_NUMBER_INGREDIENTS
	 */

	protected $VALID_RECIPE_NUMBER_INGREDIENTS = "2";


	/**
	 * Valid Recipe nutrition
	 * @var string $VALID_RECIPE_NUTRITION
	 */

	protected $VALID_RECIPE_NUTRITION = "there is no nutritional value in these veggies";

	/**
	 * Valid to use as Recipe step
	 * @var string $VALID_RECIPE_STEPS
	 */

	protected $VALID_RECIPE_STEPS = "step one, wash the veggies, step two cut the veggies, step three eat the veggies";

	/**
	 * Valid Recipe submission date; this starts as null and is assigned later
	 * @var \DateTime $VALID_RECIPE_SUBMISSION_DATE
	 */

	protected $VALID_RECIPE_SUBMISSION_DATE = null;

	/**
	 * Valid user activation token from user class
	 * @var string $VALID_ACTIVATION
	 */
	private $VALID_ACTIVATION;

	/**
	 *  create dependant objects before running each test
	 */

	public final function setUp(): void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_USER_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		// create and insert a user to own the test Recipe
		$this->user = new User(generateUuidV4(), $this->VALID_ACTIVATION, "grievxus@outlook.com", "Gino Villalpando", "@grievous", $this->VALID_USER_HASH);
		$this->user->insert($this->getPDO());

		//create and insert a category to own the test Recipe
		$this->category = new Category(generateUuidV4(), "vegan");
		$this->category->insert($this->getPDO());

		// calculate the date
		$this->VALID_RECIPE_SUBMISSION_DATE = new \DateTime();
	}

	/**
	 * test inserting a valid Recipe and verify that the actual mySQL data matches
	 **/
	public function testInsertValidRecipe(): void {

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->category->getCategoryId(), $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_IMAGE_URL, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MINUTES, $this->VALID_RECIPE_NAME, $this->VALID_RECIPE_NUMBER_INGREDIENTS, $this->VALID_RECIPE_NUTRITION, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_SUBMISSION_DATE);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRecipe = Recipe::getRecipeByRecipeId($this->getPDO(), $recipe->getRecipeId());
		$this->assertEquals($pdoRecipe->getRecipeId()->toString(), $recipeId->toString());
		$this->assertEquals($pdoRecipe->getRecipeCategoryId(), $recipe->getRecipeCategoryId()->toString());
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $recipe->getRecipeUserId()->toString());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeImageUrl(), $this->VALID_RECIPE_IMAGE_URL);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMinutes(), $this->VALID_RECIPE_MINUTES);
		$this->assertEquals($pdoRecipe->getRecipeName(), $this->VALID_RECIPE_NAME);
		$this->assertEquals($pdoRecipe->getRecipeNumberIngredients(), $this->VALID_RECIPE_NUMBER_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeNutrition(), $this->VALID_RECIPE_NUTRITION);
		$this->assertEquals($pdoRecipe->getRecipeStep(), $this->VALID_RECIPE_STEPS);

		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRecipe->getRecipeSubmissionDate()->getTimestamp(), $this->VALID_RECIPE_SUBMISSION_DATE->getTimestamp());
	}

	public function testUpdateValidRecipe(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->category->getCategoryId(), $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_IMAGE_URL, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MINUTES, $this->VALID_RECIPE_NAME, $this->VALID_RECIPE_NUMBER_INGREDIENTS, $this->VALID_RECIPE_NUTRITION, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_SUBMISSION_DATE);
		$recipe->insert($this->getPDO());

		// edit the Recipe and update it in mySQL
		$recipe->setRecipeName($this->VALID_RECIPE_NAME);
		$recipe->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRecipe = Recipe::getRecipeByRecipeId($this->getPDO(), $recipe->getRecipeId());

		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeCategoryId(), $recipe->getRecipeCategoryId()->toString());
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $recipe->getRecipeUserId()->toString());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeImageUrl(), $this->VALID_RECIPE_IMAGE_URL);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMinutes(), $this->VALID_RECIPE_MINUTES);
		$this->assertEquals($pdoRecipe->getRecipeName(), $this->VALID_RECIPE_NAME);
		$this->assertEquals($pdoRecipe->getRecipeNumberIngredients(), $this->VALID_RECIPE_NUMBER_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeNutrition(), $this->VALID_RECIPE_NUTRITION);
		$this->assertEquals($pdoRecipe->getRecipeStep(), $this->VALID_RECIPE_STEPS);

		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRecipe->getRecipeSubmissionDate()->getTimestamp(), $this->VALID_RECIPE_SUBMISSION_DATE->getTimestamp());
	}

	/**
	 * test creating a Recipe and then deleting it
	 **/
	public function testDeleteValidRecipe(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->category->getCategoryId(), $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_IMAGE_URL, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MINUTES, $this->VALID_RECIPE_NAME, $this->VALID_RECIPE_NUMBER_INGREDIENTS, $this->VALID_RECIPE_NUTRITION, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_SUBMISSION_DATE);
		$recipe->insert($this->getPDO());

		// delete the Recipe from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$recipe->delete($this->getPDO());

		// grab the data from mySQL and enforce the Recipe does not exist
		$pdoRecipe = Recipe::getRecipeByRecipeId($this->getPDO(), $recipe->getRecipeId());
		$this->assertNull($pdoRecipe);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("recipe"));
	}

	/**
	 * test inserting a Recipe and re-grabbing it from mySQL
	 */
	public function testGetValidRecipeByRecipeId(): void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->category->getCategoryId(), $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_IMAGE_URL, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MINUTES, $this->VALID_RECIPE_NAME, $this->VALID_RECIPE_NUMBER_INGREDIENTS, $this->VALID_RECIPE_NUTRITION, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_SUBMISSION_DATE);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the results meet expectations
		$pdoRecipe = Recipe::getRecipeByRecipeId($this->getPDO(), $recipe->getRecipeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeCategoryId(), $recipe->getRecipeCategoryId()->toString());
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $recipe->getRecipeUserId()->toString());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeImageUrl(), $this->VALID_RECIPE_IMAGE_URL);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMinutes(), $this->VALID_RECIPE_MINUTES);
		$this->assertEquals($pdoRecipe->getRecipeName(), $this->VALID_RECIPE_NAME);
		$this->assertEquals($pdoRecipe->getRecipeNumberIngredients(), $this->VALID_RECIPE_NUMBER_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeNutrition(), $this->VALID_RECIPE_NUTRITION);
		$this->assertEquals($pdoRecipe->getRecipeStep(), $this->VALID_RECIPE_STEPS);

		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRecipe->getRecipeSubmissionDate()->getTimestamp(), $this->VALID_RECIPE_SUBMISSION_DATE->getTimestamp());
	}

	/**
	 * test grabbing a Recipe that does not exist
	 * @param $fakeRecipeId
	 */
	public function testGetInvalidRecipeByRecipeId($fakeRecipeId): void {

		// grab a recipe id that exceeds the maximum allowable recipe id
		$fakeRecipeId = generateUuidV4();
		$recipe = Recipe::getRecipeByRecipeId($this->getPDO(), $fakeRecipeId);
		$this->assertNull($recipe);
	}

	/**
	 * test grabbing a Recipe by recipe description
	 */

	public function testGetValidRecipeByRecipeUserId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->category->getCategoryId(), $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_IMAGE_URL, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MINUTES, $this->VALID_RECIPE_NAME, $this->VALID_RECIPE_NUMBER_INGREDIENTS, $this->VALID_RECIPE_NUTRITION, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_SUBMISSION_DATE);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Recipe::getRecipeByRecipeUserId($this->getPDO(), $this->user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("TheDeepDiveDawgs\CommunityCookbook\Recipe", $results);

		// grab the result from the array and validate it
		$pdoRecipe = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeCategoryId(), $this->category->getCategoryId);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->user->getUserId());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeImageUrl(), $this->VALID_RECIPE_IMAGE_URL);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMinutes(), $this->VALID_RECIPE_MINUTES);
		$this->assertEquals($pdoRecipe->getRecipeName(), $this->VALID_RECIPE_NAME);
		$this->assertEquals($pdoRecipe->getRecipeNumberIngredients(), $this->VALID_RECIPE_NUMBER_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeNutrition(), $this->VALID_RECIPE_NUTRITION);
		$this->assertEquals($pdoRecipe->getRecipeStep(), $this->VALID_RECIPE_STEPS);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRecipe->getRecipeSubmissionDate()->getTimestamp(), $this->VALID_RECIPE_SUBMISSION_DATE->getTimestamp());
	}

	/**
	 * test grabbing a Recipe by description that does not exist
	 **/
	public function testGetInvalidRecipeByRecipeUserId(): void {
		// grab a recipe by recipe user id that does not exist
		$recipe = Recipe::getRecipeByRecipeUserId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $recipe);
	}

	/**
	 * test grabbing a Recipe by recipe category
	 */

	public function testGetValidRecipeByRecipeCategoryId(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->category->getCategoryId(), $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_IMAGE_URL, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MINUTES, $this->VALID_RECIPE_NAME, $this->VALID_RECIPE_NUMBER_INGREDIENTS, $this->VALID_RECIPE_NUTRITION, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_SUBMISSION_DATE);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Recipe::getRecipeByRecipeCategoryId($this->getPDO(), $this->category->getCategoryId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("TheDeepDiveDawgs\CommunityCookbook\Recipe", $results);

		// grab the result from the array and validate it
		$pdoRecipe = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeCategoryId(), $this->category->getCategoryId);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->user->getUserId());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeImageUrl(), $this->VALID_RECIPE_IMAGE_URL);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMinutes(), $this->VALID_RECIPE_MINUTES);
		$this->assertEquals($pdoRecipe->getRecipeName(), $this->VALID_RECIPE_NAME);
		$this->assertEquals($pdoRecipe->getRecipeNumberIngredients(), $this->VALID_RECIPE_NUMBER_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeNutrition(), $this->VALID_RECIPE_NUTRITION);
		$this->assertEquals($pdoRecipe->getRecipeStep(), $this->VALID_RECIPE_STEPS);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRecipe->getRecipeSubmissionDate()->getTimestamp(), $this->VALID_RECIPE_SUBMISSION_DATE->getTimestamp());
	}

	/**
	 * test grabbing a Recipe by category that does not exist
	 **/
	public function testGetInvalidRecipeByRecipeCategoryId(): void {
		// grab a recipe by recipe category id that does not exist
		$recipe = Recipe::getRecipeByRecipeCategoryId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $recipe);
	}

	/**
	 * test grabbing all Recipes
	 */

	public function testGetAllValidRecipe(): void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->category->getCategoryId(), $this->user->getUserId(), $this->VALID_RECIPE_DESCRIPTION, $this->VALID_RECIPE_IMAGE_URL, $this->VALID_RECIPE_INGREDIENTS, $this->VALID_RECIPE_MINUTES, $this->VALID_RECIPE_NAME, $this->VALID_RECIPE_NUMBER_INGREDIENTS, $this->VALID_RECIPE_NUTRITION, $this->VALID_RECIPE_STEPS, $this->VALID_RECIPE_SUBMISSION_DATE);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$results = Recipe::getAllRecipe($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertCount(1, $results);

		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("\TheDeepDiveDawgs\CommunityCookBook\Recipe", $results);


		// grab the result from the array and validate it
		$pdoRecipe = $results[0];
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeCategoryId(), $this->category->getCategoryId);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->user->getUserId());
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeImageUrl(), $this->VALID_RECIPE_IMAGE_URL);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMinutes(), $this->VALID_RECIPE_MINUTES);
		$this->assertEquals($pdoRecipe->getRecipeName(), $this->VALID_RECIPE_NAME);
		$this->assertEquals($pdoRecipe->getRecipeNumberIngredients(), $this->VALID_RECIPE_NUMBER_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeNutrition(), $this->VALID_RECIPE_NUTRITION);
		$this->assertEquals($pdoRecipe->getRecipeStep(), $this->VALID_RECIPE_STEPS);

		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRecipe->getRecipeSubmissionDate()->getTimestamp(), $this->VALID_RECIPE_SUBMISSION_DATE->getTimestamp());
	}
}
