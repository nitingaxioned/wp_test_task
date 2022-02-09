<?php  
  get_header(); 
  the_post();
  has_post_thumbnail() && ($img_url = get_the_post_thumbnail_url());
  $title = get_the_title();
  $date = get_the_date();
  $excerpt = get_excerpt_50(get_the_excerpt());
  $link = get_the_permalink();
  $disc = get_field('disc');
  $tagline = get_field('tagline');
  $rd1 = get_field('set_random_recommended_grade_1');
  $rd2 = get_field('set_random_recommended_grade_2');
  $rd3 = get_field('set_random_recommended_grade_3');
  $cid = get_the_ID();
 ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php
			if ( $title != null ) {?>
				<h2><?php echo $title; ?></h2>
			<?php } 
			if ( $date != null ) {?>
				<span><?php echo $date; ?></span>
			<?php } 
			if ( $excerpt != null ) {?>
				<p><?php echo $excerpt; ?></p>
			<?php } 
			if( has_post_thumbnail() ) {?>
			<div class="img-box">
				<img src="<?php echo $img_url ?>" alt="thumbnail">
			</div>
			<?php
            }
			if ( $disc != null ) {?>
				<p><?php echo $disc; ?></p>
			<?php } 
			if ( $tagline != null ) {?>
				<h4><?php echo $tagline; ?></h4>
			<?php } 
		?>
		<ul class="lists" >
			<?php
				$queryArr = array(
        		'post_type' => 'grade',
				);
				$res = new wp_Query($queryArr);
				$n = $res->post_count;
				$post = 1;
				for ($x = 0; $x < $n; $x++) {
					$id = $res->posts[$x]->ID;
					if(($id == $rd1 || $id == $rd2 || $id == $rd3) && $id != $cid) {
						showpost($res->posts[$x]);
						$post++;
					}
				} 
				if( $post < 3) {
					for ($x = 0; $x < $n; $x++) {
						$id = $res->posts[$x]->ID;
						if($id != $rd1 && $id != $rd2 && $id != $rd3 && $id != $cid && $post <= 3) {
							showpost($res->posts[$x]);
							$post++;
						}
					} 
				}
			?>
		</ul>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();