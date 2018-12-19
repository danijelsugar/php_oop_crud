<?php 

	// get id of product we want to deleted
	$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID');

	// include database and object files
	include_once 'config/Database.php';
	include_once 'objects/Product.php';

	// database connection
	$database = new Database();
	$db = $database->getConnection();

	// prepare product object
	$product = new Product($db);

	// id of product we want to delete
	$product->id = $id;

	$product->delete();
	header("location: index.php");

?>