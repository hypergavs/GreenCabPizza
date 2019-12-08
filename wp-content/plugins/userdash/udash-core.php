<?php
/*
Plugin Name: User Main Dashboard
Version: 1.0
Author: GM
*/
show_admin_bar(false);
	function get_sales_summary($user_id){
		global $wpdb;
		$query1 = $wpdb->get_results("Select * From jd_tbl_sales Where encoder_id='".$user_id."' GROUP By DATE_FORMAT(trans_date,'%Y-%m-%d'), prod_id");	
		if($query1){
			foreach($query1 as $qry1){
				$ctr++;
				$branch = $wpdb->get_row("Select * From jd_tbl_cabloc Where id='".$qry1->branch_id."'");	
				$product = $wpdb->get_row("Select * From jd_tbl_flavors Where id='".$qry1->prod_id."'");
				$supply = $wpdb->get_row("Select sum(qty) as stock From jd_tbl_supply Where DATE_FORMAT(trans_date,'%Y-%m-%d')=DATE_FORMAT('".$qry1->trans_date."','%Y-%m-%d')");
				$sales = $wpdb->get_row("Select sum(sold_qty) as sold From jd_tbl_sales Where DATE_FORMAT(trans_date,'%Y-%m-%d')=DATE_FORMAT('".$qry1->trans_date."','%Y-%m-%d')");
				$total_sales = number_format($sales->sold * $product->price,2);
				$unsold = ($supply->stock - $sales->sold);
				$total_unsold = number_format($unsold * $product->price,2);
				$a[$ctr] .= array($branch->address, $branch->franchise_owner, $qry->trans_date, $product->flavor, $product->price, $product->price_change_date, $supply->stock, $sales->sold, $total_sales, $unsold, $total_unsold);
				
			} 	
		}
	}
function user_dash(){
	global $wpdb;
	ob_start();
	$curr_user = get_current_user_id();
	$fname = get_user_meta($curr_user, "first_name", true);
	$user_info =get_userdata(get_current_user_id());
	$role = $user_info->roles;
	if(is_user_logged_in()){
	?>
    <script language="javascript" src="<?php echo plugin_dir_url( __FILE__ ) ?>dashboard-script.js"></script>
		<div class="container" id="main-dash-wrap">
        	<div class="row">
            	<div class="col-md-3" id="dash-side-nav">
                	<h4><li class="fa fa-user-circle-o"></li> Howdy, <?php echo ucfirst($fname) ?></h4>
                	<ul>
                    <?php
					if($role[0]=="administrator"){
					?>
                		<a href="<?php echo plugin_dir_url( __FILE__ ) ?>include/dashboard" id="dashboard-link"><li>Dashboard</li></a>
                        <a href="<?php echo plugin_dir_url( __FILE__ ) ?>include/user-manager" id="user-manager"><li>User List</li></a>
                        <a href="<?php echo plugin_dir_url( __FILE__ ) ?>include/production-record" id="production-record"><li>Inventory</li></a>
                        <a href="<?php echo plugin_dir_url( __FILE__ ) ?>include/cab-locations" id="cab-locations"><li>Cab Locations</li></a>
                        <a href="<?php echo plugin_dir_url( __FILE__ ) ?>include/reports" id="reports"><li>Reports</li></a>
                        <a href="<?php echo wp_logout_url("logout") ?>" id="logout-btn"><li>Logout</li></a>
                    <?php
					}else{
					?>
                    	<a href="<?php echo plugin_dir_url( __FILE__ ) ?>include/dashboard" id="dashboard-link"><li>Dashboard</li></a>
                        <a href="<?php echo plugin_dir_url( __FILE__ ) ?>include/production-record" id="production-record"><li>Inventory</li></a>
                        <a href="<?php echo wp_logout_url("logout") ?>" id="logout-btn"><li>Logout</li></a>
                    <?php
					}
					?>
                    </ul>
                </div>
                <div class="col-md-9" id="dashboard">
                
                </div>
            </div>
        </div>
		
	<?php	
	}else{
		?>
        <div class="deny-access">
			<h3>Access Denied!</h3>
			<p>You should log-in first!</p>
		</div>
        <?php
	}
	
}

add_shortcode("userdash","user_dash");

function print_report(){
	global $wpdb;
?>
<?php
	if(wp_verify_nonce($_GET['secure'], 'secureprintreport')){
$date_from_c = date_create($_GET['d_from']);	
$date_to_c = date_create($_GET['d_to']);
$date_from = date_format($date_from_c,"Y-m-d");
$date_to = date_format($date_to_c, "Y-m-d");
$get_prods = $wpdb->get_results("Select * From jd_tbl_flavors");
$cat = $_GET['cat'];


?>
<h2 align="center">Sales Report as of <?php echo date_format(date_create($date_from), "M d, Y") ?> to <?php echo date_format(date_create($date_to), "M d, Y") ?></h2><br /><br />
<table class="table table-condensed">
	<thead>
    	<th>#</th>
    	<th>Product</th>
    	<th>Quantity</th>
    	<th>Amount</th>
    	<th>Percent of Total</th>
    	</thead>
    <?php
	foreach($get_prods as $prods){
		if($cat=="sold"){
		$total_all_sales = $wpdb->get_row("Select sum(sold) * item_price as total_all_sales From jd_tbl_sales_view Where branch LIKE '%".$cab_loc_id."%' and trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
		$ctr+=1;
		$get_amounts = $wpdb->get_results("Select 
										sum(sold) as sold_total,
										sum(sold) * item_price as total_amount_sold
										 From jd_tbl_sales_view Where branch LIKE '%".$cab_loc_id."%' and flavor='".$prods->flavor."' and trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
		
		
			foreach($get_amounts as $amts){
				if($amts->total_amount_sold>0){
				$perc = $amts->total_amount_sold / $total_all_sales->total_all_sales * 100;
				}else{
				$perc = 0;	
				}
				$qty += number_format($amts->sold_total,0);
				$amt += $amts->total_amount_sold;
				$t_perc += number_format($perc,2);
				echo '
				<tr>
					<td>'.$ctr.'</td>
					<td>'.$prods->flavor.'</td>
					<td>'.number_format($amts->sold_total,0).'</td>
					<td>'.number_format($amts->total_amount_sold,2).'</td>
					<td>'.number_format($perc,2).'%</td>
				</tr>
				';	
			}
		}elseif($cat=="unsold"){
			
			$total_all_sales = $wpdb->get_row("Select (sum(delivered) - sum(sold)) * item_price as total_all_sales From jd_tbl_sales_view Where branch LIKE '%".$cab_loc_id."%' and trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
			$ctr+=1;
			$get_amounts = $wpdb->get_results("Select 
											(sum(delivered) - sum(sold)) as sold_total,
											(sum(delivered) - sum(sold)) * item_price as total_amount_sold
											 From jd_tbl_sales_view Where branch LIKE '%".$cab_loc_id."%' and flavor='".$prods->flavor."' and trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
			
			
				foreach($get_amounts as $amts){
					if($amts->total_amount_sold>0){
					$perc = $amts->total_amount_sold / $total_all_sales->total_all_sales * 100;
					}else{
					$perc = 0;	
					}
					$qty += number_format($amts->sold_total,0);
					$amt += $amts->total_amount_sold;
					$t_perc += number_format($perc,2);
					echo '
					<tr>
						<td>'.$ctr.'</td>
						<td>'.$prods->flavor.'</td>
						<td>'.number_format($amts->sold_total,0).'</td>
						<td>'.number_format($amts->total_amount_sold,2).'</td>
						<td>'.number_format($perc,2).'%</td>
					</tr>
					';	
				}
		}
	}
	?>
    <tr><td colspan="2"><strong>Total:</strong></td>
    	<td><strong><?php echo $qty; ?></strong></td>
    	<td><strong>N/A</strong></td>
    	<td><strong><?php echo $t_perc; ?>%</strong></td>
    </tr>
</table>


<?php
}
?>
<?php
}

add_shortcode("print-report","print_report");

function jd_logout(){
	global $wpdb;
	ob_start();
	if(!is_user_logged_in()){
		?>
        <div class="deny-access">
			<h3>Logged out successfuly!</h3>
		</div>
        <?php
	}else{
		?>
        <div class="deny-access">
			<h3>Access Denied!</h3>
			<p>You should log-in first!</p>
		</div>
        <?php
	}
	
}

add_shortcode("jd-logout","jd_logout");

function udash_style() {
	wp_enqueue_style('udash-style', plugin_dir_url( __FILE__ ) . 'css/udash-style.css');
}
add_action('wp_enqueue_scripts', 'udash_style');
?>