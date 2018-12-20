	<div class="row">
		<div class="col 12">
			<form role="search" action="search.php">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Type product name or description..." name="s" id="srch-term" required>
					<button class=" btn btn-primary" type="submit">Search</button>
				</div>
			</form>
		</div>
	</div>
	
	<div class="row">
        <div class="col 12">
    		<div class="right-button-margin">
    			<a href="create_product.php" class="btn btn-primary pull-right">Create product</a>
    		</div>
        </div>
	</div>
<?php
    // display product if there are any
    if($totalRows>0): 
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
                                <a href="read_one.php?id=<?php echo $id; ?>" class="btn btn-primary left-margin">
                                    <span class='glyphicon glyphicon-list'></span> Read
                                </a>
                                <a href="update_product.php?id=<?php echo $id; ?>" class="btn btn-info left-margin">
                                    <span class='glyphicon glyphicon-edit'></span> Edit
                                </a>
                                <a href="delete_product.php?id=<?php echo $id; ?>" class="btn btn-danger delete-object">
                                    <span class='glyphicon glyphicon-remove'></span> Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

				<div class="row">
			        <div class="col 12">
			            <?php include_once 'paging.php'; ?>
			        </div>
			    </div>

            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col 12">
                <div class='alert alert-info'>No products found.</div>
            </div>
        </div>
    <?php endif; ?>