<?php /* Template Name: New Listing */

$user = wp_get_current_user();
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	get_header( 'admin' );
else:
	get_header();
endif;
the_post();
$user = wp_get_current_user();
$id   = $_GET['id'] ?? null;
$cpt  = 'apartment';

if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	?>

	<div class="container">
		<form method="post" id="new_listing_form" class="edit_listing_form" enctype="multipart/form-data">
			<div class="edit_listing_form--header mb-4 pb-3">
				<div class="edit_listing_form_msg">
					<span>
						<?php _e( 'Post Created', '_it_start' ); ?>
					</span>
				</div>
				<h5 class="mb-1 edit_listing_form--title">
					<?php the_title(); ?>
				</h5>
			</div>
			<div class="row">
				<div class="col-lg-3 col-sm-6">
					<label>
						<span><?php _e( 'City', '_it_start' ); ?></span>
						<input type="text" name="city">
					</label>
				</div>
				<div class="col-lg-3 col-sm-6">
					<label>
						<span><?php _e( 'State', '_it_start' ); ?></span>
						<input type="text" name="state">
					</label>
				</div>
				<div class="col-lg-3 col-sm-6">
					<label>
						<span><?php _e( 'Zip Code', '_it_start' ); ?></span>
						<input type="text" name="zip">
					</label>
				</div>
				<div class="col-lg-3 col-sm-6">
					<label>
						<span><?php _e( 'Property Type', '_it_start' ); ?></span>
					</label>
					<?php $propertytypes = array(
						'Condo',
						'Townhome',
						'Duplex',
						'Single Family Home',
						'ApartmentForRent'
					); ?>

					<select name="propertytype" id="">
						<option value="" selected ><?php _e( 'Select', '_it_start' ); ?></option>
						<?php foreach ( $propertytypes as $type ): ?>
							<option value="<?php echo $type; ?>"><?php echo $type; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-xxl-4 col-lg-6 col-md-8">
					<div class="row">
						<div class="col-md-7">
							<label>
								<span><?php _e( 'Address', '_it_start' ); ?></span>
								<input class="title" name="title" type="text" id="title"
									   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"/>
							</label>
						</div>
						<div class="col-md-5">
							<label>
								<span><?php _e( 'Apartment Number', '_it_start' ); ?></span>
								<input type="text" name="apartment_number" id="apartment_number">
							</label>
						</div>
					</div>
				</div>
				<div class="col-xxl-2 col-lg-2 col-md-4">
					<label>
						<span><?php _e( 'Price', '_it_start' ); ?></span>
						<span class="price_input">
						<input type="text" name="price" id="price"
							   placeholder="00,000">
							/<?php _e( 'month', '_it_start' ); ?>
						</span>
					</label>
				</div>
				<div class="col-xxl-2 col-lg-3 col-md-4">
					<span class="label_block">
						<span class="visible-md-up"><?php _e( 'Bed & Bath', '_it_start' ); ?></span>
						<span class="beds_and_bath flex-column flex-md-row mb-0">
						<span class="beds_input">
							<span class="label_block hidden-md-up">
								<span class="mb-0"><?php _e( 'Beds COUNT', '_it_start' ); ?></span>
							</span>
							<input type="text" name="bedrooms"
								   placeholder="0">
							<span class="visible-md-up"><?php _e( 'Beds', '_it_start' ); ?></span>
						</span>
						<span class="bath_input">
							<span class="label_block hidden-md-up">
								<span class="mb-0"><?php _e( 'Bath COUNT', '_it_start' ); ?></span>
							</span>
							<input type="text" name="bathrooms"
								   placeholder="0">
							<span class="visible-md-up"><?php _e( 'Bath', '_it_start' ); ?></span>
						</span>
						</span>
					</span>
				</div>
				<div class="col-xxl-2 col-lg-3 col-md-4">
					<label>
						<span><?php _e( 'Size', '_it_start' ); ?></span>
						<span class="size_input">
						<input type="text" name="squares_ft"
							   placeholder="00,000">
							/<?php _e( 'Sq. ft', '_it_start' ); ?>
						</span>
					</label>
				</div>
				<div class="col-xxl-2 col-lg-3 col-md-4">
					<label>
						<span><?php _e( 'MOVE IN', '_it_start' ); ?></span>
						<input type="text" class="datepicker" name="move_in"
							   placeholder="DD/MM/YEAR">
					</label>
				</div>
				<div class="col-lg-6">
					<label>
						<span><?php _e( 'Description', '_it_start' ); ?><span class="required">*</span></span>
						<textarea name="overview_content" id=""
								  placeholder="<?php _e( 'Write...', '_it_start' ); ?>"></textarea>
					</label>
					<div class="label_checkbox_group">
						<label class="label_checkbox">
							<input type="checkbox"
								   name="first_month_free">
							<span><?php _e( 'New to Market', '_it_start' ); ?></span>
						</label>
						<label class="label_checkbox">
							<input type="checkbox"
								   name="new_to_market">
							<span><?php _e( 'First Month Free', '_it_start' ); ?></span>
						</label>
					</div>
				</div>
				<div class="col-lg-6">
					<?php
					//					user_agent
					$args  = array(
						'role'    => 'agent',
						'orderby' => 'user_nicename',
						'order'   => 'ASC'
					);
					$users = get_users( $args );
					?>
					<label for="user_agent">
						<span><?php _e( 'Assigned Agents', '_it_start' ); ?></span>
					</label>
					<div class="user_agent_select">
						<select name="user_agent" id="user_agent">
							<option value="" disabled selected><?php _e( 'Choose Agent', '_it_start' ); ?></option>
							<?php foreach ( $users as $user ) {
								$user_id           = $user->ID;
								$user_id_prefixed  = 'user_' . $user->ID;
								$photo             = get_field( 'photo', $user_id_prefixed );
								$author_first_name = get_the_author_meta( 'first_name', $user_id );
								$author_last_name  = get_the_author_meta( 'last_name', $user_id );

								?>
								<option
									value="<?php echo esc_html( $user->id ); ?>" <?php echo get_field( 'user_agent', $id ) == $user->id ? 'selected' : null; ?>
									data-icon="<?php echo wp_get_attachment_image_url( $photo, 'full' ); ?>">
									<?php echo trim( sprintf( '%1$s %2$s', $author_first_name, $author_last_name ) ); ?>
								</option>
							<?php } ?>
						</select>
					</div>
				</div>

				<div class="col-lg-6">

					<div class="mb-5">
						<label for="collections">
							<span><?php _e( 'Building Amenities', '_it_start' ); ?></span>
						</label>

						<?php
						$terms = get_terms( array(
							'taxonomy'   => 'building_amenities',
							'orderby'    => 'term_id',
							'order'      => 'ASC',
							'hide_empty' => false,
						) );
						?>
						<div class="d-flex flex-wrap align-items-start">
							<select name="building_amenities[]" multiply id="building_amenities" multiple
									class="select2_muliply">
								<?php foreach ( $terms as $term ) {
									$term_name = $term->name;
									$term_slug = $term->slug;
									?>
									<option value="<?php echo esc_html( $term_slug ); ?>">
										<?php echo esc_html( $term_name ); ?>
									</option>
								<?php } ?>
							</select>
							<span
								class="building_amenities_open select2_open_btn">+ <?php _e( 'Add Amenities', '_it_start' ); ?></span>
						</div>
					</div>

					<div>
						<label for="collections">
							<span><?php _e( 'Apartment Amenities', '_it_start' ); ?></span>
						</label>

						<?php
						$terms = get_terms( array(
							'taxonomy'   => 'apartment_amenities',
							'orderby'    => 'term_id',
							'order'      => 'ASC',
							'hide_empty' => false,
						) );
						?>
						<div class="d-flex flex-wrap align-items-start">
							<select name="apartment_amenities[]" id="apartment_amenities" multiple
									class="select2_muliply">
								<?php foreach ( $terms as $term ) {
									$term_name = $term->name;
									$term_slug = $term->slug;

									?>
									<option value="<?php echo esc_html( $term_slug ); ?>">
										<?php echo esc_html( $term_name ); ?>
									</option>
								<?php } ?>
							</select>
							<span
								class="apartment_amenities_open select2_open_btn">+ <?php _e( 'Add Amenities', '_it_start' ); ?></span>
						</div>
					</div>
				</div>

				<div class="col-lg-6">
					<div class="mb-5">
						<label for="collections">
							<span><?php _e( 'Assigned Collections', '_it_start' ); ?></span>
						</label>

						<?php
						$terms = get_terms( array(
							'taxonomy'   => 'collections',
							'orderby'    => 'term_id',
							'order'      => 'ASC',
							'hide_empty' => false,
						) );
						?>
						<div class="d-flex flex-wrap align-items-start">
							<select name="collections[]" id="listing_collections" multiple
									class="select2_muliply">
								<?php foreach ( $terms as $term ) { ?>
									<option value="<?php echo esc_html( $term->slug ); ?>">
										<?php echo esc_html( $term->name ); ?>
									</option>
								<?php } ?>
							</select>
							<span
								class="listing_collections_open select2_open_btn">+ <?php _e( 'Add Collection', '_it_start' ); ?></span>
						</div>
					</div>

					<div>
						<label for="collections">
							<span><?php _e( 'Neighborhood', '_it_start' ); ?></span>
						</label>

						<?php
						$terms = get_terms( array(
							'taxonomy'   => 'neighborhood',
							'orderby'    => 'term_id',
							'order'      => 'ASC',
							'hide_empty' => false,
						) );
						?>
						<div class="d-flex flex-wrap align-items-start">
							<select name="building_neighborhood[]" id="building_neighborhood"
									class="select2_muliply" multiple>
								<?php
								foreach ( $terms as $term ) {
									$term_name = $term->name;
									$term_slug = $term->slug;
									?>
									<option value="<?php echo esc_html( $term_slug ); ?>">
										<?php echo esc_html( $term_name ); ?>
									</option>
								<?php } ?>
							</select>
							<span
								class="building_neighborhood_open select2_open_btn">+ <?php _e( 'Add Neighborhood', '_it_start' ); ?></span>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12">
					<label>
						<span><?php _e( 'Subway Lines', '_it_start' ); ?></span>
					</label>
					<div class="subway_lines">
						<div class="row mb-3">
							<div class="col-sm-4 col-3">
								<strong><?php _e( 'Type', '_it_start' ); ?></strong>
							</div>
							<div class="col-sm-4 col-6">
								<strong><?php _e( 'Title', '_it_start' ); ?></strong>
							</div>
							<div class="col-sm-4 col-3">
								<strong><?php _e( 'Location', '_it_start' ); ?></strong>
							</div>
						</div>
						<div class="subway_lines_body">
							<div class="row">
								<div class="col-sm-4 col-3">
									<?php $subwayLines = array(
										'1',
										'2',
										'3',
										'4',
										'5',
										'a',
										'b',
										'c',
										'd',
										'e',
										'f',
										'g',
										'j',
										'l',
										'm',
										'n',
										'q',
										's',
										'sf',
										'sir',
										'sr',
										'w',
										'z'
									); ?>

									<select name="subway_lines_type[]" id="">
										<?php foreach ( $subwayLines as $line ): ?>
											<option
												value="<?php echo $line; ?>"><?php echo $line; ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-sm-4 col-6">
									<input type="text" name="subway_lines_title[]">
								</div>

								<div class="col-sm-4 col-3">
									<input type="text" name="subway_lines_location[]">
								</div>
								<div class="remove_subway_line">remove</div>
							</div>
						</div>
						<div class="text-right mt-3">
							<div class="select2_open_btn new_subway_line">
								<?php _e( 'New Subway Line', '_it_start' ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="mt-5">
				<span class="label_block">
					<span><?php _e( 'Upload listing images and choose cover images*', '_it_start' ); ?></span>
				</span>
				<div class="edit_listing_form__gallery">
					<div id="imagePreviewContainer">
						<label class="file_input">
							<span>
								<svg width="57" height="58" viewBox="0 0 57 58" fill="none"
									 xmlns="http://www.w3.org/2000/svg"><use xlink:href="#upload_icon"></use></svg>
								<?php _e( 'Upload Images', '_it_start' ); ?>
							</span>
							<input accept="image/*" type='file' id="gallery" name="gallery[]" multiple/>
						</label>
					</div>
				</div>

			</div>
			<br>

			<input type="hidden" id="status" name="status" value="active">
			<input type="hidden" name="post_id" value="<?php echo $id; ?>">
			<input type="hidden" name="cpt" value="<?php echo $cpt; ?>">

			<div class="edit_listing_form--footer preloader_container">
				<input type="submit" data-status="draft" class="submit draft"
					   value="<?php _e( 'Save Draft', '_it_start' ); ?>"/>

				<input type="submit" data-status="publish" id="" class="submit button"
					   value="<?php _e( 'Publish', '_it_start' ); ?>"/>
			</div>
		</form>
	</div>

<?php else: ?>
	<div class="admin_error404">
		<?php get_template_part( 'template-parts/components/404' ); ?>
	</div>
<?php endif;
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	get_footer( 'admin' );
else:
	get_footer();
endif;
