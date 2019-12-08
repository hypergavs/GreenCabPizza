<?php
require_once '../../../wp-load.php';
$error = 0;

if($_POST['CRusername'] && wp_verify_nonce($_POST['secret'], 'CRlogin-nonce')){
	
		// this returns the user ID and other info from the user name
		$user = get_user_by('login',$_POST['CRusername']);
		//$user_role = key($user->jd_capabilities);
		$pass = $_POST['password1'];
		
 
		if(!isset($_POST['password1']) || $_POST['password1'] == '') {
			// if no password was entered
			_e('Error: Please enter a password');
			$error += 1;
			
		
		}else{
				// check the user's login with their password
			if($user && wp_check_password( $pass, $user->user_pass, $user->ID)){
				
					
				if($errors==0) {
					
					wp_setcookie($_POST['CRusername'], $_POST['password1'], true);
					wp_set_current_user($user->ID, $_POST['CRusername']);	
					do_action('wp_login', $_POST['CRusername']);
					echo "OK";
					//wp_redirect(home_url()."/dashboard"); exit;
					
				}
			}else{
				_e("Error: It's Either your Username or Password is Incorrect!");
				$error += 1;	
			}	
		}
 

 
		// retrieve all error messages
 
		// only log the user in if there are no errors
		
	
 }else{
	 echo "Error: Username is Empty.";
 }

?>