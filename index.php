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

    //query products
	$stmt = $product->readAll();
	$num = $stmt->rowCount();
	

	// set page header
	$pageTitle = 'Read Products';
	include_once 'layout_header.php';

    // create button
?>
	<div class="row">
        <div class="col 12">
    		<div class="right-button-margin">
    			<a href="create_product.php" class="btn btn-primary pull-right">Create</a>
    		</div>
        </div>
	</div>
<?php
    // display product if there are any
    if($num>0): 
?>
        <div class="row">
            <div class="col 12">
                <table class="table table-hover table-bordered">
                    <thead>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    
                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): 
    
                        extract($row);
                        
                    ?>
                        <tr>
                            <td><?php echo $fullname ?></td>
                            <td><?php echo $price ?></td>
                            <td><?php echo $description ?></td>

                            <td>
                                <?php 
                                    $category->id = $category_id;
                                    $category->readName();
                                    echo $category->fullname;
                                ?>
                            </td>

                            <td>
                                <a href="#" class="btn btn-primary left-margin">
                                    <span class='glyphicon glyphicon-list'></span> Read
                                </a>
                                <a href="#" class="btn btn-info left-margin">
                                    <span class='glyphicon glyphicon-edit'></span> Edit
                                </a>
                                <a href="#" class="btn btn-danger delete-object">
                                    <span class='glyphicon glyphicon-remove'></span> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col 12">
                <div class='alert alert-info'>No products found.</div>
            </div>
        </div>
    <?php endif; ?>
    	


	<?php include_once 'layout_footer.php';
    
    
