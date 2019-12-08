<?php require_once '../../../../wp-load.php';
if(wp_verify_nonce($_POST['secure'], 'secureedituser')){
	$user_id = $_POST['rec_id'];
	$fname = ucfirst($_POST['fname']);
	$lname = ucfirst($_POST['lname']);
	$role = $_POST['user_role'];
	$newpass = $_POST['pass1'];
	$newpass2 = $_POST['pass2'];
	$contact = $_POST['contact'];
	if($newpass&&$newpass2){
		if($newpass===$newpass2){
			$update_user = wp_update_user(array(
							'ID'			=> $user_id,
							'first_name'	=> $fname,
							'last_name'		=> $lname,
							'role'			=> $role,
							'description'	=> $contact,
							'user_pass'		=> $newpass
						));
			if(!is_wp_error( $update_user )){
				
							$rec_id = $_POST['rec_id'];
							$address = $_POST['address'];
							$franchise_owner = $_POST['f_owner'];
							$map_loc = $_POST['map_loc'];
							$lat = $_POST['lat'];
							$lang = $_POST['lang'];
							$qry = $wpdb->query($wpdb->prepare("Update jd_tbl_cabloc Set address=%s, franchise_owner=%s, map_loc=%s, lat=%s, lang=%s Where id=%d",
													$address, $franchise_owner, $map_loc, $lat, $lang, $rec_id
													));
				echo "OK";
			}else{
				echo "Error Happened While processing your request, Please try again.";
			}
		}else{
			echo "Password did not match!";	
		}
	}elseif($newpass==""&&$newpass2==""&&$old_pass==""){
		$update_user = wp_update_user(array(
							'ID'			=> $user_id,
							'first_name'	=> $fname,
							'last_name'		=> $lname,
							'role'			=> $role,
							'description'	=> $contact
						));
		if(!is_wp_error( $update_user )){
			
			$rec_id = $_POST['rec_id'];
			$address = $_POST['address'];
			$franchise_owner = $_POST['f_owner'];
			$map_loc = $_POST['map_loc'];
			$lat = $_POST['lat'];
			$lang = $_POST['lang'];
			$qry = $wpdb->query($wpdb->prepare("Update jd_tbl_cabloc Set address=%s, franchise_owner=%s, map_loc=%s, lat=%s, lang=%s Where id=%d",
									$address, $franchise_owner, $map_loc, $lat, $lang, $rec_id
									));
			
			echo "OK";
		}else{
			echo "Error Happened While processing your request, Please try again.";
		}
	}else{
		echo "OK";
	}
}else{
	echo "Access Denied!";	
}







?>