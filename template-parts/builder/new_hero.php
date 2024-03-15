<?php
$classes = 'new_hero_section ';

//$margin_top    = get_sub_field( 'margin_top' );
//$margin_bottom = get_sub_field( 'margin_bottom' );
$background = get_sub_field( 'background' );
$content    = get_sub_field( 'content' );

?>
<?php if ( $content || $background ) : ?>
	<section class="<?php echo esc_attr( $classes ); ?>">

		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<div class="editor">
						<div class="text-xl text-center text-sm-left">
							<?php echo $content; ?>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php if ( $background ) : ?>
			<div class="new_hero_section--bg">
				<?php echo wp_get_attachment_image( $background, 'full' ); ?>
			</div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/builder/components/search_banner_form' ); ?>


	</section>
<?php endif; ?>
