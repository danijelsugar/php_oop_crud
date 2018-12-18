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

?>

	<div class="row">
        <div class="col 12">
    		<div class="right-button-margin">
    			<a href="index.php" class="btn btn-primary pull-right">Read products</a>
    		</div>
        </div>
	</div>

<?php 
	
	include_once 'layout_footer.php';

?>