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
    public $image;
    public $timestamp;

    public function __construct($db) 
    {
    	$this->conn = $db;
    }

    //create product
    public function create() 
    {

    	//query
    	$query = "INSERT INTO " . $this->tableName . " SET fullname=:fullname, price=:price, description=:description, category_id=:category_id, image=:image, created=:created";

    	$stmt = $this->conn->prepare($query);

    	//posted values
    	$this->fullname = htmlspecialchars(strip_tags($this->fullname));
    	$this->price = htmlspecialchars(strip_tags($this->price));
    	$this->description = htmlspecialchars(strip_tags($this->description));
    	$this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->image = htmlspecialchars(strip_tags($this->image));

    	//to get timestamp for created field
    	$this->timestamp = date('Y-m-d H:i:s');

        //bind values
    	$stmt->bindParam(':fullname', $this->fullname);
    	$stmt->bindParam(':price', $this->price);
    	$stmt->bindParam(':description', $this->description);
    	$stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':image', $this->image);
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
                    id, fullname, description, price, category_id, image  
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
        $this->image = $row['image'];

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

    // delete particular object, id is product id
    public function delete() 
    {

        $query = "DELETE FROM " . $this->tableName . " WHERE id=:id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

    }

    public function search($searchTerm, $fromRecordNum, $recordsPerPage) 
    {

        $query = "SELECT 
                    id, fullname, price, description, category_id, created 
                FROM 
                    " . $this->tableName . "
                WHERE 
                    fullname LIKE ? OR description LIKE ? 
                ORDER BY 
                    fullname ASC 
                LIMIT 
                    ?, ?";


        $stmt = $this->conn->prepare($query);

        // bind variable values
        $searchTerm = "%{$searchTerm}%";
        $stmt->bindParam(1, $searchTerm);
        $stmt->bindParam(2, $searchTerm);
        $stmt->bindParam(3, $fromRecordNum, PDO::PARAM_INT);
        $stmt->bindParam(4, $recordsPerPage, PDO::PARAM_INT);

        // execute query
        $stmt->execute();

        // return values from database
        return $stmt;

    }

    // used for paging products based on search term
    public function countAllSearch($searchTerm) 
    {

        $query = "SELECT 
                    count(*) as total_rows
                FROM "
                    . $this->tableName . 
                " WHERE
                    fullname LIKE ?";

        $stmt = $this->conn->prepare($query);
        $searchTerm = "%{$searchTerm}%";

        $stmt->bindParam(1, $searchTerm);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row["totalRows"];

    }

    // will upload image file to server
    public function uploadPhoto() 
    {

        $resultMessage = "";

        // now, if image is not empty, try to upload the image
        if($this->image) {

            // sha1_file() function is used to make a unique file name
            $targetDirectory = "uploads/";
            $targetFile = $targetDirectory . $this->image;
            $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);

            // error message is empty
            $fileUploadErrorMessages="";

            // make sure that file is a real image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check!==false){
                // submitted file is an image
            }else{
                $fileUploadErrorMessages.="<div>Submitted file is not an image.</div>";
            }

            // make sure certain file types are allowed
            $allowedFileTypes=array("jpg", "jpeg", "png", "gif");
            if(!in_array($fileType, $allowedFileTypes)){
                $fileUploadErrorMessages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
            }

            // make sure file does not exist
            if(file_exists($targetFile)){
                $fileUploadErrorMessages.="<div>Image already exists. Try to change file name.</div>";
            }

            // make sure submitted file is not too large, can't be larger than 1 MB
            if($_FILES['image']['size'] > (1024000)){
                $fileUploadErrorMessages.="<div>Image must be less than 1 MB in size.</div>";
            }

            // make sure the 'uploads' folder exists
            // if not, create it
            if(!is_dir($targetDirectory)){
                mkdir($targetDirectory, 0777, true);
            }

            // if $file_upload_error_messages is still empty
            if(empty($fileUploadErrorMessages)){
                // it means there are no errors, so try to upload the file
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)){
                    // it means photo was uploaded
                }else{
                    $resultMessage.="<div class='alert alert-danger'>";
                        $resultMessage.="<div>Unable to upload photo.</div>";
                        $resultMessage.="<div>Update the record to upload photo.</div>";
                    $resultMessage.="</div>";
                }
            }

            // if $file_upload_error_messages is NOT empty
            else{
                // it means there are some errors, so show them to user
                $resultMessage.="<div class='alert alert-danger'>";
                    $resultMessage.="{$fileUploadErrorMessages}";
                    $resultMessage.="<div>Update the record to upload photo.</div>";
                $resultMessage.="</div>";
            }

        }

        return $resultMessage;

    }

}