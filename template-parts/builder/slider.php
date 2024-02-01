<?php
$classes = 'module_slider';
$margin_top = get_sub_field('margin_top');
$margin_bottom = get_sub_field('margin_bottom');
$content = get_sub_field('content');
$categories = get_sub_field('categories');

if ($margin_top) {
	$classes .= ' mt-' . $margin_top;
}
if ($margin_bottom) {
	$classes .= ' mb-' . $margin_bottom;
}
?>
<section class="<?php echo esc_attr($classes); ?>">
	<svg class="svg_5" width="542" height="276" viewBox="0 0 542 276" fill="none" xmlns="http://www.w3.org/2000/svg">
		<use xlink:href="#svg_elem_5"></use>
	</svg>

	<?php if ($content): ?>
		<div class="container">
			<?php echo $content; ?>
		</div>
	<?php endif; ?>
	<div class="swiper swiper-images text-grey">
		<div class="swiper-wrapper">
			<?php if ($categories) : ?>
				<?php foreach ($categories as $term) :
					$taxonomy_prefix = 'neighborhood';
					$term_id = $term->term_id;
					$term_id_prefixed = $taxonomy_prefix . '_' . $term_id;
					$image_for_slider = get_field('image_for_slider', $term_id_prefixed);
					?>
					<div class="swiper-slide">
						<div class="d-flex flex-wrap align-items-center flex-column flex-lg-row slide_block">
							<?php if ($image_for_slider) : ?>
								<div class="slide_img">
									<?php echo wp_get_attachment_image($image_for_slider, null); ?>
								</div>
							<?php endif; ?>
							<div class="slide_content">
								<h4><?php echo esc_html($term->name); ?></h4>
								<p>
									<?php echo esc_html($term->description); ?>
								</p>
								<hr class="visible-sm-up">
								<div class="btn-group">
									<a href="<?php echo esc_url(get_term_link($term)); ?>" class="btn btn-md">
										<?php _e('apartments', '_it_start'); ?>
									</a>
									<a href="<?php echo home_url(); ?>/neighborhoods" class="btn btn-outline btn-md">
										<?php _e('ALL neighborhoods', '_it_start'); ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>

