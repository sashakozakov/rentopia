<?php
$apartment_number = get_field( 'apartment_number' );
$location         = get_field( 'buildings_subtitle' );
$bedrooms         = get_field( 'bedrooms' );
$bathrooms        = get_field( 'bathrooms' );
$post_type        = $args['post-type'];
global $wp;
?>
<div class="listing_grid--row">
	<div class="elem elem_id visible-lg-up">
		ID# <?php echo get_the_ID(); ?>
	</div>
	<div class="elem elem_date visible-lg-up">
		<?php echo get_the_date( 'm/d, H:i' ); ?>
	</div>
	<div class="elem elem_address">
		<?php the_title(); ?><?php echo $apartment_number ? ' ' . $apartment_number : ''; ?><?php echo $location ? ', ' . $location : ''; ?>
	</div>
	<?php if ( $post_type == 'apartment' ): ?>
		<div class="elem elem_comfort">
			<?php if ( $bedrooms ): ?>
				<span>
				<?php echo $bedrooms; ?>
				<?php echo $bedrooms == 1 ? __( 'Bed', '_it_start' ) : __( 'Beds', '_it_start' ); ?>
			</span>
			<?php endif; ?>
			<?php if ( $bathrooms ): ?>
				<span>
				<?php echo $bathrooms; ?>
				<?php _e( 'Bath', '_it_start' ); ?>
			</span>
			<?php endif; ?>
		</div>
	<?php else: ?>
		<div class="elem elem_<?php echo $post_type == 'apartment' ? 'comfort' : 'neighborhood'; ?> ">
			<?php
			$taxonomy       = 'neighborhood';
			$primary_cat_id = get_post_meta( get_the_id(), '_yoast_wpseo_primary_' . $taxonomy, true );
			if ( $primary_cat_id ) { ?>
				<?php $primary_cat = get_term( $primary_cat_id, $taxonomy );
				if ( isset( $primary_cat->name ) ) {
					echo $primary_cat->name;
				}
			} else {
				$terms = get_the_terms( get_the_ID(), 'neighborhood' );
				if ( $terms ) {
					foreach ( $terms as $tax ) {
						echo $tax->name;
					}
				}
			} ?>
		</div>
	<?php endif; ?>
	<?php if ( $post_type == 'apartment' ): ?>
		<div class="elem elem_status">
			<?php
			if ( get_post_status() == 'publish' ) {
				$status = __( 'Active', '_it_start' );
			} elseif ( get_post_status() == 'pending' ) {
				$status = __( 'Non-Active', '_it_start' );
			} else {
				$status = get_post_status();
			}
			$slug = strtolower( trim( preg_replace( '/[^A-Za-z0-9-]+/', '-', $status ) ) );
			?>
			<div class="hidden-lg-up listing_info">
				<span class="id">ID# <?php echo get_the_ID(); ?></span>
				<span class="date"><?php echo get_the_date( 'd/m, H:i' ); ?></span>
			</div>
			<span class="status <?php echo $slug; ?>">
			<?php echo $status; ?>
		</span>
		</div>
	<?php endif; ?>
	<div class="elem elem_actions">
		<span class="hidden-lg-up">
			<?php _e( 'Actions', '_it_start' ); ?>
		</span>
		<div>
			<a href="<?php the_permalink(); ?>" class="view_link">
				<svg width="24" height="15" viewBox="0 0 24 15" fill="none"
					 xmlns="http://www.w3.org/2000/svg">
					<use xlink:href="#view"></use>
				</svg>
			</a>
			<?php if ( $post_type == 'apartment' ): ?>
			<a href="<?php echo home_url(); ?>/edit-listing?id=<?php echo get_the_ID(); ?>" class="edit_link">
				<?php else: ?>
				<a href="<?php echo home_url(); ?>/edit-building?id=<?php echo get_the_ID(); ?>" class="edit_link">
					<?php endif; ?>
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
						 xmlns="http://www.w3.org/2000/svg">
						<use xlink:href="#edit"></use>
					</svg>
				</a>
				<a href="#" class="trash_link delete_listing" delete-listing-id="<?php echo get_the_ID(); ?>">
					<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
						<use xlink:href="#trash"></use>
					</svg>
				</a>
				<a href="<?php echo home_url( $wp->request ); ?>?clone_id=<?php echo get_the_ID(); ?>"
				   class="trash_link clone_listing" clone-listing-id="<?php echo get_the_ID(); ?>">
					<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
						<use xlink:href="#clone"></use>
					</svg>
				</a>
		</div>
	</div>
</div>
