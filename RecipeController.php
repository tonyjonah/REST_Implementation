<?php

// namespace REST2;



/**
* RecipeController class
*
* @package REST2
* @author tonyjonah
**/
class RecipeController Extends PDO {

	/**
	* @var PDO object to store the connection to the mysql db
	*/
	private $db_conn;

	require 'cred.php';

	/**
	* Constructor for RecipeController
	*
	* @param null
	* @return void
	*/
	public function __constructor($db, $login, $pass) 
	{
		try {
			$db_conn = new PDO($db, $login, $pass);
		} catch(PDOException $e) {
			echo "Could not connect to database" . $e->getMessage() . ' on line ' . $e->getLine();
		}
		return $this;
	}

	/**
	 * GetMenu gets the complete details of the meal
	 * 
	 * @param integer $meal_id
	 * @return array
	 */
	public function getMenu($meal_id) {		
		$sql = 'SELECT recipes.name, recipes.description, recipes.chef, categories.name
				FROM recipes INNER JOIN categories
				ON recipes.category_id = categories.id
				WHERE recipes.id = :id';

		$stmt = $db_conn->prepare($sql);

		$stmt->execute(
			array(
				'id' => $meal_id,
			));

		$response = $stmt->fetchAll();

		return $response;
	}

	/**
	 * GetCategory gets the category of the meal
	 *
	 * @param string category The category of food to choose
	 * @param integer meal_id 
	 * @return array
	 */
	public function getCategory($category, $meal_id) {
		$sql = 'SELECT recipes.name, recipes.description, recipes.chef, categories.name
				FROM recipes INNER JOIN categories
				ON recipes.category_id = categories.id
				WHERE categories.id = :category_id
				AND recipes.id = :id';

		$stmt = $db_conn->prepare($sql);

		$stmt->execute(
			array(
				'category_id' => $category,
				'id' => $meal_id,
			));

		$respone = $stmt->fetchAll();

		return $response;
	}

	/**
	* GetFullMenu gets the full listing of all meals and their details
	*
	* @return array
	*/
	public function getFullMenu() {
		$sql = 'SELECT recipes.name, recipes.description, recipes.chef, categories.name
				FROM recipes INNER JOIN categories 
				ON recipes.category_id = categories.id;'; 

				$stmt = $this->db_conn->prepare($sql);

		$stmt->execute();

		$respone = $stmt->fetchAll();
	}
}
// END class