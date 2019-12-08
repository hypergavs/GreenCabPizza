<?php
require_once '../../../../wp-load.php';
global $wpdb;
if(is_user_logged_in()){
	$rec_id = $_POST['rec_id'];
	$action = $_POST['action'];
	if($action=='suspend'){
		$qry = $wpdb->query($wpdb->prepare("Update jd_users Set user_status=1 Where ID=%s", $rec_id));
		if($qry){
			
		}else{
			echo "Error Happened While processing your request, Please try again.";	
		}
	}
}else{
	echo "Access Denied!";	
}
?>