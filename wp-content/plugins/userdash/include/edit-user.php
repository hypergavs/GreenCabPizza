<?php
require_once '../../../../wp-load.php';
if(is_user_logged_in()){
	if($_POST['action']=='edit'){
		global $wpdb;
		$user_id = $_POST['rec_id'];
		$result1 = $wpdb->get_row($wpdb->prepare("Select * From jd_users Where ID=%d", $user_id));
		$user_info =get_userdata($user_id);
		$role = $user_info->roles;
		$fname = get_user_meta($user_id, "first_name", true);
		$lname = get_user_meta($user_id, "last_name", true);
		$contact = get_user_meta($user_id, "description", true);
		$rec_id = $_POST['rec_id'];
		$result = $wpdb->get_row($wpdb->prepare("Select * From jd_tbl_cabloc Where id=%s", $rec_id));
		?>
		<script language="javascript">
		$(document).ready(function(e) {
			$("#change-pass-btn").click(function(){
				$("#password-form").toggle();	
			});
			
			$("#edit-user").submit(function(e){
				e.preventDefault();
				$.post($(this).attr("action"), $(this).serialize(), function(data){
					if(data!="OK"){
						$(".notif").html(data);
					}else{
						$("#user-manager").click();
					}
				});	
			});
			
				
		
		});
		</script>
		<h3><li class="fa fa-user-plus"></li> Edit User Info. </h3>
		<div class="container-fluid">
			<form action="<?php echo plugin_dir_url( __FILE__ ) ?>p_edit_user.php" method="post" class="form-inline" id="edit-user">
            <div class="form-group" id="add-new-user-wrap">
                <div class="input-group">
                    <div class="input-group-addon">First Name</div><input type="text" name="fname" placeholder="First Name" class="form-control"  value="<?php echo $fname ?>" />
                </div>
                <div class="clearfix"></div>
                <div class="input-group">
                    <div class="input-group-addon">Last Name</div><input type="text" name="lname" placeholder="Last Name" class="form-control"   value="<?php echo $lname ?>" />
                </div>
                <div class="clearfix"></div>
                <div class="input-group">
                    <div class="input-group-addon">User Role</div>
                    <select name="user_role" class="form-control" >
                        <option value="<?php echo $role[0] ?>"><?php echo ucfirst($role[0]) ?></option>
                        <option value="vendor">Vendor</option>
                        <option value="employee">Employee</option>
                        <option value="auditor">Auditor</option>
                        <option value="administrator">Administrator</option>
                    </select>
                </div>
                <div class="clearfix"></div>
                <div class="input-group">
                    <div class="input-group-addon">Contact No.</div><input type="text" name="contact" class="form-control"  placeholder="Phone/Home No."  value="<?php echo $contact ?>" />
                </div>
                <div class="clearfix"></div>
                <div class="input-group">
                    <div class="input-group-addon">Username</div><input type="text" name="uname" class="form-control"  readonly placeholder="Username"  value="<?php echo $result1->user_login; ?>" />
                </div>
              
                <div class="clearfix"></div>
                <span id="password-form">
                    <div class="input-group">
                        <div class="input-group-addon">New Password</div><input type="password" class="form-control"  name="pass1" placeholder="New Password" />
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">Repeat Password</div><input type="password" class="form-control"  name="pass2" placeholder="Repeat Password" />
                    </div>
                </span>
                <div class="clearfix"></div>
                <div class="input-group">
                        <input type="button" value="Change Password" class="form-control" id="change-pass-btn" />
                </div>
                
			 </div>
             
             <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">Cab Address</div>
                            <input type="text" name="address" class="form-control" placeholder="Cab Address" value="<?php  echo $result->address ?>" />
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">Franchise Owner</div>
                            <input type="text" name="f_owner" class="form-control" placeholder="Franchise Owner" value="<?php  echo $result->franchise_owner ?>" />
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">Google Map Link</div>
                            <input type="text" name="map_loc" class="form-control" placeholder="Google Map Link" value="<?php  echo $result->map_loc ?>" />
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">Google Map Latitude</div>
                            <input type="text" name="lat" class="form-control" placeholder="Google Map Latitude" value="<?php  echo $result->lat ?>" />
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">Google Map Longitude</div>
                            <input type="text" name="lang" class="form-control" placeholder="Google Map Longitude" value="<?php  echo $result->lang ?>" />
                        </div>
                    </div>
             <div class="clearfix"></div>
                <div class="input-group">
                    <input type="hidden" name="secure" value="<?php echo wp_create_nonce('secureedituser') ?>" />
                    <input type="hidden" name="rec_id" value="<?php echo $user_id; ?>" />
                    <input type="submit" value="Submit" class="btn btn-primary btn-lg pull-right" />
                </div>
			 </form>
			 <div class="row">
				<div class="col-md-12 notif"></div>
			 </div>
		</div>
		
			
			
			
			
			
			
			
	   
		<?php
	}else{
		echo "Access Denied!";	
	}
}else{
	echo "Access Denied!";
}
?>