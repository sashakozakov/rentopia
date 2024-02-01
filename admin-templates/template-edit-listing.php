<?php /* Template Name: Account: Edit Listing */

$user = wp_get_current_user();
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	get_header( 'admin' );
else:
	get_header();
endif;
the_post();
$_GET['id'] = $_GET['id'] ?? null;
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :


	if ( isset( $_POST['title'] ) ) {
//		$_GET['id']      = $_POST['post_id'];
		$status  = $_POST['status'];
		$my_post = array(
			'ID'          => $_GET['id'],
			'post_title'  => $_POST['title'],
			'post_status' => $status,
		);
		wp_update_post( $my_post );


		if ( isset( $_POST['subway_lines_title'] ) == true ) {
			$type     = $_POST['subway_lines_type'];
			$title    = $_POST['subway_lines_title'];
			$location = $_POST['subway_lines_location'];
			$result   = array();
			for ( $i = 0; $i < count( $_POST['subway_lines_type'] ); $i ++ ) {
				$result[] = array(
					'field_649efe942c9c6' => $type[ $i ],
					'field_6429d459b5615' => $title[ $i ],
					'field_6429d464b5616' => $location[ $i ]
				);
			}
			update_field( 'subway_lines', $result, $_POST['post_id'] );
		}


		// Save categories
		if ( isset( $_POST['collections'] ) ) {
			$collections_cat = $_POST['collections'];
			wp_set_post_categories( $_GET['id'], $collections_cat, 'collections' ); // Assign categories to 'collections' taxonomy
		}

		if ( isset( $_POST['building_neighborhood'] ) ) {
			$building_neighborhood_terms    = $_POST['building_neighborhood'];
			$building_neighborhood_term_ids = array();
			foreach ( $building_neighborhood_terms as $term_slug ) {
				$term = get_term_by( 'slug', $term_slug, 'neighborhood' );
				if ( $term ) {
					$building_neighborhood_term_ids[] = $term->term_id;
				}
			}
			wp_set_post_terms( $_GET['id'], $building_neighborhood_term_ids, 'neighborhood' );
		}

		if ( isset( $_POST['building_amenities'] ) ) {
			$building_amenities_terms    = $_POST['building_amenities'];
			$building_amenities_term_ids = array();
			foreach ( $building_amenities_terms as $term_slug ) {
				$term = get_term_by( 'slug', $term_slug, 'building_amenities' );
				if ( $term ) {
					$building_amenities_term_ids[] = $term->term_id;
				}
			}
			wp_set_post_terms( $_GET['id'], $building_amenities_term_ids, 'building_amenities' );
		}

		if ( isset( $_POST['apartment_amenities'] ) ) {
			$apartment_amenities_terms     = $_POST['apartment_amenities'];
			$apartment_amenities_terms_ids = array();
			foreach ( $apartment_amenities_terms as $term_slug ) {
				$term = get_term_by( 'slug', $term_slug, 'apartment_amenities' );
				if ( $term ) {
					$apartment_amenities_terms_ids[] = $term->term_id;
				}
			}
			wp_set_post_terms( $_GET['id'], $apartment_amenities_terms_ids, 'apartment_amenities' );
		}
	}

	if ( isset( $_POST['location'] ) ) {
		$location = $_POST['location'];
		update_field( 'buildings_subtitle', $location, $_GET['id'] ); // Update the 'location' field value
	}

	if ( isset( $_POST['apartment_number'] ) ) {
		$apartment_number = $_POST['apartment_number'];
		update_field( 'apartment_number', $apartment_number, $_GET['id'] ); // Update the 'apartment_number' field value
	}

	if ( isset( $_POST['price'] ) ) {
		$new_price = $_POST['price'];
		update_field( 'price', intval( $new_price ), $_GET['id'] ); // Update the 'price' field value
	}

	if ( isset( $_POST['bedrooms'] ) ) {
		$bedrooms = $_POST['bedrooms'];
		update_field( 'bedrooms', intval( $bedrooms ), $_GET['id'] ); // Update the 'bedrooms' field value
	}

	if ( isset( $_POST['bathrooms'] ) ) {
		$bathrooms = $_POST['bathrooms'];
		update_field( 'bathrooms', intval( $bathrooms ), $_GET['id'] ); // Update the 'bathrooms' field value
	}

	if ( isset( $_POST['squares_ft'] ) ) {
		$squares_ft = $_POST['squares_ft'];
		update_field( 'squares_ft', intval( $squares_ft ), $_GET['id'] ); // Update the 'squares_ft' field value
	}

	if ( isset( $_POST['move_in'] ) ) {
		$move_in = $_POST['move_in'];
		update_field( 'move_in', $move_in, $_GET['id'] ); // Update the 'move_in' field value
	}

	if ( isset( $_POST['city'] ) ) {
		$city = $_POST['city'];
		update_field( 'city', $city, $_GET['id'] );
	}

	if ( isset( $_POST['state'] ) ) {
		$state = $_POST['state'];
		update_field( 'state', $state, $_GET['id'] );
	}

	if ( isset( $_POST['zip'] ) ) {
		$zip = $_POST['zip'];
		update_field( 'zip', $zip, $_GET['id'] );
	}

	if ( isset( $_POST['propertytype'] ) ) {
		$propertytype = $_POST['propertytype'];
		update_field( 'propertytype', $propertytype, $_GET['id'] );
	}

	// overview_content
	if ( isset( $_POST['overview_content'] ) ) {
		$move_in = $_POST['overview_content'];
		update_field( 'overview_content', $move_in, $_GET['id'] ); // Update the 'overview_content' field value
	}

	// new_to_market
	if ( isset( $_POST['new_to_market'] ) ) {
		$new_to_market = true;
	} else {
		$new_to_market = false;
	}
	update_field( 'new_to_market', $new_to_market, $_GET['id'] ); // Update the 'new_to_market' field value

	// $first_month_free
	if ( isset( $_POST['first_month_free'] ) ) {
		$first_month_free = true;
	} else {
		$first_month_free = false;
	}
	update_field( 'first_month_free', $first_month_free, $_GET['id'] ); // Update the 'first_month_free' field value

	if ( isset( $_POST['user_agent'] ) ) {
		$move_in = $_POST['user_agent'];
		update_field( 'user_agent', $move_in, $_GET['id'] ); // Update the 'user_agent' field value
	}

	if ( isset( $_POST['collections'] ) ) {
		wp_set_object_terms( $_GET['id'], $_POST['collections'], 'collections' );
	}


	// Gallery
	if ( isset( $_FILES['gallery'] ) ) {

		require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
		require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
		require_once( ABSPATH . "wp-admin" . '/includes/media.php' );

//	TODO: Gallery uploading not opening WP Media
		$files            = $_FILES['gallery'];
		$old_images       = $_POST['gallery_ids'];
		$old_images_array = explode( ",", $old_images[0] );
		if ( isset( $files ) ) {
			for ( $i = 0; $i < count( $files['name'] ); $i ++ ) {
				$file = array(
					'name'     => $files['name'][ $i ],
					'type'     => $files['type'][ $i ],
					'tmp_name' => $files['tmp_name'][ $i ],
					'error'    => $files['error'][ $i ],
					'size'     => $files['size'][ $i ]
				);

				$attachment_id = media_handle_sideload( $file, $_POST['post_id'] );
				if ( ! is_wp_error( $attachment_id ) ) {
					$image_ids[] = $attachment_id;
				}

				$image_ids[] = $attachment_id;
			}

			foreach ( $old_images_array as $val ) {
				$image_ids[] = $val;
			}
			$update_result = update_field( 'gallery', $image_ids, $_POST['post_id'] );


			if ( isset( $_POST['listing_image_input'] ) ) {
				$listing_image_input = $_POST['listing_image_input'];
				$set_thumb           = set_post_thumbnail( $_POST['post_id'], $listing_image_input );
			}
		}
	}

	?>

	<div class="mt-5"></div>

	<div class="container">

		<form method="post" id="edit_listing_form" class="edit_listing_form" enctype="multipart/form-data">
			<div class="edit_listing_form--header mb-4 pb-3">
				<div class="edit_listing_form_msg">
					<span>
						<?php _e( 'Changes saved!', '_it_start' ); ?>
					</span>
				</div>
				<h5 class="mb-1 edit_listing_form--title">
					<?php the_title(); ?>
				</h5>
				<span class="subtitle">
					ID#
					<?php echo $_GET['id']; ?>
				</span>
			</div>
			<div class="row">
				<div class="col-lg-3 col-sm-6">
					<label>
						<span><?php _e( 'City', '_it_start' ); ?></span>
						<input type="text" name="city"
							   value="<?php echo get_field( 'city', $_GET['id'] ); ?>">
					</label>
				</div>
				<div class="col-lg-3 col-sm-6">
					<label>
						<span><?php _e( 'State', '_it_start' ); ?></span>
						<input type="text" name="state"
							   value="<?php echo get_field( 'state', $_GET['id'] ); ?>">
					</label>
				</div>
				<div class="col-lg-3 col-sm-6">
					<label>
						<span><?php _e( 'Zip Code', '_it_start' ); ?></span>
						<input type="text" name="zip"
							   value="<?php echo get_field( 'zip', $_GET['id'] ); ?>">
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
						<option value="" ><?php _e( 'Select', '_it_start' ); ?></option>
						<?php foreach ( $propertytypes as $type ): ?>
							<option
								value="<?php echo $type; ?>" <?php echo $type == get_field( 'propertytype', $_GET['id'] ) ? 'selected' : ''; ?>><?php echo $type; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="col-xxl-4 col-lg-6 col-md-8">
					<div class="row">
						<div class="col-md-7">
							<label>
								<span><?php _e( 'Address', '_it_start' ); ?></span>
								<input class="title" name="title" type="text" id="title"
									   value="<?php echo get_the_title( $_GET['id'] ); ?>"/>
							</label>
						</div>
						<div class="col-md-5">
							<label>
								<span><?php _e( 'Apartment Number', '_it_start' ); ?></span>
								<input type="text" name="apartment_number" id="apartment_number"
									   value="<?php echo get_field( 'apartment_number', $_GET['id'] ); ?>">
							</label>
						</div>
					</div>
				</div>
				<div class="col-xxl-2 col-lg-2 col-md-4">
					<label>
						<span><?php _e( 'Price', '_it_start' ); ?></span>
						<span class="price_input">
						<input type="text" name="price" id="price"
							   value="<?php echo get_field( 'price', $_GET['id'] ); ?>"
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
								   value="<?php echo get_field( 'bedrooms', $_GET['id'] ); ?>"
								   placeholder="0">
							<span class="visible-md-up"><?php _e( 'Beds', '_it_start' ); ?></span>
						</span>
						<span class="bath_input">
							<span class="label_block hidden-md-up">
								<span class="mb-0"><?php _e( 'Bath COUNT', '_it_start' ); ?></span>
							</span>
							<input type="text" name="bathrooms"
								   value="<?php echo get_field( 'bathrooms', $_GET['id'] ); ?>"
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
							   value="<?php echo get_field( 'squares_ft', $_GET['id'] ); ?>"
							   placeholder="00,000">
							/<?php _e( 'Sq. ft', '_it_start' ); ?>
						</span>
					</label>
				</div>
				<div class="col-xxl-2 col-lg-3 col-md-4">
					<label>
						<span><?php _e( 'MOVE IN', '_it_start' ); ?></span>
						<!--						<input type="date" name="move_in" value="-->
						<?php //echo get_field( 'move_in', $_GET['id'] );
						?><!--" placeholder="DD/MM/YEAR">-->
						<?php
						$move_in = get_field( 'move_in', $_GET['id'] );
						$newDate = date( "d/m/Y", strtotime( $move_in ) );
						?>
						<input type="text" class="datepicker" name="move_in" value="<?php echo $newDate; ?>"
							   placeholder="DD/MM/YEAR">
					</label>
				</div>
				<div class="col-lg-6">
					<label>
						<span><?php _e( 'Description', '_it_start' ); ?><span class="required">*</span></span>
						<textarea name="overview_content" required id=""
								  placeholder="<?php _e( 'Write...', '_it_start' ); ?>"><?php echo strip_tags( get_field( 'overview_content', $_GET['id'] ) ); ?></textarea>
					</label>
					<div class="label_checkbox_group">
						<label class="label_checkbox">
							<input type="checkbox"
								   name="new_to_market" <?php echo get_field( 'new_to_market', $_GET['id'] ) ? 'checked' : ''; ?>>
							<span><?php _e( 'New to Market', '_it_start' ); ?></span>
						</label>
						<label class="label_checkbox">
							<input type="checkbox"
								   name="first_month_free" <?php echo get_field( 'first_month_free', $_GET['id'] ) ? 'checked' : ''; ?>>
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
							<option></option>
							<?php foreach ( $users as $user ) {
								$user_id           = $user->ID;
								$user_id_prefixed  = 'user_' . $user_id;
								$photo             = get_field( 'photo', $user_id_prefixed );
								$author_first_name = get_the_author_meta( 'first_name', $user_id );
								$author_last_name  = get_the_author_meta( 'last_name', $user_id );

								?>
								<?php if ( isset( $_POST['user_agent'] ) ) : ?>
									<option value="<?php echo esc_html( $user_id ); ?>" <?php echo $user_agent == $user_id ? 'selected' : null; ?> data-icon="<?php echo wp_get_attachment_image_url( $photo, 'full' ); ?>">
								<?php else: ?>
									<option value="<?php echo esc_html( $user_id ); ?>" <?php echo get_field( 'user_agent', $_GET['id'] ) == $user_id ? 'selected' : null; ?> data-email="<?php the_author_meta( 'user_email', $user_id ); ?>" data-icon="<?php echo wp_get_attachment_image_url( $photo, 'full' ); ?>">
								<?php endif; ?>
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
						$terms = get_the_terms( $_GET['id'], 'building_amenities' );
						if ( $terms ):
							foreach ( $terms as $term ) {
								$term_id  = $term->term_id;
								$result[] = $term->name;
								?>
							<?php } ?>
						<?php endif; ?>

						<?php
						$terms = get_terms( array(
							'taxonomy'   => 'building_amenities',
							'orderby'    => 'term_id',
							'order'      => 'ASC',
							'hide_empty' => false,
						) );
						?>
						<div class="d-flex flex-wrap align-items-start">
							<select name="building_amenities[]" multiple id="building_amenities"
									class="select2_muliply">
								<?php foreach ( $terms as $term ) {
									$term_name = $term->name;
									$term_slug = $term->slug;
									if ( $result ) {
										$selected = in_array( $term_name, $result ) ? 'selected' : '';
									} else {
										$selected = '';
									}
									?>
									<option value="<?php echo esc_html( $term_slug ); ?>" <?php echo $selected; ?>>
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
						$terms = get_the_terms( $_GET['id'], 'apartment_amenities' );
						if ( $terms ):
							foreach ( $terms as $term ) {
								$term_id  = $term->term_id;
								$result[] = $term->name;
								?>
							<?php } ?>
						<?php endif; ?>

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
									if ( $result ) {
										$selected = in_array( $term_name, $result ) ? 'selected' : '';
									} else {
										$selected = '';
									}
									?>
									<option value="<?php echo esc_html( $term_slug ); ?>" <?php echo $selected; ?>>
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
						$terms = get_the_terms( $_GET['id'], 'collections' );
						if ( $terms ):
							foreach ( $terms as $term ) {
								$term_id  = $term->term_id;
								$result[] = $term->name;
								?>
							<?php } ?>
						<?php endif; ?>

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
								<?php foreach ( $terms as $term ) {
									$term_name = $term->name;
									$term_slug = $term->slug;
									if ( $result ) {
										$selected = in_array( $term_name, $result ) ? 'selected' : '';
									} else {
										$selected = '';
									}
									?>
									<option value="<?php echo esc_html( $term_slug ); ?>" <?php echo $selected; ?>>
										<?php echo esc_html( $term_name ); ?>
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
						$terms = get_the_terms( $_GET['id'], 'neighborhood' );
						if ( $terms ):
							foreach ( $terms as $term ) {
								$term_id  = $term->term_id;
								$result[] = $term->name;
								?>
							<?php } ?>
						<?php endif; ?>

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
									if ( $result ) {
										$selected = in_array( $term_name, $result ) ? 'selected' : '';
									} else {
										$selected = '';
									}
									?>
									<option value="<?php echo esc_html( $term_slug ); ?>" <?php echo $selected; ?>>
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
							<?php while ( have_rows( 'subway_lines', $_GET['id'] ) ) : the_row(); ?>
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
													value="<?php echo $line; ?>" <?php echo $line == get_sub_field( 'type' ) ? 'selected' : ''; ?>><?php echo $line; ?></option>
											<?php endforeach; ?>
										</select>
									</div>

									<div class="col-sm-4 col-6">
										<input type="text" name="subway_lines_title[]"
											   value="<?php the_sub_field( 'title' ); ?>">
									</div>

									<div class="col-sm-4 col-3">
										<input type="text" name="subway_lines_location[]"
											   value="<?php the_sub_field( 'value' ); ?>">
									</div>
									<div class="remove_subway_line">remove</div>
								</div>
							<?php endwhile; ?>
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

						<?php $gallery_ids = get_field( 'gallery', $_GET['id'] ); ?>
						<?php if ( $gallery_ids ) : ?>
							<?php foreach ( $gallery_ids as $gallery_id ):
								$image_url = wp_get_attachment_image_url( $gallery_id, 'full' );
								$attachment_id = pippin_get_image_id( $image_url );
								$image_ids[] = $attachment_id;
								?>
								<div class="new_image" id="<?php echo $attachment_id; ?>">
									<div class="new_image_inner">
										<?php echo wp_get_attachment_image( $gallery_id, 'full', null, [ 'class' => 'preview-image' ] ); ?>
									</div>
									<label class="new_image_input_wrapper">
										<input type="radio" name="listing_image_input"
											   value="<?php echo $attachment_id; ?>"
											   class="listing_image_input" <?php echo get_post_thumbnail_id( $_GET['id'] ) == $attachment_id ? 'checked' : ''; ?>>
										<?php _e( 'Select as Cover Image', 'rentopia' ); ?>
									</label>
									<i class="remove-icon fa fa-times"></i>
								</div>
							<?php endforeach; ?>
							<!--							--><?php //$image_ids_string = implode( ', ', $image_ids ); ?>
							<?php $image_ids_string = implode( ', ', $gallery_ids ); ?>
						<?php endif; ?>


					</div>
				</div>

			</div>


			<input type="hidden" id="status" name="status" value="active">
			<input type="hidden" id="hidden_gallery_input" name="gallery_ids[]"
				   value="<?php echo $image_ids_string; ?>">
			<input type="hidden" name="post_id" value="<?php echo $_GET['id']; ?>">

			<div class="edit_listing_form--footer preloader_container">
				<input type="submit" data-status="draft" class="submit draft"
					   value="<?php _e( 'Save Draft', '_it_start' ); ?>"/>

				<a href="<?php echo get_permalink( $_GET['id'] ); ?>?preview=true" class="preview"
				   title="<?php _e( 'Preview', '_it_start' ); ?>">
					<?php _e( 'Preview', '_it_start' ); ?>
				</a>


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
