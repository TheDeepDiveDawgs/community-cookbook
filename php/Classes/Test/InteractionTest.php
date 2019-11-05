<?php
namespace TheDeepDiveDawgs\CommunityCookbook\Test;
use TheDeepDiveDawgs\CommunityCookBook\{
		User, Category, Recipe, Interaction
};

//grab class under scrutiny
require_once(dirname(__DIR__) . "autoload.php");

//grab the uuid generator
require_once(dirname(__DIR__, 1) . "lib/uuid.php");