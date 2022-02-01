<?php  
  get_header(); 
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
		while ( have_posts() ) :
			the_post();
			if ( get_the_title() != null ) {?>
				<h1><?php the_title(); ?></h1>
				<span><?php the_date(); ?></span>
			<?php } 
			if ( the_excerpt() != null ) {
				the_excerpt();
			}
			if( has_post_thumbnail() ) {
                echo '<img src="'.get_the_post_thumbnail_url().'" alt="thumbnail" width="50%">';
            }
			if(get_field('disc') != null) {
				echo "<p>".get_field('disc')."</p>"; 
			}
			if(get_field('btn_for_redirect') != null) {
				$data = get_field('btn_for_redirect');
				echo "<a class='btn' target='".$data['target']."' href='".$data['url']."' title='Get Started'>".$data['title']."</a>";
			}
			if(get_field('tagline') != null) {
				echo "<h4>".get_field('tagline')."</h4>"; 
			}
		endwhile; // End of the loop.
		show_random_three_grade();
		?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();