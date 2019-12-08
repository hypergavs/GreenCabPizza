<?php
require_once '../../../../wp-load.php';
global $wpdb;
if(wp_verify_nonce($_POST['secure'], 'secureaddinventoryrecord')){
	$p_as_of = $wpdb->get_row("Select * From jd_tbl_flavors Where flavor='".$_POST['flavor']."'");
	$brach = $_POST['cab-loc'];
	$branch_owner = $_POST['f_owner'];
	$flavor = $_POST['flavor'];
	$item_price = $_POST['currprice'];
	$price_as_of = $p_as_of->price_change_date;
	$delivered = $_POST['delivered'];
	$sold = $_POST['sold'];
	$unsold = $_POST['unsold'];
	$return_ = $_POST['return_'];
	$total_sales = $_POST['receivable'];
	$encoder = get_current_user_id();
	$total_unsold = $_POST['total_unsold'];
	
	$insert = $wpdb->query($wpdb->prepare(
					"Insert Into jd_tbl_sales (branch, branch_owner, flavor, item_price, price_as_of, delivered, sold, total_sales, unsold, total_unsold, return_, encoder)
					VALUES(%s,%s,%s,%d,%s,%d,%d,%d,%d,%d,%d,%d)", $brach, $branch_owner, $flavor, $item_price, $price_as_of, $delivered, $sold, $total_sales, 
					$unsold, $total_unsold, $return_, $encoder
					));
	if($insert){
		echo "OK";
	}else{
		echo "Something went wrong while trying to process your request. Please try again.";	
	}
	
	
}else{
	echo "Access Denied!";	
}
?>