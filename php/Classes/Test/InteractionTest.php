<?php
namespace TheDeepDiveDawgs\CommunityCookbook\Test;

use TheDeepDiveDawgs\CommunityCookbook\{User, Recipe, Interaction};

// grab the encrypted properties file
require_once("/etc/apache2/capstone-mysql/Secrets.php");


//grab class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

//grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/*
 * Full PHP unit test for the Interaction class
 *
 * This is a complete unit test for the Interaction class, complete due to all mySQL/PDO
 * enable methods are tested valid and invalid inputs
 *
 * @see Interaction
 * @author Daniel Hernandez
 */

class InteractionTest extends CommunityCookbookTest {

	/**
	 * User that created the interaction, this is for foreign key relations
	 * @var User $user
	 **/
	protected $user = null;

	/**
	 * Recipe that the interaction was based on, this is for foreign key relations
	 * @var Recipe $user
	 */
	protected $recipe = null;

	/**
	 * Interaction of a recipe by a user, this is for foreign key relations
	 * @var Interaction $interaction
	 */
	protected $interaction = null;

	/**
	 * valid user hash to create the user object to own the test
	 * @var $VALID_USER_HASH
	 */
	protected $VALID_USER_HASH;

	/**
	 * valid activationToken to create profile object to own the test
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION;

	/**
	 *timestamp of interaction; this starts at null and is assigned later
	 * @var \DateTime $VALID_INTERACTIONDATE
	 */
	protected $VALID_INTERACTIONDATE;

	/**
	 * rating of interaction
	 * @var int $VALID_INTERACTIONRATING
	 */
	protected $VALID_INTERACTIONRATING = "PHPUnit Test Passing";

	/**
	 * content of updated rating
	 * @var int $VALID_INTERACTIONRATING2
	 */
	protected $VALID_INTERACTIONRATING2 = "PHPUnit Test Still Passing";

	/**
	 * create dependent objects before running each test
	 */

	public final function setUp(): void {
		//run default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_USER_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));

		//create and insert User to own the test Interaction
		$this->user = new User(generateUuidV4(), $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_FULLNAME, $this->VALID_HANDLE, $this->VALID_HANDLE2, $this->VALID_USER_HASH);
		$this->user->insert($this->getPDO());

		//create and insert mocked recipe
		$this->recipe = new Recipe(generateUuidV4(), $this->user->getUserId(), "PHPUnit interaction test passing");
		$this->recipe->insert($this->getPDO());

		//calculate the date (use the the time the unit test was setup)
		$this->VALID_INTERACTIONDATE = new \DateTime();

		}

	/**
	 * test inserting a valid interaction and verify that the actual mySQL data matches
	 */
	public function testInsertValidInteraction(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("interaction");

		//create a new interaction and insert into mySQL
		$interaction = new Interaction($this->user->getUserId(), $this->recipe->getRecipeId(), $this->VALID_INTERACTIONDATE);
		$interaction->insert($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoInteraction = Interaction::getInteractionByInteractionRecipeIdAndInteractionUserId($this->getPDO(), $this->user->getUserId(), $this->recipe->getRecipeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("interaction"));
		$this->assertEquals($pdoInteraction->getUserId(), $this->user->getUserId());
		$this->assertEquals($pdoInteraction->getRecipeId(), $this->user->getRecipeId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoInteraction->getInteractionDate()->getTimeStamp(), $this->VALID_INTERACTIONDATE->getTimestamp());

	}

	/**
	 * test inserting a Interaction, editing it, and then updating it
	 **/
	public function testUpdateValidInteraction(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("interaction");

		//create a new Interaction and insert to into mySQL
		$interaction = new Interaction($this->user->getUserId(), $this->recipe->getRecipeId(), $this->VALID_INTERACTIONDATE);
		$interaction->insert($this->getPDO());

		//edit the interaction and update the interaction from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("interaction"));
		$interaction->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoInteraction = Interaction::getInteractionByInteractionRecipeIdAndInteractionUserId($this->getPDO(), $this->user->getUserId(), $this->recipe->getRecipeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("interaction"));
		$this->assertEquals($pdoInteraction->getUserId(), $this->user->getUserId());
		$this->assertEquals($pdoInteraction->getRecipeId(), $this->user->getRecipeId());
		//format the date too seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoInteraction->getInteractionDate()->getTimeStamp(), $this->VALID_INTERACTIONDATE->getTimestamp());

	}

	/**
	 * test creating a Interaction and then deleting it
	 */
	public function testDeleteValidInteraction(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("interaction");

		//create a new Interaction and insert to into mySQL
		$interaction = new Interaction($this->user->getUserId(), $this->recipe->getRecipeId(), $this->VALID_INTERACTIONDATE);
		$interaction->insert($this->getPDO());

		//delete the interaction from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("interaction"));
		$interaction->delete($this->getPDO());

		//grab the data from mySQL and enforce the Recipe does not exist
		$pdoInteraction = Interaction::getInteractionByInteractionRecipeIdAndInteractionUserId($this->getPDO(), $this->user->getUserId(), $this->recipe->getRecipeId());
		$this->assertNull($pdoInteraction);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("interaction"));
	}

	/**
	 * test inserting a Interaction and regrabbing it from mySQL
	 */

	public function testGetInteractionByInteractionRecipeIdAndInteractionUserId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("interaction");

		//create a new interaction and insert into mySQL
		$interaction = new Interaction($this->user->getUserId(), $this->interaction->getInteractionId(), $this->VALID_INTERACTIONDATE);
		$interaction->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectations
		$pdoInteraction = Interaction::getInteractionByInteractionRecipeIdAndInteractionUserId($this->getPDO(), $this->user->getUserId(), $this->recipe->getRecipeId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("interaction"));
		$this->assertEquals($pdoInteraction->getInteractionUserId(), $this->user->getUserId());
		$this->assertEquals($pdoInteraction->getInteractionRecipeId(), $this->recipe->getRecipeId());

		//format date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoInteraction->getInteractionDate()->getTimestamp(), $this->VALID_INTERACTIONDATE->getTimestamp());

	}

	/**
	 * test grabbing an interaction that does not exist
	 **/

	public function testGetInvalidInteractionByInteractionRecipeIdAndInteractionUserId() {
		//grab a recipe id and user id that exceeds the maximum allowable recipe id and user id
		$interaction = Interaction::getInteractionByInteractionRecipeIdAndInteractionUserId($this->getPDO(), generateUuidV4(), generateUuidV4());
		$this->assertNull($interaction);

	}

	/**
	 * test grabbing an Interaction by recipe id
	 */

	public function testGetValidInteractionByRecipeId(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("interaction");

		//create a new Interaction and insert into mySQL
		$interaction = new Interaction($this->user->getUserId(), $this->recipe->getRecipeId(), $this->VALID_INTERACTIONDATE);
		$interaction->insert($this->getPDO());

		//grab the data form mySQL and enforce the fields match our expectations
		$results = Interaction::getInteractionByInteractionRecipeId($this->getPDO(), $this->recipe->getRecipeId());
		$this->assertEquals($numRows + 1, $this->getConnection() - getRowCount("interaction"));
		$this->assertCount(1, $results);
		$this->assertOnlyContainsInstancesOf("TheDeepDiveDawgs\CommunityCookbook\Interaction", $results);

		//grab the result and from the array and validate it
		$pdoInteraction = $results[0];
		$this->assertEquals($pdoInteraction->getInteractionUserId(), $this->user->getUserId());
		$this->assertEquals($pdoInteraction->getInteractionRecipeId(), $this->interaction->getRecipeId());

		//format date to seconds since the beginning of time to avoid a roundoff error
		$this->assertEquals($pdoInteraction->getInteractionDate()->getTimeStamp(), $this->VALID_INTERACTIONDATE->getTimestamp());
	}

	/**
	 * test grabbing an interaction by user id
	 */

	public function testGetValidInteractionByUserId(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("interaction");

		//create a new interaction and insert into mySQL
		$interaction = new Interaction($this->user->getUserId(), $this->interaction->getRecipeId(), $this->VALID_INTERACTIONDATE);
		$interaction->insert($this->getPDO());

		//grab the data from mySQL and enforce that the fields match our expectations
		$results = Interacton::getInteractionByInteractionUserId($this->getPDO(), $this->user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("interaction"));
		$this->assertCount(1, $results);

		//enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("TheDeepDiveDawgs\CommunityCookbook\Interaction", $results);

		//grab the result from the array and validate it
		$pdoInteraction = $results[0];
		$this->assertEquals($pdoInteraction->getInteractionUserId(), $this->user->getUserId());
		$this->assertEquals($pdoInteraction->getInteractionRecipeId(), $this->recipe->getRecipeId());

		//format the date to seconds since the beginning of time to avoid round off error
		$this->assertEquals($pdoInteraction->getInteractionDate()->getTimeStamp(), $this->VALID_INTERACTIONDATE->getTimestamp());

	}

	/**
	 *
	 * test grabbing a interaction by user id that does not exist
	 */

	public function testGetInvalidInteractionByUserId(): void {
		//grab a recipe id that exceeds the maximum allowable user id
		$interaction = Interaction::getInteractionByInteractionUserId($this->getPDO(), generateUuidV4());
		$this->assertCount(0, $interaction);
	}
}


