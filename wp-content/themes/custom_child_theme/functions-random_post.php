<?php

function add_admin_page(){
    // to creat admin page
    add_menu_page(
        __('Custom random posts'), //page title
        'Random Grade', // menu title
        'manage_options', // to specify capable user
        'random_posts_page', //slug
        'random_posts_page_data', // claback Function
        "https://www.buckheadhairrestoration.com/wp-content/uploads/2014/10/20x20-Checkmark.png", // icon Url
        '110' //position
    );

    // to creat admin sub page as first page
    add_submenu_page(
        'random_posts_page', // parrent slug 
        'Random Grade', //page titel 
        'Random 3', // menu title
        'manage_options', // to specify capable user
        'random_posts_page', // slug // shuld be same for first page of nemu
        'random_posts_page_data' // clallback // shuld be same for first page of nemu
    );

    add_action('admin_init', 'set_random_custome_setting');
}

add_action('admin_menu', 'add_admin_page');

//callback for admin menu created
function random_posts_page_data() {
    ?>
    <h1><?php bloginfo('name'); ?></h1>
    <h2>The Custome admin Menu Page </h2>
    <p>To set Random Gread Posts</p>
    <?php settings_errors(); ?>
    <form method='post' action='options.php'>
        <?php settings_fields( 'ste_posts' ); ?>
        <?php do_settings_sections( 'random_posts_page' ); ?>
        <?php submit_button(); ?>
    </form>
    <?php
}

// to regisrer custom settings of api
function set_random_custome_setting(){
    // creating section
    add_settings_section('section','Section one','sectionc_callback','random_posts_page');

    // to register settings
    register_setting( 'ste_posts', 'post_1');
    register_setting( 'ste_posts', 'post_2');
    register_setting( 'ste_posts', 'post_3');

    // to add setting field
    add_settings_field('post_1','Set Random Post 1','post_list1','random_posts_page','section');
    add_settings_field('post_2','Set Random Post 2','post_list2','random_posts_page','section');
    add_settings_field('post_3','Set Random Post 3','post_list3','random_posts_page','section');

}

function sectionc_callback(){
    echo 'Section One Starts here. To set Random Gread Posts by admin using Dashboard.';
}

function post_list1(){ post_list('post_1'); }
function post_list2(){ post_list('post_2'); }
function post_list3(){ post_list('post_3'); }

function post_list($name){
    $option_id = get_option($name);
    ?>
        <label for=<?php echo $name; ?>> <?php echo $name; ?> :</label>
        <select name=<?php echo $name; ?> id=<?php echo $name; ?>>
            <?php
                $queryArr = array(
                    'posts_per_page' => -1,
                    'post_type' => 'grade',
                    );
                $res = new wp_Query($queryArr);
                while($res->have_posts()) {
                    $res->the_post(); 
                    $id = get_the_ID();
                    if ($id == $option_id) {
                        $selected = "selected";
                    } else {
                        $selected = "";
                    }
                    echo '<option value="'.$id.'" '.$selected.'>'.get_the_title().'</option>';
                }
            ?>
        </select>
    <?php
}

function show_random_three_grade() {
    $ids = array(
        get_option('post_1'),
        get_option('post_2'),
        get_option('post_3')
    );
    foreach ($ids as $id) {
		$queryArr = array(
            'p' => $id,
		);
		$res = new wp_Query($queryArr);
		while($res->have_posts()) {
			show_post($res);
        }
    }
}