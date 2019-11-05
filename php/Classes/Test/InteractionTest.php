<?php
namespace TheDeepDiveDawgs\CommunityCookbook\Test;
use TheDeepDiveDawgs\CommunityCookbook\CommunityCookbookTest;
use TheDeepDiveDawgs\CommunityCookBook\{
		User, Category, Recipe, Interaction
};

//grab class under scrutiny
require_once(dirname(__DIR__) . "autoload.php");

//grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");

/*
 * Full PHP unit test for the interaction class
 *
 * This is a complete unit test for the interaction class, complete due to all mySQL/PDO
 * enable methods are tested valid and invalid inputs
 *
 * @see interaction
 *
 * @author Daniel Hernandez
 */

class InteractionTest extends CommunityCookbookTest {

	/**
	 * User that created the Interaction, this is for foreign key relations
	 * @var User $user
	 **/

	protected $user = null;

	/**
	 * Recipe that the Interaction was based on, this is for foreign key relations
	 * @var Recipe $user
	 */

	protected $recipe = null;

}