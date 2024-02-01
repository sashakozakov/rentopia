<?php
$classes = 'content_module';
$content = get_sub_field('content');
?>
<?php if ($content) : ?>
	<section class="<?php echo esc_attr($classes); ?>">
		<div class="container">
			<?php echo $content; ?>
		</div>
	</section>
<?php endif; ?>
