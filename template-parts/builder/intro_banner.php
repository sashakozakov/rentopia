<?php
$classes = 'module_intro';
$margin_top = get_sub_field('margin_top');
$margin_bottom = get_sub_field('margin_bottom');
$show_breadcrumbs = get_sub_field('show_breadcrumbs');
$content = get_sub_field('content');
$image = get_sub_field('image');
$mobile_image = get_sub_field('mobile_image');

if ($margin_top) {
	$classes .= ' mt-' . $margin_top;
}
if ($margin_bottom) {
	$classes .= ' mb-' . $margin_bottom;
}
?>
<section class="<?php echo esc_attr($classes); ?>">

	<?php if ($image) : ?>
		<?php echo wp_get_attachment_image($image, 'full', "", array("class" => "module_intro--img img-contain visible-sm-up")); ?>
	<?php endif; ?>

	<?php if ($mobile_image) : ?>
		<?php echo wp_get_attachment_image($mobile_image, 'full', "", array("class" => "module_intro--img img-contain hidden-sm-up")); ?>
	<?php else: ?>
		<?php if ($image) : ?>
			<?php echo wp_get_attachment_image($image, 'full', "", array("class" => "module_intro--img img-contain hidden-sm-up")); ?>
		<?php endif; ?>
	<?php endif; ?>

	<div class="container">
		<?php if ($show_breadcrumbs) : ?>
			<div class="visible-sm-up">
				<?php get_template_part('template-parts/breadcrumbs'); ?>
			</div>
		<?php endif; ?>
		<div class="module_intro--content text-center text-sm-left">
			<?php if ($content) : ?>
				<div class="row">
					<div class="col-lg-5 col-md-7 text-lg">
						<?php echo $content; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
