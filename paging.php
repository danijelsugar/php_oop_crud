<nav aria-label="Page navigation example">
  	<ul class="pagination justify-content-center">

<?php
	// button for first page
	if($page>1){
		echo "<li class='page-item'><a class='page-link' href='{$pageUrl}' title='Go to first page'>First</a></li>";
	}
	
	//calculates total pages
	$totalPages = ceil($totalRows / $recordsPerPage);

	//range of pages
	$range = 2;

	// display links to 'range of pages' around 'current page'
	$initialNum = $page - $range;
	$conditionLimitNum = ($page + $range)  + 1;

	for ($x=$initialNum; $x<$conditionLimitNum; $x++) {

		// be sure '$x is greater than 0' AND 'less than or equal to the $totalPages'
    	if (($x > 0) && ($x <= $totalPages)) {

    		// current page
    		if($x==$page){
    			echo "<li class='active page-item'><a class='page-link' href='#'>$x <span class='sr-only'>(current)</span></a></li>";
    		}

    		// not current page
    		else {
    			echo "<li class ='page-item'><a class='page-link' href='{$pageUrl}page=$x'>$x</a></li>";
    		}
    	}
	}

	// button for last page
	if($page<$totalPages){
		echo "<li class='page-item'><a class='page-link' href='{$pageUrl}page=$totalPages' title='Last page'>Last</a></li>";
	}

?>
	</ul>
</nav>
