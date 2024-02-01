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

<footer class="footer">
	<div class="container">
		<div class="footer__top">
			<?php if ($logo) : ?>
				<div class="footer__top--logo">
					<a href="<?php echo home_url(); ?>" class="site-logo" rel="home">
						<?php echo wp_get_attachment_image($logo, 'full'); ?>
					</a>
				</div>
			<?php endif; ?>

			<?php wp_nav_menu(array(
				'theme_location' => 'footer',
				'container_class' => 'footer-links__container',
				'menu_class' => 'footer-links',
				'fallback_cb' => false
			)); ?>

			<?php if (is_active_sidebar('footer-1')): ?>
				<aside class="footer__top--sidebar sidebar_1 widget-area">
					<?php dynamic_sidebar('footer-1'); ?>
				</aside>
			<?php endif; ?>
			<?php if (is_active_sidebar('footer-2')): ?>
				<aside class="footer__top--sidebar sidebar_2 widget-area visible-sm-up">
					<?php dynamic_sidebar('footer-2'); ?>
				</aside>
			<?php endif; ?>
			<?php if (is_active_sidebar('footer-3')): ?>
				<aside class="footer__top--sidebar sidebar_3 widget-area visible-sm-up">
					<?php dynamic_sidebar('footer-3'); ?>
				</aside>
			<?php endif; ?>


			<?php get_template_part('template-parts/socials'); ?>
		</div>
	</div>

	<div class="footer__copyright text-sm">
		<div class="container text-center">
			<span>
				&copy; <?php echo date('Y') ?>
				<?php the_field( 'copyright_text', 'option' ); ?>
			</span>
		</div>
	</div>
</footer>

<?php get_template_part('template-parts/svg'); ?>

<?php if (($enable_to_top && !is_404()) || is_single()) : ?>
	<a id="to-top" href="#top">
		<svg>
			<use xlink:href="#angle-up"></use>
		</svg>
	</a>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
