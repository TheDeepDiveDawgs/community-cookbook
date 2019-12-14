<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";
require_once (dirname(__DIR__, 2) . "/Classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require("../../lib/uuid.php");

$secrets = new \Secrets("/etc/apache2/capstone-mysql/cookbook.ini");
$pdo = $secrets->getPdoObject();

use TheDeepDiveDawgs\CommunityCookbook\ {Category};


$category1 = new Category(generateUuidV4(), "New Mexican");
$category1->insert($pdo);

$category2 = new Category(generateUuidV4(), "Appetizers");
$category2->insert($pdo);

$category3 = new Category(generateUuidV4(), "Breakfast");
$category3->insert($pdo);

$category4 = new Category(generateUuidV4(), "Dessert");
$category4->insert($pdo);


$category5 = new Category(generateUuidV4(), "Dinner");
$category5->insert($pdo);

$category6 = new Category(generateUuidV4(), "Holiday");
$category6->insert($pdo);

$category7 = new Category(generateUuidV4(), "Kid-friendly");
$category7->insert($pdo);

$category8 = new Category(generateUuidV4(), "Lunch");
$category8->insert($pdo);

$category9 = new Category(generateUuidV4(), "Vegetarian");
$category9->insert($pdo);



