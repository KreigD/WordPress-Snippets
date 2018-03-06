<?php

/**
* An example of how I set up AJAX post filtering and AJAX load-on-scroll functionality in a real-world project
*/

// Setup AJAX for filter posts by category and for load more button
function ajax_filter_posts_scripts() {
	// Enqueue script
	wp_register_script('afp_script', get_stylesheet_directory_uri() . '/js/ajax-filter-posts.js', false, null, false);
	wp_enqueue_script('afp_script');

  // You have to localize your JS in order to tie into WordPress's AJAX
	global $wp_query;
	wp_localize_script( 'afp_script', 'afp_vars', array(
				'afp_ajax_url' => admin_url( 'admin-ajax.php' ),
				'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
			)
	);
}
add_action('wp_enqueue_scripts', 'ajax_filter_posts_scripts', 100);

// AJAX filter posts by category
function prefix_load_cat_posts () {

    // Get the selected category/categories
		$cat_id = $_POST['category__in'];

			$args = array (
				'post_type' => 'post',
				'post_status' => 'publish',
				'category__in' => $cat_id,
				'posts_per_page' => 9,
				'orderby' => 'date',
				'order' => 'DESC',
			);

		$filter_posts = new WP_Query($args);
		ob_start ();

		if ( $filter_posts->have_posts() ) : while ( $filter_posts->have_posts() ) : $filter_posts->the_post(); ?>

      <!-- This it the HTML we wish to return after the user selects a category -->
			<article class="article-card">
				<header class="card-header">
					<div class="card-img" style="background: url('<?php echo the_post_thumbnail_url( 'small' ); ?>') no-repeat center center; width: 100%; background-size: cover;"></div>
					<a href="<?php the_permalink(); ?>" class="article-title"><?php the_title( "<h4>", "</h4>" ) ?></a>
					<p class="article-author">By
						<?php the_author(); ?>
					</p>
				</header>
				<div class="card-content">
					<p>
						<?php echo wp_trim_words(get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true), 15, '...'); ?>
					</p>
				</div>
				<footer class="card-footer">
					<a href="<?php the_permalink(); ?>" class="btn btn-article" role="button">Read Now</a>
				</footer>
			</article>

			<?php
				endwhile; endif;

		wp_reset_postdata();

	$response = ob_get_contents();
	ob_end_clean();

	echo $response;

	die(1);
}
add_action( 'wp_ajax_nopriv_load-filter', 'prefix_load_cat_posts' );
add_action( 'wp_ajax_load-filter', 'prefix_load_cat_posts' );

// AJAX Load More
function afp_load_more() {
	$cat_id = $_POST['category__in'];
	if (empty($cat_id)) {
		$cat_id = array(3, 4, 28, 35, 353);
  }

  // I seet the args differently here mostly because of how many AJAX request paramaters I was pulling in.
	$args = isset( $_POST['query'] ) ? array_map( 'esc_attr', $_POST['query'] ) : array();
	$args['post_type'] = isset( $args['post_type'] ) ? esc_attr( $args['post_type'] ) : 'post';
	$args['paged'] = esc_attr( $_POST['page'] );
	$args['post_status'] = 'publish';
	$args['category__in'] = $cat_id;
	$args['order'] = 'DESC';
	$args['orderby'] = 'date';
	$args['offset'] = esc_attr( $_POST['offset'] );
	$args['posts_per_page'] = 9;
	ob_start();
	$loop = new WP_Query( $args );
	if( $loop->have_posts() ): while( $loop->have_posts() ): $loop->the_post();
	?>

	<article class="article-card">
		<header class="card-header">
			<div class="card-img" style="background: url('<?php echo the_post_thumbnail_url( 'small' ); ?>') no-repeat center center; width: 100%; background-size: cover;"></div>
			<a href="<?php the_permalink(); ?>" class="article-title"><?php the_title( "<h4>", "</h4>" ) ?></a>
			<p class="article-author">By
				<?php the_author(); ?>
			</p>
		</header>
		<div class="card-content">
			<p>
				<?php echo wp_trim_words(get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true), 15, '...'); ?>
			</p>
		</div>
		<footer class="card-footer">
			<a href="<?php the_permalink(); ?>" class="btn btn-article" role="button">Read Now</a>
		</footer>
	</article>

	<?php
	endwhile; endif; wp_reset_postdata();
	$res = ob_get_contents();
	ob_end_clean();

	echo $res;
	wp_die();
}
add_action( 'wp_ajax_afp_load_more', 'afp_load_more' );
add_action( 'wp_ajax_nopriv_afp_load_more', 'afp_load_more' );