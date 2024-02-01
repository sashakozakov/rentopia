<?php /* Template Name: Add Agent */

$user = wp_get_current_user();
if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) :
	get_header( 'admin' );
else:
	get_header();
endif;
the_post();

?>
<?php if ( have_posts() ) :
	while ( have_posts() ) : the_post(); ?>

	<?php endwhile; ?>
<?php endif; ?>

<?php


if ( is_user_logged_in() && ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) ) : ?>

	<div class="mt-5 pt-5">
		<div class="container mt-md-4 pt-md-2">
			<?php
			// TODO: show Success message

			/* Get user info. */
			global $current_user, $wp_roles;
			get_currentuserinfo();

			$errors = [];

			if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {
				if ( isset( $_POST['adduser'] ) ) {
					$fname        = sanitize_text_field( $_POST['first-name'] );
					$lname        = sanitize_text_field( $_POST['last-name'] );
					$description  = sanitize_text_field( $_POST['description'] );
					$job_position = sanitize_text_field( $_POST['job_position'] );
					$experience   = sanitize_text_field( $_POST['experience'] );
					$languages    = sanitize_text_field( $_POST['languages'] );
					$phone        = sanitize_text_field( $_POST['phone'] );
					$mail         = filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL );
					$linkedin     = sanitize_text_field( $_POST['linkedin'] );
					$instagram    = sanitize_text_field( $_POST['instagram'] );
					$twitter      = sanitize_text_field( $_POST['twitter'] );
					$facebook     = sanitize_text_field( $_POST['facebook'] );
					$nickname     = sanitize_text_field( $_POST['nickname'] );

					$pass1 = $_POST['pass1'];
					$pass2 = $_POST['pass2'];


					if ( $fname & $nickname && $pass1 && $pass2 && $mail ) {
						if ( $pass1 == $pass2 ) {
							$full_name = trim( $fname . ' ' . $lname );
							$username  = sanitize_title( $full_name );

							$user_data = array(
								'user_login' => sanitize_title( $full_name ),
								'user_pass'  => $pass1,
								'user_email' => $mail,
								'first_name' => $fname,
								'last_name'  => $lname,
								'nickname'   => $nickname,
								'role'       => 'agent'
							);

							$user_id = wp_insert_user( $user_data );

							$to      = $mail;
							$subject = 'New Password from ' . home_url();
							$body    = 'Dear: ' . $full_name . "\r\n";
							$body    .= 'Your username: ' . $username . "\r\n";
							$body    .= 'Your new password: ' . $pass1 . "\r\n";

							$headers = 'From: your_email@t0h.4d1.myftpupload.com' . "\r\n" .
									   'Reply-To: your_email@t0h.4d1.myftpupload.com' . "\r\n" .
									   'X-Mailer: PHP/' . phpversion();

							if ( wp_mail( $to, $subject, $body, $headers ) ) { ?>
								<div class="edit_listing_form_msg active">
									<?php echo sprintf( '<span>Email to <strong>%1$s</strong> sent successfully.</span>', $mail ); ?>
								</div>
							<?php } else {
								echo 'Error: Unable to send email.';
							}
							// end send email


// TODO: open images from wp mdeia
							require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
							require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
							require_once( ABSPATH . "wp-admin" . '/includes/media.php' );

							$photo = $_FILES['settings_main_photo'];
							$file  = array(
								'name'     => sanitize_file_name( $photo['name'] ),
								'type'     => $photo['type'],
								'tmp_name' => $photo['tmp_name'],
								'error'    => $photo['error'],
								'size'     => $photo['size']
							);

							$attachment_id = media_handle_sideload( $file, $user_id );
							$update_result = update_field( 'photo', $attachment_id, 'user_' . $user_id );


							if ( ! is_wp_error( $user_id ) ) {

								update_user_meta( $user_id, 'job_position', $job_position );
								update_user_meta( $user_id, 'experience', $experience );
								update_user_meta( $user_id, 'languages', $languages );
								update_user_meta( $user_id, 'description', $description );
								update_user_meta( $user_id, 'phone', $phone );
								update_user_meta( $user_id, 'linkedin', $linkedin );
								update_user_meta( $user_id, 'instagram', $instagram );
								update_user_meta( $user_id, 'twitter', $twitter );
								update_user_meta( $user_id, 'facebook', $facebook );

							} else {
								$errors[] = $user_id->get_error_message();
							}
						} else {
							$errors[] = 'Your passwords did not match.';
						}
					} else {
						$errors[] = 'Invalid input. Please fill in all the required fields.';
					}
				}
			}

			if ( ! empty( $errors ) ) {
				echo '<div class="messages">';
				foreach ( $errors as $error ) {
					echo '<p>' . esc_html( $error ) . '</p>';
				}
				echo '</div>';
			}


			if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php if ( ! is_user_logged_in() ) : ?>
					<p class="warning">
						<?php _e( 'You must be logged in to edit your profile.', 'profile' ); ?>
					</p><!-- .warning -->
				<?php else : ?>
					<?php
//		if ( $_POST['updated'] == 'true' ) : ?><!-- <p>Your profile has been updated</p> --><?php //endif; ?>
					<?php if ( count( $errors ) > 0 ) {
						echo '<p class="error">' . implode( "<br />", $errors ) . '</p>';
					} ?>

					<form method="post" id="update_profile_info" class="settings_main" enctype="multipart/form-data"
						  action="<?php the_permalink(); ?>">

						<div class="settings_main_info">

							<div class="settings_main_info--img">

								<label class="settings_main_photo">
									<div class="inner_img">
									</div>
									<input type="file" accept="image/*" name="settings_main_photo"
										   id="settings_main_photo">
								</label>
							</div>

							<div class="settings_main_info--bio">
								<input class="name" name="firs_last_name" type="text" id="firs_last_name"
									   placeholder="<?php _e( 'Full Name', '_it_start' ); ?>"/>
								<input class="job_position" name="job_position" type="text" id="job_position"
									   placeholder="<?php _e( 'Job Description', '_it_start' ); ?>"/>
							</div>
						</div>

						<div class="settings_main__grid">
							<div class="col col-1">
								<label>
									<span><?php _e( 'EXPERIENCE', '_it_start' ); ?></span>
									<input class="experience" name="experience" type="text" id="experience"
										   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"
										   value=""/>
								</label>
								<label>
									<span><?php _e( 'LANGUAGES', '_it_start' ); ?></span>
									<input class="languages" name="languages" type="text" id="languages"
										   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"
										   value=""/>
								</label>
							</div>
							<div class="col col-2">
								<label>
									<span><?php _e( 'ABOUT', '_it_start' ); ?></span>
									<textarea name="description" id="description" rows="3"
											  placeholder="<?php _e( 'Write...', '_it_start' ); ?>"
											  cols="50"></textarea>
								</label>
							</div>
							<div class="col col-3">
								<label>
									<span><?php _e( 'Phone number', '_it_start' ); ?></span>
									<input class="phone" name="phone" type="text" id="phone"
										   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"/>
								</label>
								<label>
									<span><?php _e( 'Email', '_it_start' ); ?>*</span>
									<input class="text-input input" name="email" type="email" id="email" required
										   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"
									/>
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
									   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"
									   value=""/>
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
									   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"
									   value=""/>
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
									   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"
									   value=""/>
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
									   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"
									   value=""/>
							</li>
						</ul>

						<div class="settings_main__footer">
							<label>
								<span><?php _e( 'User', '_it_start' ); ?>*</span>
								<input class="name" name="nickname" type="text" id="nickname" id="linkedin"
									   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"
								/>
							</label>
							<label>
								<span><?php _e( 'Password*', '_it_start' ); ?></span>
								<input class="text-input" name="pass1" type="password" id="pass1"
									   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"/>
							</label>
							<label>
								<span><?php _e( 'Repeat Password*', '_it_start' ); ?></span>
								<input class="text-input" name="pass2" type="password" id="pass2"
									   placeholder="<?php _e( 'Write...', '_it_start' ); ?>"/>
							</label>
						</div>

						<input type="hidden" name="first-name" id="first-name" value="">
						<input type="hidden" name="last-name" id="last-name" value="">
						<p class="form-submit text-right mt-4">
							<input name="adduser" type="submit" id="adduser" class="submit button"
								   value="<?php _e( 'Save', '_it_start' ); ?>"/>
							<?php wp_nonce_field( 'update-user' ) ?>
							<input name="action" type="hidden" id="action" value="update-user"/>
						</p>
					</form>
				<?php endif; ?>
			<?php endwhile; ?>
			<?php else: ?>
				<p class="no-data">
					<?php _e( 'Sorry, no page matched your criteria.', '_it_start' ); ?>
				</p><!-- .no-data -->
			<?php endif; ?>
		</div>
	</div>

<?php else: ?>
	<div class="admin_error404">
		<?php get_template_part( 'template-parts/components/404' ); ?>
	</div>
<?php endif; ?>

<?php
get_footer( 'admin' );
