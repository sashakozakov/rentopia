<?php


if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
	acf_add_options_sub_page('Global blocks');
	acf_add_options_sub_page('Header');
	acf_add_options_sub_page('Partners');
	acf_add_options_sub_page('Footer');
	acf_add_options_sub_page('Contacts');
	acf_add_options_sub_page('Settings');
	acf_add_options_sub_page('Common for apartment');
	acf_add_options_sub_page('Login page');
}

# Enqueue Custom Scripts
define('DIR', get_template_directory_uri() . '/');
define('PATH_IMG', DIR.'images/');
define('PATH_ANIMATION', DIR.'template-parts/animations/');

add_action( 'wp_enqueue_scripts', 'overprint_wp_enqueue_scripts' );
function overprint_wp_enqueue_scripts() {

	# enqueue custom styles
	wp_enqueue_style( 'app.css', DIR . 'css/app.css', false, filemtime(get_template_directory().'/css/app.css') );

	# enqueue custom scripts
	wp_enqueue_script('app.js', DIR . 'js/app.js', false,  filemtime(get_template_directory().'/js/app.js'), true );


}

function register_menu() {
	register_nav_menu('main_menu', 'Main menu');
}
add_action('after_setup_theme', 'register_menu');

function print_html($tmpl, $values, $required = 0)

{
	if (!empty($values[$required])) {
		echo vsprintf($tmpl, $values);
	}
}

add_theme_support( 'post-thumbnails');

show_admin_bar(false);

/**
 * Add arrows to menu items
 * @author Bill Erickson
 * @link http://www.billerickson.net/code/add-arrows-to-menu-items/
 *
 * @param string $item_output, HTML output for the menu item
 * @param object $item, menu item object
 * @param int $depth, depth in menu structure
 * @param object $args, arguments passed to wp_nav_menu()
 * @return string $item_output
 */
function be_arrows_in_menus( $item_output, $item, $depth, $args ) {
	if( in_array( 'menu-item-has-children', $item->classes ) ) {
		$arrow = '<i class="caret fa fa-angle-down"></i>';
		$item_output = str_replace( '</a>', '</a>' . $arrow, $item_output );
	}
	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'be_arrows_in_menus', 10, 4 );


//add SVG to allowed file uploads
function add_file_types_to_uploads($file_types){
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');

function register_apartment() {

	register_post_type( 'apartment',
		array( 'labels' => array(
			'name' => __( 'Apartments', 'rentopia' ), /* This is the Title of the Group */
			'singular_name' => __( 'Apartment', 'rentopia' ), /* This is the individual type */
			'all_items' => __( 'All Apartments', 'rentopia' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'rentopia' ), /* The add new menu item */
			'add_new_item' => __( 'Add New work', 'rentopia' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'rentopia' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Apartment', 'rentopia' ), /* Edit Display Title */
			'new_item' => __( 'New Apartment', 'rentopia' ), /* New Display Title */
			'view_item' => __( 'View Apartment', 'rentopia' ), /* View Display Title */
			'search_items' => __( 'Search Apartments', 'rentopia' ), /* Search apartment Title */
			'not_found' =>  __( 'Nothing found in the Database.', 'rentopia' ), /* This displays if there are no entries yet */
			'not_found_in_trash' => __( 'Nothing found in Trash', 'rentopia' ),  //This displays if there is nothing in the trash
			'parent_item_colon' => '',
			''
		), /* end of arrays */
			'description' => __( 'This is the apartment type', 'rentopia' ), /* work Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_rest' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => 'dashicons-list-view', /* the icon for the work type menu */
			'rewrite'   => array( 'slug' => 'apartments', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => true, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => true,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array('title', 'thumbnail', 'page-attributes', 'post-formats', 'editor','author'),
		)
	);
}

add_action( 'init', 'register_apartment');


function register_neighborhoods(){
	register_taxonomy('neighborhood', array('apartment'), array(
		'label'                 => '',
		'labels'                => array(
			'name'              => 'Neighborhoods',
			'singular_name'     => 'Neighborhood',
			'search_items'      => 'Search Neighborhoods',
			'all_items'         => 'All Neighborhoods',
			'view_item '        => 'View Neighborhood',
			'parent_item'       => 'Parent Neighborhood',
			'parent_item_colon' => 'Parent Neighborhood:',
			'edit_item'         => 'Edit Neighborhood',
			'update_item'       => 'Update Neighborhood',
			'add_new_item'      => 'Add New Neighborhood',
			'new_item_name'     => 'New Neighborhood Name',
			'menu_name'         => 'Neighborhoods',
		),
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => null,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_tagcloud'         => true,
		'show_in_rest'          => true,
		'rest_base'             => null,
		'hierarchical'          => true,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null,
		'show_admin_column'     => true,
		'_builtin'              => false,
		'show_in_quick_edit'    => null,
	) );
}

add_action( 'init', 'register_neighborhoods' );

function register_types(){
	register_taxonomy('apartment_tag', array('apartment'), array(
		'label'                 => '',
		'labels'                => array(
			'name'              => 'Tags',
			'singular_name'     => 'Tag',
		),
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => null,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_tagcloud'         => true,
		'show_in_rest'          => true,
		'rest_base'             => null,
		'hierarchical'          => false,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null,
		'show_admin_column'     => true,
		'_builtin'              => false,
		'show_in_quick_edit'    => null,
	) );
}

add_action( 'init', 'register_types' );

function register_amenities(){
	register_taxonomy('amenity', array('apartment'), array(
		'label'                 => '',
		'labels'                => array(
			'name'              => 'Amenities',
			'singular_name'     => 'Amenity',
		),
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => null,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_tagcloud'         => true,
		'show_in_rest'          => true,
		'rest_base'             => null,
		'hierarchical'          => true,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null,
		'show_admin_column'     => true,
		'_builtin'              => false,
		'show_in_quick_edit'    => null,
	) );
}

add_action( 'init', 'register_amenities' );

function register_exclusive() {

	register_post_type( 'exclusive',
		array( 'labels' => array(
			'name' => __( 'Exclusives', 'rentopia' ), /* This is the Title of the Group */
			'singular_name' => __( 'Exclusive', 'rentopia' ), /* This is the individual type */
			'all_items' => __( 'All Exclusives', 'rentopia' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'rentopia' ), /* The add new menu item */
			'add_new_item' => __( 'Add New work', 'rentopia' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'rentopia' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Exclusive', 'rentopia' ), /* Edit Display Title */
			'new_item' => __( 'New Exclusive', 'rentopia' ), /* New Display Title */
			'view_item' => __( 'View Exclusive', 'rentopia' ), /* View Display Title */
			'search_items' => __( 'Search Exclusive', 'rentopia' ), /* Search apartment Title */
			'not_found' =>  __( 'Nothing found in the Database.', 'rentopia' ), /* This displays if there are no entries yet */
			'not_found_in_trash' => __( 'Nothing found in Trash', 'rentopia' ),  //This displays if there is nothing in the trash
			'parent_item_colon' => '',
			''
		), /* end of arrays */
			'description' => __( 'This is the Exclusive type', 'rentopia' ), /* work Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_rest' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => 'dashicons-list-view', /* the icon for the work type menu */
			'rewrite'   => array( 'slug' => 'exclusives', 'with_front' => false ), /* you can specify its url slug */
			'has_archive' => true, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => true,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array('title', 'thumbnail', 'page-attributes', 'post-formats', 'editor','author'),
		)
	);
	flush_rewrite_rules();
}

//add_action( 'init', 'register_exclusive');


function register_neighborhoods_exclusive(){
	register_taxonomy('exclusive_neighborhood', array('exclusive'), array(
		'label'                 => '',
		'labels'                => array(
			'name'              => 'Neighborhoods',
			'singular_name'     => 'Neighborhood',
			'search_items'      => 'Search Neighborhoods',
			'all_items'         => 'All Neighborhoods',
			'view_item '        => 'View Neighborhood',
			'parent_item'       => 'Parent Neighborhood',
			'parent_item_colon' => 'Parent Neighborhood:',
			'edit_item'         => 'Edit Neighborhood',
			'update_item'       => 'Update Neighborhood',
			'add_new_item'      => 'Add New Neighborhood',
			'new_item_name'     => 'New Neighborhood Name',
			'menu_name'         => 'Neighborhoods',
		),
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => null,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_tagcloud'         => true,
		'show_in_rest'          => true,
		'rest_base'             => null,
		'hierarchical'          => true,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null,
		'show_admin_column'     => true,
		'_builtin'              => false,
		'show_in_quick_edit'    => null,
	) );
}

//add_action( 'init', 'register_neighborhoods_exclusive' );

function register_types_exclusive(){
	register_taxonomy('exclusive_tag', array('exclusive'), array(
		'label'                 => '',
		'labels'                => array(
			'name'              => 'Tags',
			'singular_name'     => 'Tag',
		),
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => null,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_tagcloud'         => true,
		'show_in_rest'          => true,
		'rest_base'             => null,
		'hierarchical'          => false,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null,
		'show_admin_column'     => true,
		'_builtin'              => false,
		'show_in_quick_edit'    => null,
	) );
}

//add_action( 'init', 'register_types_exclusive' );

function register_amenities_exclusive(){
	register_taxonomy('exclusive_amenity', array('exclusive'), array(
		'label'                 => '',
		'labels'                => array(
			'name'              => 'Amenities',
			'singular_name'     => 'Amenity',
		),
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => null,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_tagcloud'         => true,
		'show_in_rest'          => true,
		'rest_base'             => null,
		'hierarchical'          => true,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null,
		'show_admin_column'     => true,
		'_builtin'              => false,
		'show_in_quick_edit'    => null,
	) );
}

//add_action( 'init', 'register_amenities_exclusive' );


function register_building() {

	register_post_type( 'building',
		array( 'labels' => array(
			'name' => __( 'Buildings', 'rentopia' ), /* This is the Title of the Group */
			'singular_name' => __( 'Building', 'rentopia' ), /* This is the individual type */
			'all_items' => __( 'All Buildings', 'rentopia' ), /* the all items menu item */
			'add_new' => __( 'Add New', 'rentopia' ), /* The add new menu item */
			'add_new_item' => __( 'Add New work', 'rentopia' ), /* Add New Display Title */
			'edit' => __( 'Edit', 'rentopia' ), /* Edit Dialog */
			'edit_item' => __( 'Edit Building', 'rentopia' ), /* Edit Display Title */
			'new_item' => __( 'New Building', 'rentopia' ), /* New Display Title */
			'view_item' => __( 'View Building', 'rentopia' ), /* View Display Title */
			'search_items' => __( 'Search Building', 'rentopia' ), /* Search apartment Title */
			'not_found' =>  __( 'Nothing found in the Database.', 'rentopia' ), /* This displays if there are no entries yet */
			'not_found_in_trash' => __( 'Nothing found in Trash', 'rentopia' ),  //This displays if there is nothing in the trash
			'parent_item_colon' => '',
			''
		), /* end of arrays */
			'description' => __( 'This is the building type', 'rentopia' ), /* work Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_rest' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => 'dashicons-list-view', /* the icon for the work type menu */
			'rewrite'   => array( 'slug' => 'buildings', 'with_front' => true ), /* you can specify its url slug */
			'has_archive' => true, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => true,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array('title', 'thumbnail', 'page-attributes', 'post-formats', 'editor','author'),
		)
	);
	flush_rewrite_rules();
}

add_action( 'init', 'register_building');


function register_neighborhoods_building(){
	register_taxonomy('building_neighborhood', array('building'), array(
		'label'                 => '',
		'labels'                => array(
			'name'              => 'Neighborhoods',
			'singular_name'     => 'Neighborhood',
			'search_items'      => 'Search Neighborhoods',
			'all_items'         => 'All Neighborhoods',
			'view_item '        => 'View Neighborhood',
			'parent_item'       => 'Parent Neighborhood',
			'parent_item_colon' => 'Parent Neighborhood:',
			'edit_item'         => 'Edit Neighborhood',
			'update_item'       => 'Update Neighborhood',
			'add_new_item'      => 'Add New Neighborhood',
			'new_item_name'     => 'New Neighborhood Name',
			'menu_name'         => 'Neighborhoods',
		),
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => null,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_tagcloud'         => true,
		'show_in_rest'          => true,
		'rest_base'             => null,
		'hierarchical'          => true,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null,
		'show_admin_column'     => true,
		'_builtin'              => false,
		'show_in_quick_edit'    => null,
	) );
}

add_action( 'init', 'register_neighborhoods_building' );

function register_types_building(){
	register_taxonomy('building_tag', array('building'), array(
		'label'                 => '',
		'labels'                => array(
			'name'              => 'Tags',
			'singular_name'     => 'Tag',
		),
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => null,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_tagcloud'         => true,
		'show_in_rest'          => true,
		'rest_base'             => null,
		'hierarchical'          => false,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null,
		'show_admin_column'     => true,
		'_builtin'              => false,
		'show_in_quick_edit'    => null,
	) );
}

add_action( 'init', 'register_types_building' );

function register_amenities_building(){
	register_taxonomy('building_amenity', array('building'), array(
		'label'                 => '',
		'labels'                => array(
			'name'              => 'Amenities',
			'singular_name'     => 'Amenity',
		),
		'description'           => '',
		'public'                => true,
		'publicly_queryable'    => null,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'show_tagcloud'         => true,
		'show_in_rest'          => true,
		'rest_base'             => null,
		'hierarchical'          => true,
		'rewrite'               => true,
		'capabilities'          => array(),
		'meta_box_cb'           => null,
		'show_admin_column'     => true,
		'_builtin'              => false,
		'show_in_quick_edit'    => null,
	) );
}

add_action( 'init', 'register_amenities_building' );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function flexible_footer_widgets_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Footer menu', 'flexible-footer-widgets' ),
		'id'            => 'footer-menu',
		'description'   => esc_html__( 'Add widgets here for the first footer column.', 'flexible-footer-widgets' ),
		'before_widget' => '<div class="custom-col">',
		'after_widget'  => '</div>',
	) );
}
add_action( 'widgets_init', 'flexible_footer_widgets_widgets_init' );


function get_terms_group($slug, $hide_empty = false) {

	$all_terms = get_terms( $slug, array(
		'hide_empty' => $hide_empty,
	));

	$grouped_terms = array();

	foreach ($all_terms as $key => $term) {

		if ($term->parent) {
			$grouped_terms[$term->parent]['children'][] = $term;
		} else {
			$grouped_terms[$term->term_id]['parent'] = $term;
		}

	}

	return  $grouped_terms;
}

function get_amenities($id = null) {

	$all_terms = wp_get_post_terms( $id, 'amenity', array(
		'hide_empty' => false,
		'hierarchical' => true
	));

	//return $all_terms;

	$grouped_terms = array();

	foreach ($all_terms as $key => $term) {

		if ($term->parent) {
			$grouped_terms[$term->parent]['children'][] = $term;
		} else {
			$grouped_terms[$term->term_id]['parent'] = $term;
		}

	}

	return  $grouped_terms;
}

function get_amenities_exclusive($id = null) {

	$all_terms = wp_get_post_terms( $id, 'exclusive_amenity', array(
		'hide_empty' => false,
		'hierarchical' => true
	));

	//return $all_terms;

	$grouped_terms = array();

	foreach ($all_terms as $key => $term) {

		if ($term->parent) {
			$grouped_terms[$term->parent]['children'][] = $term;
		} else {
			$grouped_terms[$term->term_id]['parent'] = $term;
		}

	}

	return  $grouped_terms;
}

function get_price_items($min = 0, $max = 10000, $step = 500) {

	$steps = array();

	for ($i = $min; $i < $max; $i = $i + $step) {
		$steps[] = array($i, $i + $step);
	}

	return $steps;

}

function to_money_str($price) {

	if (!is_numeric($price)) return $price;

	return '$'.number_format($price, 0, '.', ',');
}

function show_appartment_info($count, $label) {
	$html = '';

	if($count) {
		$html = $count . ' ' . $label;

		if ($count > 1) {
			$html .= 's';
		}

		echo $html;
	} else {
		echo 'n/a';
	}
}

function show_appartment_info_tag($count, $label) {
	$html = '';

	if($count) {
		$html = $label . ' <div class="separator"></div>' . $count;

		if ($count > 1) {
			//$html .= 's';

		}

		echo $html;
	} else {
		echo 'n/a';
	}
}
function show_appartment_info_single($count, $label) {
	$html = '';

	if($count) {
		$html =   $label . ' ' .$count;

		if ($count > 1) {
			$html .= '';
		}

		echo $html;
	} else {
		echo 'n/a';
	}
}

function the_neighborhoods_str($term, $term_names = array()) {
	$term_names[] = $term->name;

	if ($term->parent) {
		the_neighborhoods_str(get_term($term->parent, 'neighborhood'), $term_names);
	} else {
		echo implode(', ', $term_names);
	}
}

function include_animation($name) {
	echo '<div class="animation">';
	get_template_part('template-parts/animations/' . $name . '/index');
	echo '</div>';
}


include 'components/search-apartments.php';
include 'components/custom-login.php';

function add_admin_scripts($hook) {
	wp_enqueue_script('admin.js', DIR . 'admin/admin.js');
}

add_action('admin_enqueue_scripts', 'add_admin_scripts');

add_filter( 'shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3 );

function custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
	$additional_attrs = array('apartment-link');

	foreach ($additional_attrs as $key => $attr) {
		if ( isset( $atts[$attr] ) ) {
			$out[$attr] = $atts[$attr];
		}
	}

	return $out;
}


add_action('wp_footer', 'wc_wp_footer_callback');

function wc_wp_footer_callback(){
	?>
	<script type="text/javascript">
		jQuery(window).load(function(){
			//wc_update_wc_neighborhood();
			jQuery('#search-form input[name="wc_neighborhood[]"]').change(function() {
				wc_update_wc_neighborhood();
			});

			function wc_update_wc_neighborhood() {
				wc_neighborhood = '';
				jQuery('#search-form input[name="wc_neighborhood[]"]').each( function () {
					if(this.checked) {
						wc_neighborhood = wc_neighborhood.concat(','+jQuery(this).val());
					}
				});
				//wc_neighborhood = wc_neighborhood.replace(/^,|,$/g,'');
				jQuery('#search-form input[name="neighborhood"]').val(wc_neighborhood);

				var wc_neighborhood_new = '';
				var i = 1;
				jQuery('#search-form .custom-col').each( function () {
					jQuery(this).find('input[name="wc_neighborhood[]"]').each( function () {
						if(this.checked) {
							if(i == 1) {
								wc_neighborhood_new = wc_neighborhood_new.concat(', '+jQuery(this).next().text());
							} else if(i == 2) {
								wc_neighborhood_new = wc_neighborhood_new.concat(' +');
							}
							//wc_neighborhood_new = wc_neighborhood_new.concat(', '+jQuery(this).next().text());
							i = i+1;
						}
					});
					wc_neighborhood_new = wc_neighborhood_new.replace(/^,|,$/g,'');
				});
				jQuery('#search-form button#neighborhood .filter-button').addClass('selected');
				jQuery('#search-form button#neighborhood span.value.js-filter-value').html(wc_neighborhood_new);

			}
		});
	</script>
	<?php
}

add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>
	<h3><?php //_e("Social Info", "blank"); ?></h3>

	<p>
		<label for="location"><?php _e("Location"); ?></label>
		<input type="text" name="location" id="location" value="<?php echo esc_attr( get_the_author_meta( 'location', $user->ID ) ); ?>" class="text-input input" /><br />
		<!-- span class="description"><?php //_e("Please enter your facebook."); ?></span-->
	</p>
	<p>
		<label for="instagram"><?php _e("Instagram"); ?></label>

		<input type="text" name="instagram" id="instagram" value="<?php echo esc_attr( get_the_author_meta( 'instagram', $user->ID ) ); ?>" class="text-input input" /><br />
		<!-- span class="description"><?php //_e("Please enter your instagram."); ?></span-->

	</p>
	<p>
		<label for="facebook"><?php _e("Facebook"); ?></label>
		<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="text-input input" /><br />
		<!-- span class="description"><?php //_e("Please enter your facebook."); ?></span-->
	</p>
	<p>
		<label for="twitter"><?php _e("Twitter"); ?></label>
		<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="text-input input" /><br />


		<!--- span class="description"><?php //_e("Please enter your twitter."); ?></span -->
	</p>


<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) {
		return false;
	}
	update_user_meta( $user_id, 'location', $_POST['location'] );
	update_user_meta( $user_id, 'instagram', $_POST['instagram'] );
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
}


function add_ajaxurl_cdata_to_front(){ ?>
	<script type="text/javascript"> //<![CDATA[
		ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
		//]]> </script>
<?php }
add_action( 'wp_head', 'add_ajaxurl_cdata_to_front', 1);


add_action( 'wp_footer', 'add_js_to_wp_footer' );
function add_js_to_wp_footer(){ ?>
	<script type="text/javascript">
		/*jQuery(".simplefavorite-button").click( function() {*/
		jQuery(document).on('click', Favorites.selectors.button, function(e){

			check_status = jQuery(this).hasClass("active");

			apartment_id = jQuery(this).attr('data-postid');

			//alert('click');

			if(check_status){

				check_statuss = 'false';

				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "view_site_description" , "remove_id" : "remove_id" ,"status" : check_statuss , "apartment_id" : apartment_id},
					success: function(data){
						/*alert(data);*/
					}
				});

			}	else	{

				check_statuss = 'true';

				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {"action": "view_site_description" , "add_id" : "add_id" ,"status" : check_statuss , "apartment_id" : apartment_id},
					success: function(data){
						/*alert(data);*/
					}
				});
			}
		});
	</script>
<?php }

function view_site_description(){

	global $current_user, $wp_roles, $wpdb;
	$apartment_id_save = $_POST['apartment_id'];

	//update_user_meta($current_user->ID, 'apartment_id_save','');
	//print_r($_POST);
	$save_new_valuess = '';

	$get_apartment_id_save = get_user_meta( $current_user->ID, 'apartment_id_save' , true );
	//print_r($get_apartment_id_save);
	$apartment_id_save_blank = '';
	if($_POST['add_id'] == 'add_id'){

		if(empty($get_apartment_id_save)){

			$save_new_valuess = $apartment_id_save;
			update_user_meta($current_user->ID, 'apartment_id_save',$save_new_valuess);

		}	else	{

			$get_valuess = explode(',',$get_apartment_id_save);
			$key_not_found = in_array($apartment_id_save, $get_valuess);

			if(empty($key_not_found)){
				$save_new_valuess = $get_apartment_id_save.",".$apartment_id_save;
				update_user_meta($current_user->ID, 'apartment_id_save',$save_new_valuess);
			}
		}
	}

	if($_POST['remove_id'] == 'remove_id'){

		$apartment_id_save_blank = '';

		if(empty($get_apartment_id_save)){

			$save_new_valuess = $apartment_id_save;
			update_user_meta($current_user->ID, 'apartment_id_save',$apartment_id_save_blank);

		}	else	{

			$get_valuess = explode(',',$get_apartment_id_save);
			$key_not_found = in_array($apartment_id_save, $get_valuess);
			$key_find = array_search($apartment_id_save,$get_valuess);

			$array_without_strawberries = array_diff($get_valuess, array($apartment_id_save));
			$lengthofnewarray =  count($array_without_strawberries);

			if($lengthofnewarray == 1){
				$save_new_valuesse = $array_without_strawberries[0];

			}	else	{

				$save_to_database = explode(",",$array_without_strawberries);
				$c  = 0;
				foreach($array_without_strawberries as $std){
					if($c == ($lengthofnewarray - 1)){
						$save_new_valuesse .= $std;
					}	else	{
						$save_new_valuesse .= $std.",";
					}
					$c =  $c + 1;
				}
			}
			update_user_meta($current_user->ID, 'apartment_id_save',$save_new_valuesse);
		}


	}
}
add_action( 'wp_ajax_view_site_description', 'view_site_description' );
add_action( 'wp_ajax_nopriv_view_site_description', 'view_site_description' );

function load_jquery_core(){
	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'load_jquery_core');

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}
