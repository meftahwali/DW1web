<?php
// start titel
function getTitle(){
	global $pageTitle;
	if (isset($pageTitle)) {
        echo $pageTitle;
        	}else{
        		echo 'Default';
        	}
}
// end titel