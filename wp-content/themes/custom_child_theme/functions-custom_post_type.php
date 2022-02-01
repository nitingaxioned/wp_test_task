<?php

// creating Coustom post type Grade
function grade_post_types() {
	register_post_type('grade', array(
	  'public' => true,
	  'show_in_rest' => true,
	  'labels' => array(
		'name' => 'Grade',
		'add_new_item' => 'Add New Grade',
		'edit_item' => 'Edit Grade',
		'all_items' => 'All Grades',
		'singular_name' => 'Grade',
	  ),
	  'has_archive' => true,
	  'publicly_queryable' => true,
	  'menu_position' => 5,
	  'rewrite' => array('slug'=>'grade'),
	  'menu_icon' => 'dashicons-welcome-learn-more',
	  'supports' => array('title','author','excerpt','thumbnail')
	));
  
	//Coustom post type Categorys.
	register_taxonomy('grade-cat', 'grade', array(
	  'hierarchical' => true,
	  'labels' => array(
		'name' => _x( 'Categorys', 'taxonomy general name' ),
		'singular_name' => _x( 'Category', 'taxonomy singular name' ),
		'menu_name' => 'Grade Categorys'
	  ),
	  'rewrite'       => true, 
	  'query_var'     => true 
	));
}
  
add_action('init', 'grade_post_types');

  // custom post excerpt length

add_filter('excerpt_length','custom_excerpt_len', 55);

function custom_excerpt_len($length){
    global $post;
    if ($post->post_type == 'grade') {
        return 50;
    } else {
        return 55;
    }
}