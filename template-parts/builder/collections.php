<?php
$classes = 'module_collections';
$margin_top = get_sub_field('margin_top');
$margin_bottom = get_sub_field('margin_bottom');
$content = get_sub_field('content');
$bottom_link = get_sub_field('bottom_link');

if ($margin_top) {
	$classes .= ' mt-' . $margin_top;
}
if ($margin_bottom) {
	$classes .= ' mb-' . $margin_bottom;
}
?>
<section class="<?php echo esc_attr($classes); ?>">
	<svg class="svg_3" width="437" height="374" viewBox="0 0 437 374" fill="none" xmlns="http://www.w3.org/2000/svg">
		<use xlink:href="#svg_elem_3"></use>
	</svg>

	<svg class="svg_4 visible-md-up" width="901" height="394" viewBox="0 0 901 394" fill="none" xmlns="http://www.w3.org/2000/svg">
		<use xlink:href="#svg_elem_4"></use>
	</svg>

	<div class="container d-flex flex-column module_collections--container">
		<div class="module_collections--content">
			<?php echo $content; ?>
		</div>

		<?php if (have_rows('collections')) : ?>
			<div class="swiper module_collections__grid module_collections__slider row justify-content-center">
				<div class="swiper-wrapper">
					<?php while (have_rows('collections')) : the_row(); ?>
						<?php $icon = get_sub_field('icon'); ?>
						<?php $image = get_sub_field('image'); ?>

						<div class="swiper-slide module_collections__grid--item">
							<div class="inner_block">
								<div class="inner_block--img">
									<?php echo wp_get_attachment_image($image, 'full'); ?>
								</div>
								<div class="caption">
									<?php if ($icon) : ?>
										<div class="caption__icon">
											<?php echo wp_get_attachment_image($icon, 'full'); ?>
										</div>
									<?php endif; ?>
									<h4>
										<?php the_sub_field('title'); ?>
									</h4>
									<?php the_sub_field('caption'); ?>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<div class="swiper-pagination hidden-lg-up"></div>
			</div>
		<?php endif; ?>

		<?php if ($bottom_link) : ?>
			<div class="text-right mt-2">
				<a href="<?php echo esc_url($bottom_link['url']); ?>" class="show_more"
				   target="<?php echo esc_attr($bottom_link['target']); ?>"><?php echo esc_html($bottom_link['title']); ?></a>
			</div>
		<?php endif; ?>
	</div>
</section>

