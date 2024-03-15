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
$logo              = get_field( 'footer_logo', 'option' );
$footer_form_title = get_field( 'footer_form_title', 'option' );
$footer_form       = get_field( 'footer_form', 'option' );
$phone             = get_field( 'phone', 'option' );
$email             = get_field( 'email', 'option' );
$address           = get_field( 'address', 'option' );
$enable_to_top     = get_field( 'enable_to_top', 'option' );
?>

</main><!-- /.site-content -->

<footer class="new_footer">
	<div class="container">

		<div class="row flex-md-row-reverse">
			<?php if ( $footer_form ) : ?>
				<div class="col-md-6 offset-lg-1 new_footer__right">
					<?php if ( $footer_form_title ): ?>
						<h3>
							<?php echo $footer_form_title; ?>
						</h3>
					<?php endif; ?>
					<?php echo do_shortcode( '[contact-form-7 id="' . $footer_form . '" title="Footer Form"]' ); ?>
				</div>
			<?php endif; ?>
			<div class="col-lg-5 col-md-6 new_footer__left">
				<div class="new_footer__copyright text-sm text-center">
					<span>
						&copy; <?php echo date( 'Y' ) ?>
						<?php the_field( 'copyright_text', 'option' ); ?>
					</span>
				</div>
				<div class="new_footer__left--bottom">
					<div class="inner_block">
						<?php if ( $logo ) : ?>
							<div class="new_footer__logo">
								<a href="<?php echo home_url(); ?>" class="site-logo" rel="home">
									<?php echo wp_get_attachment_image( $logo, 'full' ); ?>
								</a>
							</div>
						<?php endif; ?>

						<?php if ( $phone ): ?>
							<table>
								<?php if ( $phone ): ?>
									<tr>
										<td><?php _e( 'Phone', '_it_start' ); ?></td>
										<td>
											<a href="tel:<?php echo it_phone_cleaner($phone); ?>">
												<?php echo $phone; ?>
											</a>
										</td>
									</tr>
								<?php endif; ?>
								<?php if ( $email ): ?>
									<tr>
										<td><?php _e( 'Email', '_it_start' ); ?></td>
										<td>
											<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
										</td>
									</tr>
								<?php endif; ?>
								<?php if ( $address ): ?>
									<tr>
										<td><?php _e( 'Address', '_it_start' ); ?></td>
										<td><?php echo $address; ?></td>
									</tr>
								<?php endif; ?>
							</table>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>


	</div>

</footer>

<?php get_template_part( 'template-parts/svg' ); ?>

<?php if ( ( $enable_to_top && ! is_404() ) || is_single() ) : ?>
	<a id="to-top" href="#top">
		<svg>
			<use xlink:href="#angle-up"></use>
		</svg>
	</a>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
