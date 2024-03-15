<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package _it_start
 */

get_header();
the_post();
?>


<?php if ( have_rows( 'builder' ) ) : ?>

	<?php get_template_part( 'template-parts/builder' ); ?>

<?php else:

$the_content     = apply_filters( 'the_content', get_the_content() );
$hide_page_title = get_field( 'hide_page_title' );
?>

<?php if ( ! empty( $the_content ) ) { ?>
	<div class="container pt-5 mt-5">
		<div class="row justify-content-center pt-5">
			<div class="col-lg-9">
				<?php if ( $hide_page_title != 1 ): ?>
					<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php endif; ?>
				<section class="entry-content">
					<?php the_content(); ?>
				</section>
			</div>
		</div>
	</div>
<?php } ?>
<?php endif; ?>


<?php
get_footer();
