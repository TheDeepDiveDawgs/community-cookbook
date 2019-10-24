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
	userHandle,
	userHash ,
	userName ,
	unique(userEmail),
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
	recipeRating,
	recipeSteps,
	recipeSubmissionDate,
	recipeTags,
	primary key(recipeId),
	foreign key(recipeUserId) references user(userId),
	foreign key(receipeCategoryId) references category(categoryId)
);

-- create new table called category
create table category(
	categoryId BINARY,
	categoryName,
	primary key(categoryId)
);

-- create new table called interaction
create table interaction(
	interactionUserId,
	interactionRecipeId,
	interactionDate,
	interactionRating,
	foreign key(interactionUserId) references user(userId),
	foreign key(interactionRecipeId) references recipe(recipeId)
);