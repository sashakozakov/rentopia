<?php /* Template Name: Agents List */

$user = wp_get_current_user();
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	get_header( 'admin' );
else:
	get_header();
endif;
the_post();
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) : ?>

	<div class="container">
		<div class="listing_header">
			<div class="listing_header--left">
				<h1 class="listing_title">
					<?php the_title(); ?>
				</h1>
				<span class="listing_subtitle"><?php _e( 'Manage your Agents', '_it_start' ); ?></span>
			</div>
			<div class="d-flex align-items-center hidden-lg-up">
				<a href="<?php echo home_url(); ?>/add-new-agent" class="btn btn-outline">
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M6 1V10.5833" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M1 5.79199H11" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					<?php _e( 'New', '_it_start' ); ?>
				</a>
			</div>
		</div>

		<form role="search" action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
			  method="POST" class="agents_filter_form">
			<label>
				<input name="text" type="text" placeholder="Search Listing..." class="agents_filter_el_input">
			</label>
			<div class="d-flex align-items-center listing_filter_form--right_side visible-sm-up">
				<a href="<?php echo home_url(); ?>/add-new-agent" class="btn btn-outline">
					<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M6 1V10.5833" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
						<path d="M1 5.79199H11" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
					<?php _e( 'add new Agent', '_it_start' ); ?>
				</a>
			</div>
			<!--			<input type="hidden" name="listingsearch" value="1">-->
			<input type="hidden" name="s" value="">
			<input type="hidden" name="action" value="agents_search">
		</form>
	</div>

	<?php
	$args  = array(
		'role__in' => array( 'agent', 'pending', 'nonactive' ),
		'orderby'  => 'user_nicename',
		'order'    => 'ASC'
	);
	$users = get_users( $args ); ?>
	<div class="pt-5">
		<div class="container">
			<div class="agents_grid">
				<div class="agents_grid--header visible-lg-up">
					<div class="agents_grid--row">
						<div class="elem elem_agent_name"><?php _e( 'AGent NAME', '_it_start' ); ?>#</div>
						<div class="elem elem_email"><?php _e( 'Email', '_it_start' ); ?></div>
						<div class="elem elem_phone"><?php _e( 'Phone', '_it_start' ); ?></div>
						<div class="elem elem_status"><?php _e( 'Status', '_it_start' ); ?></div>
						<div class="elem elem_actions"><?php _e( 'Actions', '_it_start' ); ?></div>
					</div>
				</div>
				<div class="agents_grid--body">
					<?php foreach ( $users as $user ) {
						$user_id_prefixed = 'user_' . $user->ID;

						?>
						<?php get_template_part( 'admin-templates/agents_grid_row', null, [ 'user'    => $user,
																							'user_id' => $user_id_prefixed
						] ); ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="admin_error404">
		<?php get_template_part( 'template-parts/components/404' ); ?>
	</div>
<?php endif; ?>

<?php
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	get_footer( 'admin' );
else:
	get_footer();
endif;
