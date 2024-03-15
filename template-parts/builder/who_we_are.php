<?php
$classes       = 'who_we_are';
$margin_top    = get_sub_field( 'margin_top' );
$margin_bottom = get_sub_field( 'margin_bottom' );
$title         = get_sub_field( 'title' );
$content       = get_sub_field( 'content' );
$right_content = get_sub_field( 'right_content' );
$button        = get_sub_field( 'button' );

$classes .= $margin_top ? ' mt-' . $margin_top : '';
$classes .= $margin_bottom ? ' mb-' . $margin_bottom : '';
?>
<section class="<?php echo esc_attr( $classes ); ?>">
	<div class="container">
		<?php if ( $title ): ?>
			<h3 class="who_we_are--title text-center">
				<?php echo $title; ?>
			</h3>
		<?php endif; ?>

		<?php if ( have_rows( 'numbers' ) ) : ?>
			<div class="who_we_are__features">
				<?php while ( have_rows( 'numbers' ) ) : the_row();
					$icon  = get_sub_field( 'icon' );
					$title = get_sub_field( 'title' );
					$text  = get_sub_field( 'text' );
					?>
					<div class="who_we_are__features--item">
						<?php if ( $icon ) : ?>
							<?php echo wp_get_attachment_image( $icon, 'full' ); ?>
						<?php endif; ?>
						<?php if ( $title ): ?>
							<span class="title">
								<?php echo $title; ?>
							</span>
						<?php endif; ?>
						<?php if ( $text ): ?>
							<span class="text">
								<?php echo $text; ?>
							</span>
						<?php endif; ?>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>

		<div class="who_we_are--content">
			<?php if ( $content ): ?>
				<div class="left_content">
					<?php echo $content; ?>
				</div>
			<?php endif; ?>
			<div class="right_content">
				<?php echo $right_content; ?>
				<?php if ( $button ) : ?>
					<div class="text-center mt-4 mt-lg-5 pt-lg-1">
						<a href="<?php echo esc_url( $button['url'] ); ?>" class="btn"
						   target="<?php echo esc_attr( $button['target'] ); ?>"><?php echo esc_html( $button['title'] ); ?></a>
					</div>
				<?php endif; ?>
			</div>
		</div>

	</div>
</section>
