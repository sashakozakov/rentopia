<?php /* Template Name: Account: Edit Building */

$user = wp_get_current_user();
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	get_header( 'admin' );
else:
	get_header();
endif;
the_post();
$id = $_GET['id'] ?? null;
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :

	echo "<div class='mt-5 pt-5'></div>";
	echo $_POST['banner_image_val'];
	if ( isset( $_POST['title'] ) ) {
		$status  = 'publish';
		$my_post = array(
			'ID'         => $_GET['id'],
			'post_type'  => 'building',
			'post_title' => $_POST['title'],
//			'post_status' => $status,
		);
		wp_update_post( $my_post );


		if ( isset( $_POST['building_posts'] ) ) {
			$building_posts = $_POST['building_posts'];
			$value[]        = $building_posts;

			update_field( 'connected_apartaments', $building_posts, $_GET['id'] ); // Update the 'building_posts' field value
		}

		// Save categories
//		if ( isset( $_POST['collections'] ) ) {
//			$collections_cat = $_POST['collections'];
//			wp_set_post_categories( $_GET['id'], $collections_cat, 'collections' ); // Assign categories to 'collections' taxonomy
//		}

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

		if ( isset( $_POST['location'] ) ) {
			$location = $_POST['location'];
			update_field( 'buildings_subtitle', $location, $_GET['id'] ); // Update the 'location' field value
		}
	}


	require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
	require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
	require_once( ABSPATH . "wp-admin" . '/includes/media.php' );

	if ( isset( $_FILES['thumb'] ) ) {
		$file = $_FILES['thumb'];

		$file = array(
			'name'     => $file['name'],
			'type'     => $file['type'],
			'tmp_name' => $file['tmp_name'],
			'error'    => $file['error'],
			'size'     => $file['size']
		);
		if ( ! empty( $file['name'] ) ) {
			$attachment_id = media_handle_sideload( $file, $_GET['id'] );
			set_post_thumbnail( $_GET['id'], $attachment_id );
		} else {
			if ( $_POST['thumb_image_val'] == 'reset' ) {
				delete_post_thumbnail( $_GET['id'] );
			}
		}
	}

	// banner img
	if ( isset( $_FILES['banner_img'] ) ) {
		$file = $_FILES['banner_img'];

		$file = array(
			'name'     => $file['name'],
			'type'     => $file['type'],
			'tmp_name' => $file['tmp_name'],
			'error'    => $file['error'],
			'size'     => $file['size']
		);
		if ( ! empty( $file['name'] ) ) {
			$attachment_id = media_handle_sideload( $file, $_GET['id'] );
			$update_result = update_field( 'banner_image', $attachment_id, $_GET['id'] );
		} else {
			if ( $_POST['banner_image_val'] == 'reset' ) {
				delete_field( 'banner_image', $_GET['id'] );
			}
		}
	}

	?>

	<div class="mt-5"></div>

	<div class="container">

		<form method="post" id="edit_building_form" class="edit_listing_form" enctype="multipart/form-data">
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
				<div class="col-md-6">
					<label>
						<span><?php _e( 'Title', '_it_start' ); ?></span>
						<input class="title" name="title" type="text" id="title"
							   value="<?php echo get_the_title( $_GET['id'] ); ?>"/>
					</label>
				</div>
				<div class="col-md-6">
					<label>
						<span><?php _e( 'Location', '_it_start' ); ?></span>
						<input type="text" name="location" id="location"
							   value="<?php echo get_field( 'buildings_subtitle', $_GET['id'] ); ?>"
							   placeholder="">
					</label>

				</div>

				<div class="col-lg-6">

					<div class="mb-5">
						<label for="building_amenities">
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

				</div>

				<div class="col-lg-6">

					<div class="mb-5">
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

				<div class="col-lg-6">

					<div class="mb-5">
						<label for="building_posts">
							<span><?php _e( 'Posts', '_it_start' ); ?></span>
						</label>

						<?php $connected_apartaments = get_field( 'connected_apartaments', $_GET['id'] ); ?>
						<?php if ( $connected_apartaments ) : ?>
							<?php foreach ( $connected_apartaments as $post ) : ?>
								<?php setup_postdata( $post ); ?>
								<?php $result[] = get_the_title(); ?>
							<?php endforeach; ?>
							<?php wp_reset_postdata(); ?>
						<?php endif; ?>


						<?php
						$args         = array(
							'post_type'      => 'apartment',
							'posts_per_page' => - 1,
						);
						$custom_query = new WP_Query( $args );
						$posts        = $custom_query->posts;
						?>
						<!--						--><?php //if ( $custom_query->have_posts() ):
						?>
						<div class="d-flex flex-wrap align-items-start">
							<select name="building_posts[]" id="building_posts"
									class="select2_muliply" multiple>
								<!--									--><?php //while ( $custom_query->have_posts() ): $custom_query->the_post();
								foreach ( $posts as $post ) {
									if ( $result ) {
										$selected = in_array( get_the_title(), $result ) ? 'selected' : '';
									} else {
										$selected = '';
									}
									?>

									<option value="<?php echo $post->ID; ?>" <?php echo $selected; ?>>
										<?php echo $post->post_title; ?>
									</option>

								<?php } ?>
								<!--									--><?php //endwhile;
								?>
							</select>
							<span
								class="building_posts_open select2_open_btn">+ <?php _e( 'Add Post', '_it_start' ); ?></span>
						</div>
						<!--						--><?php //endif;
						//						wp_reset_postdata();
						?>
					</div>

				</div>
			</div>

			<div class="mt-5">
				<span class="label_block">
					<span><?php _e( 'Upload thumbnail image', '_it_start' ); ?></span>
				</span>
				<div class="edit_listing_form__gallery">
					<div id="imagePreviewContainer">
						<label class="file_input">
							<span>
								<svg width="57" height="58" viewBox="0 0 57 58" fill="none"
									 xmlns="http://www.w3.org/2000/svg"><use xlink:href="#upload_icon"></use></svg>
								<?php _e( 'Upload Image', '_it_start' ); ?>
							</span>
							<input accept="image/*" type='file' id="thumb" name="thumb"/>
						</label>

						<?php if ( has_post_thumbnail( $_GET['id'] ) ) : ?>
							<div class="new_image">
								<div class="new_image_inner">
									<?php echo get_the_post_thumbnail( $_GET['id'], 'full', [ 'class' => 'preview-image' ] ) ?>
								</div>
								<i class="remove-icon fa fa-times"></i>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="mt-5">
				<span class="label_block">
					<span><?php _e( 'Upload banner image', '_it_start' ); ?></span>
				</span>
				<div class="edit_listing_form__gallery">
					<div id="banner_img_container">
						<label class="file_input">
							<span>
								<svg width="57" height="58" viewBox="0 0 57 58" fill="none"
									 xmlns="http://www.w3.org/2000/svg"><use xlink:href="#upload_icon"></use></svg>
								<?php _e( 'Upload Image', '_it_start' ); ?>
							</span>
							<input accept="image/*" type='file' id="banner_img" name="banner_img"/>
						</label>

						<?php
						$banner_image = get_field( 'banner_image', $_GET['id'] );
						if ( $banner_image ) : ?>
							<div class="new_image">
								<div class="new_image_inner">
									<?php echo wp_get_attachment_image( $banner_image, 'full', '', array( [ 'class' => 'preview-image' ] ) ); ?>
								</div>
								<i class="remove-icon fa fa-times"></i>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>


			<input type="hidden" id="status" name="status" value="active">
			<input type="hidden" name="post_id" value="<?php echo $_GET['id']; ?>">
			<input type="hidden" id="thumb_image_val" name="thumb_image_val" value="<?php echo has_post_thumbnail($_GET['id']); ?>">
			<input type="hidden" id="banner_image_val" name="banner_image_val" value="<?php echo $banner_image; ?>">

			<div class="edit_listing_form--footer preloader_container">
				<!--				<input type="submit" data-status="draft" class="submit draft"-->
				<!--					   value="--><?php //_e( 'Save Draft', '_it_start' );
				?><!--"/>-->

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
