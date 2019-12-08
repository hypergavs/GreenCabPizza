<?php
require_once '../../../../wp-load.php';
global $wpdb;
if(wp_verify_nonce($_POST['secure'], 'secureaddcabloc')){
	$address = $_POST['address'];
	$f_owner = $_POST['f_owner'];
	$map_loc = $_POST['g_map_link'];
	$lat = $_POST['g_map_lat'];
	$lang = $_POST['g_map_lang'];
	$qry = $wpdb->query($wpdb->prepare(
				"Insert Into jd_tbl_cabloc (address, franchise_owner, map_loc, lat, lang) VALUES (%s,%s,%s,%s,%s)",
				$address, $f_owner, $map_loc, $lat, $lang
			));
			
	if($qry){
		echo "OK";
	}else{
		echo "Something went wrong while trying to complete your request, Please try again.";	
	}
}else{
	echo "Access Denied!";	
}
?>