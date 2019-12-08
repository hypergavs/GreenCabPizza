<?php
require_once '../../../../wp-load.php';
if(is_user_logged_in()){
	global $wpdb;
	?>
    <script language="javascript">
    $(document).ready(function(e) {
        $("#add-new-user").submit(function(e){
			e.preventDefault();
			$.post($(this).attr("action"), $(this).serialize(), function(data){
				if(data!=""){
					$(".notif").html(data);
				}else{
					$("#user-manager").click();
				}
			});	
		});
		
			
	
    });
    </script>
    <h3><li class="fa fa-user-plus"></li> Add New User </h3>
    <div class="container-fluid">
    	<form action="<?php echo plugin_dir_url( __FILE__ ) ?>p_add_new_user.php" method="post" class="form-inline" id="add-new-user">
        <div class="form-group" id="add-new-user-wrap">
            <div class="input-group">
                <div class="input-group-addon">First Name</div><input type="text" name="fname" class="form-control" placeholder="First Name" />
            </div>
            <div class="clearfix"></div>
            <div class="input-group">
                <div class="input-group-addon">Last Name</div><input type="text" name="lname" class="form-control" placeholder="Last Name" />
            </div>
            <div class="clearfix"></div>
            <div class="input-group">
                <div class="input-group-addon">User Role</div>
                <select name="user_role" class="form-control">
                    <option value="vendor">Vendor</option>
                    <option value="employee">Employee</option>
                    <option value="auditor">Auditor</option>
                    <option value="administrator">Administrator</option>
                </select>
            </div>
            <div class="clearfix"></div>
            <div class="input-group">
                <div class="input-group-addon">Contact No.</div><input type="text" name="contact" class="form-control" placeholder="Phone/Home No." />
            </div>
            <div class="clearfix"></div>
            <div class="input-group">
                <div class="input-group-addon">Username</div><input type="text" name="uname" class="form-control" placeholder="Username" />
            </div>
            <div class="clearfix"></div>
            <div class="input-group">
                <div class="input-group-addon">Password</div><input type="password" name="pass1" class="form-control" placeholder="Password" />
            </div>
            <div class="clearfix"></div>
            <div class="input-group">
                <div class="input-group-addon">Repeat Password</div><input type="password" name="pass2" class="form-control" placeholder="Repeat Password" />
            </div>
            
            
            
            
            
            <div class="form-group">
                	<div class="input-group">
                    	<div class="input-group-addon">Cab Address</div>
                        <input type="text" name="address" class="form-control" placeholder="Cab Address" />
                    </div>
                	<div class="input-group">
                    	<div class="input-group-addon">Franchise Owner</div>
                        <input type="text" name="f_owner" class="form-control" placeholder="Franchise Owner" />
                    </div>
                	<div class="input-group">
                    	<div class="input-group-addon">Google Map Link</div>
                        <input type="text" name="g_map_link" class="form-control" placeholder="Google Map Link" />
                    </div>
                	<div class="input-group">
                    	<div class="input-group-addon">Google Map Latitude</div>
                        <input type="text" name="g_map_lat" class="form-control" placeholder="Google Map Latitude" />
                    </div>
                	<div class="input-group">
                    	<div class="input-group-addon">Google Map Longitude</div>
                        <input type="text" name="g_map_lang" class="form-control" placeholder="Google Map Longitude" />
                    </div>
                	
                </div>
            </div>
            
            
            
            
            
            
            
            <div class="clearfix"></div>
            
            <div class="input-group">
                <input type="hidden" name="secure" value="<?php echo wp_create_nonce('secureaddnewuser') ?>" />
                <input type="submit" value="Submit" class="btn btn-primary btn-lg pull-right" />
            </div>
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
?>