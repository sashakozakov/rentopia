<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package _it_start
 */

get_header();
the_post();
?>

<?php get_template_part('template-parts/breadcrumbs'); ?>

	<div class="single-post--conteiner container">

		<div class="single-post--meta text-center">
			<h1 class="single-post--title h2"><?php the_title(); ?></h1>
			<span class="single-post--author">
			<?php
			$author_id = get_the_author_meta('ID');
			$author_first_name = get_the_author_meta('first_name', $author_id);
			$author_last_name = get_the_author_meta('last_name', $author_id);


			echo __('Written by', '_it_start');
			echo " <strong>$author_first_name $author_last_name</strong>"
			?>
			</span>
			<span class="single-post--date text-uppercase"><?php the_date('M d Y'); ?></span>
		</div>


		<?php if (has_post_thumbnail()) : ?>
			<div class="single-post--thumbnail">
				<?php the_post_thumbnail(); ?>
			</div>
		<?php endif; ?>


		<div class="single-post--entry-content text-md">
			<?php the_content(); ?>
		</div>

		<!--		--><?php //get_template_part( 'template-parts/post-related' ); ?>
	</div>

<?php
get_footer();
