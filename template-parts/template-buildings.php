<?php /* Template Name: Buildings */

get_header();
the_post();
?>
	<div class="padding-top">

		<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

		<?php get_template_part( 'template-parts/builder/components/search_banner' ); ?>

		<section class="buildings_section">
			<div class="container">

				<form action="<?php echo esc_url( home_url() ); ?>" id="searchform" role="search"
					  class="buildings_search_form">
					<input type="text" id="s" name="s" placeholder="<?php _e( 'Search Building...', '_it_start' ); ?>">
					<button>
						<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path
								d="M8.83333 16.4167C13.0215 16.4167 16.4167 13.0215 16.4167 8.83333C16.4167 4.64517 13.0215 1.25 8.83333 1.25C4.64517 1.25 1.25 4.64517 1.25 8.83333C1.25 13.0215 4.64517 16.4167 8.83333 16.4167Z"
								stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							<path d="M20.75 20.75L14.25 14.25" stroke-width="1.5" stroke-linecap="round"
								  stroke-linejoin="round"/>
						</svg>
					</button>
					<input type="hidden" name="post_type" value="building"/>
				</form>

				<?php
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				$args  = array(
					'post_type'      => 'building',
					'posts_per_page' => 12,
					'order'          => 'ASC',
					'orderby'        => 'meta_value_num',
					'paged'          => $paged,
					'meta_query'     => array(
						'relation' => 'OR',
						array(
							'key'     => '_thumbnail_id',
							'compare' => 'EXISTS',
						),
						array(
							'key'     => '_thumbnail_id',
							'compare' => 'NOT EXISTS',
						),
					),
				);
				$query = new WP_Query( $args );
				$count = $query->post_count;

				?>
				<?php if ( $query->have_posts() ): ?>
					<div class="row buildings__grid ajax_buildings__grid">
						<?php while ( $query->have_posts() ): $query->the_post();
							get_template_part( 'template-parts/components/buildings_loop' );
						endwhile;

						wp_reset_postdata(); ?>
					</div>
				<?php endif; ?>

				<div class="pagination">
					<?php echo paginate_links( array(
						'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
						'total'        => $query->max_num_pages,
						'current'      => max( 1, get_query_var( 'paged' ) ),
						'format'       => '?paged=%#%',
						'show_all'     => false,
						'type'         => 'list',
						'end_size'     => 2,
						'mid_size'     => 1,
						'prev_next'    => true,
						'prev_text'    => __( 'Previous', '_it_start' ),
						'next_text'    => __( 'Next', '_it_start' ),
						'add_args'     => false,
						'add_fragment' => '',
					) ); ?>

				</div>

				<?php
//				if ( $count >= 6 ) {
//					$wrapper = 'text-center mt-5 pt-3 preloader_container';
//					$title   = __( 'Load more Buildings', '_it_start' );;
//					$class  = 'load-more-btn btn btn-outline btn-md';
//					$url    = "#";
//					$target = false;
//					get_template_part( 'template-parts/components/button', null, [
//						'classes' => $class,
//						'title'   => $title,
//						'url'     => $url,
//						'target'  => $target,
//						'wrapper' => $wrapper
//					] );
//				}
				?>
			</div>
		</section>
	</div>
<?php
get_footer();
