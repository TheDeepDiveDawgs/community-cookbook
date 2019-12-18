-- these statements will drop table from database and re-add them in child to parent order.
drop table if exists interaction;
drop table if exists recipe;
drop table if exists category;
drop table if exists user;

-- creating new table called user
create table user(
   -- primary key
	userId BINARY(16) not null,
	userActivationToken CHAR(32),
	userEmail VARCHAR(128) not null,
	userFullName VARCHAR(255) not null,
	userHandle VARCHAR(32) not null,
	userHash CHAR(97) not null,
	-- making attribute unique to ensure emails do not duplicate
	unique(userEmail),
	-- making attribute unique to ensure user names do not duplicate
	unique(userHandle),
	-- this officiates the primary key for this table
	primary key(userId)
);

-- create new table called category
create table category(
   -- primary key
	categoryId BINARY(16) not null,
	categoryName VARCHAR(24) not null,
	-- making attribute unique to ensure every category does not duplicate
	unique(categoryName),
	-- this officiates the primary key for this table
	primary key(categoryId)
);

-- create new table called recipe
create table recipe(
   -- primary key
	recipeId BINARY(16) not null,
	-- foreign key
	recipeCategoryId BINARY(16)not null,
	-- foreign key
	recipeUserId BINARY(16) not null,
	recipeDescription VARCHAR(1000),
	recipeImageUrl VARCHAR(255),
	recipeIngredients VARCHAR(300) not null,
	recipeMinutes INT(3) not null,
	recipeName VARCHAR(100) not null,
	recipeNumberIngredients INT(2) not null,
	recipeNutrition VARCHAR(255),
	recipeStep VARCHAR(1500) not null,
	recipeSubmissionDate DATETIME(6) not null,
	-- index the foreign keys
	index(recipeCategoryId),
	index(recipeUserId),
	-- this officiates the primary key for this table
	primary key(recipeId),
	-- this creates the foreign key to improve join performance between recipe and user table
	foreign key(recipeUserId) references user(userId),
	-- this creates the foreign key to improve join performance between recipe and category table
	foreign key(recipeCategoryId) references category(categoryId)
);

-- create new table called interaction
create table interaction(
	-- foreign key
	interactionUserId BINARY(16) not null,
	-- foreign key
	interactionRecipeId BINARY(16) not null,
	interactionDate DATETIME(6) not null,
	interactionRating INT(1),
	-- index the foreign keys
	index(interactionUserId),
	index (interactionRecipeId),
	-- this creates the foreign key to improve join performance between interaction and user table
	foreign key(interactionUserId) references user(userId),
	-- this creates the foreign key to improve join performance between interaction and recipe table
	foreign key(interactionRecipeId) references recipe(recipeId),
	primary key (interactionUserId, interactionRecipeId)
);


