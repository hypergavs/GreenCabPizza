<?php require_once '../../../../wp-load.php';
if(wp_verify_nonce($_POST['secure'], 'secureeditcabloc')){
	$rec_id = $_POST['rec_id'];
	$address = $_POST['address'];
	$franchise_owner = $_POST['f_owner'];
	$map_loc = $_POST['map_loc'];
	$lat = $_POST['lat'];
	$lang = $_POST['lang'];
	
	$qry = $wpdb->query($wpdb->prepare("Update jd_tbl_cabloc Set address=%s, franchise_owner=%s, map_loc=%s, lat=%s, lang=%s Where id=%d",
									$address, $franchise_owner, $map_loc, $lat, $lang, $rec_id
									));
	if($qry){
		echo "OK";	
	}else{
		echo "Something went wrong while trying to complete your request, please try again.";	
	}
}else{
	echo "Access Denied!";	
}







?>