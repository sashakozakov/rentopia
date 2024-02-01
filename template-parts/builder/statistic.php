<?php
$classes = 'module_statistic';
$margin_top = get_sub_field('margin_top');
$margin_bottom = get_sub_field('margin_bottom');
$content = get_sub_field('top_content');
$content_width = get_sub_field('content_width');

if ($margin_top) {
	$classes .= ' mt-' . $margin_top;
}
if ($margin_bottom) {
	$classes .= ' mb-' . $margin_bottom;
}
?>
<section class="<?php echo esc_attr($classes); ?>">
	<svg class="svg_1 visible-sm-up" width="639" height="332" viewBox="0 0 639 332" fill="none" xmlns="http://www.w3.org/2000/svg">
		<use xlink:href="#svg_elem_1"></use>
	</svg>

	<svg class="svg_2 visible-sm-up" width="688" height="370" viewBox="0 0 688 370" fill="none" xmlns="http://www.w3.org/2000/svg">
		<use xlink:href="#svg_elem_2"></use>
	</svg>

	<div class="container d-flex flex-column">
		<?php if ($content) : ?>
			<div class="row justify-content-center">
				<div class="<?php echo $content_width; ?>">
					<div class="module_statistic__content">
						<?php echo $content; ?>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if (have_rows('numbers')) : ?>
			<div class="module_statistic__numbers">
				<div class="row">
					<?php while (have_rows('numbers')) : the_row();
						$icon = get_sub_field('icon');
						?>
						<div class="col-sm-6 col-lg-3 text-center">
							<?php if ($icon) : ?>
								<div
									class="module_statistic__numbers--icon d-flex align-items-center justify-content-center">
									<?php echo wp_get_attachment_image($icon, 'full'); ?>
								</div>
							<?php endif; ?>
							<span class="d-block h3 mb-0">
							<?php the_sub_field('text'); ?>
						</span>

						</div>
					<?php endwhile; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
