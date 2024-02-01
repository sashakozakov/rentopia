<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package _it_start
 */

get_header();
$neighborhoods = $_GET['neighborhood'] ? $_GET['neighborhood'] : null;
$bedrooms      = $_GET['bedrooms'] ? $_GET['bedrooms'] : null;
$price         = $_GET['price'] ? $_GET['price'] : null;
$filtersearch  = $_GET['filtersearch'] ? $_GET['filtersearch'] : null;
//$building_page = $_GET['post_type'] ? $_GET['post_type'] : null;

?>
<?php if ( have_rows( 'search_results_page', 'option' ) ) : ?>
	<?php while ( have_rows( 'search_results_page', 'option' ) ) : the_row();
		$show_breadcrumbs = get_sub_field( 'show_breadcrumbs' );
		$show_search_form = get_sub_field( 'show_search_form' );
		$background       = get_sub_field( 'background' );
		?>
		<section class="hero_section bg d-flex flex-wrap"
				 style="background-image: url(<?php echo wp_get_attachment_image_url( $background, 'full' ); ?>)">
			<svg width="1728" height="204" viewBox="0 0 1728 204" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path
					d="M829.641 171C504.971 172.145 0 112.5 0 112.5V204H1728V0C1728 0 1672.71 37.0014 1630.69 57C1571.77 85.0433 1535.98 95.498 1472.69 112.5C1388.62 135.082 1339.31 141.12 1253.86 151.586L1250.48 152C1087.05 172.02 994.303 170.419 829.641 171Z"
					fill="white"/>
			</svg>

			<div class="container">
				<?php if ( $show_breadcrumbs ): ?>
					<?php get_template_part( 'template-parts/breadcrumbs' ); ?>
				<?php endif; ?>
				<div class="editor color-white">
					<h1 class="page-title h3">
						<?php if ( $filtersearch ): ?>
							<?php echo esc_html__( 'Search Results', '_it_start' ); ?>
						<?php else: ?>
							<?php printf( esc_html__( 'Search Results for: %s', '_it_start' ), '<strong>' . get_search_query() . '</strong>' ); ?>
						<?php endif; ?>
					</h1>
				</div>
				<?php if ( $show_search_form ): ?>
					<?php if ( $filtersearch ): ?>
						<?php get_template_part( 'template-parts/builder/components/search_banner_form', null, [ 'neighborhoods' => $neighborhoods ] ); ?>
					<?php else: ?>
						<form class="search_banner__form" id="searchform" role="search"
							  action="<?php echo esc_url( home_url() ); ?>">
							<input class="search_banner__form--input" id="s" name="s" type="text"
								   value="<?php printf( esc_html__( '%s', '_it_start' ), get_search_query() ); ?>"
								   placeholder="" required/>
							<button type="submit">
								<svg width="26" height="26" viewBox="0 0 26 26" fill="none"
									 xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_1_3485)">
										<path
											d="M10.8333 18.4167C15.0215 18.4167 18.4167 15.0215 18.4167 10.8333C18.4167 6.64517 15.0215 3.25 10.8333 3.25C6.64517 3.25 3.25 6.64517 3.25 10.8333C3.25 15.0215 6.64517 18.4167 10.8333 18.4167Z"
											stroke="#2A2F38" stroke-width="1.5" stroke-linecap="round"
											stroke-linejoin="round"/>
										<path d="M22.75 22.75L16.25 16.25" stroke="#2A2F38" stroke-width="1.5"
											  stroke-linecap="round" stroke-linejoin="round"/>
									</g>
									<defs>
										<clipPath id="clip0_1_3485">
											<rect width="26" height="26" fill="white"/>
										</clipPath>
									</defs>
								</svg>
							</button>
							<input type="hidden" name="post_type" value="post"/>
						</form>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</section>
	<?php endwhile; ?>
<?php endif; ?>

	<div class="archive-wrapper">
	<div class="container">


		<?php

		if ( $bedrooms ) {
			$bedrooms = array_map( function ( $bedroom ) {
				return str_replace( '_bedroom', '', $bedroom );
			}, $bedrooms );
		}
		if ( $price ) {
			$prices = explode( '-', $price );
		}
		?>

<!--		--><?php //if ( $building_page == 'building' ): ?>
<!--		<div class="row buildings__grid ajax_buildings__grid">-->
<!--			--><?php //else: ?>
			<div class="row">
<!--				--><?php //endif; ?>


				<?php
				$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
				$args  = array(
					'posts_per_page' => 9,
					'order'          => 'DESC',
					'paged'          => $paged,
				);

				if ( $filtersearch ) {
//					if ($neighborhoods || $bedrooms || $price) {
//						$args['post_type'] = array('apartment', 'building');
//					} else {
//						$args['post_type'] = 'apartment';
//					}
					$args['post_type'] = 'apartment';
				}
//				elseif ( $building_page == 'building' ) {
//					$args['post_type'] = 'building';
//					$args['posts_per_page'] = '10';
//				}
				else {
					$args['post_type'] = 'post';
				}

				if ( $neighborhoods ) {
					$args['tax_query'] = array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'neighborhood',
							'field'    => 'slug',
							'terms'    => $neighborhoods,
//							'include_children' => true,
							'operator' => 'IN'
						),
					);
				}

				if ( $bedrooms && $price ) {
					$args['meta_query'] = array(
						'relation' => 'AND',
						array(
							'key'      => 'bedrooms',
							'value'    => $bedrooms,
							'operator' => 'IN'
						),
						array(
							'key'     => 'price',
							'value'   => $prices,
							'type'    => 'numeric',
							'compare' => 'BETWEEN'
						),
					);
				} elseif ( $bedrooms ) {

					$args['meta_query'] = array(
						'relation' => 'AND',
						array(
							'key'      => 'bedrooms',
							'value'    => $bedrooms,
							'operator' => 'IN'
						),
					);
				} elseif ( $price ) {
					$args['meta_query'] = array(
						'relation' => 'AND',
						array(
							'key'     => 'price',
							'value'   => $prices,
							'type'    => 'numeric',
							'compare' => 'BETWEEN'
						),
					);
				}

				$search_posts = new WP_Query( $args );
				if ( $search_posts->have_posts() ) : ?>

					<?php while ( $search_posts->have_posts() ) : $search_posts->the_post(); ?>

<!--						--><?php //if ( $building_page == 'building' ): ?>
<!--							--><?php //get_template_part( 'template-parts/components/buildings_loop' ); ?>
<!--						--><?php //else: ?>
							<div class="col-md-6 col-lg-4">
								<?php if ( $filtersearch ): ?>
									<?php get_template_part( 'template-parts/builder/components/appartament_item' ); ?>
								<?php else: ?>
									<?php get_template_part( 'template-parts/article' ); ?>
								<?php endif; ?>
							</div>
<!--						--><?php //endif; ?>

					<?php endwhile; ?>

					<div class="pagination">
						<?php echo paginate_links( array(
							'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
							'total'        => $search_posts->max_num_pages,
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

				<?php else : ?>

					<div class="col-lg-6">
						<?php get_template_part( 'template-parts/content-none' ); ?>
					</div>

				<?php endif; ?>
			</div>

		</div>
	</div>

<?php
get_footer();
