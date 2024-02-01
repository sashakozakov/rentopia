<?php /* Template Name: Edit User */

$admin_user = wp_get_current_user();
if ( is_user_logged_in() && ( in_array( 'manager', (array) $admin_user->roles ) || in_array( 'agent', (array) $admin_user->roles ) || in_array( 'administrator', (array) $admin_user->roles ) ) ) :
	get_header( 'admin' );
else:
	get_header();
endif;
the_post();
//
if ( $admin_user->roles[0] === 'administrator' && $_GET['user_id'] ) {
	$current_user = get_user_by( 'id', $_GET['user_id'] );

} else {
	$current_user = wp_get_current_user();
//		$current_user = get_user_by( 'id', get_current_user_id() );
}
$roles = ( array ) $admin_user->roles;
?>

<?php if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>

	<?php endwhile; ?>
<?php endif; ?>

<?php if ( is_user_logged_in() && ( in_array( 'manager', (array) $admin_user->roles ) || in_array( 'agent', (array) $admin_user->roles ) || in_array( 'administrator', (array) $admin_user->roles ) ) ) : ?>

	<div class="mt-5 pt-5">
	<div class="container mt-md-4 pt-md-2 <?php echo $roles[0]; ?>">

	<?php
	/* Get user info. */
//	global $current_user, $wp_roles;
//	get_currentuserinfo();
//var_dump($_POST['last-name']);

//	$error = array();
	if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

		$status = $_POST['status'];
//		if ( current_user_can( 'administrator' ) ) {
		if ( $status == 'publish' ) {
			$status = 'agent';
		}
//		} else {
//			$status = 'administrator';
//		}

		if ( ! empty( $_POST['email'] ) ) {
			if ( ! is_email( esc_attr( $_POST['email'] ) ) ) {
				$error[] = __( 'The Email you entered is not valid.  please try again.', '_it_start' );
			} else if ( ! empty( email_exists( esc_attr( $_POST['email'] ) ) ) && email_exists( esc_attr( $_POST['email'] ) ) != $current_user->id ) {
				$error[] = __( 'This email is already used by another user.  try a different one.', '_it_start' );
			} else {
				wp_update_user( array(
					'ID'         => $current_user->ID,
					'role'       => $status,
					'user_email' => esc_attr( $_POST['email'] )
				) );
			}
		}

//		if (!empty($_POST['first-name']))
//			update_user_meta($current_user->ID, 'first_name', esc_attr($_POST['first-name']));
		$fields = array(
			'first-name'   => 'first_name',
			'last-name'    => 'last_name',
			'description'  => 'description',
			'nickname'     => 'nickname',
			'job_position' => 'job_position',
			'languages'    => 'languages',
			'experience'   => 'experience',
			'phone'        => 'phone',
			'linkedin'     => 'linkedin',
			'instagram'    => 'instagram',
			'twitter'      => 'twitter',
			'facebook'     => 'facebook',
			'status'       => 'status'
		);

		foreach ( $fields as $field => $meta_key ) {
			if ( ! empty( $_POST[ $field ] ) ) {
				update_user_meta( $current_user->ID, $meta_key, esc_attr( $_POST[ $field ] ) );
			}
		}


// TODO: images not loading
		require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
		require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
		require_once( ABSPATH . "wp-admin" . '/includes/media.php' );

		$photo = $_FILES['settings_main_photo'];

			$file = array(
				'name'     => sanitize_file_name($photo['name']),
				'type'     => $photo['type'],
				'tmp_name' => $photo['tmp_name'],
				'error'    => $photo['error'],
				'size'     => $photo['size']
			);

		if ( ! empty( $file['name'] ) ) {
			$attachment_id = media_handle_sideload( $file, $current_user->id );
			$update_result = update_field( 'photo', $attachment_id, 'user_' . $current_user->id );
		}


		/* Update user password. */
		if ( ! empty( $_POST['pass1'] ) && ! empty( $_POST['pass2'] ) ) {
			if ( $_POST['pass1'] == $_POST['pass2'] ) {
				wp_update_user( array( 'ID' => $current_user->id, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
				echo "<div class='save-message'><p>";
				echo __( 'Your new password is changed.', '_it_start' );
				echo "</p></div>";
			} else {
				$error = __( 'The passwords you entered do not match.  Your password was not updated.', '_it_start' );
			}
		}


		/* Redirect so the page will show updated info.*/
		/*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
//if ( count($error) == 0 ) {
//action hook for plugins and extra fields saving
//do_action('edit_user_profile_update', $current_user->ID);
// wp_redirect( get_permalink() );
// exit;
// }
	}


	if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php
//		if ( $_POST['updated'] == 'true' ) : ?><!-- <p>Your profile has been updated</p> --><?php //endif; ?>
		<?php
//		if ( count( $error ) > 0 ) {
//			echo '<p class="error">' . implode( "<br />", $error ) . '</p>';
//		}
		?>

		<img src="<?php echo IT_DIR . '../../../wp-load.php'; ?>" alt="">
		<form method="post" id="update_profile_info" class="settings_main" enctype="multipart/form-data"
			  action="<?php the_permalink(); ?><?php echo $current_user->ID === get_the_author_meta( 'ID' ) ? '' : '?user_id=' . $current_user->ID; ?>">
			<?php
			$user_id_prefixed = 'user_' . $current_user->ID;
			$photo            = get_field( 'photo', $user_id_prefixed );
			$job_position     = get_the_author_meta( 'job_position', $current_user->ID );
			?>


			<div class="settings_main_info">
				<div class="settings_main_info--img">

					<label class="settings_main_photo">
						<div class="inner_img">
							<?php if ( $photo ) : ?>
								<?php echo wp_get_attachment_image( $photo, 'full' ); ?>
							<?php endif; ?>
						</div>
						<input type="file" accept="image/*" name="settings_main_photo" id="settings_main_photo">
					</label>
				</div>

				<div class="settings_main_info--bio">
					<input class="name" name="firs_last_name" type="text" id="firs_last_name"
						   value="<?php the_author_meta( 'first_name', $current_user->ID ); ?> <?php the_author_meta( 'last_name', $current_user->ID ); ?> "/>
					<input class="job_position" name="job_position" type="text" id="job_position"
						   value="<?php echo $job_position; ?>"
						   placeholder="<?php _e( 'Enter Job Position', '_it_start' ); ?>"/>
				</div>
			</div>

			<div class="settings_main__grid">
				<div class="col col-1">
					<label>
						<span><?php _e( 'EXPERIENCE', '_it_start' ); ?></span>
						<input class="experience" name="experience" type="text" id="experience"
							   value="<?php the_author_meta( 'experience', $current_user->ID ); ?>"/>
					</label>
					<label>
						<span><?php _e( 'LANGUAGES', '_it_start' ); ?></span>
						<input class="languages" name="languages" type="text" id="languages"
							   value="<?php the_author_meta( 'languages', $current_user->ID ); ?>"/>
					</label>
				</div>
				<div class="col col-2">
					<label>
						<span><?php _e( 'ABOUT', '_it_start' ); ?></span>
						<textarea name="description" id="description" rows="3"
								  cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
					</label>
				</div>
				<div class="col col-3">
					<label>
						<span><?php _e( 'Phone number', '_it_start' ); ?></span>
						<input class="phone" name="phone" type="text" id="phone"
							   value="<?php the_author_meta( 'phone', $current_user->ID ); ?>"/>
					</label>
					<label>
						<span><?php _e( 'Email', '_it_start' ); ?></span>
						<!--						<input type="email" value="alejandro@rentopiagroup.com">-->
						<input class="text-input input" name="email" type="email" id="email"
							   value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>"/>
					</label>
				</div>
			</div>

			<ul class="settings_main__socials">
				<li>
						<span>
							<svg width="36" height="35" viewBox="0 0 36 35" fill="none"
								 xmlns="http://www.w3.org/2000/svg">
								<g clip-path="url(#clip0_270_2463)">
									<path
										d="M26.7487 5.83301H9.2487C7.63787 5.83301 6.33203 7.13884 6.33203 8.74967V26.2497C6.33203 27.8605 7.63787 29.1663 9.2487 29.1663H26.7487C28.3595 29.1663 29.6654 27.8605 29.6654 26.2497V8.74967C29.6654 7.13884 28.3595 5.83301 26.7487 5.83301Z"
										fill="#2A2F38" stroke="#2A2F38" stroke-width="2.75" stroke-linecap="round"
										stroke-linejoin="round"/>
									<path d="M12.168 16.042V23.3337" stroke="white" stroke-width="2.75"
										  stroke-linecap="round"
										  stroke-linejoin="round"/>
									<path d="M12.168 11.667V11.6816" stroke="white" stroke-width="2.75"
										  stroke-linecap="round"
										  stroke-linejoin="round"/>
									<path d="M18 23.3337V16.042" stroke="white" stroke-width="2.75"
										  stroke-linecap="round"
										  stroke-linejoin="round"/>
									<path
										d="M23.8333 23.3337V18.9587C23.8333 18.1851 23.526 17.4432 22.9791 16.8963C22.4321 16.3493 21.6902 16.042 20.9167 16.042C20.1431 16.042 19.4013 16.3493 18.8543 16.8963C18.3073 17.4432 18 18.1851 18 18.9587"
										stroke="white" stroke-width="2.75" stroke-linecap="round"
										stroke-linejoin="round"/>
								</g>
								<defs>
									<clipPath id="clip0_270_2463">
										<rect width="35" height="35" fill="white" transform="translate(0.5)"/>
									</clipPath>
								</defs>
							</svg>

						</span>
					<input class="linkedin" name="linkedin" type="url" id="linkedin"
						   value="<?php the_author_meta( 'linkedin', $current_user->ID ); ?>"/>
				</li>
				<li>
						<span>
							<svg width="38" height="38" viewBox="0 0 38 38" fill="none"
								 xmlns="http://www.w3.org/2000/svg">
								<g clip-path="url(#clip0_270_2481)">
									<path
										d="M24.9062 6.33301H12.5729C9.16716 6.33301 6.40625 9.16854 6.40625 12.6663V25.333C6.40625 28.8308 9.16716 31.6663 12.5729 31.6663H24.9062C28.312 31.6663 31.0729 28.8308 31.0729 25.333V12.6663C31.0729 9.16854 28.312 6.33301 24.9062 6.33301Z"
										fill="#2A2F38"/>
									<path
										d="M18.7396 24.5413C21.7196 24.5413 24.1354 22.0603 24.1354 18.9997C24.1354 15.9391 21.7196 13.458 18.7396 13.458C15.7595 13.458 13.3438 15.9391 13.3438 18.9997C13.3438 22.0603 15.7595 24.5413 18.7396 24.5413Z"
										stroke="#FFFDFA" stroke-width="2" stroke-linecap="round"
										stroke-linejoin="round"/>
									<path d="M25.9375 10.7871V10.7905" stroke="#FFFDFA" stroke-width="3"
										  stroke-linecap="round"
										  stroke-linejoin="round"/>
								</g>
								<defs>
									<clipPath id="clip0_270_2481">
										<rect width="37" height="38" fill="white" transform="translate(0.5)"/>
									</clipPath>
								</defs>
							</svg>

						</span>
					<input class="instagram" name="instagram" type="url" id="instagram"
						   value="<?php the_author_meta( 'instagram', $current_user->ID ); ?>"/>
				</li>
				<li>
						<span>
							<svg width="38" height="38" viewBox="0 0 38 38" fill="none"
								 xmlns="http://www.w3.org/2000/svg">
								<g clip-path="url(#clip0_270_2474)">
									<path
										d="M34.8346 6.34894C33.2513 7.12478 31.6996 7.43986 30.0846 7.91644C28.3097 5.91353 25.6782 5.80269 23.1496 6.74953C20.6211 7.69636 18.9649 10.0112 19.0013 12.6664V14.2498C13.8634 14.3812 9.28755 12.041 6.33464 7.91644C6.33464 7.91644 -0.286865 19.6854 12.668 25.3331C9.70397 27.3075 6.74788 28.6391 3.16797 28.4998C8.40564 31.3545 14.1136 32.3362 19.0551 30.9017C24.7235 29.255 29.3816 25.0069 31.1692 18.6435C31.7025 16.7082 31.9672 14.7087 31.9561 12.7013C31.953 12.307 34.347 8.31228 34.8346 6.34736V6.34894Z"
										fill="#2A2F38"/>
								</g>
								<defs>
									<clipPath id="clip0_270_2474">
										<rect width="38" height="38" fill="white"/>
									</clipPath>
								</defs>
							</svg>

						</span>
					<input class="twitter" name="twitter" type="url" id="twitter"
						   value="<?php the_author_meta( 'twitter', $current_user->ID ); ?>"/>
				</li>
				<li>
						<span>
							<svg width="38" height="38" viewBox="0 0 38 38" fill="none"
								 xmlns="http://www.w3.org/2000/svg">
								<g clip-path="url(#clip0_270_2490)">
									<path
										d="M11.082 16.2431V22.3581H15.3021V33.0592H20.9288V22.3581H25.1488L26.5555 16.2431H20.9288V13.1857C20.9288 12.7802 21.077 12.3914 21.3408 12.1047C21.6046 11.818 21.9624 11.6569 22.3355 11.6569H26.5555V5.54199H22.3355C20.4701 5.54199 18.6811 6.34731 17.3621 7.78077C16.0431 9.21424 15.3021 11.1584 15.3021 13.1857V16.2431H11.082Z"
										fill="#2A2F38"/>
								</g>
								<defs>
									<clipPath id="clip0_270_2490">
										<rect width="38" height="38" fill="white"/>
									</clipPath>
								</defs>
							</svg>

						</span>
					<input class="facebook" name="facebook" type="url" id="facebook"
						   value="<?php the_author_meta( 'facebook', $current_user->ID ); ?>"/>
				</li>
			</ul>

			<div class="settings_main__footer">
				<label>
					<span><?php _e( 'User', '_it_start' ); ?></span>
					<input class="name" name="nickname" type="text" id="nickname"
						   value="<?php the_author_meta( 'nickname', $current_user->ID ); ?>"/>
				</label>
				<label>
					<span><?php _e( 'Password', '_it_start' ); ?></span>
					<input class="text-input" name="pass1" type="password" id="pass1" placeholder="********"/>
				</label>
				<label>
					<span><?php _e( 'Repeat Password', '_it_start' ); ?></span>
					<input class="text-input" name="pass2" type="password" id="pass2" placeholder="********"/>
				</label>
				<?php if ( $admin_user->roles[0] === 'administrator' && $_GET['user_id'] ) { ?>
					<label>
						<span><?php _e( 'Status', '_it_start' ); ?></span>
						<select name="status" id="" class="select2_select">
							<option
								value="publish" <?php echo $current_user->roles[0] == 'agent' ? 'selected' : ''; ?>><?php _e( 'Active', '_it_start' ); ?></option>
							<option
								value="pending" <?php echo $current_user->roles[0] == 'pending' ? 'selected' : ''; ?>><?php _e( 'Pending', '_it_start' ); ?></option>
							<option
								value="nonactive" <?php echo $current_user->roles[0] == 'nonactive' ? 'selected' : ''; ?>><?php _e( 'Non-Active', '_it_start' ); ?></option>
						</select>
					</label>
				<?php } ?>
			</div>


			<input type="hidden" name="first-name" id="first-name"
				   value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>">
			<input type="hidden" name="last-name" id="last-name"
				   value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>">

			<p class="form-submit text-right mt-4">
				<!--										--><?php //echo $referer; ?>
				<input name="updateuser" type="submit" id="updateuser" class="submit button"
					   value="<?php _e( 'Save', '_it_start' ); ?>"/>
				<?php wp_nonce_field( 'update-user' ) ?>
				<input name="action" type="hidden" id="action" value="update-user"/>
			</p>
		</form>

	<?php endwhile; ?>
	<?php else: ?>
		<p class="no-data">
			<?php _e( 'Sorry, no page matched your criteria.', 'profile' ); ?>
		</p><!-- .no-data -->
	<?php endif; ?>

<?php else : ?>
	<div class="admin_error404">
		<?php get_template_part( 'template-parts/components/404' ); ?>
	</div>
<?php endif; ?>
	</div>
	</div>

<?php
if ( is_user_logged_in() && ( in_array( 'manager', (array) $admin_user->roles ) || in_array( 'agent', (array) $admin_user->roles ) || in_array( 'administrator', (array) $admin_user->roles ) ) ) :
	get_footer( 'admin' );
else:
	get_footer();
endif;
