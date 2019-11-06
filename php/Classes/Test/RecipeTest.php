<?php

namespace TheDeepDiveDawgs\CommunityCookbook\Test;

use TheDeepDiveDawgs\CommunityCookbook\{CommunityCookbookTest, User, Category, Recipe, Interaction};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

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
	 * Profile that created the Recipe; this is for foreign key relations
	 * @var Recipe Recipe
	 **/

	protected $recipe = null;

	/**
	 * valid RECIPE id to create the RECIPE object to own the test
	 * @var $VALID_RECIPE_ID
	 */

	protected $VALID_RECIPE_ID; "placeholder, valid recipe id"

	/**
	 * content of the Recipe category id
	 * @var string $VALID_RECIPE_ID
	 **/

	protected $VALID_RECIPE_CATEGORY_ID = "place holder for category";

	/**
	 * content of the updated Recipe category id
	 * @var string $VALID_RECIPECATEGORYID2
	 **/

	protected $VALID_RECIPE_CATEGORY2 = "place holder for category";

	/**
	 * content of the updated Recipe user id
	 * @var string $VALID_RECIPEUSERID
	 **/

	protected $VALID_RECIPE_USER_ID = null;


	/**
	 * Valid to use as Recipe description
	 * @var string $VALID_RECIPEDESCRIPTION
	 */

	protected $VALID_RECIPE_DESCRIPTION = null;

	/**
	 * Valid to use as Recipe image url
	 * @var string $VALID_RECIPEDEIMAGEURL
	 */

	protected $VALID_RECIPE_IMAGE_URL = null;

	/**
	 * Valid to use as Recipe ingredients
	 * @var string $VALID_RECIPEINGREDIENTS
	 */

	protected $VALID_RECIPE_INGREDIENTS = null;


	/**
	 * Valid to use as Recipe minutes
	 * @var string $VALID_RECIPEMINUTES
	 */

	protected $VALID_RECIPE_MINUTES = null;


	/**
	 * Valid to use as Recipe name
	 * @var string $VALID_RECIPENAME
	 */

	protected $VALID_RECIPE_NAME = null;


	/**
	 * Valid to use as Recipe number of ingredients
	 * @var string $VALID_RECIPENUMBERINGREDIENTS
	 */

	protected $VALID_RECIPE_NUMBER_INGREDIENTS = null;


	/**
	 * Valid to use as Recipe nutrition
	 * @var string $VALID_RECIPENUTRITION
	 */

	protected $VALID_RECIPE_NUTRITION = null;

	/**
	 * Valid to use as Recipe step
	 * @var string $VALID_RECIPESTEP
	 */

	protected $VALID_RECIPE_STEP = null;

	/**
	 * Valid to use as Recipe submission date
	 * @var string $VALID_RECIPESUBMISSIONDATE
	 * Valid to use as sunriseRecipeDate
	 */

	protected $VALID_RECIPE_SUBMISSION_DATE = null;
	/* Valid  to use as sunriseRecipeDate
	 */

/**
 *  create dependant objects before running each test
 */

	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_RECIPE_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		// create and insert a Profile to own the test Recipe
		$this->profile = new Profile(generateUuidV4(), null,"@handle", "https://media.giphy.com/media/3og0INyCmHlNylks9O/giphy.gif", "test@phpunit.de",$this->VALID_PROFILE_HASH, "+12125551212");
		$this->profile->insert($this->getPDO());
		// calculate the date (just use the time the unit test was setup...)
		$this->VALID_TWEETDATE = new \DateTime();
		//format the sunrise date to use for testing
		$this->VALID_SUNRISEDATE = new \DateTime();
		$this->VALID_SUNRISEDATE->sub(new \DateInterval("P10D"));
		//format the sunset date to use for testing
		$this->VALID_SUNSETDATE = new\DateTime();
		$this->VALID_SUNSETDATE->add(new \DateInterval("P10D"));
		
	}

	/**
	 * test inserting a valid Recipe and verify that the actual mySQL data matches
	 **/
	public function testInsertValidRecipe() : void {

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->profile->getProfileId(), $this->VALID_RECIPE, $this->VALID_RECIPE_ID);
		$recipe->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRecipe = Recipe::getRecipeByRecipeId($this->getPDO(), $recipe->getRecipeId());
		$this->assertEquals($pdoRecipe->getRecipeId()->toString(), $recipeId->toString());
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipe->getRecipeId()->toString());
		$this->assertEquals($pdoRecipe->getRecipeCategoryId(),$this->VALID_RECIPE_ID;
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRecipe->getRecipeUserId()->getTimestamp(), $this->VALID_RECIPE_USER_ID->getTimestamp());
	}

	/**
	 * test inserting a Recipe, editing it, and then updating it
	 **/
	public function testUpdateValidRecipe($pdoRecipeNumberIngredients, $pdoRecipeNutrition, $pdoRecipeStep, $pdoRecipeSubmissionDate, $pdoRecipeName, $pdoRecipeMinutes, $pdoRecipeDescription, $pdoRecipeImageUrl, $pdoRecipeIngredients, $pdoRecipeUserId, $pdoRecipeCategoryId, $pdoRecipeId) : void {

		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");

		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->profile->getProfileId(), $this->VALID_RECIPE_CONTENT, $this->VALID_RECIPE_DATE);
		$recipe->insert($this->getPDO());

		// edit the Recipe and update it in mySQL
		$recipe->setRecipeContent($this->VALID_RECIPE_CATEGORY2);
		$recipe->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoRecipe = Recipe::getRecipeByRecipeId($this->getPDO(), $recipe->getRecipeId());
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertEquals($pdoRecipe->getRecipeProfileId()->toString(), $this->profile->getProfileId()->toString());
		$this->assertEquals($pdoRecipe->getRecipeContent(), $this->VALID_RECIPE_CATEGORY2);
		$this->assertEquals($pdoRecipeId->getRECIPEID(), $this->VALID_RECIPE_ID);
		$this->assertEquals($pdoRecipeCategoryId->getRecipeCategoryId(), $this->VALID_CATEGORY);
		$this->assertEquals($pdoRecipeUserId->getRecipeUserId(), $this->VALID_USER_ID2);
		$this->assertEquals($pdoRecipeDescription->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipeImageUrl->getRecipeImageUrl(), $this->VALID_RECIPE_IMAGE_URL);
		$this->assertEquals($pdoRecipeIngredients->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIETS);
		$this->assertEquals($pdoRecipeMinutes->getRecipeMinutes(), $this->VALID_RECIPE_MINUTES2);
		$this->assertEquals($pdoRecipeName->getRecipeName(), $this->VALID_RECIPE_NAME);
		$this->assertEquals($pdoRecipeNumberIngredients->getRecipeNumberIngredients(), $this->VALID_NUMBER_INGREDIENTS);
		$this->assertEquals($pdoRecipeNutrition->getRecipeNutrition(), $this->VALID_RECIPE_NUTRITION);
		$this->assertEquals($pdoRecipeStep->getRecipeStep(), $this->VALID_STEPS2);
		$this->assertEquals($pdoRecipeSubmissionDate->getRecipeSubmissionDate(), $this->VALID_DATETIME);

		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRecipe->getRecipeDate()->getTimestamp(), $this->VALID_RECIPEDATE->getTimestamp());
	}

	/**
	 * test creating a Recipe and then deleting it
	 **/
	public function testDeleteValidRecipe() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");
		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->profile->getProfileId(), $this->VALID_RECIPE_CONTENT, $this->VALID_RECIPE_DATE);
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
	 * test grabbing a Recipe that does not exist
	 **/
	public function testGetInvalidRecipeByRecipeId($fakeRecipeId) : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$fakeRECIPEID = generateUuidV4();
		$recipe = Recipe::getRecipeByRecipeId($this->getPDO(), $fakeRecipeId);
		$this->assertNull($recipe);
	}

	/**
	 * test inserting a Recipe and re-grabbing it from mySQL
	 *
	 **/
	public function testGetValidRecipeByRecipeProfileId($pdoRecipeSubmissionDate, $pdoRecipeStep, $pdoRecipeNutrition, $pdoRecipe) : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");
		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->profile->getProfileId(), $this->VALID_RECIPECONTENT, $this->VALID_RECIPEDATE);
		$recipe->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Recipe::getRecipeByRecipeProfileId($this->getPDO(), $recipe->getRecipeProfileId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\communityCookBook\\Recipe", $results);
		$this->assertEquals($pdoRecipe->getRecipeId(), $this->VALID_RECIPE);
		$this->assertEquals($pdoRecipe->getRecipeCategoryId(), $this->VALID_RECIPE_CATEGORY_ID);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->VALID_RECIPE_USER_ID);
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeImageUrl(), $this->VALID_RECIPE_IMAGE_URL);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMinutes(), $this->VALID_RECIPE_MINUTES);
		$this->assertEquals($pdoRecipe->getRecipeName(), $this->VALID_RECIPE_NAME);
		$this->assertEquals($pdoRecipe->getRecipeNumberIngredients(), $this->VALID_RECIPE_NUMBER_INGREDIENTS);
		$this->assertEquals($pdoRecipeNutrition->getRecipeNutrition(), $this->VALID_RECIPE_NUTRITTION);
		$this->assertEquals($pdoRecipeStep->getRecipeStep(), $this->VALID_RECIPE_STEPS);
		$this->assertEquals($pdoRecipeSubmissionDate->getRecipeSubmissionDate(), $this->VALID_RECIPE_SUBMISSION_DATE);

		// grab the result from the array and validate it
		$pdoRecipe = $results[0];
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoRecipe->getRecipeContent(), $this->VALID_RECIPE_CONTENT);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRecipe->getRecipeDate()->getTimestamp(), $this->VALID_RECIPE_DATE->getTimestamp());
	}

	/**
	 * test grabbing a Recipe that does not exist
	 * @param $fakeRecipeId
	 * @param $recipe
	 */
	public function testGetInvalidRecipeByRecipeProfileId($fakeRecipeId, $recipe) : void {
		// grab a profile id that exceeds the maximum allowable profile id
		$fakeRecipeId = generateUuidV4();
		$fakeRecipeID = Recipe::getRecipeByRecipeProfileId($this->getPDO(), $fakeRecipeId);
		$this->assertCount(0, $recipe);
	}

	/**
	 * test grabbing a Recipe by recipe content
	 * @param $pdoRecipe
	 * @param $pdoRecipeNutrition
	 * @param $pdoRecipeStep
	 * @param $pdoRecipeSubmissionDate
	 */
	public function testGetValidRecipeByRecipeContent($pdoRecipe, $pdoRecipeNutrition, $pdoRecipeStep, $pdoRecipeSubmissionDate) : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");
		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->profile->getProfileId(), $this->VALID_RECIPE_ID, $this->VALID_RECIPE_DATE);
		$recipe->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Recipe::getRecipeByRecipeContent($this->getPDO(), $recipe->getRecipeContent());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertCount(1, $results);
		// enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\communityCookBook\\Recipe", $results);
		$this->assertEquals($pdoRecipe->getRecipeId(), $this->VALID_RECIPE);
		$this->assertEquals($pdoRecipe->getRecipeCategoryId(), $this->VALID_RECIPE_CATEGORY_ID);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->VALID_RECIPE_USER_ID);
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeImageUrl(), $this->VALID_RECIPE_IMAGE_URL);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMinutes(), $this->VALID_RECIPE_MINUTES);
		$this->assertEquals($pdoRecipe->getRecipeName(), $this->VALID_RECIPE_NAME);
		$this->assertEquals($pdoRecipe->getRecipeNumberIngredients(), $this->VALID_RECIPE_NUMBER_INGREDIENTS);
		$this->assertEquals($pdoRecipeNutrition->getRecipeNutrition(), $this->VALID_RECIPE_NUTRITTION);
		$this->assertEquals($pdoRecipeStep->getRecipeStep(), $this->VALID_RECIPE_STEPS);
		$this->assertEquals($pdoRecipeSubmissionDate->getRecipeSubmissionDate(), $this->VALID_RECIPE_SUBMISSION_DATE);

		// grab the result from the array and validate it
		$pdoRecipe = $results[0];
		$this->assertEquals($pdoRecipe->getRecipeId(), $recipeId);
		$this->assertEquals($pdoRecipe->getRecipeProfileId(), $this->profile->getProfileId());
		$this->assertEquals($pdoRecipe->getRecipeContent(), $this->VALID_TWEETCONTENT);
		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRecipe->getRecipeDate()->getTimestamp(), $this->VALID_RECIPE_DATE->getTimestamp());
	}

	/**
	 * test grabbing a Recipe by content that does not exist
	 **/
	public function testGetInvalidRecipeByRecipeContent() : void {
		// grab a recipe by content that does not exist
		$recipe = Recipe::getRecipeByRecipeContent($this->getPDO(), "line 335 if error, recipe content");
		$this->assertCount(0, $recipe);
	}

	/**
	 * test grabbing all Recipes
	 **/

	public function testGetAllValidRecipes($pdoRecipeSubmissionDate, $pdoRecipeStep, $pdoRecipeNutrition) : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("recipe");
		// create a new Recipe and insert to into mySQL
		$recipeId = generateUuidV4();
		$recipe = new Recipe($recipeId, $this->profile->getProfileId(), $this->VALID_RECIPE_ID, $this->VALID_RECIPE_DATE);
		$recipe->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$results = Recipe::getAllRecipes($this->getPDO());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("recipe"));
		$this->assertCount(1, $results);
		// grab the result from the array and validate it
		$pdoRecipe = $results[0];
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\CommunityCookBook\\Recipe", $results);
		$this->assertEquals($pdoRecipe->getRecipeId(), $this->VALID_RECIPE);
		$this->assertEquals($pdoRecipe->getRecipeCategoryId(), $this->VALID_RECIPE_CATEGORY_ID);
		$this->assertEquals($pdoRecipe->getRecipeUserId(), $this->VALID_RECIPE_USER_ID);
		$this->assertEquals($pdoRecipe->getRecipeDescription(), $this->VALID_RECIPE_DESCRIPTION);
		$this->assertEquals($pdoRecipe->getRecipeImageUrl(), $this->VALID_RECIPE_IMAGE_URL);
		$this->assertEquals($pdoRecipe->getRecipeIngredients(), $this->VALID_RECIPE_INGREDIENTS);
		$this->assertEquals($pdoRecipe->getRecipeMinutes(), $this->VALID_RECIPE_MINUTES);
		$this->assertEquals($pdoRecipe->getRecipeName(), $this->VALID_RECIPE_NAME);
		$this->assertEquals($pdoRecipe->getRecipeNumberIngredients(), $this->VALID_RECIPE_NUMBER_INGREDIENTS);
		$this->assertEquals($pdoRecipeNutrition->getRecipeNutrition(), $this->VALID_RECIPE_NUTRITTION);
		$this->assertEquals($pdoRecipeStep->getRecipeStep(), $this->VALID_RECIPE_STEPS);
		$this->assertEquals($pdoRecipeSubmissionDate->getRecipeSubmissionDate(), $this->VALID_RECIPE_SUBMISSION_DATE);

		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoRecipe->getRecipeDate()->getTimestamp(), $this->VALID_RECIPE_DATE->getTimestamp());

	}

	/**
	 * @param string $VALID_RECIPE_SUBMISSION_DATE
	 * @return RecipeTest
	 */
	public function setVALID_RECIPE_SUBMISSION_DATE(string $VALID_RECIPE_SUBMISSION_DATE): RecipeTest {
		$this->VALID_RECIPE_SUBMISSION_DATE = $VALID_RECIPE_SUBMISSION_DATE;
		return $this;
	}

	private function assertEquals($getRecipeImageUrl, string $VALID_RECIPE_IMAGE_URL) {
	}

}
