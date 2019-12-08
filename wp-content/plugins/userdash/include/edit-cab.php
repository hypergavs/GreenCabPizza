<?php
require_once '../../../../wp-load.php';
if(is_user_logged_in()){
		global $wpdb;
		$rec_id = $_POST['rec_id'];
		$result = $wpdb->get_row($wpdb->prepare("Select * From jd_tbl_cabloc Where id=%s", $rec_id));
		?>
		<script language="javascript">
		$(document).ready(function(e) {
			
			$("#edit-cab-loc").submit(function(e){
				e.preventDefault();
				$.post($(this).attr("action"), $(this).serialize(), function(data){
					if(data!="OK"){
						alert(data);
					}else{
						$("#cab-locations").click();
					}
				});	
			});
			
				
		
		});
		</script>
        <h3><li class="fa fa-user-plus"></li> Edit Cab Info. </h3>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                <form action="<?php echo plugin_dir_url( __FILE__ ) ?>p_edit_cab.php" method="post" id="edit-cab-loc">
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
                        <div class="input-group">
                        	<input type="hidden" value="<?php  echo $result->id ?>" name="rec_id"/>
                            <input type="hidden" value="<?php echo wp_create_nonce('secureeditcabloc'); ?>" name="secure" />
                            <input type="submit" value="Edit Cab Info." class="btn btn-primary pull-right" />
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
		
			
			
			
			
			
			
			
	   
		<?php
}else{
	echo "Access Denied!";
}
?>