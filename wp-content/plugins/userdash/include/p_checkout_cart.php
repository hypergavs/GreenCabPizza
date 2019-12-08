<?php require_once '../../../../wp-load.php';
if(wp_verify_nonce($_POST['secure'], 'securecheckoutcart')){
	$invoice = $_POST['invoice'];
	$qry = $wpdb->query($wpdb->prepare("Insert Into jd_tbl_sales Select * From jd_tbl_sales_temp Where invoice=%s", $invoice
									));
	$qry_delete = $wpdb->query($wpdb->prepare("Delete From jd_tbl_sales_temp Where invoice=%s", $invoice));
	if($qry){
		echo "OK";	
	}else{
		echo "Something went wrong while trying to complete your request, please try again.";	
	}
}else{
	echo "Access Denied!";	
}







?>