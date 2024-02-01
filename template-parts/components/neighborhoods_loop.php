<?php
$terms           = $args['terms'];

// Loop through each term and display its name and description
foreach ($terms as $term) :
	$term_name = $term->name;
	$term_description = $term->description;
	$term_id = $term->term_id;
	$taxonomy_prefix = 'neighborhood';
	$term_id_prefixed = $taxonomy_prefix . '_' . $term_id;
	$image = get_field('image', $term_id_prefixed);
	?>
	<div class="col-12">
		<a href="<?php echo get_term_link($term->term_id); ?>" class="building__item">
			<div class="building__item--img">
				<div>
					<?php if ($image) : ?>
						<?php echo wp_get_attachment_image($image, 'full'); ?>
					<?php else: ?>
						<?php it_image_placeholder(); ?>
					<?php endif; ?>
				</div>
			</div>
			<div class="building__item--caption">
				<h5 class="building__item--title">
					<?php echo $term_name; ?>
				</h5>
				<p>
					<?php echo $term_description; ?>
				</p>

				<span class="building__item--link">
					<?php _e('View Apartments', 'rentopia'); ?>
				</span>
			</div>
		</a>
	</div>

<?php endforeach; ?>
