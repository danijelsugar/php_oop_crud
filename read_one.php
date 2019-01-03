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

	//prepare objects
	$product = new Product($db);
	$category = new Category($db);

	// id property of product we read
	$product->id = $id;

	// details of product
	$product->readOne();

	// set page header
	$pageTitle = 'Update Product';
	include_once 'layout_header.php';

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
			<table class="table table-hover table-bordered">
				<tr>
					<td>Name</td>
					<td><?php echo $product->fullname; ?></td>
				</tr>
				<tr>
					<td>Price</td>
					<td><?php echo $product->price; ?></td>
				</tr>
				<tr>
					<td>Description</td>
					<td><?php echo $product->description; ?></td>
				</tr>
				<tr>
					<td>Category</td>
					<td>
						<?php 
						// reads product category
						$category->id = $product->category_id;
						$category->readName();
						echo $category->fullname;

						?>
					</td>
				</tr>
				<tr>
					<td>Image</td>
					<td>
						<?php 

							echo $product->image ? "<img src='uploads/{$product->image}' style='width:300px;' />" : "No image found.";

						?>
					</td>
				</tr>
			</table>
		</div>
	</div>

<?php 

	include_once 'layout_footer.php';
	