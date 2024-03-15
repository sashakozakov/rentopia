<?php
$classes = 'module_blog_post';
$margin_top = get_sub_field('margin_top');
$margin_bottom = get_sub_field('margin_bottom');
$content = get_sub_field('content');
$button = get_sub_field('button');
$image = get_sub_field('image');
$columns_reverse = get_sub_field('columns_reverse');
$show_decor_element = get_sub_field('show_decor_element');
$img_out = get_sub_field('image_outside_container');

if ($margin_top) {
	$classes .= ' mt-' . $margin_top;
}
if ($margin_bottom) {
	$classes .= ' mb-' . $margin_bottom;
}
?>
<section class="<?php echo esc_attr($classes); ?>">

	<?php /*
	<?php if ($show_decor_element) : ?>
		<svg class="svg svg_11 visible-md-up" width="348" height="324" viewBox="0 0 348 324" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<use xlink:href="#svg_elem_11"></use>
		</svg>
	<?php endif; ?>
 */ ?>
	<?php if ($image && $img_out) : ?>
		<div class="img_block mb-4 mb-md-0 <?php echo $columns_reverse ? ' img_left' : 'img_right'; ?>">
			<?php echo wp_get_attachment_image($image, 'full'); ?>
		</div>
	<?php endif; ?>
	<div class="container">
		<div class="row align-items-center <?php echo $columns_reverse ? 'flex-row-reverse text-md-right' : ''; ?>">
			<div class="<?php echo $img_out ? '' : 'col-lg-5'; ?> col-md-6 order-2">
				<div class="module_blog_post--content text-center text-md-left text-grey">
					<?php echo $content; ?>

					<?php if ($button) : ?>
						<div class="btn-group justify-content-md-start justify-content-center">
							<?php $wrapper = false;
							$title = $button['title'];
							$class = 'btn';
							$url = $button['url'];
							$target = $button['target'];
							get_template_part('template-parts/components/button', null, ['classes' => $class, 'title' => $title, 'url' => $url, 'target' => $target, 'wrapper' => $wrapper]);
							?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			<?php if ($image && $img_out == false) : ?>
				<div
					class="col-lg-7 col-md-6 text-center order-1 <?php echo $columns_reverse ? 'text-md-left' : 'text-md-right'; ?>">
					<?php echo wp_get_attachment_image($image, 'full'); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
