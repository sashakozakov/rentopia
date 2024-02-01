<?php
$classes = 'module_why_us';
$margin_top = get_sub_field('margin_top');
$margin_bottom = get_sub_field('margin_bottom');
$content = get_sub_field('content');

if ($margin_top) {
	$classes .= ' mt-' . $margin_top;
}
if ($margin_bottom) {
	$classes .= ' mb-' . $margin_bottom;
}
?>
<section class="<?php echo esc_attr($classes); ?>">
	<svg class="svg svg_6" width="449" height="387" viewBox="0 0 449 387" fill="none"
		 xmlns="http://www.w3.org/2000/svg">
		<use xlink:href="#svg_elem_6"></use>
	</svg>
	<div class="container d-flex flex-column">
		<?php if ($content) : ?>
			<div class="module_why_us--content text-lg">
				<?php echo $content; ?>
			</div>
		<?php endif; ?>

		<?php if (have_rows('blocks')) : ?>
			<div class="swiper justify-content-center module_why_us__slider">
				<div class="swiper-wrapper">
					<?php while (have_rows('blocks')) : the_row(); ?>
						<?php $image = get_sub_field('image'); ?>
						<?php $size = 'full'; ?>
						<div class="swiper-slide">
							<div class="block_item text-center text-sm-left">
								<?php if ($image) : ?>
									<div class="block_item--img d-flex align-items-center justify-content-center">
										<?php echo wp_get_attachment_image($image, $size); ?>
									</div>
								<?php endif; ?>
								<h4 class="block_item--title">
									<?php the_sub_field('title'); ?>
								</h4>
								<?php the_sub_field('content'); ?>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<div class="swiper-pagination hidden-lg-up"></div>
			</div>
		<?php endif; ?>
	</div>
</section>
