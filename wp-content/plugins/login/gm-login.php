<?php
/*
Plugin Name: Front End Registration and Login by GM
Description: Provides simple front end registration and login forms
Version: 1.0
Author: GM
*/

function gm_login() {
 	?>

    
        	<div id="login-form" class="container">
            <?php
				if(!is_user_logged_in()){
			?>
            	<h2>Member Login</h2>
            	<div class="row">
                    <form action="<?php echo plugin_dir_url( __FILE__ ) ?>" method="post" id="form-login">
                        <div class="form-group">
                            <label for="CRusername" class="gm-frm-label">USERNAME:</label>
                        	<i class="glyphicon glyphicon-user"></i>
                            <input type="text" name="CRusername" class="form-control" id="CRusername" placeholder="Your Username" />
                        </div>
                        
                        <div class="form-group">
                        
                            <label for="password1" class="gm-frm-label">PASSWORD:</label>
                            <i class="glyphicon glyphicon-lock"></i>
                            <input type="password" name="password1" class="form-control" placeholder="Your Password" />
                        </div>
                        
                        <input type="hidden" name="secret" value="<?php echo wp_create_nonce('CRlogin-nonce'); ?>"/>
                        
                        <hr class="style2" />
                        <div class="notif"></div>
                        <div class="col-md-6" id="forgot-pass"><a href="#">Forgot Password?</a></div><div class="col-md-6"><input type="submit" name="submit" value="LOGIN" /></div>
                    </form>
            	</div>
            </div>
            <?php
				}else{
			?>
            
            	<div class="deny-access">
                    <h3>Access Denied!</h3>
                    <p>User Already Logged In!</p>
                </div>
            
            <?php
				}
			?>
            
            
    
    
    <?php
}
add_shortcode("gm-login","gm_login");

function cr_logout(){
	?>
          <div class="deny-access">
              <h3>Account successfuly logged out.</h3>
              <p>Thank you for investing with us!</p>
          </div>
    <?php
}
add_shortcode("cr-logout", "cr_logout");

function login_css() {
	wp_enqueue_style('login-style', plugin_dir_url( __FILE__ ) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'login_css');


?>