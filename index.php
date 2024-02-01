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

<?php
/**
 * Flexible Content
 */

$index = 1;
// loop over the ACF flexible fields of this page / post
if ( !is_archive() ) {
	while ( the_flexible_field( 'builder', get_option( 'page_for_posts' ) ) ) {
		// load the layout from sub folder
		get_template_part( 'template-parts/builder/' . get_row_layout(), null, [ 'index' => $index ] );
		$index ++;
	}
}  
?>


	<div class="archive-wrapper pt-0">
		<div class="container">

			<?php
			$categories = get_categories( array(
				'orderby' => 'name',
				'order'   => 'ASC'
			) ); ?>

			<?php if ( $categories ): ?>
				<ul class="blog_categories text-md">
					<li class="<?php echo ! is_front_page() && is_home() ? 'current-cat' : ''; ?>">
						<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>">
							<?php _e( 'All', '_it_start' ); ?>
						</a>
					</li>
					<?php wp_list_categories( array(
						'title_li' => ''
					) ); ?>
				</ul>


			<?php endif; ?>

			<?php if ( have_posts() ) : ?>

				<div class="row">
					<?php
					$i     = 1;
					$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
					while ( have_posts() ) : the_post(); ?>

						<div class="<?php echo $i == 1 && $paged == 1 ? 'col-lg-12' : 'col-lg-4'; ?>">
							<?php get_template_part( 'template-parts/article', null, [ 'item'  => $i,
																					   'paged' => $paged
							] ); ?>
						</div>

						<?php $i ++; endwhile; ?>
				</div>
				<!--				--><?php //get_template_part( 'template-parts/pagination' ); ?>
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

			<?php else: ?>

				<div class="row">
					<div class="col-lg-6">
						<?php get_template_part( 'template-parts/content-none' ); ?>
					</div>
				</div>

			<?php endif; ?>

		</div>
	</div>

<?php
get_footer();
