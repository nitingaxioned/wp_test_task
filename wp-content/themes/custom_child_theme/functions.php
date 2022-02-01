<?php

###################################
# //Enqueue Theme scripts & style
###################################

add_action( 'wp_enqueue_scripts', 'enqueue_styles' );

function enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/css/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri().'/css/style.css' );
    // for jQuery
	  wp_enqueue_script('jquery_mini_cdn','https://code.jquery.com/jquery-3.6.0.min.js');
}



###################################
# // Theme supports 
###################################

// to display thumbnail img
add_theme_support( 'post-thumbnails' );



###################################
# // importing supported files
###################################

// custom post type
get_template_part( 'functions', 'custom_post_type' );

// filter functionality
get_template_part( 'functions', 'filter-ajax' );