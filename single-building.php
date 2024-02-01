<?php
get_header();
the_post();
$connected_apartaments = get_field( 'connected_apartaments' );
$banner_image          = get_field( 'banner_image' );
//$link_to_wishlist      = get_field( 'link_to_wishlist' );

?>
	<div class="padding-top">

		<?php get_template_part( 'template-parts/breadcrumbs' ); ?>

		<section class="search_banner">
			<?php if ( $banner_image ) : ?>
				<div class="search_banner__mask mb-4">
					<div>
						<?php echo wp_get_attachment_image( $banner_image, 'full' ); ?>
					</div>
				</div>
			<?php endif; ?>
			<div class="container d-flex flex-column">
				<div class="text-lg text-center">
					<h1>
						<?php the_title(); ?>
					</h1>
				</div>

				<?php get_template_part( 'template-parts/builder/components/search_banner_form' ); ?>
			</div>
		</section>

		<section class="buildings_section portfolio_section">
			<div class="container">
				<!--				--><?php //if ( $link_to_wishlist ) : ?>
				<!--					<div class="text-right text-sm-left">-->
				<!--						<a href="-->
				<?php //echo esc_url( $link_to_wishlist['url'] ); ?><!--" class="wishlist_link"-->
				<!--						   target="-->
				<?php //echo esc_attr( $link_to_wishlist['target'] ); ?><!--">-->
				<!--							<svg width="34" height="30" viewBox="0 0 34 30" fill="none"-->
				<!--								 xmlns="http://www.w3.org/2000/svg">-->
				<!--								<path-->
				<!--									d="M30.4767 15.6926L17.1615 28.3821L3.84627 15.6926M3.84627 15.6926C2.96801 14.8703 2.27622 13.8818 1.81446 12.7895C1.35269 11.6973 1.13097 10.5248 1.16323 9.34605C1.1955 8.16727 1.48107 7.00768 2.00195 5.94032C2.52283 4.87295 3.26775 3.92093 4.18978 3.14419C5.11182 2.36746 6.191 1.78284 7.35938 1.42715C8.52776 1.07146 9.76002 0.952407 10.9786 1.07749C12.1971 1.20257 13.3755 1.56907 14.4396 2.15392C15.5037 2.73876 16.4305 3.52928 17.1615 4.4757C17.8957 3.53616 18.8235 2.75254 19.8869 2.1739C20.9502 1.59526 22.1263 1.23405 23.3414 1.11288C24.5565 0.99171 25.7846 1.11319 26.9487 1.4697C28.1128 1.82622 29.1878 2.41011 30.1066 3.18482C31.0254 3.95953 31.7682 4.9084 32.2883 5.97202C32.8085 7.03564 33.0949 8.19113 33.1297 9.36616C33.1644 10.5412 32.9467 11.7105 32.4902 12.8008C32.0337 13.8912 31.3483 14.8791 30.4767 15.7029"-->
				<!--									stroke="#F67282" stroke-width="1.5" stroke-linecap="round"-->
				<!--									stroke-linejoin="round"/>-->
				<!--							</svg>-->
				<!--							--><?php //echo esc_html( $link_to_wishlist['title'] ); ?>
				<!--						</a>-->
				<!--					</div>-->
				<!--				--><?php //endif; ?>

				<div class="row appartaments__grid"><?php if ( $connected_apartaments ) : ?>
						<?php foreach ( $connected_apartaments as $post ) : ?>
							<?php setup_postdata( $post ); ?>
							<div class="col-lg-4 col-md-6">
								<?php get_template_part( 'template-parts/builder/components/appartament_item' ); ?>
							</div>
						<?php endforeach; ?>
						<?php wp_reset_postdata(); ?>
					<?php endif; ?>
				</div>

			</div>
		</section>
	</div>

<?php
get_footer();
