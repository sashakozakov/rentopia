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
if ( ! is_archive() ) {
	while ( the_flexible_field( 'builder', get_option( 'page_for_posts' ) ) ) {
		// load the layout from sub folder
		get_template_part( 'template-parts/builder/' . get_row_layout(), null, [ 'index' => $index ] );
		$index ++;
	}
}
?>


    <div class="archive-wrapper blog-archive-wrapper pt-0">
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

			<?php
			$categories  = get_the_category();
			$category_id = $categories[0]->cat_ID;
			$paged       = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args        = array(
				'post_type'      => 'post',
				'posts_per_page' => 4,
				'order'          => 'DESC',
				'post_status'    => 'publish',
				'paged'          => $paged,
			);
			if ( is_category() ) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'id',
						'terms'    => $category_id
					),
				);
			}
			$query = new WP_Query( $args );
			if ( $query->have_posts() ) : ?>

                <div class="row ajax_blog__grid" data-term="<?php echo $category_id; ?>">
					<?php
					$i     = 1;
					$count = $query->post_count;
					while ( $query->have_posts() ) : $query->the_post(); ?>
						<?php get_template_part( 'template-parts/article', null, [
							'item'  => $i,
							'paged' => $paged
						] ); ?>
						<?php $i ++; endwhile; ?>
                </div>

				<?php
				if ( $count >= 4 ) {
					$wrapper = 'text-center mt-5 pt-3 preloader_container';
					$title   = __( 'Load more', 'rentopia' );;
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

			<?php else: ?>

                <div class="row">
                    <div class="col-12 text-center">
						<?php get_template_part( 'template-parts/content-none' ); ?>
                    </div>
                </div>

			<?php endif; ?>

        </div>
    </div>

<?php
get_footer();
