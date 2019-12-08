<html <?php language_attributes(); ?>>
	<head>
    	<?php wp_head(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>GreenCab Pizza</title>
    </head>
<body <?php body_class(); ?>>
<div class="container-fluid wow fadeIn" id="top-content">
	<div class="row">
        <div class="col-md-4 col-sm-2" id="the-logo">
            
        </div>
		<div class="col-md-8 col-sm-10" id="the-menu">
            
            <nav class="nav" id="fix-header">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNav">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        
                    </div>
                    <div class="collapse navbar-collapse" id="mainNav">
                    <?php
                            $args = array(
                                'theme_location' => 'primary'
                            );
                            wp_nav_menu($args);
                        ?>
                    </div>
            </nav>
        </div>
    </div>
</div>


