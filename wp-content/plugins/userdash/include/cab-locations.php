<?php
require_once '../../../../wp-load.php';
if(is_user_logged_in()){
	global $wpdb;
	?>
    <script language="javascript">
    $(document).ready(function(e) {
        $("#add-cab-loc").submit(function(e){
			e.preventDefault();
			var url = $(this).attr("action") + '.php';
			$.post(url, $(this).serialize(), function(data){
				if(data=="OK"){
					$("#add-cab-loc").trigger("reset");
					$("#cab-locations").click();
				}else{
					alert(data);	
				}
			});
		});
		$(".edit-cab").click(function(e){
			e.preventDefault();
			var url = $(this).attr("href") + $(this).attr("class") + ".php";
			$.post(url, {rec_id: $(this).attr("rec_id")}, function(data){
				$("#dashboard").html(data);	
			});
		});
		
		$(".unlock-cab").click(function(e){
			e.preventDefault();
			var url = $(this).attr("href") + $(this).attr("class") + ".php";
			var ans = confirm("Are you sure you want to unlock this cab?");
			if(ans==true){
				$.post(url, {rec_id: $(this).attr("rec_id"), action: "unlock"}, function(data){
					if(data==""){
						$("#cab-locations").click();
					}else{
						alert(data);	
					}
				});
			}else{
				return false;	
			}
		});
		
		$(".suspend-cab").click(function(e){
			e.preventDefault();
			var url = $(this).attr("href") + $(this).attr("class") + ".php";
			var ans = confirm("Are you sure you want to suspend this cab?");
			if(ans==true){
				$.post(url, {rec_id: $(this).attr("rec_id"), action: "suspend"}, function(data){
					if(data==""){
						$("#cab-locations").click();
					}else{
						alert(data);	
					}
				});
			}else{
				return false;	
			}
		});
		
    });
    </script>
	<h3><li class="fa fa-map-pin"></li>  Cab Locations</h3>

    
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
            	<table class="table table-condensed">
                	<thead>
                    	<th>Franchise Owner</th>
                    	<th>Address</th>
                    	<th>Map Link</th>
                    	<th>Latitude</th>
                    	<th>Longitude</th>
                        <th>Status</th>
                    	<th>Option</th>
                    </thead>
                    <?php
                    $results = $wpdb->get_results("Select * From jd_tbl_cabloc");
					if($results){
						foreach($results as $res){
							if($res->cab_status!=0){
								$cab_status = "Inactive";
								$cab_color = "danger";		
								$cab_option = "<a href='".plugin_dir_url( __FILE__ )."' class='unlock-cab' rec_id='".$res->id."' title='unlock cab'><li class='fa fa-unlock'></li></a>
												<a href='".plugin_dir_url( __FILE__ )."' class='edit-cab' rec_id='".$res->id."' title='edit cab'><li class='fa fa fa fa-pencil'></li></a>
												";
							}else{
								$cab_status = "Active";
								$cab_color = "";
								$cab_option = "<a href='".plugin_dir_url( __FILE__ )."' class='suspend-cab' rec_id='".$res->id."' title='suspend cab'><li class='fa fa fa-lock'></li></a>
												<a href='".plugin_dir_url( __FILE__ )."' class='edit-cab' rec_id='".$res->id."' title='edit cab'><li class='fa fa fa fa-pencil'></li></a>
												";
							}
							echo '
								<tr class="'.$cab_color.'">
									<td>'.$res->franchise_owner.'</td>
									<td>'.$res->address.'</td>
									<td>'.$res->map_loc.'</td>
									<td>'.$res->lat.'</td>
									<td>'.$res->lang.'</td>
									<td>'.$cab_status.'</td>
									<td>'.$cab_option.'</td>
								</tr>
							';	
						}
					}else{
						echo '<tr><td colspan="7" align="center">No Record Found.</td></tr>';	
					}
					?>
                </table>
            </div>
        </div>
    </div>
	<?php
}else{
	echo "Access Denied!";
}
?>