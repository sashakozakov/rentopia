<?php
$classes       = 'module_team';
$margin_top    = get_sub_field( 'margin_top' );
$margin_bottom = get_sub_field( 'margin_bottom' );
$text          = get_sub_field( 'text' );

if ( $margin_top ) {
	$classes .= ' mt-' . $margin_top;
}
if ( $margin_bottom ) {
	$classes .= ' mb-' . $margin_bottom;
}
?>
<section class="<?php echo esc_attr( $classes ); ?>">
	<div class="container">
		<?php $top_managers = get_sub_field( 'top_managers' ); ?>
		<?php if ( $top_managers ) : ?>
			<div class="row justify-content-center team_members__grid">
			<?php
			$i = 1;
			foreach ( $top_managers as $post ) : ?>
				<?php setup_postdata( $post );
				$experience = get_field( 'experience' );
				$languages  = get_field( 'languages' );
				$email      = get_field( 'email' );
				$phone      = get_field( 'phone' );
				?>
				<div class="col-md-4 col-sm-6">
					<div class="team_member">
						<a href="<?php echo $post->ID; ?>" class="team_member--link">
							<div class="team_member--img">
								<div>
									<?php the_post_thumbnail(); ?>
								</div>
							</div>
							<div class="team_member--caption text-center">
								<h5><?php the_title(); ?></h5>
								<p class="text-uppercase">
									<?php
									$terms = wp_get_post_terms( get_the_ID(), 'job_position' );

									if ( ! empty( $terms ) ) {
										$term = esc_html( $terms[0]->name );
										echo $term;
									}

									?>
								</p>
							</div>
						</a>

						<div class="hidden_content text-left">
							<div class="info_content">
								<span class="info_title"><?php _e( 'About', '_it_start' ); ?> </span>
								<?php the_content(); ?>

								<?php if ( $languages ): ?>
									<div class="pt-lg-5 pt-3">
										<span class="info_title"><?php _e( 'LANGUAGES', '_it_start' ); ?></span>
										<p>
											<?php echo $languages; ?>
										</p>
									</div>
								<?php endif; ?>
								<?php if ( $experience ): ?>
									<div class="pb-2 pt-3">
										<span class="info_title"><?php _e( 'EXPERIENCE', '_it_start' ); ?></span>
										<p>
											<?php echo $experience; ?>
										</p>
									</div>
								<?php endif; ?>

								<?php if ( $phone || $email ): ?>
									<div class="contact_row pt-2">
										<span class="info_title"><?php _e( 'Contact', '_it_start' ); ?></span>
										<?php if ( $phone ): ?>
											<p class="mb-1">
												<a href="tel:<?php echo it_phone_cleaner( $phone ); ?>">
													<?php echo $phone; ?>
												</a>
											</p>
										<?php endif; ?>
										<?php if ( $email ): ?>
											<p class="mb-1">
												<a href="mailto:<?php echo $email; ?>">
													<?php echo $email; ?>
												</a>
											</p>
										<?php endif; ?>
									</div>
								<?php endif; ?>


								<?php if ( have_rows( 'socials' ) ) : ?>
									<hr>
									<div class="row mt-2 pt-1">
										<div class="col-12 d-flex flex-wrap align-items-center socials">
											<?php while ( have_rows( 'socials' ) ) : the_row();
												$name = get_sub_field( 'social_network' );
												?>
												<a href="<?php the_sub_field( 'url' ); ?>" rel="nofollow"
												   target="_blank"
												   class="social_link social_link--<?php echo esc_attr( $name ); ?>">
													<svg class="icon-<?php echo esc_attr( $name ); ?>">
														<use xlink:href="#<?php echo esc_attr( $name ); ?>"></use>
													</svg>
												</a>
											<?php endwhile; ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>

				<?php if ( $i % 3 == 0 ) { ?>
					</div><div class="row justify-content-center team_members__grid">
				<?php } ?>
				<?php $i ++; endforeach; ?>
			<?php wp_reset_postdata(); ?>


			<div class="row team_members__popup visible-sm-up" id="team_members__popup">
				<div class="col-12">
					<?php
					$i = 1;
					foreach ( $top_managers as $post ) : ?>
						<?php setup_postdata( $post ); ?>
						<div class="team_member__info" id="<?php echo $post->ID; ?>">
							<div class="team_member__info--nav">
								<div class="prev_btn">
									<svg width="15" height="26" viewBox="0 0 15 26" fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<path d="M13.9272 25L1.00016 13L13.9272 1" stroke="#2A2F38" stroke-width="2"
											  stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
								<div class="next_btn">
									<svg width="15" height="26" viewBox="0 0 15 26" fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<path d="M1.00146 25L13.9285 13L1.00146 1" stroke="#2A2F38" stroke-width="2"
											  stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
								<div class="close_btn">
									<svg width="27" height="26" viewBox="0 0 27 26" fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<path d="M1.00146 1L25.0015 25M25.0015 1L1.00146 25" stroke="#2A2F38"
											  stroke-width="2"
											  stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="info_thumbnail">
										<?php the_post_thumbnail(); ?>
									</div>
								</div>
								<div class="col-md-6">
									<div class="info_content text-md">
										<h4 class="team_member__info--title"><?php the_title(); ?></h4>
										<span
											class="info_title">
											<?php _e( 'About', '_it_start' ); ?>
											<?php the_title(); ?></span>
										<?php the_content(); ?>

										<div class="row pb-2 pt-lg-5 pt-3">
											<div class="col-lg-7 col-md-6">
												<span
													class="info_title"><?php _e( 'EXPERIENCE', '_it_start' ); ?></span>
												<p>
													<?php the_field( 'experience' ); ?>
												</p>
											</div>
											<div class="col-lg-5 col-md-6">
												<span class="info_title"><?php _e( 'LANGUAGES', '_it_start' ); ?></span>
												<p>
													<?php the_field( 'languages' ); ?>
												</p>
											</div>
										</div>

										<hr>

										<div class="row contact_row pt-2">
											<div class="col-12">
												<span class="info_title"><?php _e( 'Contact', '_it_start' ); ?></span>
											</div>
											<div class="col-md-5">
												<p>
													<a href="tel:<?php the_field( 'phone' ); ?>">
														<?php the_field( 'phone' ); ?>
													</a>
												</p>
											</div>
											<div class="col-md-7">
												<p>
													<a href="mailto:<?php the_field( 'email' ); ?>">
														<?php the_field( 'email' ); ?>
													</a>
												</p>
											</div>
										</div>
										<?php if ( have_rows( 'socials' ) ) : ?>
											<div class="row mt-4 pt-3">
												<div class="col-12 d-flex flex-wrap align-items-center socials">
													<?php while ( have_rows( 'socials' ) ) : the_row();
														$name = get_sub_field( 'social_network' );
														?>
														<a href="<?php the_sub_field( 'url' ); ?>" rel="nofollow"
														   target="_blank"
														   class="social_link social_link--<?php echo esc_attr( $name ); ?>">
															<svg class="icon-<?php echo esc_attr( $name ); ?>">
																<use
																	xlink:href="#<?php echo esc_attr( $name ); ?>"></use>
															</svg>
														</a>
													<?php endwhile; ?>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>

						<?php
						/*
						if ($i % 3 == 0) { ?>
				</div>
				<div class="row justify-content-center team_members__grid">
						<?php } */ ?>
						<?php $i ++;
					endforeach; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>
			</div>

		<?php endif; ?>


		<?php $other_employees = get_sub_field( 'other_employees' ); ?>
		<?php if ( $other_employees ) : ?>
		<div class="row justify-content-center team_members__grid">
			<?php
			$i = 1;
			foreach ( $other_employees

			as $post ) : ?>
			<?php setup_postdata( $post );
			$experience = get_field( 'experience' );
			$languages  = get_field( 'languages' );
			$email      = get_field( 'email' );
			$phone      = get_field( 'phone' );
			?>
			<div class="col-md-4 col-sm-6">
				<div class="team_member">
					<a href="<?php echo $post->ID; ?>" class="team_member--link">
						<div class="team_member--img">
							<div>
								<?php the_post_thumbnail(); ?>
							</div>
						</div>
						<div class="team_member--caption text-center">
							<h5><?php the_title(); ?></h5>
							<p class="text-uppercase">
								<?php
								$terms = wp_get_post_terms( get_the_ID(), 'job_position' );

								if ( ! empty( $terms ) ) {
									$term = esc_html( $terms[0]->name );
									echo $term;
								}

								?>
							</p>
						</div>
					</a>

					<div class="hidden_content text-left">
						<div class="info_content">
							<span class="info_title"><?php _e( 'About', '_it_start' ); ?> </span>
							<?php the_content(); ?>

							<?php if ( $languages ): ?>
								<div class="pt-lg-5 pt-3">
									<span class="info_title"><?php _e( 'LANGUAGES', '_it_start' ); ?></span>
									<p>
										<?php echo $languages; ?>
									</p>
								</div>
							<?php endif; ?>
							<?php if ( $experience ): ?>
								<div class="pb-2 pt-3">
									<span class="info_title"><?php _e( 'EXPERIENCE', '_it_start' ); ?></span>
									<p>
										<?php echo $experience; ?>
									</p>
								</div>
							<?php endif; ?>

							<?php if ( $phone || $email ): ?>
								<div class="contact_row pt-2">
									<span class="info_title"><?php _e( 'Contact', '_it_start' ); ?></span>
									<?php if ( $phone ): ?>
										<p class="mb-1">
											<a href="tel:<?php echo it_phone_cleaner( $phone ); ?>">
												<?php echo $phone; ?>
											</a>
										</p>
									<?php endif; ?>
									<?php if ( $email ): ?>
										<p class="mb-1">
											<a href="mailto:<?php echo $email; ?>">
												<?php echo $email; ?>
											</a>
										</p>
									<?php endif; ?>
								</div>
							<?php endif; ?>


							<?php if ( have_rows( 'socials' ) ) : ?>
								<hr>
								<div class="row mt-2 pt-1">
									<div class="col-12 d-flex flex-wrap align-items-center socials">
										<?php while ( have_rows( 'socials' ) ) : the_row();
											$name = get_sub_field( 'social_network' );
											?>
											<a href="<?php the_sub_field( 'url' ); ?>" rel="nofollow"
											   target="_blank"
											   class="social_link social_link--<?php echo esc_attr( $name ); ?>">
												<svg class="icon-<?php echo esc_attr( $name ); ?>">
													<use xlink:href="#<?php echo esc_attr( $name ); ?>"></use>
												</svg>
											</a>
										<?php endwhile; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>

				</div>
			</div>

			<?php if ( $i % 3 == 0 ) { ?>
		</div>
		<div class="row justify-content-center team_members__info_grid">
			<?php } ?>
			<?php $i ++;
			endforeach; ?>
			<?php wp_reset_postdata(); ?>


			<div class="row team_members__popup visible-sm-up" id="team_members__popup">
				<div class="col-12">
					<?php
					$i = 1;
					foreach ( $other_employees as $post ) : ?>
						<?php setup_postdata( $post );
						$languages  = get_field( 'languages' );
						$experience = get_field( 'experience' );
						$phone      = get_field( 'phone' );
						$email      = get_field( 'email' );
						?>
						<div class="team_member__info" id="<?php echo $post->ID; ?>">
							<div class="team_member__info--nav">
								<div class="prev_btn">
									<svg width="15" height="26" viewBox="0 0 15 26" fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<path d="M13.9272 25L1.00016 13L13.9272 1" stroke="#2A2F38" stroke-width="2"
											  stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
								<div class="next_btn">
									<svg width="15" height="26" viewBox="0 0 15 26" fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<path d="M1.00146 25L13.9285 13L1.00146 1" stroke="#2A2F38" stroke-width="2"
											  stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
								<div class="close_btn">
									<svg width="27" height="26" viewBox="0 0 27 26" fill="none"
										 xmlns="http://www.w3.org/2000/svg">
										<path d="M1.00146 1L25.0015 25M25.0015 1L1.00146 25" stroke="#2A2F38"
											  stroke-width="2"
											  stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="info_thumbnail">
										<?php the_post_thumbnail(); ?>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="info_content text-md">
										<h4 class="team_member__info--title"><?php the_title(); ?></h4>
										<span class="info_title">
											<?php _e( 'About', '_it_start' ); ?>
											<?php the_title(); ?>
										</span>
										<?php the_content(); ?>

										<div class="row pb-2 pt-lg-5 pt-3">
											<?php if ( $experience ): ?>
												<div class="col-lg-7 col-md-6">
													<span
														class="info_title"><?php _e( 'EXPERIENCE', '_it_start' ); ?></span>
													<p>
														<?php echo $experience; ?>
													</p>
												</div>
											<?php endif; ?>
											<?php if ( $languages ): ?>
												<div class="col-lg-5 col-md-6">
													<span
														class="info_title"><?php _e( 'LANGUAGES', '_it_start' ); ?></span>
													<p>
														<?php echo $languages; ?>
													</p>
												</div>
											<?php endif; ?>
										</div>

										<hr>

										<div class="row contact_row pt-2">
											<div class="col-12">
												<span class="info_title"><?php _e( 'Contact', '_it_start' ); ?></span>
											</div>
											<?php if ( $phone ): ?>
												<div class="col-md-5">
													<p>
														<a href="tel:<?php echo it_phone_cleaner( $phone ); ?>">
															<?php echo $phone; ?>
														</a>
													</p>
												</div>
											<?php endif; ?>
											<?php if ( $email ): ?>
												<div class="col-md-7">
													<p>
														<a href="mailto:<?php echo $email; ?>">
															<?php echo $email; ?>
														</a>
													</p>
												</div>
											<?php endif; ?>
										</div>
										<?php if ( have_rows( 'socials' ) ) : ?>
											<div class="row mt-4 pt-3">
												<div class="col-12 d-flex flex-wrap align-items-center socials">
													<?php while ( have_rows( 'socials' ) ) : the_row();
														$name = get_sub_field( 'social_network' );
														?>
														<a href="<?php the_sub_field( 'url' ); ?>" rel="nofollow"
														   target="_blank"
														   class="social_link social_link--<?php echo esc_attr( $name ); ?>">
															<svg class="icon-<?php echo esc_attr( $name ); ?>">
																<use
																	xlink:href="#<?php echo esc_attr( $name ); ?>"></use>
															</svg>
														</a>
													<?php endwhile; ?>
												</div>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>

						<?php
						/*
						if ($i % 3 == 0) { ?>
				</div>
				<div class="row justify-content-center team_members__grid">
						<?php } */ ?>
						<?php $i ++;
					endforeach; ?>
					<?php wp_reset_postdata(); ?>
				</div>
			</div>


			<?php endif; ?>
		</div>
</section>
