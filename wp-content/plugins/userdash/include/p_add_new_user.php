<?php
require_once '../../../../wp-load.php';
global $wpdb;
if(wp_verify_nonce($_POST['secure'], 'secureaddnewuser')){
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$uname = $_POST['uname'];
	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$user_role = $_POST['user_role'];
	$contact = $_POST['contact'];
	require_once(ABSPATH . WPINC . '/registration.php');
	if(!username_exists($uname)) {
		if($pass1===$pass2){
			$new_user_id = wp_insert_user(array(
					'user_login'		=> $uname,
					'user_pass'	 		=> $pass1,
					'role'				=> $user_role,
					'display_name'		=> $fname." ".$lname,
					'user_registered'	=> date('Y-m-d H:i:s'),
					'first_name'		=> $fname,
					'last_name'			=> $lname,
					'description'		=> $contact
						)
					);
			if($new_user_id){
				
				$address = $_POST['address'];
				$f_owner = $_POST['f_owner'];
				$map_loc = $_POST['g_map_link'];
				$lat = $_POST['g_map_lat'];
				$lang = $_POST['g_map_lang'];
				$qry = $wpdb->query($wpdb->prepare(
							"Insert Into jd_tbl_cabloc (address, franchise_owner, map_loc, lat, lang) VALUES (%s,%s,%s,%s,%s)",
							$address, $f_owner, $map_loc, $lat, $lang
						));
				
			}else{
				echo "Error Happened While processing your request, Please try again.";	
			}
		}else{
			echo "Password doesn't Match!";	
		}
	}else{
		echo "Username is not available!";
	}
	
}else{
	echo "Access Denied!";	
}
?>