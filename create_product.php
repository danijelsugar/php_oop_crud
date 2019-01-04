<?php

	// include database and object files
	include_once 'config/Database.php';
	include_once 'objects/Product.php';
	include_once 'objects/category.php';

	// instance database and objects
	$database = new Database();
	$db = $database->getConnection();

	$product = new Product($db);
    $category = new Category($db);

    // set page header
	$pageTitle = 'Create Product';
	include_once 'layout_header.php';


	//if the form have been submited
	if(isset($_POST["create_product"])){

		//set products property values
		$product->fullname = $_POST["fullname"];
		$product->price = $_POST["price"];
		$product->description = $_POST["description"];
		$product->category_id = $_POST["category_id"];

		$image=!empty($_FILES["image"]["name"]) ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";
		$product->image = $image;

		// informs user if creating product is successful
		if($product->create()){
			echo '<div class="alert alert-success">Product has been created.</div>';
		}else{
			echo '<div class="alert alert-danger">Unable to create product.</div>';
		}
	}

?>
	<div class="row form-group">
        <div class="col 12">
    		<div class="right-button-margin">
    			<a href="index.php" class="btn btn-primary pull-right">Read products</a>
    		</div>
        </div>
	</div>
<?php 

	// try to upload the submitted file
	// uploadPhoto() method will return an error message, if any.
	echo $product->uploadPhoto();

?>

	<div class="row">
		<div class="col 12">
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label for="fullname">Name</label>
					<input type="text" name="fullname" class="form-control">
				</div>
				<div class="form-group">
					<label for="price">Price</label>
					<input type="number" name="price" class="form-control">
				</div>
				<div class="form-group">
					<label for="description">Description</label>
					<input type="text" name="description" class="form-control">
				</div>
				<div class="form-group">
					<label for="category_id">Category</label>
					<select class="custom-select" name="category_id">
						<option value="0">Select category...</option>
						<?php 
							// read the product categories from database
							$stmt = $category->read();

							// write them in drop-down
							while($rowCategory = $stmt->fetch(PDO::FETCH_ASSOC)):
								extract($rowCategory);
						?>
						<option value="<?php echo $id; ?>"><?php echo $fullname; ?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="image">Upload image</label>
					<input type="file" name="image">
				</div>
				<input type="submit" class="btn btn-primary" name="create_product" value="Create">
			</form>
		</div>
	</div>



<?php include_once 'layout_footer.php'; ?>