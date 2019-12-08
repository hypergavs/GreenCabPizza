<?php
/*
Plugin Name: GreenCab Homepage
Description: Provides simple front end registration and login forms
Version: 1.0
Author: JD
*/


function the_home(){
	global $wpdb;
	?>
    <script language="javascript">
    $(document).ready(function(e) {
		$('.multi-item-carousel').carousel({
		  interval: false
		});
		
		// for every slide in carousel, copy the next slide's item in the slide.
		// Do the same for the next, next item.
		$('.multi-item-carousel .item').each(function(){
		  var next = $(this).next();
		  if (!next.length) {
			next = $(this).siblings(':first');
		  }
		  next.children(':first-child').clone().appendTo($(this));
		  
		  if (next.next().length>0) {
			next.next().children(':first-child').clone().appendTo($(this));
		  } else {
			$(this).siblings(':first').children(':first-child').clone().appendTo($(this));
		  }
		});
		  $("#theCarousel .carousel-inner .item:first-child").addClass("active");
		  $("#event_photo_slider .carousel-inner .item:first-child").addClass("active");
		
		$(".featured-product-list .gal_url").click(function(e){
			e.preventDefault();	
			var photo_id = $(this).attr("href");
			$("#event_photo_slider .item.active").removeClass("active");
			$("#event_photo_slider .item." + photo_id).addClass("active");
		});
		  
    });
    </script>
    
    
    <div class="container">
        <div class="row" id="event_photo_slider_wrap">
        	<div class="col-md-8 col-sm-8 col-xs-7">
            	<div id="event_photo_slider" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                
            
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                
					<?php 
						$gal_id = 1;
						$gal_url = content_url()."/uploads/photo-gallery";
						$gallery = $wpdb->get_row("Select * From jd_bwg_gallery Where id='$gal_id'");
						$images = $wpdb->get_results("Select * From jd_bwg_image Where gallery_id='$gal_id'");
						if($gallery){
							if($images){
								  foreach($images as $image){
									  echo '
										   <div class="item '.$image->id.'">
											  <img src="'.$gal_url.$image->image_url.'">
											  
											</div>
									  ';	
								  }  
							}
						}
					?>
                    
            
                 
                
                </div>
            
                <!-- Left and right controls -->
                <a class="left carousel-control" href="#event_photo_slider" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#event_photo_slider" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
         	
            <div class="col-md-4 col-sm-4 col-xs-5 featured-product-list verticalCarousel">
            	
                <div class="col-md-11 col-sm-10 col-xs-9">
					<?php
                        $gal_url = content_url()."/uploads/photo-gallery";
                        $gallery = $wpdb->get_results("Select * From jd_bwg_image Where gallery_id=1");
                        if($gallery){
                            echo '<ul class="verticalCarouselGroup vc_list">';
                            foreach($gallery as $gal){
                                echo '
                                        <li><a href="'.$gal->id.'" class="gal_url"><img src="'.$gal_url.$gal->thumb_url.'" class="img-responsive">
                                      </a></li>';	
                            }
                            echo '</ul>';
                        }
                    ?>
            	</div>
            	<div class="vscroll-controls col-md-1 col-sm-2 col-xs-3">
                	<a href="#" class="vc_goUp"><li class="glyphicon glyphicon-chevron-up" style="font-size:20px; color:#FFF;"></li></a>
                    <a href="#" class="vc_goDown"><li class="glyphicon glyphicon-chevron-down" style="font-size:20px; color:#FFF;"></li></a>
                </div>
            </div>
            
            
        </div>
        
        
      </div>
    
    	<script language="javascript">
        	$(document).ready(function(e) {
                $("#cab-locator-form").submit(function(e){
					e.preventDefault();
					$.post($(this).attr("action"), $(this).serialize(), function(data){
						$("#cab-locator-feedback").html(data);
					});	
				});
            });
        </script>
    
    
    	<div class="container-fluid" id="cab-locator">
        	<div class="row">
            	<div class="container">
                	<h3><li class="glyphicon glyphicon-search"></li>Find our locations here.</h3>
                	<form action="<?php echo plugin_dir_url( __FILE__ ) ?>locate-cab.php" method="post" id="cab-locator-form">
                    	<div class="col-md-2">
                    		<label for="address_text">Locate Address: </label>
                        </div>
                        <div class="col-md-7">
                        	<input type="text" name="address_text" placeholder="Input address here.." />
                        </div>
                        <div class="col-md-3">
                        	<input type="hidden" value="<?php echo wp_create_nonce('gcsecurelocatecab'); ?>" name="secure" />
                        	<input type="submit" value="Locate" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="container" id="cab-locator-feedback">
            	
            </div>
            
        </div>
    
    
    	
 
    
    
    	
    
        <script>
            $(".verticalCarousel").verticalCarousel({
                currentItem: 2,
                showItems: 2,
            });
        </script>
    
    <?php
}

add_shortcode("the_home","the_home");


?>