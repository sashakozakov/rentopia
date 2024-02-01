<!--<div class="col-xl-8 col-lg-7 col-sm-6">-->
<div class="col-md-4 col-sm-6">
	<a href="<?php the_permalink(); ?>" class="building__item">
			<span class="building__item--label hidden-lg-up">
				<?php _e( 'available Units', '_it_start' ); ?>
			</span>
		<div class="building__item--img">
			<div>
				<?php if ( has_post_thumbnail() ): ?>
					<?php the_post_thumbnail(); ?>
				<?php else: ?>
					<?php it_image_placeholder(); ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="building__item--caption">
			<span class="building__item--label visible-lg-up">
				<?php _e( 'available Units', '_it_start' ); ?>
			</span>
			<h5 class="building__item--title">
				<?php the_title(); ?>
			</h5>

			<?php
			$location           = get_field( 'buildings_subtitle' );
			if ( $location ): ?>
				<p>
					<?php echo $location; ?>
				</p>
			<?php else:
				$taxonomy = 'neighborhood';
				$primary_cat_id = get_post_meta( get_the_ID(), '_yoast_wpseo_primary_' . $taxonomy, true );
				if ( $primary_cat_id ) {
					$primary_cat = get_term( $primary_cat_id, $taxonomy );
					if ( isset( $primary_cat->name ) ) { ?>
						<p>
							<?php echo $primary_cat->name; ?>
						</p>
					<?php } ?>
				<?php } ?>
			<?php endif; ?>

			<span class="building__item--link">
				<?php _e( 'View apartments', 'rentopia' ); ?>
			</span>
		</div>
	</a>
</div>
