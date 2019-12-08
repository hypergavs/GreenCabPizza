<?php
require_once '../../../../wp-load.php';
if(is_user_logged_in()){
	global $wpdb;
	if($_POST['invoice']){
		$invoice = $_POST['invoice'];	
		$prod_id = $_POST['prod_id'];
		$branch_id = $_POST['branch'];
		$user_id = get_current_user_id();
		$trans_type = $_POST['trans'];
		?>
        <script language="javascript">
        $(document).ready(function(e) {
            $("#checkout").click(function(){
				
				var invoice = "<?php echo $invoice ?>";
				
				var secure = "<?php echo wp_create_nonce('securecheckoutcart'); ?>";
				var url = "<?php echo plugin_dir_url( __FILE__ ) ?>p_checkout_cart.php";
				$.post(url,{invoice: invoice, secure: secure},function(data){
					if(data=="OK"){
						alert("Transaction Complete!");
						$("#production-record").click();
					}
					console.log(data);
				});
			});
        });
        </script>
        <?php
		
		if($trans_type=='add'){
			$qry = $wpdb->query($wpdb->prepare("Insert into jd_tbl_sales_temp (invoice, encoder_id, branch_id, sold_qty, prod_id) VALUES (%s,%d,%d,%d,%d)",
												$invoice, $user_id, $branch_id, 1, $prod_id));
			if($qry){
				$results = $wpdb->get_results($wpdb->prepare("Select invoice, sum(sold_qty) as sold_qty, prod_id From jd_tbl_sales_temp Where invoice=%s GROUP By prod_id", $invoice));
				if($results){
					echo '<table class="table table-condensed">
						<thead><th>Description</th><th>Qty x Price</th><th>Sub Total</th></thead>';

					foreach($results as $res){
						$prod_name = $wpdb->get_row("Select * From jd_tbl_flavors Where id='".$res->prod_id."'");
						$grand += number_format($res->sold_qty*$prod_name->price, 2);
						echo '<tr><td style="text-align:left"><li class="fa fa-pie-chart"></li> '.$prod_name->flavor.'</td><td>'.$res->sold_qty.' x '.$prod_name->price.'</td><td>'.number_format($res->sold_qty*$prod_name->price, 2).'</td></tr>';
					}
					echo '<tr><td colspan="2" style="text-align:right"><strong>Total: </strong></td><td>'.number_format($grand,2).'</td></tr>
					<tr><td colspan="3"><input type="button" id="checkout" class="btn btn-warning pull-right btn-lg" value="Checkout"></td></tr>';
					echo '</table>';
				}
			}
		}else{
			$qry = $wpdb->query($wpdb->prepare("Delete from jd_tbl_sales_temp Where invoice=%s and prod_id=%d LIMIT %d",
												$invoice, $prod_id, 1));
			if($qry){
				$results = $wpdb->get_results($wpdb->prepare("Select invoice, sum(sold_qty) as sold_qty, prod_id From jd_tbl_sales_temp Where invoice=%s GROUP By prod_id", $invoice));
				if($results){
					echo '<table class="table table-condensed">
						<thead><th>Description</th><th>Qty x Price</th><th>Sub Total</th></thead>';
					foreach($results as $res){
						$prod_name = $wpdb->get_row("Select * From jd_tbl_flavors Where id='".$res->prod_id."'");
						$grand += number_format($res->sold_qty*$prod_name->price, 2);
						echo '<tr><td style="text-align:left"><li class="fa fa-pie-chart"></li> '.$prod_name->flavor.'</td><td>'.$res->sold_qty.' x '.$prod_name->price.'</td><td>'.number_format($res->sold_qty*$prod_name->price, 2).'</td></tr>';
					}
					echo '<tr><td colspan="2" style="text-align:right"><strong>Total: </strong></td><td>'.number_format($grand,2).'</td></tr>
					<tr><td colspan="3"><input type="button" id="checkout" class="btn btn-warning pull-right btn-lg" value="Checkout"></td></tr>';
					echo '</table>';
				}
			}
		}
		
		
		
	}
}else{
	echo "Access Denied!";
}
?>