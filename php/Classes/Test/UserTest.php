<?php
namespace TheDeepDiveDawgs\CommunityCookbook\Test;

use TheDeepDiveDawgs\CommunityCookbook\{User, Category, Recipe, Interaction};

// grab the class under scrutiny
require_once(dirname(__DIR__) . "/autoload.php");

// grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/**
 * Full PHPUnit Test for the User class
 *
 * This is a complete PHPUnit Test of the User class. It is complete because *ALL* mySQL/PDO enabled methods
 * are tested for both invalid and valid inputs.
 *
 * @see User
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 **/
class UserTest extends CommunityCookbookTest {

	/**
	 * placeholder until account activation is created
	 * @var string $VALID_ACTIVATION
	 */
	protected $VALID_ACTIVATION;

	/**
	 * valid email to use
	 * @var string $VALID_EMAIL
	 */
	protected $VALID_EMAIL = "grievxus@outlook.com";
	/**
	 * valid full name for user
	 * @var string $VALID_FULLNAME
	 **/
	protected $VALID_FULLNAME = "Gino Villalpando";
	/**
	 * valid handle to use
	 * @var string $VALID_HANDLE
	 **/
	protected $VALID_HANDLE = "@grievous";

	/**
	 * second valid handle to use
	 * @var string $VALID_HANDLE2
	 */
	protected $VALID_HANDLE2 = "@grievous";

	/**
	 * valid hash to use
	 * @var $VALID_USER_HASH
	 */
	protected $VALID_USER_HASH;



	/**
	 * create dependent objects before running each Test
	 **/
	public final function setUp()  : void {
		// run the default setUp() method first
		parent::setUp();
		$password = "abc123";
		$this->VALID_USER_HASH = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 384]);
		$this->VALID_ACTIVATION = bin2hex(random_bytes(16));
	}
		public function testInsertValidUser() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		$userId = generateUuidV4();

		// create and insert a User to own the Test recipe
		$user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_FULLNAME, $this->VALID_HANDLE, $this->VALID_USER_HASH);
		$user->insert($this->getPDO());

		//grab the data from mySQL and enforce the fields match our expectation
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFullName(), $this->VALID_FULLNAME);
		$this->assertEquals($pdoUser->getUserHandle(), $this->VALID_HANDLE);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_USER_HASH);
		}
	/**
	 * Test inserting a User, editing it, and then updating it
	 **/
	public function testUpdateValidUser() {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		// create a new User and insert to into mySQL
		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_FULLNAME, $this->VALID_HANDLE, $this->VALID_USER_HASH);
		$user->insert($this->getPDO());

		// edit the User and update it in mySQL
		$user->setUserHandle($this->VALID_HANDLE2);
		$user->update($this->getPDO());

		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFullName(), $this->VALID_FULLNAME);
		$this->assertEquals($pdoUser->getUserHandle(), $this->VALID_HANDLE2);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_USER_HASH);
	}

	/**
	 * Test creating a User and then deleting it
	 **/
	public function testDeleteValidUser() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");
		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_FULLNAME, $this->VALID_HANDLE, $this->VALID_USER_HASH);
		$user->insert($this->getPDO());
		// delete the User from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$user->delete($this->getPDO());
		// grab the data from mySQL and enforce the User does not exist
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertNull($pdoUser);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("user"));
	}


	/**
	 * Test inserting a User and re-grabbing it from mySQL
	 **/
	public function testGetValidUserByUserId() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");
		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_FULLNAME, $this->VALID_HANDLE, $this->VALID_USER_HASH);
		$user->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserId($this->getPDO(), $user->getUserId());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFullName(), $this->VALID_FULLNAME);
		$this->assertEquals($pdoUser->getUserHandle(), $this->VALID_HANDLE);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_USER_HASH);
	}

	/**
	 * Test grabbing a User that does not exist
	 **/
	public function testGetInvalidUserByUserId() : void {
		// grab a User id that exceeds the maximum allowable User id
		$fakeUserId = generateUuidV4();
		$user = User::getUserByUserId($this->getPDO(), $fakeUserId );
		$this->assertNull($user);
	}

	/**
	 * test creating a user by user handle
	 */
	public function testGetValidUserByUserHandle() {

		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");

		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_FULLNAME, $this->VALID_HANDLE, $this->VALID_USER_HASH);
		$user->insert($this->getPDO());

		//grab the data from mySQL
		$results = User::getUserByUserHandle($this->getPDO(), $this->VALID_HANDLE);
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("user"));

		//enforce no other objects are bleeding into user
		$this->assertContainsOnlyInstancesOf("TheDeepDiveDawgs\\CommunityCookbook\\User", $results);

		//enforce the results meet expectations
		$pdoUser = $results[0];
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFullName(), $this->VALID_FULLNAME);
		$this->assertEquals($pdoUser->getUserHandle(), $this->VALID_HANDLE);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_USER_HASH);
	}

	/*
	 * test grabbing a user by handle that does not exist
	 */
	public function testGetInvalidUserByUserHandle() : void {

		//grab a handle that does not exist
		$user = User::getUserByUserHandle($this->getPDO(), "noUsername");
		$this->assertCount(0, $user);
	}

	/**
	 * Test grabbing a User by email
	 **/
	public function testGetValidUserByEmail() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");
		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_FULLNAME, $this->VALID_HANDLE, $this->VALID_USER_HASH);
		$user->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserEmail($this->getPDO(), $user->getUserEmail());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFullName(), $this->VALID_FULLNAME);
		$this->assertEquals($pdoUser->getUserHandle(), $this->VALID_HANDLE2);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_USER_HASH);
	}
	/**
	 * Test grabbing a User by an email that does not exists
	 **/
	public function testGetInvalidUserByEmail() : void {
		// grab an email that does not exist
		$user = User::getUserByUserEmail($this->getPDO(), "does@not.exist");
		$this->assertNull($user);
	}

	/**
	 * Test grabbing a User by its activation token
	 */
	public function testGetValidUserByActivationToken() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("user");
		$userId = generateUuidV4();
		$user = new User($userId, $this->VALID_ACTIVATION, $this->VALID_EMAIL, $this->VALID_FULLNAME, $this->VALID_HANDLE, $this->VALID_USER_HASH);
		$user->insert($this->getPDO());
		// grab the data from mySQL and enforce the fields match our expectations
		$pdoUser = User::getUserByUserActivationToken($this->getPDO(), $user->getUserActivationToken());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("user"));
		$this->assertEquals($pdoUser->getUserId(), $userId);
		$this->assertEquals($pdoUser->getUserActivationToken(), $this->VALID_ACTIVATION);
		$this->assertEquals($pdoUser->getUserEmail(), $this->VALID_EMAIL);
		$this->assertEquals($pdoUser->getUserFullName(), $this->VALID_FULLNAME);
		$this->assertEquals($pdoUser->getUserHandle(), $this->VALID_HANDLE);
		$this->assertEquals($pdoUser->getUserHash(), $this->VALID_USER_HASH);
	}
	/**
	 * Test grabbing a User by an activation token that does not exist
	 **/
	public function testGetInvalidUserActivation() : void {
		// grab an activation token that does not exist
		$user = User::getUserByUserActivationToken($this->getPDO(), "88015c507fbc02f37bf8bc398ee4eaad");
		$this->assertNull($user);
	}
}
