<?php
require_once dirname(__DIR__, 2) . "/vendor/autoload.php";
require_once (dirname(__DIR__, 2) . "/Classes/autoload.php");
require_once("/etc/apache2/capstone-mysql/Secrets.php");
require("../../lib/uuid.php");

$secrets = new \Secrets("/etc/apache2/capstone-mysql/cookbook.ini");
$pdo = $secrets->getPdoObject();


use TheDeepDiveDawgs\CommunityCookbook\{User, Recipe, Interaction, Category};

$password = "C00kb00k26!";
$hash = password_hash($password, PASSWORD_ARGON2I, ["time_cost" => 9]);

$abqcookbook = new User(generateUuidV4(), null, "abqcookbook@gmail.com", "Abq CookBook", "AbqCookBook", $hash);
$abqcookbook->insert($pdo);
echo "successful user creation";

$newmexican = new Category(generateUuidV4(), "New Mexican");
$newmexican->insert($pdo);
echo "successful category creation1";
$appetizers = new Category(generateUuidV4(), "Appetizers");
$appetizers->insert($pdo);
echo "successful category creation2";
$breakfast = new Category(generateUuidV4(), "Breakfast");
$breakfast->insert($pdo);
echo "successful category creation3";
$dessert = new Category(generateUuidV4(), "Dessert");
$dessert->insert($pdo);
echo "successful category creation4";
$dinner = new Category(generateUuidV4(), "Dinner");
$dinner->insert($pdo);
echo "successful category creation5";
$holiday = new Category(generateUuidV4(), "Holiday");
$holiday->insert($pdo);
echo "successful category creation6";


$recipe1 = new Recipe(generateUuidV4(), $breakfast->getCategoryId(), $abqcookbook->getUserId(),  "named after the movie because on their own, 
each of the fruits used would be rejected, but together they make a popular combination! 
(amounts are approximate--use whatever you have)", null, ["bananas",
"strawberries",
"fresh pineapple",
"low-fat plain yogurt"],
10, "Breakfast Club Smoothie", 4, null, ["cut fruit in large chunks",
"puree in blender until smooth and pink",
"be refreshed as your bad fruit is redeemed !"], null);
$recipe1->insert($pdo);
echo "successful recipe creation1";
