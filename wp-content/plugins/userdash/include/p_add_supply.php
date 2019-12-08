<?php require_once '../../../../wp-load.php';
if(wp_verify_nonce($_POST['secure'], 'secureaddsupply')){
	$ctr = count($_POST)-2;
	$a = 0;
	foreach($_POST as $key => $val){
		$a++;
		if($ctr>$a){
			$prod_id = explode("-",$key);
			if($val<>0||$val<>""){
				$qry = $wpdb->query($wpdb->prepare("Insert Into jd_tbl_supply (trans_type, branch_loc, encoder_id, prod_id, qty) VALUES (%s,%d,%d,%d,%d)", "Add", $_POST['cab-loc'], get_current_user_id(), $prod_id[1], $val));
			}
		}
	}
	if($qry){
		echo "OK";	
	}else{
		echo "Something went wrong while trying to complete your request, please try again.";	
	}
}else{
	echo "Access Denied!";	
}







?>