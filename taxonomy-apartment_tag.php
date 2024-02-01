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
	<section class="content_module">
		<div class="container">
			<h1 class="h2 text-center">
				<?php echo get_the_archive_title(); ?>
			</h1>
		</div>
	</section>


	<section class="buildings_section portfolio_section">
		<div class="container">

			<?php if ( have_posts() ): ?>
				<div class="row appartaments__grid">
					<?php
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					while ( have_posts() ): the_post(); ?>
						<div class="col-lg-4 col-md-6">
							<?php get_template_part( 'template-parts/builder/components/appartament_item' ); ?>
						</div>
					<?php endwhile; ?>
				</div>
				<?php
				wp_reset_postdata();
			else: ?>

				<div class="row">
					<div class="col-lg-6">
						<?php get_template_part( 'template-parts/content-none' ); ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="pagination">
				<?php echo paginate_links( array(
					'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
					'total'        => $wp_query->max_num_pages,
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


		</div>
	</section>


<?php
get_footer();
