<?php
$classes = 'module_tiles_blocks';
$margin_top = get_sub_field('margin_top');
$margin_bottom = get_sub_field('margin_bottom');
$content = get_sub_field('top_content');

if ($margin_top) {
	$classes .= ' mt-' . $margin_top;
}
if ($margin_bottom) {
	$classes .= ' mb-' . $margin_bottom;
}
?>
<section class="<?php echo esc_attr($classes); ?>">

	<svg class="svg svg_9" width="373" height="455" viewBox="0 0 373 455" fill="none"
		 xmlns="http://www.w3.org/2000/svg">
		<use xlink:href="#svg_elem_9"></use>
	</svg>
	<svg class="svg svg_10" width="435" height="348" viewBox="0 0 435 348" fill="none"
		 xmlns="http://www.w3.org/2000/svg">
		<use xlink:href="#svg_elem_10"></use>
	</svg>
	<div class="container d-flex flex-column">

		<div class="module_tiles_blocks--content">
			<?php echo $content; ?>
		</div>

		<?php if (have_rows('tiles_blocks')) : ?>
			<div class="swiper tiles_blocks tiles_slider">
				<div class="swiper-wrapper">
					<?php while (have_rows('tiles_blocks')) : the_row(); ?>
						<?php $image = get_sub_field('image'); ?>
						<div class="swiper-slide tiles_blocks--item">
							<?php if ($image) : ?>
								<div class="tiles_blocks--img">
									<div>
										<?php echo wp_get_attachment_image($image, 'full'); ?>
									</div>
								</div>
							<?php endif; ?>
							<div class="content_block">
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
