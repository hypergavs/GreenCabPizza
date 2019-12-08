<?php
require_once '../../../../wp-load.php';
if(is_user_logged_in()){
	global $wpdb;
	$branches = $wpdb->get_results("Select * From jd_tbl_cabloc");
	$user_info =get_userdata(get_current_user_id());
	$role = $user_info->roles;
	$encoder = $role[0]=="administrator" ? "" : get_current_user_id();
	?>
    <script language="javascript">
    $(document).ready(function(e) {
        $(".cab-loc-sup").change(function(){
			var url = '<?php echo plugin_dir_url( __FILE__ ) ?>get_franchise_owner.php';
			$.post(url, { branch: $(this).val() }, function(data){
				$("input[name=f_owner_sup]").val(data);
			});
		});
		$(".cab-loc-sal").change(function(){
			var url = '<?php echo plugin_dir_url( __FILE__ ) ?>get_franchise_owner.php';
			$.post(url, { branch: $(this).val() }, function(data){
				$("input[name=f_owner_sal]").val(data);
			});
		});
        $("select[name=flavor]").change(function(){
			var url = '<?php echo plugin_dir_url( __FILE__ ) ?>get_current_product_price.php';
			$.post(url, { flavor: $(this).val() }, function(data){
				$("input[name=currprice]").val(data);
			});
			$("input[name=total_sold]").val($("input[name=sold]").val() * $("input[name=currprice]").val());
			$("input[name=total_unsold]").val($("input[name=unsold]").val() * $("input[name=currprice]").val());
			$("input[name=receivable]").val($("input[name=sold]").val() * $("input[name=currprice]").val());
		});
		$("input[name=delivered],input[name=sold],input[name=unsold]").blur(function(){
			if($("input[name=currprice]")!=""){
				$("input[name=total_sold]").val($("input[name=sold]").val() * $("input[name=currprice]").val());
				$("input[name=total_unsold]").val($("input[name=unsold]").val() * $("input[name=currprice]").val());
				$("input[name=receivable]").val($("input[name=sold]").val() * $("input[name=currprice]").val());
			}else{
				alert("Please select product flavor first before trying to change the amount of delivered, sold and unsold.");	
			}
			
		});
		
		$("#add-inventory-record").submit(function(e){
			e.preventDefault();
			var sold = parseInt($("input[name=sold]").val());
			var unsold = parseInt($("input[name=unsold]").val());
			var return_ = parseInt($("input[name=return_]").val());
			var total_sold_unsold = (sold+unsold+return_);
			if(total_sold_unsold!=$("input[name=delivered]").val()){
				alert("Kindly check sold and unsold, it should not be greater than or less than the delivered product.");
			}else{
			var url = $(this).attr("action");
			$.post(url, $(this).serialize(), function(data){
				if(data=="OK"){
					$("#add-inventory-record").trigger("reset");
				}else{
					alert(data);	
				}
			});
			}
		});
		
		
	//pie
	var ctxP = document.getElementById("pieChart").getContext('2d');
	
	var myPieChart = new Chart(ctxP, {
		type: 'pie',
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
			datasets: [
				{
					data: [<?php 
					foreach($amount as $amt){
						echo "".$amt.",";
					}
					?>],
					backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
					hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
				}
			]
		},
		options: {
			responsive: true
		}    
	});
		
		
		
		$("#add-inv-supply").submit(function(e){
			e.preventDefault();
			var error = 0;
			var error_msg = "";
			$(".gm-field-text", this).each(function(index, element) {
                console.log($(this).val());
				if($(this).val()!=""){
					if($(this).val()>=0&&$.isNumeric($(this).val())){
					
					}else{
						error += 1;		
					}
				}
            });
			
			var url = $(this).attr("action");
			if(error){
				alert("Invalid input found. Please check your inputs.");	
			}else{
				$.post(url, $(this).serialize(), function(data){
					if(data=="OK"){
						$("#production-record").click();
					}else{
						alert(data);	
					}
				});	
			}
		});
		
		
		
    });
    </script>
    <h3><i class="fa fa-truck" aria-hidden="true"></i>  Supply</h3>
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-8">
            	<form action="<?php echo plugin_dir_url( __FILE__ ) ?>p_add_supply.php" method="post" id="add-inv-supply">
                <div class="form-group gm-form-group-1">
                	
                    <?php
                    	$prods = $wpdb->get_results("Select * From jd_tbl_flavors");
						if($prods){
						foreach($prods as $prod){
							$stocks = $wpdb->get_row("Select sum(qty) as qty_sum From jd_tbl_supply Where prod_id='".$prod->id."' and encoder_id='".get_current_user_id()."'");
							$sales = $wpdb->get_row("Select sum(sold_qty) as qty_sum From jd_tbl_sales Where prod_id='".$prod->id."' and encoder_id='".get_current_user_id()."'");
							$color = $stocks->qty_sum < 5 ? "FF0000;" : "000;";
							echo '
                			<div class="input-group gm-input-group-1">
							<div class="input-group-addon gm-group-addon-1">'.$prod->flavor.'</div>
							<input type="text" class="form-control gm-field-text" name="prod-'.$prod->id.'" placeholder="Number of Delivery">
							<div class="input-group-addon gm-group-addon-1" style="color:'.$color.'">'.($stocks->qty_sum - $sales->qty_sum).' in stock</div>
                    		</div>
							';	
						}	
						}
					?>
                    <div class="input-group">
                	<div class="input-group-addon">Branch</div>
                        <select name="cab-loc" class="form-control gm-field-select cab-loc-sup" required>
                            <option value="">Select Branch</option>
                            <?php
                            if($branches){
                                foreach($branches as $branch){
                                    echo '
                                        <option value="'.$branch->id.'">'.$branch->address.'</option>
                                    ';	
                                }	
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">Franchise Owner</div>
                        <input type="text" class="form-control" value="" name="f_owner_sup" readonly>
                    </div>
                    <div class="input-group">
                        <input type="hidden" name="secure" value="<?php echo wp_create_nonce('secureaddsupply') ?>" />
                        <input type="submit" value="Add Supply" class="btn btn-primary btn-lg pull-right" />
                    </div>
                    
                </div>
                </form>
            </div>
            <div class="col-md-4">
            	
            </div>
        </div>
    </div>
    
    
    
    <script language="javascript">
    $(document).ready(function(e) {
        $(".add-cart").click(function(){
			var invoice = $("input[name=invoice]").val();
			var url = $("#the-cart").attr("action");
			var branch = $(".cab-loc-sal").val();
			var stock_rem = parseInt($("."+$(this).attr("id")).text());
			var prod_id = $(this).attr("prod_id");
			stock_rem -= 1;
			if(stock_rem>-1){
				$.post(url,{invoice: invoice, branch: branch, prod_id: prod_id, trans: 'add'}, function(data){
					$("#cart-feedback").html(data);
				});
				$("."+$(this).attr("id")).text(stock_rem);
			}else{
				$(this).attr("readonly");
			}
			
		});
		$(".minus-cart").click(function(){
			var invoice = $("input[name=invoice]").val();
			var url = $("#the-cart").attr("action");
			var branch = $(".cab-loc-sal").val();
			var stock_rem = parseInt($("."+$(this).attr("id")).text());
			var max_val = parseInt($("."+$(this).attr("id")).attr("max"));
			var prod_id = $(this).attr("prod_id");
			stock_rem += 1;
			if(stock_rem<=max_val){
				$.post(url,{invoice: invoice, prod_id: prod_id, trans: 'minus'}, function(data){
					$("#cart-feedback").html(data);
				});
				$("."+$(this).attr("id")).text(stock_rem);
			}else{
				$(this).attr("readonly");
			}
		});
    });
    </script>
    
    
    
    <h3><li class="fa fa-money"></li>  Sales</h3>
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-6">
            	
            	<form action="<?php echo plugin_dir_url( __FILE__ ) ?>p_update_cart.php" method="post" id="the-cart">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">Invoice</div>
                        <input type="text" class="form-control" value="<?php echo "INV".time(); ?>" name="invoice" readonly>
                    </div>
                 	<div class="input-group">
                	<div class="input-group-addon">Branch</div>
                        <select name="cab-loc" class="form-control gm-field-select cab-loc-sal" required>
                            <option value="">Select Branch</option>
                            <?php
                            if($branches){
                                foreach($branches as $branch){
                                    echo '
                                        <option value="'.$branch->id.'">'.$branch->address.'</option>
                                    ';	
                                }	
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group">
                        <div class="input-group-addon">Franchise Owner</div>
                        <input type="text" class="form-control" value="" name="f_owner_sal" readonly>
                    </div>
				<?php
                    $prods = $wpdb->get_results("Select * From jd_tbl_flavors");
                    if($prods){
                    foreach($prods as $prod){
                        $stocks = $wpdb->get_row("Select sum(qty) as qty_sum From jd_tbl_supply Where prod_id='".$prod->id."' and encoder_id='".get_current_user_id()."'");
						$sales = $wpdb->get_row("Select sum(sold_qty) as qty_sum From jd_tbl_sales Where prod_id='".$prod->id."' and encoder_id='".get_current_user_id()."'");
                        $color = $stocks->qty_sum < 5 ? "FF0000;" : "000;";
                        echo '
                        <div class="input-group">
                        <div class="input-group-addon gm-group-addon-1">'.$prod->flavor.'</div>
						
						
						<div class="input-group-addon">
						<input type="button" id="stock_rem'.$prod->id.'" prod_id="'.$prod->id.'" class="btn btn-info add-cart" value="+">
						<input type="button" id="stock_rem'.$prod->id.'" prod_id="'.$prod->id.'" class="btn btn-info minus-cart" value="-">
						</div>
                        <div class="input-group-addon" style="color:'.$color.'"><span class="stock_rem'.$prod->id.'" max='.($stocks->qty_sum - $sales->qty_sum).'>'.($stocks->qty_sum - $sales->qty_sum).'</span> in stock</div>
                        </div>
                        ';	
                    }	
                    }
                ?>
                </div>
                </form>
            </div>
            <div class="col-md-6">
            	<h3><li class="fa fa-shopping-cart"></li>  Cart</h3>
                <div id="cart-feedback"></div>
            </div>
        </div>
    </div>
    
	<h3><li class="fa fa-pencil-square"></li>  Chart</h3>
    <div class="container-fluid">
    	<div class="row">
    
        <div class="col-md-12">
			<canvas id="pieChart"></canvas>
        </div>
        </div>
	</div>
    
    <div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12">
            	<table class="table table-condensed">
                	<thead>
                    	<th>Flavor</th>
                    	<th>Trans Date</th>
                    	<th>Delivered</th>
                    	<th>Sold</th>
                    	<th>Unsold</th>
                    	<th>Receivable</th>
                    </thead>
                    <?php
                    $results = $wpdb->get_results("Select * From jd_tbl_sales_view Where encoder LIKE '%".$encoder."%'");
					if($results){
						foreach($results as $res){
							$trans_date = date_create($res->trans_date);
							echo '
								<tr>
									<td>'.$res->flavor.'</td>
									<td>'.date_format($trans_date, 'M d, Y').'</td>
									<td>'.$res->delivered.'</td>
									<td>'.$res->sold.'</td>
									<td>'.($res->delivered - $res->sold).'</td>
									<td align="right" class="money">'.number_format($res->sold * $res->item_price,2).'</td>
								</tr>
							';	
						}
					}else{
						echo '<tr><td colspan="6" align="center">No Record Found.</td></tr>';	
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