<?php

###################################
# //Enqueue Theme scripts & style
###################################

add_action( 'wp_enqueue_scripts', 'load_script_css' );
function load_script_css() {
    // for css
	wp_enqueue_style('main_style',get_theme_file_uri('/css/style.css'));

    // for jQuery
	wp_enqueue_script('jquery_mini_cdn','https://code.jquery.com/jquery-3.6.0.min.js');

    // // for script
    // wp_enqueue_script('js-for-ajax',get_theme_file_uri('/js/script.js'));

    // for ajax
    wp_enqueue_script( 'ajax-script', get_theme_file_uri('/js/script.js'), array('jquery') );
	wp_localize_script(
        'ajax-script',
        'ajax_object',
        array( 
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'action' => 'filter',
        )
    );
}

add_action( 'wp_footer', 'load_custum_script' );
function load_custum_script() {
	// for jQuery
	// wp_enqueue_script('jquery_mini_cdn','https://code.jquery.com/jquery-3.6.0.min.js');
    // for script
	// wp_enqueue_script('js-for-ajax',get_theme_file_uri('/js/script.js'));
}


###################################
# // Theme supports 
###################################

// to display thumbnail img
add_theme_support( 'post-thumbnails' );

// to display title and tagline
add_theme_support( 'title-tag' );

// to display custom logo
add_theme_support( 'custom-logo', array(
	'header-text' => array('site-tittle', 'site-description'),
	'height' => 50,
	'width' => 200	
	)
);

// to set custom bg img
add_theme_support( 'custom-background', array(
	'default-color' => '#fefefe',
	'default-image' => ''
	)
);


###################################
# // register menues
###################################

register_nav_menus(
    array(
        'primary-menu' => 'header menu',
    )
);


###################################
# // Coustom post type Grade
###################################

add_action('init', 'grade_post_types');

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


###################################
# // Custom Functions
###################################

function get_excerpt_50($excerpt) {
    if(strlen($excerpt) > 50) {
        $excerpt = substr($excerpt, 0, 47) . '...';
    }
    return $excerpt;
}

function showpost($obj) {
    $title = $obj->post_title;
    $excerpt = get_excerpt_50($obj->post_excerpt);
    $link = get_permalink($obj->ID)
    ?>
        <li><?php
            if ( $title != null ) {?>
				<h3><?php echo $title; ?></h3>
			<?php } 
			if ( $excerpt != null ) {?>
				<p><?php echo $excerpt; ?></p>
			<?php } ?>
            <a title="Read More" href="<?php echo $link; ?>"><button class='btn'>Read More</button></a>
        </li>
    <?php
}


###################################
# // Ajax Functions
###################################

// hooks for filter ajax
add_action( 'wp_ajax_filter', 'filter_ajax' );
add_action( 'wp_ajax_nopriv_filter', 'filter_ajax' );

// callback for filter_ajax
function filter_ajax(){
	$cat_id = $_REQUEST['id'];
	$pg = $_REQUEST['pg'];
    $queryArr = array(
		'posts_per_page' => 6,
		'post_type' => 'grade',
		);
    if ($cat_id != 'all') {
        $queryArr['tax_query'] = array(
            array(
              'taxonomy' => 'grade-cat',
              'field' => 'term_id',
              'terms' => $cat_id
            ),
        );
    }
    if( $pg == 1 ) {
        $res = new wp_Query($queryArr);
        if ($res->found_posts < 1) {
            ?>
            <li><p>Nothing Found :(</p></li>
            <?php
            hideLoadBtn();
            die();
        }
        $n = $res->post_count;
		for ($x = 0; $x < $n; $x++) {
			showpost($res->posts[$x]);
		}
        haveMore($queryArr, $pg);
    } else {
        $queryArr['paged'] = $pg;
        $res = new wp_Query($queryArr);
        $n = $res->post_count;
		for ($x = 0; $x < $n; $x++) {
			showpost($res->posts[$x]);
		}
        haveMore($queryArr, $pg);
    }
	die();
}

function hideLoadBtn(){
    ?>
    <script>
        jQuery('.load_more').hide();
    </script>
    <?php
}

function showLoadBtn(){
    ?>
    <script>
        jQuery('.load_more').show();
    </script>
    <?php
}

function haveMore($queryArr, $pg){
    $queryArr['posts_per_page'] = -1;
    $res = new wp_Query($queryArr);
    $noOfPost = $res->found_posts;
    $expg = ceil($noOfPost/6);
    ($pg == $expg) ? hideLoadBtn() : showLoadBtn();
}