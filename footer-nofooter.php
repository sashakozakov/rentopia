<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _it_start
 */
$logo = get_field('footer_logo', 'option');
$enable_to_top = get_field('enable_to_top', 'option');
?>

</main><!-- /.site-content -->

<?php get_template_part('template-parts/svg'); ?>


<?php wp_footer(); ?>

</body>
</html>
