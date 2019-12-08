<?php
require_once '../../../../wp-load.php';
if(is_user_logged_in()){
	global $wpdb;
	?>
    <script language="javascript">
    $(document).ready(function(e) {
        $("input[name=date_from]").datepicker({maxDate: 0});
        $("input[name=date_to]").datepicker({minDate: 0});
		$("#gen-sales-rep").submit(function(e){
			e.preventDefault();
			var url = $(this).attr("action");
			$.post(url, $(this).serialize(), function(data){
				$("#report-preview-feedback").html(data);
			});
		});
    });
    </script>
	<h3><li class="fa fa-file-text-o"></li>  Reports</h3>
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-8">
                <div class="form-group">
            	<form action="<?php echo plugin_dir_url( __FILE__ ) ?>preview-report.php" method="post" id="gen-sales-rep">
                	<div class="input-group">
                    	<div class="input-group-addon">From</div>
                        <input type="text" name="date_from" class="form-control" required />
                    </div>
                	<div class="input-group">
                    	<div class="input-group-addon">To</div>
                        <input type="text" name="date_to" class="form-control" required />
                    </div>
                	<div class="input-group">
                    	<div class="input-group-addon">Category</div>
                        <select name="cat" class="form-control" required>
                        	<option value="">Select Category</option>
                            <option value="sold">Sales</option>
                            <option value="unsold">Unpurchased</option>
                        </select>
                    </div>
					<div class="input-group">
                    	<div class="input-group-addon">Location</div>
                        <select name="cab_loc_id" class="form-control" required>
                        	<option value="">Select Location</option>
                            <option value="">All</option>
                            <?php
							$res = $wpdb->get_results("Select * From jd_tbl_cabloc");
							if($res){
								foreach($res as $res1){										
									echo '
									<option value="'.$res1->address.'">'.$res1->address.', '.$res->franchise_owner.'</option>
									';		
								}
							}
							?>
                        </select>
                    </div>
                	<div class="input-group">
                        <input type="hidden" value="<?php echo wp_create_nonce('securegensalesrep'); ?>" name="secure" />
                        <input type="submit" value="Generate" class="btn btn-primary pull-right" />
                    </div>
                </form>
                </div>
            </div>
        </div>
        
        <div class="row" id="report-preview-feedback">
        	
        </div>
        
    </div>
	<?php
}else{
	echo "Access Denied!";
}
?>