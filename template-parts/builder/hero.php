<?php
$classes = 'hero_section bg d-flex flex-wrap align-items-center';

$margin_top    = get_sub_field( 'margin_top' );
$margin_bottom = get_sub_field( 'margin_bottom' );
$background    = get_sub_field( 'background' );
$content       = get_sub_field( 'content' );

if ( $margin_top ) {
	$classes .= ' mt-' . $margin_top;
}
if ( $margin_bottom ) {
	$classes .= ' mb-' . $margin_bottom;
}
?>
<?php if ( $content || $background ) :	?>
	<section class="<?php echo esc_attr( $classes ); ?>" style="background-image: url(<?php echo preg_replace('/\s+/', '', $background); ?>);">
		<svg class="visible-sm-up" width="1728" height="204" viewBox="0 0 1728 204" fill="none"
			 xmlns="http://www.w3.org/2000/svg">
			<path
				d="M829.641 171C504.971 172.145 0 112.5 0 112.5V204H1728V0C1728 0 1672.71 37.0014 1630.69 57C1571.77 85.0433 1535.98 95.498 1472.69 112.5C1388.62 135.082 1339.31 141.12 1253.86 151.586L1250.48 152C1087.05 172.02 994.303 170.419 829.641 171Z"
				fill="white"/>
		</svg>

		<div class="container">
			<div class="editor color-white text-center">
				<div class="text-xl">
					<?php echo $content; ?>
				</div>
				<?php get_template_part( 'template-parts/builder/components/search_banner_form' ); ?>
			</div>
		</div>
	</section>
<?php endif; ?>
