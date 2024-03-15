<?php
$classes = 'module_hiring';
$margin_top = get_sub_field('margin_top');
$margin_bottom = get_sub_field('margin_bottom');
$content = get_sub_field('content');
$hiring_blocks = get_sub_field('hiring_blocks');

if ($margin_top) {
	$classes .= ' mt-' . $margin_top;
}
if ($margin_bottom) {
	$classes .= ' mb-' . $margin_bottom;
}
?>
<?php if ($content || $hiring_blocks) : ?>
	<section class="<?php echo esc_attr($classes); ?>">
<?php /*
		<svg class="svg svg_7 visible-md-up" width="407" height="409" viewBox="0 0 407 409" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<use xlink:href="#svg_elem_7"></use>
		</svg>
		<svg class="svg svg_8 visible-md-up" width="301" height="426" viewBox="0 0 301 426" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<use xlink:href="#svg_elem_8"></use>
		</svg>
 */ ?>
		<div class="d-flex flex-column align-items-center">
			<?php if ($content) : ?>
				<div class="container">
					<div class="module_hiring__content">
						<?php echo $content; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if (have_rows('hiring_blocks')) : ?>
				<div class="container hiring_blocks">
					<?php
					$i = 1;
					while (have_rows('hiring_blocks')) : the_row();
						$image = get_sub_field('image');
						$mobile_image = get_sub_field('mobile_image');
						$content = get_sub_field('content');
						?>
						<?php if ($image) : ?>
							<div class="row">
								<div class="col-md-11 <?php echo $i % 2 == 0 ? 'col-lg-11' : 'col-lg-10'; ?>">
									<?php if ($i % 2 == 0): ?>
										<?php if ($content) : ?>
											<div class="content_block--wrapper content_block--top">
												<div class="content_block">
													<?php echo $content; ?>
												</div>
											</div>
										<?php endif; ?>
									<?php endif; ?>
									<div class="text-center">
										<?php echo wp_get_attachment_image($image, 'full', '', array("class" => "visible-md-up")); ?>
										<?php if ($mobile_image): ?>
											<?php echo wp_get_attachment_image($mobile_image, 'full', '', array("class" => "hidden-md-up")); ?>
										<?php else: ?>
											<?php echo wp_get_attachment_image($image, 'full', '', array("class" => "hidden-md-up")); ?>
										<?php endif; ?>
									</div>
									<?php if ($content) : ?>
										<div class="content_block--wrapper content_block--bottom">
											<div class="content_block text-center text-md-left">
												<?php echo $content; ?>
											</div>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
						<?php $i++; endwhile; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>
