<?php
$preview_user_agent = $args['preview_agent_id'];
$contact_agent = get_field('contact_agent');
if ( $preview_user_agent ) {
	$user_agent = $preview_user_agent;
} else {
	$user_agent = get_field( 'user_agent' );
}
?>
<?php if ($contact_agent) : ?>
	<?php $post = $contact_agent;
	setup_postdata($post);
	$whatsapp = get_field('whatsapp');
	$phone = get_field('phone');
	$email = get_field('email');
	?>
	<div class="container big_agent_block_container">
		<div class="agent_block big_block">
			<div class="row">
				<div class="col-md-4 text-center">
					<div class="agent_block__img">
						<div>
							<?php if (has_post_thumbnail()) : ?>
								<?php the_post_thumbnail(); ?>
							<?php else: ?>
								<?php it_image_placeholder(); ?>
							<?php endif; ?>
						</div>
					</div>
					<p class="agent_block--name">
						<?php the_title(); ?>
					</p>
					<span class="subtitle"><?php _e('Agent', '_it_start'); ?></span>
				</div>
				<div class="col-md-6 d-flex flex-column flex-wrap align-items-start">
					<div class="visible-md-up">
						<h4>
							<?php _e('Contact Agent', '_it_start'); ?>
						</h4>
						<?php the_content(); ?>
					</div>
					<div class="socials">
						<?php if ($email): ?>
							<div>
								<?php echo do_shortcode('[email]' . $email . '[/email]'); ?>
							</div>
						<?php endif; ?>
						<?php if ($whatsapp): ?>
							<div>
								<a href="<?php echo it_phone_cleaner($whatsapp); ?>">
									<svg width="22" height="22" viewBox="0 0 22 22" fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<use xlink:href="#whatsapp"></use>
									</svg>
								</a>
							</div>
						<?php endif; ?>
						<?php if ($phone): ?>
							<div>
								<a href="tel:<?php echo it_phone_cleaner($phone); ?>">
									<svg width="22" height="23" viewBox="0 0 22 23" fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<use xlink:href="#phone"></use>
									</svg>
								</a>
							</div>
						<?php endif; ?>
					</div>

					<?php if ($phone): ?>
						<a href="tel:<?php echo it_phone_cleaner($phone); ?>" class="btn">
							<?php _e('APPLY FOR RENT', '_it_start'); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
<?php endif; ?>

<?php if ($user_agent) :
	$first_name = get_the_author_meta('first_name', $user_agent);
	$last_name = get_the_author_meta('last_name', $user_agent);
	$description = get_the_author_meta('description', $user_agent);
	$phone = get_the_author_meta('phone', $user_agent);
	$whatsapp = get_the_author_meta('whatsapp', $user_agent);
	$email = get_the_author_meta('user_email', $user_agent);
	?>
	<div class="container big_agent_block_container">
		<div class="agent_block big_block">
			<div class="row">
				<div class="col-md-4 text-center">
					<div class="agent_block__img">
						<div>
							<?php
							$user_acf_prefix = 'user_';
							$user_id_prefixed = $user_acf_prefix . $user_agent;
							$photo = get_field('photo', $user_id_prefixed);
							if ($photo) : ?>
								<?php echo wp_get_attachment_image($photo, null); ?>
							<?php else: ?>
								<?php it_image_placeholder(); ?>
							<?php endif; ?>
						</div>
					</div>
					<p class="agent_block--name">
						<?php echo $first_name; ?>
						<?php echo $last_name; ?>
					</p>
					<span class="subtitle"><?php _e('Agent', '_it_start'); ?></span>
				</div>
				<div class="col-md-6 d-flex flex-column flex-wrap align-items-start">
					<div class="visible-md-up">
						<h4>
							<?php _e('Contact Agent', '_it_start'); ?>
						</h4>
						<?php echo $description; ?>
					</div>
					<div class="socials">
						<?php if ($email): ?>
							<div>
								<?php echo do_shortcode('[email]' . $email . '[/email]'); ?>
							</div>
						<?php endif; ?>
						<?php if ($whatsapp): ?>
							<div>
								<a href="https://wa.me/<?php echo it_phone_cleaner($whatsapp); ?>">
									<svg width="22" height="22" viewBox="0 0 22 22" fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<use xlink:href="#whatsapp"></use>
									</svg>
								</a>
							</div>
						<?php endif; ?>
						<?php if ($phone): ?>
							<div>
								<a href="tel:<?php echo it_phone_cleaner($phone); ?>">
									<svg width="22" height="23" viewBox="0 0 22 23" fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<use xlink:href="#phone"></use>
									</svg>
								</a>
							</div>
						<?php endif; ?>
					</div>

					<?php if ($phone): ?>
						<a href="tel:<?php echo it_phone_cleaner($phone); ?>" class="btn">
							<?php _e('APPLY FOR RENT', '_it_start'); ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
<?php endif; ?>
