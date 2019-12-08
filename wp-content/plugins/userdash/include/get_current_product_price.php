<?php
require_once '../../../../wp-load.php';
if(is_user_logged_in()){
	global $wpdb;
	$result = $wpdb->get_row("Select * From jd_tbl_flavors Where flavor='".$_POST['flavor']."'");
	if($result){
		echo $result->price;	
	}
}else{
	echo "Access Denied!";
}
?>