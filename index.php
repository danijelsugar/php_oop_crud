<?php

    // page given in URL parameter, default page is one
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
     
    // set number of records per page
    $recordsPerPage = 5;
     
    // calculate for the query LIMIT clause
    $fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;

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
    $stmt = $product->readAll($fromRecordNum, $recordsPerPage);
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
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col 12">
                <div class='alert alert-info'>No products found.</div>
            </div>
        </div>
    <?php endif; ?>

<?php 

    // the page where this paging is used
    $pageUrl = "index.php?";
     
    // count all products in the database to calculate total pages
    $totalRows = $product->countAll();
     
    // paging buttons here
?>  

    <div class="row">
        <div class="col 12">
            <?php include_once 'paging.php'; ?>
        </div>
    </div>


    <?php include_once 'layout_footer.php';
    