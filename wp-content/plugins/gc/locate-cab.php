<?php
require_once '../../../wp-load.php';
global $wpdb;
if(wp_verify_nonce($_POST['secure'], 'gcsecurelocatecab')){
	$qry = $wpdb->get_results($wpdb->prepare("Select * From jd_tbl_cabloc Where address LIKE %s or franchise_owner LIKE %s or map_loc LIKE %s", "%".$wpdb->esc_like($_POST['address_text'])."%","%".$wpdb->esc_like($_POST['address_text'])."%","%".$wpdb->esc_like($_POST['address_text'])."%"));
	if($qry){
		foreach($qry as $res){
		?>
        	<script language="javascript">
            $(document).ready(function(e) {
                $(".get-map").click(function(e){
					e.preventDefault();
					var url = $(this).attr("href") + "?lat="+$(this).attr("lat")+"&lang="+$(this).attr("lang");
					var map_id = $(this).attr("map_id");
					window.open(url);
				});
				$(".get-map-google").click(function(e){
					e.preventDefault();
					var url = $(this).attr("href");
					window.open(url);
				});
            });
            </script>
            <div class="row" style="margin:20px auto;">
            	<div class="col-md-7">
                <strong>Address: </strong><?php echo $res->address; ?>
                <strong>Franchise Owner: </strong><?php echo $res->franchise_owner; ?>
                <div id="map-wrap">
                	<a href="<?php echo plugin_dir_url( __FILE__ ) ?>get-map.php" lat="<?php echo $res->lat ?>" lang="<?php echo $res->lang ?>" class="get-map">
                    <li class="fa fa-map"> Show Map</li>
                    </a>
                    |
                    <a href="<?php echo $res->map_loc; ?>" lat="<?php echo $res->lat ?>" lang="<?php echo $res->lang ?>" class="get-map-google">
                    <li class="fa fa-google"> Show Map on Google</li>
                    </a>
                    <div class="map-feedback"></div>
                </div>
                </div>
            </div>
            
            
		<?php
		}
	}else{
		echo 'Store not found.';	
	}
}else{
	echo "Access Denied!";	
}

?>