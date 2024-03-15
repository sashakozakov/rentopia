<?php
get_header();
the_post();
$banner_image = get_field( 'banner_image' );
//$connected_apartaments = get_field( 'connected_apartaments' );
//$link_to_wishlist      = get_field( 'link_to_wishlist' );

?>
	<div class="padding-top">

		<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

		<section class="search_banner">
			<?php if ( $banner_image ) : ?>
				<div class="search_banner__mask mb-4">
					<div>
						<?php echo wp_get_attachment_image( $banner_image, 'full' ); ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="container d-flex flex-column">
				<div class="text-lg text-center">
					<h1>
						<?php the_title(); ?>
					</h1>
				</div>

				<?php get_template_part( 'template-parts/builder/components/search_banner_form' ); ?>
			</div>
		</section>

		<section class="buildings_section portfolio_section pb-5">
			<div class="container">
				<?php /*
				Not Actual code
				<?php if ( $connected_apartaments ) : ?>
					<div class="row appartaments__grid">
						<?php foreach ( $connected_apartaments as $post ) : ?>
							<?php setup_postdata( $post ); ?>
							<div class="col-lg-4 col-md-6">
								<?php get_template_part( 'template-parts/builder/components/appartament_item' ); ?>
							</div>
						<?php endforeach; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				<?php endif; ?>
 */ ?>


				<div class="row appartaments__grid" data-pageID="<?php echo get_the_ID(); ?>">
					<?php
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					$args  = array(
						'post_type'      => 'apartment',
						'orderby'        => 'DESC',
						'posts_per_page' => 12,
						'paged'          => $paged,
						'meta_query'     => array(
							'relation' => 'AND',
							array(
								'key'     => 'connected_building',
								'value'   => get_the_id(),
								'compare' => 'IN'
							),
						),
					);
					$query = new WP_Query( $args );
					$count = $query->post_count;
					?>
					<?php if ( $query->have_posts() ): ?>
						<?php while ( $query->have_posts() ): $query->the_post(); ?>
							<div class="col-xl-3 col-lg-4 col-md-6">
								<?php get_template_part( 'template-parts/builder/components/new_appartament_item' ); ?>
							</div>
						<?php endwhile; ?>
					<?php endif;
					wp_reset_postdata(); ?>
				</div>

				<?php
				if ( $count >= 12 ) {
					$wrapper = 'text-center mt-5 pt-3 preloader_container';
					$title   = __( 'Load more Buildings', 'rentopia' );;
					$class  = 'load-more-btn btn btn-outline btn-md';
					$url    = "#";
					$target = false;
					get_template_part( 'template-parts/components/button', null, [
						'classes' => $class,
						'title'   => $title,
						'url'     => $url,
						'target'  => $target,
						'wrapper' => $wrapper
					] );
				}
				?>

			</div>
		</section>
	</div>

<?php if ( have_rows( 'builder' ) ) : ?>

	<?php get_template_part( 'template-parts/builder' ); ?>

<?php endif; ?>

<?php
get_footer();
