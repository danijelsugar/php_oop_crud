<?php

class Product
{

	//database connection and table name
	private $conn;
	private $tableName = 'products';

	// object properties
    public $id;
    public $fullname;
    public $price;
    public $description;
    public $category_id;
    public $timestamp;

    public function __construct($db) 
    {
    	$this->conn = $db;
    }

    //create product
    public function create() 
    {

    	//query
    	$query = "INSERT INTO " . $this->tableName . " SET fullname=:fullname, price=:price, description=:description, category_id=:category_id, created=:created";

    	$stmt = $this->conn->prepare($query);

    	//posted values
    	$this->fullname = htmlspecialchars(strip_tags($this->fullname));
    	$this->price = htmlspecialchars(strip_tags($this->price));
    	$this->description = htmlspecialchars(strip_tags($this->description));
    	$this->category_id = htmlspecialchars(strip_tags($this->category_id));

    	//to get timestamp for created field
    	$this->timestamp = date('Y-m-d H:i:s');

        //bind values
    	$stmt->bindParam(':fullname', $this->fullname);
    	$stmt->bindParam(':price', $this->price);
    	$stmt->bindParam(':description', $this->description);
    	$stmt->bindParam(':category_id', $this->category_id);
    	$stmt->bindParam(':created', $this->timestamp);

    	if($stmt->execute()){
    		return true;
    	}else{
    		return false;
    	}

    }

    public function readAll($fromRecordNum, $recordsPerPage)
    {

    	$query = "SELECT
                id, fullname, description, price, category_id
            FROM
                " . $this->tableName . "
            ORDER BY
                fullname ASC
            LIMIT
                {$fromRecordNum}, {$recordsPerPage}";
 
	    $stmt = $this->conn->prepare($query);
	    $stmt->execute();
	 
	    return $stmt;

    }

    // used for paging products
    public function countAll() 
    {

        $query = "SELECT id FROM " . $this->tableName . "";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;

    }

    //reads all information about a particular product 
    public function readOne() 
    {

        $query = "SELECT
                    id, fullname, description, price, category_id 
                FROM 
                    " . $this->tableName . "
                WHERE 
                    id=:id
                LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('id',$this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->fullname = $row['fullname'];
        $this->description = $row['description'];
        $this->price = $row['price'];
        $this->category_id = $row['category_id'];

    }

    //updates particular product
    public function update() 
    {

        $query = "UPDATE "
                    . $this->tableName . " 
                SET
                    fullname=:fullname,
                    price=:price,
                    description=:description,
                    category_id=:category_id
                WHERE
                    id=:id";

        $stmt = $this->conn->prepare($query);

        //posted values
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind parameters
        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":id", $this->id);

        //execute query
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

}