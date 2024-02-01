<?php /* Template Name: Account: My Listing */

$user = wp_get_current_user();
global $wp;
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	get_header( 'admin' );
else:
	get_header();
endif;
the_post();
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	$post_type = get_field( 'post_type' );
	if ( $_GET['clone_id'] ) {
		$clone_id = $_GET['clone_id'];
		duplicate_post( $clone_id ); ?>
		<script>
			if(typeof window.history.pushState == 'function') {
				window.history.pushState({}, "Hide", '<?php echo home_url( $wp->request ); ?>');
			}
		</script>
		<?php } ?>

	<div class="container">
		<div class="listing_header">
			<div class="listing_header--left">
				<h1 class="listing_title">
					<?php the_title(); ?>
				</h1>
				<span class="listing_subtitle"><?php _e( 'Your assigned listings', '_it_start' ); ?></span>
			</div>
			<?php if ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ): ?>
				<?php if ( $post_type == 'apartment' ): ?>
					<a href="<?php echo home_url(); ?>/new-listing?cpt=<?php echo $post_type; ?>"
					   class="btn btn-outline">
						<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<use xlink:href="#plus"></use>
						</svg>
						<span class="visible-sm-up"><?php _e( 'add new listing', '_it_start' ); ?></span>
						<span class="hidden-sm-up"><?php _e( 'new', '_it_start' ); ?></span>
					</a>
				<?php else: ?>
					<a href="<?php echo home_url(); ?>/new-building"
					   class="btn btn-outline">
						<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<use xlink:href="#plus"></use>
						</svg>
						<span class="visible-sm-up"><?php _e( 'add new building', '_it_start' ); ?></span>
						<span class="hidden-sm-up"><?php _e( 'new', '_it_start' ); ?></span>
					</a>
				<?php endif; ?>
			<?php endif; ?>
		</div>


		<?php
		$terms = get_terms( array(
			'taxonomy' => 'neighborhood',
			'orderby'  => 'term_id',
			'order'    => 'ASC',
		) );
		?>
		<div class="listing_filter_form--btn hidden-lg-up">
			<svg width="37" height="37" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
				<use xlink:href="#settings_icon"></use>
			</svg>
		</div>
		<form role="search" action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
			  method="POST" class="listing_filter_form">
			<label>
				<input name="text" type="text" placeholder="Search Listing..." class="filter_el_input">
			</label>
			<div class="d-flex align-items-lg-center listing_filter_form--right_side">
				<span class="subtitle">
					<?php _e( 'Filter by', '_it_start' ); ?>
				</span>
				<?php if ( $post_type == 'apartment' ): ?>
					<select id="status_select2" name="status" class="filter_el">
						<option value=""><?php _e( 'Status', '_it_start' ); ?></option>
						<option value="publish"><?php _e( 'Active', '_it_start' ); ?></option>
						<option value="pending"><?php _e( 'Non-Active', '_it_start' ); ?></option>
						<option value="draft"><?php _e( 'Draft', '_it_start' ); ?></option>
					</select>
				<?php endif; ?>
				<select id="neighborhood_select2" name="neighborhood" class="filter_el">
					<option value=""><?php _e( 'Neighborhood', '_it_start' ); ?></option>
					<?php
					// Loop through each term and display its name and description
					foreach ( $terms as $term ) {
						$term_name = $term->name;
						$term_slug = $term->slug; ?>
						<option value="<?php echo $term_slug; ?>"><?php echo $term_name; ?></option>
					<?php } ?>
				</select>

				<?php if ( ( in_array( 'manager', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) && $post_type == 'apartment' ):
					$args = array(
						'role'       => 'agent',
						'orderby'    => 'meta_value',
						'order'      => 'ASC',
						'meta_query' => array(
							'relation' => 'OR',
							array(
								'key'     => 'first_name',
								'compare' => 'EXISTS',
							),
//							array(
//								'key' => 'last_name',
//								'compare' => 'EXISTS',
//							),
						),
					);
					$users = get_users( $args );
					?>
					<select id="user_agent_select2" name="user_agent" class="filter_el">
						<option value=""><?php _e( 'Agent', '_it_start' ); ?></option>

						<?php foreach ( $users as $user ) {
							$user_acf_prefix  = 'user_';
							$user_id_prefixed = $user_acf_prefix . $user->ID;
							$photo            = get_field( 'photo', $user_id_prefixed );
							$first_name       = get_the_author_meta( 'first_name', $user->ID );
							$last_name        = get_the_author_meta( 'last_name', $user->ID );

							?>
							<option value="<?php echo esc_html( $user->id ); ?>"
									data-icon="<?php echo wp_get_attachment_image_url( $photo, 'full' ); ?>">
								<?php echo trim( sprintf( '%1$s %2$s', $first_name, $last_name ) ); ?>
							</option>
						<?php } ?>

					</select>
				<?php endif; ?>

				<a href="#" class="btn close_filter hidden-lg-up">
					<?php _e( 'Done', '_it_start' ); ?>
				</a>
			</div>
			<!--			<input type="hidden" name="listingsearch" value="1">-->
			<input type="hidden" name="s" value="">
			<input type="hidden" name="post_type" value="<?php echo $post_type; ?>">
			<input type="hidden" name="action" value="listing_filter">
		</form>
	</div>

	<?php
	$args = array(
//		'post_type' => array('apartment', 'building'),
		'post_type'      => $post_type,
		'posts_per_page' => - 1,
		'orderby'        => 'date',
	);
	if ( $post_type == 'apartment' ) {
		$args['post_status'] = array( 'publish', 'pending', 'draft' );
	} else {
		$args['post_status'] = 'any';
	}
	$query = new WP_Query( $args ); ?>
	<?php if ( $query->have_posts() ): ?>
	<div class="pt-5">
		<div class="container">
			<div class="listing_grid">
				<div class="listing_grid--header visible-lg-up">
					<div class="listing_grid--row">
						<div class="elem elem_id">
							<?php if ( $post_type == 'building' ): ?>
								<?php _e( 'Building ID', '_it_start' ); ?>#
							<?php else: ?>
								<?php _e( 'Listing ID', '_it_start' ); ?>#
							<?php endif; ?>
						</div>
						<div class="elem elem_date"><?php _e( 'UPLOAD Date', '_it_start' ); ?></div>
						<div class="elem elem_address">
							<?php if ( $post_type == 'building' ): ?>
								<?php _e( 'Title', '_it_start' ); ?>
							<?php else: ?>
								<?php _e( 'ADDRESS', '_it_start' ); ?>
							<?php endif; ?>
						</div>
						<div class="elem elem_<?php echo $post_type == 'apartment' ? 'comfort' : 'neighborhood'; ?> ">
							<?php if ( $post_type == 'apartment' ): ?>
								<?php _e( 'Bed & Bath', '_it_start' ); ?>
							<?php else: ?>
								<?php _e( 'Neighborhood', '_it_start' ); ?>
							<?php endif; ?>
						</div>
						<?php if ( $post_type == 'apartment' ): ?>
							<div class="elem elem_status"><?php _e( 'Status', '_it_start' ); ?></div>
						<?php endif; ?>
						<div class="elem elem_actions"><?php _e( 'Actions', '_it_start' ); ?></div>
					</div>
				</div>
				<div class="listing_grid--body">
					<?php while ( $query->have_posts() ): $query->the_post(); ?>
						<?php get_template_part( 'admin-templates/listing_grid_row', null, [ 'post-type' => $post_type ] ); ?>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
<?php endif;
	wp_reset_postdata(); ?>
<?php
else: ?>
	<div class="admin_error404">
		<?php get_template_part( 'template-parts/components/404' ); ?>
	</div>
<?php endif;

if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	get_footer( 'admin' );
else:
	get_footer();
endif;

