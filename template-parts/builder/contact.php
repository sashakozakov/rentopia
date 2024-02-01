<?php
$classes = 'module_contact';
$margin_top = get_sub_field('margin_top');
$margin_bottom = get_sub_field('margin_bottom');
$content = get_sub_field('content');
$buttons = get_sub_field('buttons');

if ($margin_top) {
	$classes .= ' mt-' . $margin_top;
}
if ($margin_bottom) {
	$classes .= ' mb-' . $margin_bottom;
}
?>
<?php if ($content || $buttons): ?>
	<section class="<?php echo esc_attr($classes); ?>">
		<div class="container">
			<div class="module_contact__inner">
				<div class="module_contact__container">
					<?php echo $content; ?>

					<?php if (have_rows('buttons')) : ?>
						<div class="btn-group mt-5 justify-content-center">
							<?php while (have_rows('buttons')) : the_row(); ?>
								<?php $link = get_sub_field('link'); ?>
								<?php if ($link) : ?>
									<a href="<?php echo esc_url($link['url']); ?>"
									   class="btn <?php the_sub_field('style'); ?>"
									   target="<?php echo esc_attr($link['target']); ?>"><?php echo esc_html($link['title']); ?></a>
								<?php endif; ?>
							<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
