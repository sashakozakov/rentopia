<?php
/**
 * Functions which will be called on after_setup_theme
 *
 * @link https://developer.wordpress.org/reference/hooks/after_setup_theme/
 *
 * @package _it_start
 */

if ( ! function_exists( 'it_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function it_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on IT Starter, use a find and replace
		 * to change '_it_start' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( '_it_start', get_template_directory() . '/languages' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Register new image presets
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_image_size/
		 */
		// add_image_size('full-hd', 1920, 1080, true);     //example.

		/**
		 * This theme uses wp_nav_menu() in one location.
		 *
		 * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
		 */
		register_nav_menus( [
			'main'       => esc_html__( 'Main Nav', '_it_start' ),
			'admin_menu' => esc_html__( 'Admin Menu', '_it_start' ),
//			'footer' => esc_html__( 'Footer Nav', '_it_start' ),
		] );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		] );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

	}
endif;
add_action( 'after_setup_theme', 'it_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function it_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'it_content_width', 1130 );
}

add_action( 'after_setup_theme', 'it_content_width', 0 );

/**
 * Add page slug to <body> class
 *
 * @link https://developer.wordpress.org/reference/functions/body_class/
 */
function it_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}

	return $classes;
}

add_filter( 'body_class', 'it_slug_body_class' );

/**
 * Changes Gravity Forms Ajax Spinner (next, back, submit) to a transparent image
 *
 * this allows us to target the css and create a pure css spinner or add different image instead.
 */
add_filter( 'gform_ajax_spinner_url', 'spinner_url', 10, 2 );
function spinner_url( $image_src, $form ) {
	return 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'; // relative to your theme images folder
}


/**
 * Remove archive title prefix
 */
add_filter( 'get_the_archive_title_prefix', 'it_archive_prefix' );
function it_archive_prefix( $prefix ) {
	$prefix = '';

	return $prefix;
}


/**
 * Limit post excerpt length
 *
 * @link https://developer.wordpress.org/reference/hooks/excerpt_length/
 */
add_filter( 'excerpt_length', function ( $length ) {
	return 20;
} );

// This will add a filter on `excerpt_more` that returns an empty string.
add_filter( 'excerpt_more', '__return_empty_string' );


// display 9 posts per page on the blog page
//function my_post_queries( $query ) {
//	if (!is_admin() && $query->is_main_query()){
//		if(is_home()){
//			if ($query->query_vars['paged'] > 1) {
//				$query->set('posts_per_page', 9);
//			} else {
//				$query->set('posts_per_page', 4);
//			}
//		}
//	}
//}
//add_action( 'pre_get_posts', 'my_post_queries' );


//Changing the posts per page on first page without breaking pagination in WordPress
add_action( 'pre_get_posts', 'rentopia_query_offset', 1 );
function rentopia_query_offset( &$query ) {

	if ( is_admin() ) {
		return;
	}

	// Before anything else, make sure this is the right query...
	if ( is_home() && ! is_front_page() || is_category() ) {
		if ( ( $query->is_home() && is_main_query() ) || ( ! is_front_page() && is_main_query() ) ) {


			// First, define your desired offset...
			$offset = 1; // old value: -2

			// Next, determine how many posts per page you want (we'll use WordPress's settings)
			$ppp = get_option( 'posts_per_page' );

			// Next, detect and handle pagination...
			if ( $query->is_paged ) {

				// Manually determine page query offset (offset + current page (minus one) x posts per page)
				$page_offset = $offset + ( ( $query->query_vars['paged'] - 1 ) * $ppp );

				// Apply adjust page offset
				$query->set( 'offset', $page_offset );

			} else {

				// This is the first page. Set a different number for posts per page
				$query->set( 'posts_per_page', $offset + $ppp );

			}
		}
	}
}

add_filter( 'found_posts', 'my_offset_pagination', 10, 2 );
function my_offset_pagination( $found_posts, $query ) {

	if ( is_admin() ) {
		return;
	}

	$ppp            = get_option( 'posts_per_page' );
	$first_page_ppp = 6;

	if ( $query->is_home() && $query->is_main_query() ) {
		if ( ! is_paged() ) {

			return ( $first_page_ppp + ( $found_posts - $first_page_ppp ) * $first_page_ppp / $ppp );

		} else {

			return ( $found_posts - ( $first_page_ppp - $ppp ) );

		}
	}

	return $found_posts;
}


function filter_add_query_vars( $query_vars ) {
	$query_vars[] = 'filtersearch';

	return $query_vars;
}

add_filter( 'query_vars', 'filter_add_query_vars' );


// Yoast Seo removing socials contact info
add_filter( 'user_contactmethods', 'yoast_seo_admin_user_remove_social', 99 );

function yoast_seo_admin_user_remove_social( $contactmethods ) {
	unset( $contactmethods['facebook'] );
	unset( $contactmethods['instagram'] );
	unset( $contactmethods['linkedin'] );
	unset( $contactmethods['myspace'] );
	unset( $contactmethods['pinterest'] );
	unset( $contactmethods['soundcloud'] );
	unset( $contactmethods['tumblr'] );
	unset( $contactmethods['twitter'] );
	unset( $contactmethods['youtube'] );
	unset( $contactmethods['wikipedia'] );

	//Do not remove the lines below
	return $contactmethods;
}


/*
 * Change WP Login file URL using "login_url" filter hook
 * https://developer.wordpress.org/reference/hooks/login_url/
 */
add_filter( 'login_url', 'rentopia_login_url', PHP_INT_MAX );
function rentopia_login_url( $login_url ) {
	$login_url = site_url( 'admin', 'login' );

	return $login_url;
}



// redirect user after log ing
function rentopia_restrict_wpadmin_access() {
	if ( ! defined('DOING_AJAX') || ! DOING_AJAX ) {
		$user = wp_get_current_user();

		if ( isset( $user->roles ) && is_array( $user->roles ) ) {
			if ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) {
				wp_redirect( home_url() . '/listing' );
				die;
			}
		}
	}
}
//add_action( 'admin_init', 'rentopia_restrict_wpadmin_access' );




/*@ After login redirection by user role */
//if ( !function_exists('tf_after_login_redirection_by_user_roles') ):
//
//	add_filter( 'login_redirect', 'tf_after_login_redirection_by_user_roles', 10, 3 );
//	function tf_after_login_redirection_by_user_roles( $redirect_to, $request, $user ) {
//		global $user;
//		if ( isset( $user->roles ) && is_array( $user->roles ) ) :
//			if ( in_array( 'manager', (array) $user->roles ) || in_array( 'agent', (array) $user->roles ) || in_array( 'administrator', (array) $user->roles ) ) :
//				$page_id = 566;
//				return get_permalink($page_id);
//			else:
//				return home_url();
//			endif;
//
//		else:
//			return $redirect_to;
//		endif;
//	}
//endif;



/**
 * Duplicates a post & its meta and returns the new duplicated Post ID.
 *
 * @param int $post_id The Post ID you want to clone.
 * @return int The duplicated Post ID.
 */
function duplicate_post(int $post_id): int
{
	$old_post = get_post($post_id);
	if (!$old_post) {
		// Invalid post ID, return early.
		return 0;
	}

	$title = $old_post->post_title;

	// Create new post array.
	$new_post = [
		'post_title'  => 'clone '.$title,
		'post_name'   => sanitize_title($title),
		'post_status' => 'draft',
		'post_type'   => $old_post->post_type,
	];

	// Insert new post.
	$new_post_id = wp_insert_post($new_post);

	// Copy post meta.
	$post_meta = get_post_custom($post_id);
	foreach ($post_meta as $key => $values) {
		foreach ($values as $value) {
			add_post_meta($new_post_id, $key, maybe_unserialize($value));
		}
	}

	// Copy post taxonomies.
	$taxonomies = get_post_taxonomies($post_id);
	foreach ($taxonomies as $taxonomy) {
		$term_ids = wp_get_object_terms($post_id, $taxonomy, ['fields' => 'ids']);
		wp_set_object_terms($new_post_id, $term_ids, $taxonomy);
	}

	// Return new post ID.
	return $new_post_id;
}
