<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _it_start
 */

get_header();
?>

<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

    <div class="archive-wrapper pt-0 tax-collections-archive-wrapper">

		<?php

		// get the query object
		$term             = get_queried_object();
		$term_id          = $term->term_id;
		$term_id_prefixed = 'collections' . '_' . $term_id;
		$image            = get_field( 'image', $term_id_prefixed );
		?>

        <section class="search_banner mb-5">
            <div class="container">
                <div class="text-lg text-center mb-5">
					<?php if ( $image ) : ?>
                        <div class="search_banner__mask mb-4">
                            <div>
								<?php echo wp_get_attachment_image( $image, 'full' ); ?>
                            </div>
                        </div>
					<?php endif; ?>
                    <h1 class="h3">
						<?php echo $term->name; ?>
                    </h1>
                </div>


				<?php get_template_part( 'template-parts/builder/components/search_banner_form' ); ?>
            </div>
        </section>


        <div class="container">

			<?php
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args  = array(
				'posts_per_page' => 12,
				'post_type'      => 'apartment',
				'paged'          => $paged,
				'post_status'    => 'publish',
				'tax_query'      => array(
					array(
						'taxonomy' => 'collections',
						'field'    => 'term_id',
						'terms'    => $term_id,
					),
				),
			);
			$query = new WP_Query( $args );
			if ( $query->have_posts() ): ?>
                <div class="row appartaments__grid tax_collection_grid" data-term="<?php echo $term_id; ?>">
					<?php
					$count = $query->post_count;
					while ( $query->have_posts() ): $query->the_post(); ?>
                        <div class="col-xl-3 col-lg-4 col-md-6">
							<?php get_template_part( 'template-parts/builder/components/new_appartament_item' ); ?>
                        </div>
					<?php endwhile; ?>
                </div>
				<?php
				wp_reset_postdata();
			else: ?>

                <div class="row">
                    <div class="col-12">
						<?php get_template_part( 'template-parts/content-none' ); ?>
                    </div>
                </div>
			<?php endif; ?>


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
    </div>

<?php
get_footer();
