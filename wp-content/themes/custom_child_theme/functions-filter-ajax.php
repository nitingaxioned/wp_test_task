<?php

##########################
//	Tab Filters with Ajax
##########################

// hooks for filter ajax
add_action( 'wp_ajax_filter', 'filter_ajax' );
add_action( 'wp_ajax_nopriv_filter', 'filter_ajax' );

// callback for filter_ajax
function filter_ajax(){
	$cat_id = $_REQUEST['id'];
	$pg = $_REQUEST['pg'];
    $queryArr = array(
		'posts_per_page' => $_REQUEST['ppg'],
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
            get_template_part( 'content', 'none' );
            hideLoadBtn();
            die();
        }
        while($res->have_posts()) { 
            show_post($res);
        }
        haveMore($queryArr, $pg);
    } else {
        $queryArr['paged'] = $pg;
        $res = new wp_Query($queryArr);
        while($res->have_posts()) { 
            show_post($res);
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
    $expg = ceil($noOfPost/$_REQUEST['ppg']);
    ($pg == $expg) ? hideLoadBtn() : showLoadBtn();
}

function show_post($res) {
    $res->the_post(); 
    ?>
      <div class='flex-box'>
        <?php
            if( has_post_thumbnail() ) {
                echo '<img src="'.get_the_post_thumbnail_url().'" alt="thumbnail" width="20%">';
            } ?>
            <div class="data-txt">
                <?php if ( get_the_title() != null ) {?>
                    <h2><?php the_title(); ?></h2>
                    <span><?php echo get_the_date(); ?></span>
                <?php } 
                if ( the_excerpt() != null ) {
                    the_excerpt();
                }
                ?>
                <a title="Read More" href="<?php the_permalink(); ?>"><button class='btn'>Read More</button></a>
            </div>
      </div>
    <?php
} 