-- these statements will drop table from database and re-add them in child to parent order.
drop table if exists user;
drop table if exists recipe;
drop table if exists category;
drop table if exists  interaction;

-- creating new table called user
create table user(
	userId BINARY(16) not null,
	userActivationToken,
	userEmail,
	userFullName ,
	userHandle,
	userHash,
	-- making attribute unique to ensure emails do not duplicate
	unique(userEmail),
	-- this officiates the primary key for this table
	primary key(userId)
);

-- create new table called recipe
create table recipe(
	recipeId,
	receipeCategoryId,
	recipeUserId,
	recipeDescription,
	recipeIngredients,
	recipeMinutes,
	recipeName,
	recipeNutrition,
	recipeNumberIngredients,
	recipeSteps,
	recipeSubmissionDate,
	-- this officiates the primary key for this table
	primary key(recipeId),
	-- this creates th e foreign key to improve join performance between recipe and user table
	foreign key(recipeUserId) references user(userId),
	-- this creates th e foreign key to improve join performance between recipe and category table
	foreign key(receipeCategoryId) references category(categoryId)
);

-- create new table called category
create table category(
	categoryId BINARY,
	categoryName,
	-- this officiates the primary key for this table
	primary key(categoryId)
);

-- create new table called interaction
create table interaction(
	interactionUserId,
	interactionRecipeId,
	interactionDate,
	interactionRating,
	-- this creates th e foreign key to improve join performance between interaction and user table
	foreign key(interactionUserId) references user(userId),
	-- this creates th e foreign key to improve join performance between interaction and receipe table
	foreign key(interactionRecipeId) references recipe(recipeId)
);