-- these statements will drop table from database and re-add them in child to parent order.
drop table if exists user;
drop table if exists recipe;
drop table if exists category;
drop table if exists  interaction;

-- creating new table called user
create table user(
	userId BINARY(16) not null,
	userName,
	userEmail,
	userActivationToken,
	userUsername,
	userHash,
	unique(userEmail),
	primary key(userId)
);

-- create new table called recipe
create table recipe(
	recipeId,
	recipeUserId,
	recipeSubmissionDate,
	recipeName,
	recipeMinutes,
	recipeTags,
	recipeNutrition,
	recipeNumberSteps,
	recipeSteps,
	recipeDescription,
	recipeIngredients,
	recipeNumberIngredients,
	recipeRating,
	primary key(recipeId),
	foreign key(recipeUserId) references user(userId)
);

-- create new table called category
create table category(
	categoryId,
	categoryRecipeId,
	categoryName,
	primary key(categoryId),
	foreign key(categoryRecipeId) references recipe(recipeId)
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