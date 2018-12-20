<?php
    
    // core.php holding pagination variables
    include_once 'config/core.php';

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
    $pageTitle = 'Search';
    include_once 'layout_header.php';

    // search term
    $searchTerm = isset($_GET["s"]) ? $_GET["s"] : "";

    //query products
    $stmt = $product->search($searchTerm, $fromRecordNum, $recordsPerPage);

     // the page where this paging is used
    $pageUrl = "index.php?s={$searchTerm}";
     
    // count all products in the database to calculate total pages
    $totalRows = $product->countAll();

    include_once 'read_template.php';
    
    // footer with javascripts and closing html tags
    include_once 'layout_footer.php';
