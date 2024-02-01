<?php /* Template Name: Account: New Building */

$user = wp_get_current_user();
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	get_header( 'admin' );
else:
	get_header();
endif;
the_post();
$user = wp_get_current_user();
$id   = $_GET['id'];
$cpt  = 'building';

if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	?>

	<div class="container">
		<form method="post" id="new_building_form" class="edit_listing_form" enctype="multipart/form-data">
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
				<div class="col-md-6">
					<label>
						<span><?php _e( 'Title', '_it_start' ); ?></span>
						<input class="title" name="title" type="text" id="title"/>
					</label>
				</div>
				<div class="col-md-6">
					<label>
						<span><?php _e( 'Location', '_it_start' ); ?></span>
						<input type="text" name="location" id="location"
							   placeholder="">
					</label>

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
							<select name="building_amenities[]" multiple id="building_amenities"
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

				</div>

				<div class="col-lg-6">

					<div class="mb-5">
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

				<div class="col-lg-6">

					<div class="mb-5">
						<label for="building_posts">
							<span><?php _e( 'Posts', '_it_start' ); ?></span>
						</label>


						<?php
						$args         = array(
							'post_type'      => 'apartment',
							'posts_per_page' => - 1,
						);
						$custom_query = new WP_Query( $args );
						$posts        = $custom_query->posts;
						?>
						<div class="d-flex flex-wrap align-items-start">
							<select name="building_posts[]" id="building_posts"
									class="select2_muliply" multiple>
								<?php foreach ( $posts as $post ) { ?>

									<option value="<?php echo $post->ID; ?>">
										<?php echo $post->post_title; ?>
									</option>

								<?php } ?>
							</select>
							<span
								class="building_posts_open select2_open_btn">+ <?php _e( 'Add Post', '_it_start' ); ?></span>
						</div>
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
					</div>
				</div>
			</div>

			<input type="hidden" id="status" name="status" value="active">
			<input type="hidden" name="post_id" value="<?php echo $id; ?>">

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
