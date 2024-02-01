<?php
/**
 * Editor modification
 *
 * @link https://codex.wordpress.org/TinyMCE_Custom_Styles
 *
 * @package _it_start
 */

/**
 * Registers an editor stylesheet for the theme.
 */
add_action( 'admin_init', 'it_wpdocs_theme_add_editor_styles' );
function it_wpdocs_theme_add_editor_styles() {
	add_editor_style( IT_CSS . 'editor-styles.css' );
}

// Add TinyMCE style formats.
add_filter( 'mce_buttons_2', 'it_tiny_mce_style_formats' );
function it_tiny_mce_style_formats( $styles ) {
	array_unshift( $styles, 'styleselect' );

	return $styles;
}

add_filter( 'tiny_mce_before_init', 'it_tiny_mce_before_init_formats' );
function it_tiny_mce_before_init_formats( $settings ) {

	// Define the style_formats array
	$style_formats = [
		[
			'title' => 'Titles',
			'items' => [
				[
					'title'    => 'H1 - 64px',
					'selector' => 'p,h1,h2,h3,h4,h5,h6,li,ol,ul',
					'classes'  => 'h1',
				],
				[
					'title'    => 'H2 - 48px',
					'selector' => 'p,h1,h2,h3,h4,h5,h6,li,ol,ul',
					'classes'  => 'h2',
				],
				[
					'title'    => 'H3 - 42px',
					'selector' => 'p,h1,h2,h3,h4,h5,h6,li,ol,ul',
					'classes'  => 'h3',
				],
				[
					'title'    => 'H4 - 32px',
					'selector' => 'p,h1,h2,h3,h4,h5,h6,li,ol,ul',
					'classes'  => 'h4',
				],
				[
					'title'    => 'H5 - 24px',
					'selector' => 'p,h1,h2,h3,h4,h5,h6,li,ol,ul',
					'classes'  => 'h5',
				],
				[
					'title'    => 'H6 - 18px',
					'selector' => 'p,h1,h2,h3,h4,h5,h6,li,ol,ul',
					'classes'  => 'h6',
				],
			]
		],
		[
			'title' => 'Text',
			'items' => [
				[
					'title'    => 'Text sm - 12px',
					'selector' => 'p,h1,h2,h3,h4,h5,h6,li,ol,ul',
					'classes'  => 'text-sm',
				],
				[
					'title'    => 'Text default - 16px',
					'selector' => 'p,h1,h2,h3,h4,h5,h6,li,ol,ul',
					'classes'  => 'text-sm',
				],
				[
					'title'    => 'Text md - 18px',
					'selector' => 'p,h1,h2,h3,h4,h5,h6,li,ol,ul',
					'classes'  => 'text-sm',
				],
				[
					'title'    => 'Text lg - 22px',
					'selector' => 'p,h1,h2,h3,h4,h5,h6,li,ol,ul',
					'classes'  => 'text-lg',
				],
				[
					'title'    => 'Text xl - 24px',
					'selector' => 'p,h1,h2,h3,h4,h5,h6,li,ol,ul',
					'classes'  => 'text-xl',
				],
			],
		],
		[
			'title' => 'Buttons',
			'items' => [
				[
					'title'    => 'Button (primary lg)',
					'selector' => 'a',
					'classes'  => 'btn',
					'wrapper'  => false,
				],
				[
					'title'    => 'Button (primary md)',
					'selector' => 'a',
					'classes'  => 'btn btn-md',
					'wrapper'  => false,
				],
				[
					'title'    => 'Button (outline)',
					'selector' => 'a',
					'classes'  => 'btn btn-outline',
					'wrapper'  => false,
				],
				[
					'title'    => 'Button Group',
					'classes'  => 'btn-group', // custom admin styles for this class added in editor-style.scss
					'selector' => 'p',
				],
			]
		],
		[
			'title' => 'Lists',
			'items' => [
				[
					'title'    => 'List (checked)',
					'classes'  => 'list-check',
					'selector' => 'ul',
					'wrapper'  => false,
				],
				[
					'title'    => 'List (dotted)',
					'classes'  => 'list-dot',
					'selector' => 'ul',
					'wrapper'  => false,
				],
				[
					'title'    => 'List (numbered)',
					'classes'  => 'list-number',
					'selector' => 'ol',
					'wrapper'  => false,
				],
			]
		],
	];

	if ( isset( $settings['style_formats'] ) ) {
		$orig_style_formats = json_decode( $settings['style_formats'], true );
		$style_formats      = array_merge( $orig_style_formats, $style_formats );
	}

	$settings['style_formats'] = json_encode( $style_formats );

	return $settings;
}

/**
 * Add custom colors to TinyMCE editor text color selector
 */
add_filter( 'tiny_mce_before_init', 'it_tiny_mce_before_init_colors' );
function it_tiny_mce_before_init_colors( $init ) {
	// By using the same array keys as the default values you'll override (replace) them
	$custom_colors = [
		'Black'   => '000',
		'White'   => 'fff',
		'Primary' => '01ccad',
		'Grey'    => '9f9a93',
		'Dark' => '2a2f38',
	];

	$textcolor_map = [];
	foreach ( $custom_colors as $name => $color ) {
		$textcolor_map[] = "\"$color\", \"$name\"";
	}

	if ( ! empty( $textcolor_map ) ) {
		$init['textcolor_map']  = '[' . implode( ', ', $textcolor_map ) . ']';
		$init['textcolor_rows'] = 6; // expand color grid to 6 rows
	}

	return $init;
}
