-- these statements will drop table from database and re-add them in child to parent order.
drop table if exists recipe;
drop table if exists  interaction;
drop table if exists category;
drop table if exists user;

-- creating new table called user
create table user(
	userId BINARY(16) not null,
	userActivationToken CHAR(32) not null,
	userFullName VARCHAR(255) not null,
	userEmail VARCHAR(128) not null,
	userHandle VARCHAR(32) not null,
	userHash CHAR(97) not null,
	-- making attribute unique to ensure emails do not duplicate
	unique(userEmail),
	-- this officiates the primary key for this table
	primary key(userId)
);

-- create new table called category
create table category(
	categoryId BINARY(16) not null,
	categoryName VARCHAR(24) not null,
	-- this officiates the primary key for this table
	primary key(categoryId)
);

-- create new table called interaction
create table interaction(
	interactionUserId BINARY(16) not null,
	interactionRecipeId BINARY(16) not null,
	interactionDate DATETIME not null,
	interactionRating INT(4) not null,
	-- this creates th e foreign key to improve join performance between interaction and user table
	foreign key(interactionUserId) references user(userId),
	-- this creates th e foreign key to improve join performance between interaction and receipe table
	foreign key(interactionRecipeId) references recipe(recipeId)
);

-- create new table called recipe
create table recipe(
	recipeId BINARY(16) not null,
	recipeCategoryId BINARY(16)not null,
	recipeUserId BINARY(16) not null,
	recipeDescription VARCHAR(500),
	recipeImageUrl VARCHAR(255),
	recipeIngredients VARCHAR(3000) not null,
	recipeMinutes INT(5) not null,
	recipeName VARCHAR(100) not null,
	recipeNutrition VARCHAR(255),
	recipeNumberIngredients INT(4) not null,
	recipeStep VARCHAR(4000) not null,
	recipeSubmissionDate DATETIME not null,
	-- this officiates the primary key for this table
	primary key(recipeId),
	-- this creates th e foreign key to improve join performance between recipe and user table
	foreign key(recipeUserId) references user(userId),
	-- this creates th e foreign key to improve join performance between recipe and category table
	foreign key(recipeCategoryId) references category(categoryId)
);
