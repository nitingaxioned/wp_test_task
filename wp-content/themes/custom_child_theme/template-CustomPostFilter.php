<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: CustomPostFilter
 *
 * @package storefront
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php

			while ( have_posts() ) :
				the_post();

				do_action( 'storefront_page_before' );

				get_template_part( 'content', 'page' );
				
				$temp = get_field('filter_cat');
				?>
				<select name="cat" class='cat'>
				<option value="all">All</option>
				<?php
					foreach($temp as $val){
						$tab_name = get_term($val, '', 'ARRAY_A')['name'];
						?>
						<option value="<?php echo $val; ?>"><?php echo $tab_name; ?></option>
						<?php
					}
				?>
				</select>
				<?php
			endwhile; // End of the loop.
			?>
		</main><!-- #main -->
		<div class='filter-box'>Loading.. </div>
		<button class='btn load_more'>Load More</button>
	</div><!-- #primary -->
<?php
get_footer();
?>
<script>
	let pg=1;
	let id=<?php echo $temp[0]; ?>;
	let ppg=<?php echo get_field('post_per_click'); ?>;
	jQuery('.load_more').hide();
	jQuery('.cat').on('change',function() {
		pg = 1;
		id = this.value;
		callAjax( id );
	});

	function callAjax(id) {
		jQuery('.load_more').hide();
		(pg == 1) && jQuery('.filter-box').html("<p>Loading....</p>");
		(pg != 1) && jQuery('.filter-box').append("<p>Loading....</p>");
		let wp_url = "<?php echo admin_url('admin-ajax.php'); ?>";
		let filter_data = new FormData;
		filter_data.append('action','filter');
		filter_data.append('id',id);
		filter_data.append('pg',pg);
		filter_data.append('ppg',ppg);
		jQuery.ajax({
			url : wp_url,
			data : filter_data,
			processData : false,
			contentType : false,
			type : 'post',
			success : function(data) {
				if (pg == 1) {
					jQuery('.filter-box').html(data);
				} else {
					jQuery('.filter-box').children().last().remove();
					jQuery('.filter-box').append(data);
				}
			},
			error : function(errorThrown){
				alert('Something went wrong !!! ');
			}
		});
	}
	callAjax("all");

	jQuery('.load_more').on('click',function() {
		pg++;
		callAjax( id );
	});
</script>