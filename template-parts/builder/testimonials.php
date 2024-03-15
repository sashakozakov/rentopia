<?php
$margin_top          = get_sub_field( 'margin_top' );
$margin_bottom       = get_sub_field( 'margin_bottom' );
$classes             = 'testimonials_module';
$title               = get_sub_field( 'title' );
$link                = get_sub_field( 'link' );
$featured_apartments = get_sub_field( 'featured_apartments' );

$classes .= $margin_top ? ' mt-' . $margin_top : '';
$classes .= $margin_bottom ? ' mb-' . $margin_bottom : '';
?>
<section class="<?php echo esc_attr( $classes ); ?>">
	<div class="container">
		<div class="featured_apartments_module--header">
			<?php if ( $title ): ?>
				<h3 class="text-center featured_apartments_module--title">
					<?php echo $title; ?>
				</h3>
			<?php endif; ?>
			<?php if ( $link ) : ?>
				<a href="<?php echo esc_url( $link['url'] ); ?>" class="featured_apartments_module--link visible-lg-up"
				   target="<?php echo esc_attr( $link['target'] ); ?>"><?php echo esc_html( $link['title'] ); ?></a>
			<?php endif; ?>
		</div>
	</div>

	<?php if ( have_rows( 'testimonials' ) ) : ?>
		<div class="testimonials_slider">
			<div class="swiper-wrapper">
				<?php while ( have_rows( 'testimonials' ) ) : the_row();
					$image = get_sub_field( 'image' );
					$stars = get_sub_field( 'stars' );
					$name  = get_sub_field( 'name' );
					$text  = get_sub_field( 'text' );
					?>
					<div class="swiper-slide">
						<div class="testimonials_slider__slide">
							<?php if ( $image ) : ?>
								<div class="testimonials_slider__slide--img">
									<img src="<?php echo esc_url( $image['url'] ); ?>"
										 alt="<?php echo esc_attr( $image['alt'] ); ?>"/>
								</div>
							<?php endif; ?>
							<div class="testimonials_slider__slide--content">
								<div class="stars">
									<?php for ($i = 1; $i <= $stars; $i++){ ?>
										<svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M10.5943 14.0545C10.4315 14.0545 10.2694 14.0045 10.13 13.905L6.85144 11.5538L3.57287 13.905C3.43704 14.0027 3.2738 14.055 3.10646 14.0544C2.93912 14.0539 2.77625 14.0004 2.64109 13.9018C2.50581 13.8037 2.40491 13.6654 2.35274 13.5067C2.30057 13.3479 2.29979 13.1768 2.35052 13.0175L3.57328 9.07117L0.324135 6.78161C0.189478 6.68224 0.0894749 6.54304 0.0382694 6.38371C-0.0129361 6.22438 -0.0127515 6.05298 0.0387971 5.89376C0.0907523 5.73493 0.19131 5.59644 0.326258 5.49787C0.461207 5.3993 0.62372 5.34563 0.790831 5.34445L4.81498 5.3384L6.09618 1.48997C6.14905 1.33143 6.25046 1.19355 6.38604 1.09584C6.52163 0.998133 6.68451 0.945557 6.85164 0.945557C7.01876 0.945557 7.18165 0.998133 7.31723 1.09584C7.45281 1.19355 7.55422 1.33143 7.6071 1.48997L8.86653 5.3384L12.9112 5.34445C13.0785 5.34539 13.2413 5.39903 13.3764 5.49775C13.5115 5.59647 13.612 5.73525 13.6637 5.89437C13.7154 6.05349 13.7157 6.22485 13.6645 6.38413C13.6132 6.5434 13.5131 6.68249 13.3783 6.78161L10.1292 9.07117L11.352 13.0175C11.4028 13.1767 11.4021 13.3479 11.35 13.5066C11.2979 13.6654 11.197 13.8037 11.0618 13.9018C10.9262 14.0012 10.7624 14.0547 10.5943 14.0545Z" fill="#B8C83F"/>
										</svg>
									<?php } ?>
								</div>
								<?php if ( $name ): ?>
									<h6>
										<?php echo $name; ?>
									</h6>
								<?php endif; ?>
								<?php if ( $text ): ?>
									<p>
										<?php echo $text; ?>
									</p>
								<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
			<div class="swiper-pagination new_pagination_style"></div>
		</div>
	<?php endif; ?>

	<?php if ( $link ) : ?>
		<div class="container text-center mt-4 hidden-lg-up">
			<a href="<?php echo esc_url( $link['url'] ); ?>" class="featured_apartments_module--link"
			   target="<?php echo esc_attr( $link['target'] ); ?>"><?php echo esc_html( $link['title'] ); ?></a>
		</div>
	<?php endif; ?>

</section>
