<?php 

class Category
{

	private $conn;
	private $tableName = 'category';

	public $id;
	public $fullname;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	// used to read category name from ID
	public function readName()
	{

		$query = 'SELECT fullname FROM ' . $this->tableName . ' WHERE id=:id';

		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->fullname = $row['fullname'];

	}

	//for drop-down
	public function read() 
	{

		$query = 'SELECT id, fullname FROM ' . $this->tableName . ' ORDER BY fullname';

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt;

	}

}