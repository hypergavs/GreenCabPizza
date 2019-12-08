<?php
function importStyle(){
	wp_enqueue_script('jquery-script', get_template_directory_uri().'/js/jquery-3.2.1.js');
	wp_enqueue_script('jqueryui-script', get_template_directory_uri().'/jquery-ui/jquery-ui.min.js');
	wp_enqueue_style('jqueryui-style',get_template_directory_uri().'/jquery-ui/jquery-ui.min.css');
	wp_enqueue_style('jqueryui-theme',get_template_directory_uri().'/jquery-ui/jquery-ui.theme.css');
	wp_enqueue_style('bootstrap-style','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
	wp_enqueue_style('bootstrap-fontawesome','https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_enqueue_style('bootstrap-theme','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css');
	wp_enqueue_script('bootstrap-script','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
	wp_enqueue_style('mdb-theme', get_template_directory_uri().'/mdb/css/mdb.css');
	wp_enqueue_script('custom-script', get_template_directory_uri().'/js/custom-script.js');
	wp_enqueue_style('style', get_stylesheet_uri());;
}



add_action('wp_enqueue_scripts', 'importStyle');

register_nav_menus(array(
	'primary'=>__('Primary'),
	'footer'=>__('Footer'),
));
?>