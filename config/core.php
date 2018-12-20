<?php 

	// page given in URL parameter, default page is one
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
     
    // set number of records per page
    $recordsPerPage = 5;
     
    // calculate for the query LIMIT clause
    $fromRecordNum = ($recordsPerPage * $page) - $recordsPerPage;
    