<?php 
	
	// get id of product that is been edited
	$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID');

	// include database and object files
	include_once 'config/Database.php';
	include_once 'objects/Product.php';
	include_once 'objects/category.php';

	// get database conneection
	$database = new Database();
	$db = $database->getConnection();

	// prepare objects
	$product = new Product($db);
	$category = new Category($db);

	// id property of product which will be edited
	$product->id = $id;

	// read details of product which will be edited
	$product->readOne();

	// set page header
	$pageTitle = 'Update Product';
	include_once 'layout_header.php';

	//if the form have been submited
	if(isset($_POST["edit"])){

		//set product property values
		$product->fullname = $_POST["fullname"];
		$product->price = $_POST["price"];
		$product->description = $_POST["description"];
		$product->category_id = $_POST["category_id"];

		if($product->update()){
			echo '<div class="alert alert-success">Product has been updated.</div>';
		}else{
			echo '<div class="alert alert-danger">Unable to update product.</div>';
		}
	}
?>


	<div class="row">
        <div class="col 12">
    		<div class="right-button-margin">
    			<a href="index.php" class="btn btn-primary pull-right">Read products</a>
    		</div>
        </div>
	</div>

	<div class="row">
		<div class="col 12">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$id");?>" method="post">
				<div class="form-group">
					<label for="fullname">Name</label>
					<input type="text" name="fullname" class="form-control" value="<?php echo $product->fullname; ?>">
				</div>
				<div class="form-group">
					<label for="price">Price</label>
					<input type="number" name="price" class="form-control" value="<?php echo $product->price; ?>">
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<input type="text" name="description" class="form-control" value="<?php echo $product->description; ?>">
				</div>
				<div class="form-group">
					<label for="category_id">Category</label>
					<select class="custom-select" name="category_id">
						<option value="0">Select category...</option>
						<?php 

							$stmt = $category->read();

							while($rowCategory = $stmt->fetch(PDO::FETCH_ASSOC)){
								$categoryId = $rowCategory['id'];
								$categoryFullname = $rowCategory['fullname'];

								if($product->category_id==$categoryId){
									echo "<option value='$categoryId' selected>";
								}else{
									echo "<option value='$categoryId'>";
								}

								echo "$categoryFullname</option>";
							}
						
						?>
					</select>
				</div>
				<input class="btn btn-primary" type="submit" name="edit" value="Edit">
			</form>
		</div>
	</div>

<?php 
	
	include_once 'layout_footer.php';
