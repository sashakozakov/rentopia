<?php
/**
 * The template for displaying home page
 *
 * @package _it_start
 */

get_header();
?>


<?php if (have_rows('builder')) : ?>

	<?php get_template_part('template-parts/builder'); ?>

<?php endif; ?>



<?php
get_footer();
