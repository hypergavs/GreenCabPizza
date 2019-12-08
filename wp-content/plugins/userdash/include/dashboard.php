<?php
require_once '../../../../wp-load.php';
if(is_user_logged_in()){
	global $wpdb;
	$user_info =get_userdata(get_current_user_id());
	$role = $user_info->roles;
	$encoder = $role[0]=="administrator" ? "" : get_current_user_id();
	echo $encoder;
	?>
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
						 $get_sum = $wpdb->get_row("Select sum(sold) as sold_sum From jd_tbl_sales_view Where flavor='".$prods->flavor."' and encoder LIKE '%".$encoder."%'");
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
		
		
		//line
		var ctxL = document.getElementById("sales-chart-by-month").getContext('2d');
		<?php
			$sum_by_month = [];
			$total_unsold = [];
			$months = $wpdb->get_results("Select trans_date From jd_tbl_sales_view Where encoder LIKE '%".$encoder."%' GROUP BY MONTH(trans_date)");
		?>
		var myLineChart = new Chart(ctxL, {
			type: 'line',
			data: {
				labels: [
				<?php
					foreach($months as $month){
						$m = date_create($month->trans_date);	
						echo "'".date_format($m, 'M')."',";
						$result = $wpdb->get_results("Select sum(sold) as total_sold,  sum(delivered) - sum(sold) as total_unsold From jd_tbl_sales_view Where MONTH(trans_date)='".date_format($m, 'm')."' and encoder LIKE '%".$encoder."%'");
						foreach($result as $res){
							array_push($sum_by_month, $res->total_sold);
							array_push($total_unsold, $res->total_unsold);
						}
					}
				?>
				],
				datasets: [
					{
						label: "Sold by Month",
						fillColor: "rgba(220,220,220,0.2)",
						strokeColor: "rgba(220,220,220,1)",
						pointColor: "rgba(220,220,220,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(220,220,220,1)",
						data: [
							<?php 
							foreach($sum_by_month as $sbm){
								echo "".$sbm.",";
							}
							?>
						]
					},
					{
						label: "Unsold by Month",
						fillColor: "rgba(151,187,205,0.2)",
						strokeColor: "rgba(151,187,205,1)",
						pointColor: "rgba(151,187,205,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: "#fff",
						pointHighlightStroke: "rgba(151,187,205,1)",
						data: [
							<?php 
							foreach($total_unsold as $tu){
								echo "".$tu.",";
							}
							?>
						]
					}
				]
			},
			options: {
				responsive: true
			}    
		});
					
					
    });
    </script>
	<h3><li class="fa fa-bar-chart-o"></li>  Dashboard</h3>
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
				<canvas id="sales-chart"></canvas>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-12">
				<canvas id="sales-chart-by-month"></canvas>
            </div>
        </div>
    </div>
	<?php
}else{
	echo "Access Denied!";
}
?>