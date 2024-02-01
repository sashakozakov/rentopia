<?php
$user    = $args['user'];
$user_id = $args['user_id'];
$photo   = get_field( 'photo', $user_id );

$user_id_prefixed  = 'user_' . $user->ID;
$photo             = get_field( 'photo', $user_id_prefixed );
$author_first_name = get_the_author_meta( 'first_name', $user->ID );
$author_last_name  = get_the_author_meta( 'last_name', $user->ID );


$location  = get_field( 'buildings_subtitle' );
$bedrooms  = get_field( 'bedrooms' );
$bathrooms = get_field( 'bathrooms' );
?>
<div class="agents_grid--row">
	<div class="elem elem_agent_name">
		<div class="elem_agent_name--img hidden-lg-up">
			<?php if ( $photo ) : ?>
				<?php echo wp_get_attachment_image( $photo, 'full' ); ?>
			<?php else: ?>
				<?php echo substr( $author_first_name, 0, 1 ) . '' . substr( $author_last_name, 0, 1 ); ?>
			<?php endif; ?>
		</div>
		<?php echo esc_html( $user->display_name ); ?>
	</div>

	<div class="elem elem_email">
		<?php the_author_meta( 'user_email', $user->ID ); ?>
	</div>

	<div class="elem elem_phone">
		<?php the_author_meta( 'phone', $user->ID ); ?>
	</div>

	<div class="elem elem_status">
		<?php
		$status = get_user_role($user->ID);
		$slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $status)));
		if ($status == 'agent') {
			$status_result = __('Active', '_it_start');
		} elseif ($status == 'pending') {
			$status_result = __('Pending', '_it_start');
		} else {
			$status_result = __('Non-Active', '_it_start');
		}
		?>
		<span class="status <?php echo $slug; ?>">
		<?php echo $status_result; ?>
		</span>
	</div>

	<div class="elem elem_actions">
		<span class="hidden-lg-up">
			<?php _e( 'Actions', '_it_start' ); ?>
		</span>
		<div>
			<a href="<?php echo home_url(); ?>/edit-user?user_id=<?php echo $user->ID; ?>" class="edit_link">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none"
					 xmlns="http://www.w3.org/2000/svg">
					<use xlink:href="#edit"></use>
				</svg>
			</a>
			<a href="#" class="trash_link delete_user" delete-user-id="<?php echo $user->ID; ?>">
				<svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
					<use xlink:href="#trash"></use>
				</svg>
			</a>
		</div>
	</div>
</div>
