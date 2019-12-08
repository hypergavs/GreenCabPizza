<?php
/*
Plugin Name: Print Report
Version: 1.0
Author: GM
*/
if(wp_verify_nonce($_GET['secure'], 'secureprintreport')){
$date_from_c = date_create($_GET['d_from']);	
$date_to_c = date_create($_GET['d_to']);
$date_from = date_format($date_from_c,"Y-m-d");
$date_to = date_format($date_to_c, "Y-m-d");
$get_prods = $wpdb->get_results("Select * From jd_tbl_flavors");
$cat = $_GET['cat'];


?>
<h2>Sales Report as of <?php echo date_format($date_from, "M d, Y") ?> to <?php echo date_format($date_to, "M d, Y") ?></h2>
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
		$total_all_sales = $wpdb->get_row("Select sum(total_sales) as total_all_sales From jd_tbl_sales Where trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
		$ctr+=1;
		$get_amounts = $wpdb->get_results("Select 
										sum(sold) as sold_total,
										sum(total_sales) as total_amount_sold
										 From jd_tbl_sales Where flavor='".$prods->flavor."' and trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
		
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
			
			$total_all_sales = $wpdb->get_row("Select sum(total_unsold) as total_all_sales From jd_tbl_sales Where trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
			$ctr+=1;
			$get_amounts = $wpdb->get_results("Select 
											sum(unsold) as sold_total,
											sum(total_unsold) as total_amount_sold
											 From jd_tbl_sales Where flavor='".$prods->flavor."' and trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
			
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
		}else{
			
			$ctr+=1;
			$get_amounts = $wpdb->get_results("Select 
											sum(return_) as sold_total
											 From jd_tbl_sales Where flavor='".$prods->flavor."' and trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
			
				foreach($get_amounts as $amts){
					$qty += number_format($amts->sold_total,0);
					
					if($amts->sold_total>0){
					$perc = $amts->sold_total / $qty * 100;
					}else{
					$perc = 0;	
					}
					$t_perc += number_format($perc,2);
					
					echo '
					<tr>
						<td>'.$ctr.'</td>
						<td>'.$prods->flavor.'</td>
						<td>'.number_format($amts->sold_total,0).'</td>
						<td>N/A</td>
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

<script language="javascript">
$(document).ready(function(e) {
    //bar
	var ctxB = document.getElementById("sales-chart").getContext('2d');
	var myBarChart = new Chart(ctxB, {
		type: 'bar',
		data: {
			labels: [
			<?php
			$get_prods = $wpdb->get_results("Select * From jd_tbl_flavors");
			$amount = [];
			if($get_prods){
				foreach($get_prods as $prods){
					 if($cat=="sold"){
					 	$get_sum = $wpdb->get_row("Select sum(sold) as sold_sum From jd_tbl_sales Where flavor='".$prods->flavor."' and trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
					 }elseif($cat=="unsold"){
						 $get_sum = $wpdb->get_row("Select sum(unsold) as sold_sum From jd_tbl_sales Where flavor='".$prods->flavor."' and trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
					 }else{
						 $get_sum = $wpdb->get_row("Select sum(return_) as sold_sum From jd_tbl_sales Where flavor='".$prods->flavor."' and trans_date BETWEEN CAST('".$date_from."' AS DATE) and CAST('".$date_to."' AS DATE)");
					 }
					?>"<?php echo $prods->flavor;?>",<?php
					array_push($amount, ($get_sum->sold_sum != "" ? $get_sum->sold_sum : 0));
				  }  
			}
			?>
			],
			datasets: [{
				label: 'Sales Chart',
				data: [
				<?php 
				foreach($amount as $amt){
					echo "".$amt.",";
				}
				?>
				],
				backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)',
					'rgba(153, 102, 255, 0.2)',
					'rgba(255, 159, 64, 0.2)'
				],
				borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)',
					'rgba(153, 102, 255, 1)',
					'rgba(255, 159, 64, 1)'
				],
				borderWidth: 1
			}]
		},
		optionss: {
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		}
	});
});
</script>
<canvas id="sales-chart"></canvas>
<?php
}
?>