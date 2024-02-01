<?php
$classes       = 'module_test';
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

	</div>
</section>
