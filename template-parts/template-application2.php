<?php /* Template Name: Submit An Application2 */

get_header();
the_post();
?>

	<section class="submit_application_section">
		<svg class="svg submit_application_section_svg_1" width="437" height="387" viewBox="0 0 437 387" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<path opacity="0.4" d="M-95.6142 84.6635L238.613 2.36512L431.16 7.53031L32.7719 382.713L-95.6142 84.6635Z"
				  stroke="#01CCAD" stroke-width="4"/>
		</svg>
		<svg class="svg submit_application_section_svg_2" width="315" height="455" viewBox="0 0 315 455" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<path opacity="0.4" d="M555.168 304.488L210.326 433.427L5.13412 451.853L381.762 3.80274L555.168 304.488Z"
				  stroke="#2A2F38" stroke-width="4"/>
		</svg>
		<svg class="svg submit_application_section_svg_3" width="289" height="258" viewBox="0 0 289 258" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<path d="M61.1629 2.5485L254.899 266.834L285.806 422.333L-370.438 124.42L61.1629 2.5485Z" stroke="#F87B53"
				  stroke-width="4"/>
		</svg>


		<div class="container">
			<div class="text-center submit_application_section--header text-lg">
				<h1 class="h2 mb-2">
					<?php the_title(); ?>
				</h1>
				<?php the_content(); ?>
			</div>
		</div>

		<div class="container applications_blocks">
			<div class="row">
				<?php if ( have_rows( 'left_column' ) ) : ?>
					<?php while ( have_rows( 'left_column' ) ) : the_row();
						$icon = get_sub_field( 'icon' );
						?>
						<div class="col-md-6">
							<div class="application_block">
								<div class="application_block--inner">
									<?php if ( $icon ) : ?>
										<div class="application_block--img">
											<img src="<?php echo esc_url( $icon['url'] ); ?>"
												 alt="<?php echo esc_attr( $icon['alt'] ); ?>"/>
										</div>
									<?php endif; ?>

									<?php the_sub_field( 'content' ); ?>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>

				<?php if ( have_rows( 'right_column' ) ) : ?>
					<?php while ( have_rows( 'right_column' ) ) : the_row();
						$icon = get_sub_field( 'icon' );
						?>
						<div class="col-md-6">
							<div class="application_block">
								<div class="application_block--inner">
									<?php if ( $icon ) : ?>
										<div class="application_block--img">
											<img src="<?php echo esc_url( $icon['url'] ); ?>"
												 alt="<?php echo esc_attr( $icon['alt'] ); ?>"/>
										</div>
									<?php endif; ?>

									<?php the_sub_field( 'content' ); ?>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
			</div>
		</div>
	</section>

<?php
get_footer();

