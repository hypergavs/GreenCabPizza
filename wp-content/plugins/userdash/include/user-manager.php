<?php
require_once '../../../../wp-load.php';
if(is_user_logged_in()){
	global $wpdb;
	$result = $wpdb->get_results("Select * From jd_users");
	?>
    <script language="javascript">
    $(document).ready(function(e) {
        $(".add-new-user").click(function(e){
			e.preventDefault();
			var url = $(this).attr("href") + '.php';
			$("#dashboard").load(url);
		});
		
		$(".unlock-user").click(function(e){
			e.preventDefault();
			var url = $(this).attr("href") + $(this).attr("class") + ".php";
			var ans = confirm("Are you sure you want to unlock this user?");
			if(ans==true){
				$.post(url, {rec_id: $(this).attr("rec_id"), action: "unlock"}, function(data){
					if(data==""){
						$("#user-manager").click();
					}else{
						alert(data);	
					}
				});
			}else{
				return false;	
			}
		});
		
		$(".suspend-user").click(function(e){
			e.preventDefault();
			var url = $(this).attr("href") + $(this).attr("class") + ".php";
			var ans = confirm("Are you sure you want to suspend this user?");
			if(ans==true){
				$.post(url, {rec_id: $(this).attr("rec_id"), action: "suspend"}, function(data){
					if(data==""){
						$("#user-manager").click();
					}else{
						alert(data);	
					}
				});
			}else{
				return false;	
			}
		});
		
		$(".edit-user").click(function(e){
			e.preventDefault();
			var url = $(this).attr("href") + $(this).attr("class") + ".php";
			$.post(url, {rec_id: $(this).attr("rec_id"), action: "edit"}, function(data){
				$("#dashboard").html(data);
			});	
		});
    });
    </script>
    <h3><li class="glyphicon glyphicon-user"></li> User List </h3>
    <?php
	if($result){
		echo '<table class="table table-hover">';
		echo '<thead><th>Name</th><th>Username</th><th>Registered Date</th><th>User Status</th><th>Role</th><th>Option</th></thead>';
		foreach($result as $res){
			if($res->user_status!=0){
				$user_status = "Suspended";
				$user_color = "danger";		
				$user_option = "<a href='".plugin_dir_url( __FILE__ )."' class='unlock-user' rec_id='".$res->ID."' title='unlock user'><li class='fa fa-unlock'></li></a>
								<a href='".plugin_dir_url( __FILE__ )."' class='edit-user' rec_id='".$res->ID."' title='edit user'><li class='fa fa fa fa-pencil'></li></a>
								";
			}else{
				$user_status = "Active";
				$user_color = "";
				$user_option = "<a href='".plugin_dir_url( __FILE__ )."' class='suspend-user' rec_id='".$res->ID."' title='suspend user'><li class='fa fa fa-lock'></li></a>
								<a href='".plugin_dir_url( __FILE__ )."' class='edit-user' rec_id='".$res->ID."' title='edit user'><li class='fa fa fa fa-pencil'></li></a>
								";
			}
			$user_info =get_userdata($res->ID);
			$role = $user_info->roles;
			$fname = $user_info->first_name;
			$lname = $user_info->last_name;
			echo '
			<tr class="'.$user_color.'">
				<td>'.$fname.' '.$lname.'</td>
				<td>'.$res->user_login.'</td>
				<td>'.$res->user_registered.'</td>
				<td>'.$user_status.'</td>
				<td>'.$role[0].'</td>
				<td>'.$user_option.'</td>
			</tr>
			';
		}
		echo '<tr><td colspan="6" align="right">
					<a href="'.plugin_dir_url( __FILE__ ).'add-new-user" class="add-new-user"><li class="fa fa-plus-square"></li> Add New</a>
				  </td></tr>';
		echo '</table>';
	}else{
		echo "No user found";	
	}
}else{
	echo "Access Denied!";
}
?>