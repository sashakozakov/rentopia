<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @package _it_start
 */
if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function it_widgets_init() {
	register_sidebar( [
		'name'          => esc_html__( 'Footer 1', '_it_start' ),
		'id'            => 'footer-1',
		'description'   => esc_html__( 'Add widgets here.', '_it_start' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	] );
	register_sidebar( [
		'name'          => esc_html__( 'Footer 2', '_it_start' ),
		'id'            => 'footer-2',
		'description'   => esc_html__( 'Add widgets here.', '_it_start' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	] );
	register_sidebar( [
		'name'          => esc_html__( 'Footer 3', '_it_start' ),
		'id'            => 'footer-3',
		'description'   => esc_html__( 'Add widgets here.', '_it_start' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	] );

	if ( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
		register_sidebar( array(
			'name'          => esc_html__( 'Language switcher', '_it_start' ),
			'id'            => 'language-switcher',
			'description'   => esc_html__( 'Language switcher widget area', '_it_start' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}

add_action( 'widgets_init', 'it_widgets_init' );
