<?php
require_once '../../../../wp-load.php';
if(is_user_logged_in()){
	global $wpdb;
	$result = $wpdb->get_row("Select * From jd_tbl_cabloc Where id='".$_POST['branch']."'");
	if($result){
		echo $result->franchise_owner;	
	}
}else{
	echo "Access Denied!";
}
?>