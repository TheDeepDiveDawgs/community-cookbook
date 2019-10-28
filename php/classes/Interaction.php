<?php

	/**
 	* cross section of of interaction class
 	**/

	class interaction {

		/**foreign key**/
		private $interactionUserId;

		/**foreign key**/
		private $interactionRecipeId;

		/**Date of rating**/
		private $interactionDate;

		/**user rating of recipe**/
		private $interactionRating;

		/**accessor method for interactionUserId
		 *@return Uuid value of interactionUserId
		 **/
		public function getInteractionUserId(): Uuid {
			return ($this->interactionUserId);
		}

		/**
		 * mutator method for interactionUserId
		 * @param uuid | string $newInteractionUserId value of new interaction user id
		 * @throws \RangeException if the $interactionUserId is not positive
		 * @throws \TypeError if $interactionUserId is not positive
		 * */

		public function setInteractionUserId($newInteractionUserId): void {
			try {
				$uuid = self::validateUuid($newInteractionUserId);
			} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception){
				$exceptionType = get_class($exception);
				throw(new $exceptionType($exception->getMessage(), 0, $exception));
			}

		//convert and store interactionUserId
		$this->interactionUserId = $uuid;

		}

		/**
		 * accessor method for interactionRecipeId
		 * @returns string value of interactionRecipeId
		 */

		public function getInteractionRecipeId():string{
			return ($this->interactionRecipeId);
		}

		/**
		 * mutator method for interaction recipe id
		 * @param string $newInteractionRecipeId new value of interaction user id
		 * @throws \InvalidArgumentException if $newInteractionRecipeId is not a string
		 * @throws \TypeError if $newInteractionRecipeId is not a string
		 */

		public function setInteractionRecipeId(string $newInteractionRecipeId): void {
		//if $interactionRecipeId is null return it right away
			if($newInteractionRecipeId === null) {
				$this->interactionRecipeId = null;
				return;
			}
			//store the interaction recipe id
			$this->interactionRecipeId =$newInteractionRecipeId;
		}

		/**
		 * accessor method for interaction date
		 */
	}