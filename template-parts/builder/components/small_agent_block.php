<?php
$preview_user_agent = $args['preview_agent_id'];
$class              = isset( $args['class'] ) ? $args['class'] : null;
if ( $preview_user_agent ) {
	$user_agent = $preview_user_agent;
} else {
	$user_agent = get_field( 'user_agent' );
}
?>
<?php if ( $user_agent ) : ?>
	<?php
	$first_name = get_the_author_meta( 'first_name', $user_agent );
	$last_name  = get_the_author_meta( 'last_name', $user_agent );
	$phone      = get_the_author_meta( 'phone', $user_agent );
	$whatsapp   = get_the_author_meta( 'whatsapp', $user_agent );
	$email      = get_the_author_meta( 'user_email', $user_agent );
	?>
	<div class="agent_block small_block <?php echo $class; ?>">
		<div class="row">
			<div class="col-5 col-sm-6 text-center">
				<div class="agent_block__img">
					<div>
						<?php
						$user_acf_prefix  = 'user_';
						$user_id_prefixed = $user_acf_prefix . $user_agent;
						$photo            = get_field( 'photo', $user_id_prefixed );
						if ( $photo ) : ?>
							<?php echo wp_get_attachment_image( $photo, null ); ?>
						<?php else: ?>
							<?php it_image_placeholder(); ?>
						<?php endif; ?>
					</div>
				</div>
				<p class="agent_block--name">
					<?php echo $first_name; ?>
					<?php echo $last_name; ?>
				</p>
				<span class="subtitle small"><?php _e( 'Agent', '_it_start' ); ?></span>
			</div>
			<div class="col-7 col-sm-6 d-flex flex-column flex-wrap align-items-start">
				<h5>
					<?php _e( 'Contact Agent', '_it_start' ); ?>
				</h5>
				<div class="socials">
					<?php if ( $email ): ?>
						<div>
							<?php echo do_shortcode( '[email]' . $email . '[/email]' ); ?>
						</div>
					<?php endif; ?>
					<?php if ( $whatsapp ): ?>
						<div>
							<a href="https://wa.me/<?php echo it_phone_cleaner( $whatsapp ); ?>">
								<svg width="22" height="22" viewBox="0 0 22 22" fill="none"
									 xmlns="http://www.w3.org/2000/svg">
									<use xlink:href="#whatsapp"></use>
								</svg>
							</a>
						</div>
					<?php endif; ?>
					<?php if ( $phone ): ?>
						<div>
							<a href="tel:<?php echo it_phone_cleaner( $phone ); ?>">
								<svg width="22" height="23" viewBox="0 0 22 23" fill="none"
									 xmlns="http://www.w3.org/2000/svg">
									<use xlink:href="#phone"></use>
								</svg>
							</a>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $phone ): ?>
					<a href="tel:<?php echo it_phone_cleaner( $phone ); ?>" class="btn mt-auto">
						<?php _e( 'APPLY FOR RENT', '_it_start' ); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<?php wp_reset_postdata(); ?>
	</div>
<?php endif; ?>
