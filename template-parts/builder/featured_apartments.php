<?php
$margin_top          = get_sub_field( 'margin_top' );
$margin_bottom       = get_sub_field( 'margin_bottom' );
$classes             = 'featured_apartments_module';
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

	<?php if ( $featured_apartments ) : ?>
		<div class="features_slider">
			<div class="swiper-wrapper">
				<?php foreach ( $featured_apartments as $post ) : ?>
					<?php setup_postdata( $post ); ?>
					<div class="swiper-slide">
						<?php get_template_part( 'template-parts/builder/components/new_appartament_item' ); ?>
					</div>
				<?php endforeach; ?>
				<?php wp_reset_postdata(); ?>
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

