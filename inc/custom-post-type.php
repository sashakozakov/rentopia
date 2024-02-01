<?php
/**
 * Register custom post types and taxonomies
 *
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 * @link https://developer.wordpress.org/resource/dashicons/
 */

// CPT: Project

function register_post_types()
{

	register_post_type('apartment',
		array('labels' => array(
			'name' => __('Apartments', 'rentopia'), /* This is the Title of the Group */
			'singular_name' => __('Apartment', 'rentopia'), /* This is the individual type */
			'all_items' => __('All Apartments', 'rentopia'), /* the all items menu item */
			'add_new' => __('Add New', 'rentopia'), /* The add new menu item */
			'add_new_item' => __('Add New work', 'rentopia'), /* Add New Display Title */
			'edit' => __('Edit', 'rentopia'), /* Edit Dialog */
			'edit_item' => __('Edit Apartment', 'rentopia'), /* Edit Display Title */
			'new_item' => __('New Apartment', 'rentopia'), /* New Display Title */
			'view_item' => __('View Apartment', 'rentopia'), /* View Display Title */
			'search_items' => __('Search Apartments', 'rentopia'), /* Search apartment Title */
			'not_found' => __('Nothing found in the Database.', 'rentopia'), /* This displays if there are no entries yet */
			'not_found_in_trash' => __('Nothing found in Trash', 'rentopia'),  //This displays if there is nothing in the trash
			'parent_item_colon' => '',
			''
		), /* end of arrays */
			'description' => __('This is the apartment type', 'rentopia'), /* work Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_rest' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => 'dashicons-list-view', /* the icon for the work type menu */
			'rewrite' => array('slug' => 'apartments', 'with_front' => false), /* you can specify its url slug */
			'has_archive' => true, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => true,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array('title', 'thumbnail', 'page-attributes', 'post-formats', 'author'),
		)
	);

	register_post_type('building',
		array('labels' => array(
			'name' => __('Buildings', 'rentopia'), /* This is the Title of the Group */
			'singular_name' => __('Building', 'rentopia'), /* This is the individual type */
			'all_items' => __('All Buildings', 'rentopia'), /* the all items menu item */
			'add_new' => __('Add New', 'rentopia'), /* The add new menu item */
			'add_new_item' => __('Add New work', 'rentopia'), /* Add New Display Title */
			'edit' => __('Edit', 'rentopia'), /* Edit Dialog */
			'edit_item' => __('Edit Building', 'rentopia'), /* Edit Display Title */
			'new_item' => __('New Building', 'rentopia'), /* New Display Title */
			'view_item' => __('View Building', 'rentopia'), /* View Display Title */
			'search_items' => __('Search Building', 'rentopia'), /* Search apartment Title */
			'not_found' => __('Nothing found in the Database.', 'rentopia'), /* This displays if there are no entries yet */
			'not_found_in_trash' => __('Nothing found in Trash', 'rentopia'),  //This displays if there is nothing in the trash
			'parent_item_colon' => '',
			''
		), /* end of arrays */
			'description' => __('This is the building type', 'rentopia'), /* work Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'show_ui' => true,
			'show_in_rest' => true,
			'query_var' => true,
			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
			'menu_icon' => 'dashicons-list-view', /* the icon for the work type menu */
			'rewrite' => array('slug' => 'buildings', 'with_front' => true), /* you can specify its url slug */
			'has_archive' => true, /* you can rename the slug here */
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'hierarchical' => true,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array('title', 'thumbnail', 'page-attributes', 'post-formats', 'editor', 'author'),
		)
	);
	flush_rewrite_rules();
}

add_action('init', 'register_post_types');


function register_taxonomies()
{
//	register_taxonomy('apartment_tag', array('apartment'), array(
//		'label' => '',
//		'labels' => array(
//			'name' => 'Tags',
//			'singular_name' => 'Tag',
//		),
//		'description' => '',
//		'public' => true,
//		'publicly_queryable' => null,
//		'show_in_nav_menus' => true,
//		'show_ui' => true,
//		'show_in_menu' => true,
//		'show_tagcloud' => true,
//		'show_in_rest' => true,
//		'rest_base' => null,
//		'hierarchical' => false,
//		'rewrite' => true,
//		'capabilities' => array(),
//		'meta_box_cb' => null,
//		'show_admin_column' => true,
//		'_builtin' => false,
//		'show_in_quick_edit' => null,
//	));

	register_taxonomy('building_tag', array('building'), array(
		'label' => '',
		'labels' => array(
			'name' => 'Tags',
			'singular_name' => 'Tag',
		),
		'description' => '',
		'public' => true,
		'publicly_queryable' => null,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_tagcloud' => true,
		'show_in_rest' => true,
		'rest_base' => null,
		'hierarchical' => false,
		'rewrite' => true,
		'capabilities' => array(),
		'meta_box_cb' => null,
		'show_admin_column' => true,
		'_builtin' => false,
		'show_in_quick_edit' => null,
	));

	register_taxonomy('neighborhood', array('apartment', 'building'), array(
		'label' => '',
		'labels' => array(
			'name' => 'Neighborhoods',
			'singular_name' => 'Neighborhood',
			'search_items' => 'Search Neighborhoods',
			'all_items' => 'All Neighborhoods',
			'view_item ' => 'View Neighborhood',
			'parent_item' => 'Parent Neighborhood',
			'parent_item_colon' => 'Parent Neighborhood:',
			'edit_item' => 'Edit Neighborhood',
			'update_item' => 'Update Neighborhood',
			'add_new_item' => 'Add New Neighborhood',
			'new_item_name' => 'New Neighborhood Name',
			'menu_name' => 'Neighborhoods',
		),
		'description' => '',
		'public' => true,
		'publicly_queryable' => null,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_tagcloud' => true,
		'show_in_rest' => true,
		'rest_base' => null,
		'hierarchical' => true,
		'rewrite' => true,
		'capabilities' => array(),
		'meta_box_cb' => null,
		'show_admin_column' => true,
		'_builtin' => false,
		'show_in_quick_edit' => null,
	));

	register_taxonomy('collections', array('apartment', 'building'), array(
		'label' => '',
		'labels' => array(
			'name' => 'Collections',
			'singular_name' => 'Collections',
			'search_items' => 'Search Collections',
			'all_items' => 'All Collections',
			'view_item ' => 'View Collection',
			'parent_item' => 'Parent Collection',
			'parent_item_colon' => 'Parent Collection:',
			'edit_item' => 'Edit Collection',
			'update_item' => 'Update Collection',
			'add_new_item' => 'Add New Collection',
			'new_item_name' => 'New Collection Name',
			'menu_name' => 'Collections',
		),
		'description' => '',
		'public' => true,
		'publicly_queryable' => null,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_tagcloud' => true,
		'show_in_rest' => true,
		'rest_base' => null,
		'hierarchical' => true,
		'rewrite' => true,
		'capabilities' => array(),
		'meta_box_cb' => null,
		'show_admin_column' => true,
		'_builtin' => false,
		'show_in_quick_edit' => null,
	));

	register_taxonomy('building_amenities', array('apartment', 'building'), array(
		'label' => '',
		'labels' => array(
			'name' => 'Building Amenities',
			'singular_name' => 'Building Amenities',
			'search_items' => 'Search Building Amenities',
			'all_items' => 'All Building Amenities',
			'view_item ' => 'View Building Amenities',
			'parent_item' => 'Parent Building Amenities',
			'parent_item_colon' => 'Parent Building Amenities:',
			'edit_item' => 'Edit Building Amenity',
			'update_item' => 'Update Building Amenity',
			'add_new_item' => 'Add New Building Amenity',
			'new_item_name' => 'New Building Amenity Name',
			'menu_name' => 'Building Amenities',
		),
		'description' => '',
		'public' => true,
		'publicly_queryable' => null,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_tagcloud' => true,
		'show_in_rest' => true,
		'rest_base' => null,
		'hierarchical' => true,
		'rewrite' => true,
		'capabilities' => array(),
		'meta_box_cb' => null,
		'show_admin_column' => true,
		'_builtin' => false,
		'show_in_quick_edit' => null,
	));

	register_taxonomy('apartment_amenities', array('apartment'), array(
		'label' => '',
		'labels' => array(
			'name' => 'Apartment Amenities',
			'singular_name' => 'Apartment Amenities',
			'search_items' => 'Search Apartment Amenities',
			'all_items' => 'All Apartment Amenities',
			'view_item ' => 'View Apartment Amenities',
			'parent_item' => 'Parent Apartment Amenities',
			'parent_item_colon' => 'Parent Apartment Amenities:',
			'edit_item' => 'Edit Apartment Amenity',
			'update_item' => 'Update Apartment Amenity',
			'add_new_item' => 'Add New Apartment Amenity',
			'new_item_name' => 'New Apartment Amenity Name',
			'menu_name' => 'Apartment Amenities',
		),
		'description' => '',
		'public' => true,
		'publicly_queryable' => null,
		'show_in_nav_menus' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_tagcloud' => true,
		'show_in_rest' => true,
		'rest_base' => null,
		'hierarchical' => true,
		'rewrite' => true,
		'capabilities' => array(),
		'meta_box_cb' => null,
		'show_admin_column' => true,
		'_builtin' => false,
		'show_in_quick_edit' => null,
	));
}

add_action('init', 'register_taxonomies');


function cptui_register_my_cpts()
{

	/**
	 * Post Type: Team.
	 */

	$labels = [
		"name" => esc_html__("Team", "custom-post-type-ui"),
		"singular_name" => esc_html__("Team", "custom-post-type-ui"),
	];

	$args = [
		"label" => esc_html__("Team", "custom-post-type-ui"),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => false,
		"rewrite" => ["slug" => "team", "with_front" => true],
		"query_var" => true,
		"menu_icon" => "dashicons-businessman",
		"supports" => ["title", "editor", "thumbnail"],
		"show_in_graphql" => false,
	];

	register_post_type("team", $args);
}

add_action('init', 'cptui_register_my_cpts');


function cptui_register_my_taxes()
{

	/**
	 * Taxonomy: Job Position.
	 */

	$labels = [
		"name" => esc_html__("Job Position", "custom-post-type-ui"),
		"singular_name" => esc_html__("Job Position", "custom-post-type-ui"),
	];


	$args = [
		"label" => esc_html__("Job Position", "custom-post-type-ui"),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => ['slug' => 'job_position', 'with_front' => true,],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "job_position",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => false,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy("job_position", ["team"], $args);
}

add_action('init', 'cptui_register_my_taxes');



//	function register_amenities(){
//		register_taxonomy('amenity', array('apartment'), array(
//			'label'                 => '',
//			'labels'                => array(
//				'name'              => 'Amenities',
//				'singular_name'     => 'Amenity',
//			),
//			'description'           => '',
//			'public'                => true,
//			'publicly_queryable'    => null,
//			'show_in_nav_menus'     => true,
//			'show_ui'               => true,
//			'show_in_menu'          => true,
//			'show_tagcloud'         => true,
//			'show_in_rest'          => true,
//			'rest_base'             => null,
//			'hierarchical'          => true,
//			'rewrite'               => true,
//			'capabilities'          => array(),
//			'meta_box_cb'           => null,
//			'show_admin_column'     => true,
//			'_builtin'              => false,
//			'show_in_quick_edit'    => null,
//		) );
//	}
//
//	add_action( 'init', 'register_amenities' );

//	function register_exclusive() {
//
//		register_post_type( 'exclusive',
//			array( 'labels' => array(
//				'name' => __( 'Exclusives', 'rentopia' ), /* This is the Title of the Group */
//				'singular_name' => __( 'Exclusive', 'rentopia' ), /* This is the individual type */
//				'all_items' => __( 'All Exclusives', 'rentopia' ), /* the all items menu item */
//				'add_new' => __( 'Add New', 'rentopia' ), /* The add new menu item */
//				'add_new_item' => __( 'Add New work', 'rentopia' ), /* Add New Display Title */
//				'edit' => __( 'Edit', 'rentopia' ), /* Edit Dialog */
//				'edit_item' => __( 'Edit Exclusive', 'rentopia' ), /* Edit Display Title */
//				'new_item' => __( 'New Exclusive', 'rentopia' ), /* New Display Title */
//				'view_item' => __( 'View Exclusive', 'rentopia' ), /* View Display Title */
//				'search_items' => __( 'Search Exclusive', 'rentopia' ), /* Search apartment Title */
//				'not_found' =>  __( 'Nothing found in the Database.', 'rentopia' ), /* This displays if there are no entries yet */
//				'not_found_in_trash' => __( 'Nothing found in Trash', 'rentopia' ),  //This displays if there is nothing in the trash
//				'parent_item_colon' => '',
//				''
//			), /* end of arrays */
//				'description' => __( 'This is the Exclusive type', 'rentopia' ), /* work Description */
//				'public' => true,
//				'publicly_queryable' => true,
//				'exclude_from_search' => false,
//				'show_ui' => true,
//				'show_in_rest' => true,
//				'query_var' => true,
//				'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
//				'menu_icon' => 'dashicons-list-view', /* the icon for the work type menu */
//				'rewrite'   => array( 'slug' => 'exclusives', 'with_front' => false ), /* you can specify its url slug */
//				'has_archive' => true, /* you can rename the slug here */
//				'capability_type' => 'post',
//				'hierarchical' => true,
//				/* the next one is important, it tells what's enabled in the post editor */
//				'supports' => array('title', 'thumbnail', 'page-attributes', 'post-formats', 'editor','author'),
//			)
//		);
//		flush_rewrite_rules();
//	}

//add_action( 'init', 'register_exclusive');


//	function register_neighborhoods_exclusive(){
//		register_taxonomy('exclusive_neighborhood', array('exclusive'), array(
//			'label'                 => '',
//			'labels'                => array(
//				'name'              => 'Neighborhoods',
//				'singular_name'     => 'Neighborhood',
//				'search_items'      => 'Search Neighborhoods',
//				'all_items'         => 'All Neighborhoods',
//				'view_item '        => 'View Neighborhood',
//				'parent_item'       => 'Parent Neighborhood',
//				'parent_item_colon' => 'Parent Neighborhood:',
//				'edit_item'         => 'Edit Neighborhood',
//				'update_item'       => 'Update Neighborhood',
//				'add_new_item'      => 'Add New Neighborhood',
//				'new_item_name'     => 'New Neighborhood Name',
//				'menu_name'         => 'Neighborhoods',
//			),
//			'description'           => '',
//			'public'                => true,
//			'publicly_queryable'    => null,
//			'show_in_nav_menus'     => true,
//			'show_ui'               => true,
//			'show_in_menu'          => true,
//			'show_tagcloud'         => true,
//			'show_in_rest'          => true,
//			'rest_base'             => null,
//			'hierarchical'          => true,
//			'rewrite'               => true,
//			'capabilities'          => array(),
//			'meta_box_cb'           => null,
//			'show_admin_column'     => true,
//			'_builtin'              => false,
//			'show_in_quick_edit'    => null,
//		) );
//	}

//add_action( 'init', 'register_neighborhoods_exclusive' );

//	function register_types_exclusive(){
//		register_taxonomy('exclusive_tag', array('exclusive'), array(
//			'label'                 => '',
//			'labels'                => array(
//				'name'              => 'Tags',
//				'singular_name'     => 'Tag',
//			),
//			'description'           => '',
//			'public'                => true,
//			'publicly_queryable'    => null,
//			'show_in_nav_menus'     => true,
//			'show_ui'               => true,
//			'show_in_menu'          => true,
//			'show_tagcloud'         => true,
//			'show_in_rest'          => true,
//			'rest_base'             => null,
//			'hierarchical'          => false,
//			'rewrite'               => true,
//			'capabilities'          => array(),
//			'meta_box_cb'           => null,
//			'show_admin_column'     => true,
//			'_builtin'              => false,
//			'show_in_quick_edit'    => null,
//		) );
//	}

//add_action( 'init', 'register_types_exclusive' );

//	function register_amenities_exclusive(){
//		register_taxonomy('exclusive_amenity', array('exclusive'), array(
//			'label'                 => '',
//			'labels'                => array(
//				'name'              => 'Amenities',
//				'singular_name'     => 'Amenity',
//			),
//			'description'           => '',
//			'public'                => true,
//			'publicly_queryable'    => null,
//			'show_in_nav_menus'     => true,
//			'show_ui'               => true,
//			'show_in_menu'          => true,
//			'show_tagcloud'         => true,
//			'show_in_rest'          => true,
//			'rest_base'             => null,
//			'hierarchical'          => true,
//			'rewrite'               => true,
//			'capabilities'          => array(),
//			'meta_box_cb'           => null,
//			'show_admin_column'     => true,
//			'_builtin'              => false,
//			'show_in_quick_edit'    => null,
//		) );
//	}

//add_action( 'init', 'register_amenities_exclusive' );



//	function register_neighborhoods_building(){
//		register_taxonomy('building_neighborhood', array('building'), array(
//			'label'                 => '',
//			'labels'                => array(
//				'name'              => 'Neighborhoods',
//				'singular_name'     => 'Neighborhood',
//				'search_items'      => 'Search Neighborhoods',
//				'all_items'         => 'All Neighborhoods',
//				'view_item '        => 'View Neighborhood',
//				'parent_item'       => 'Parent Neighborhood',
//				'parent_item_colon' => 'Parent Neighborhood:',
//				'edit_item'         => 'Edit Neighborhood',
//				'update_item'       => 'Update Neighborhood',
//				'add_new_item'      => 'Add New Neighborhood',
//				'new_item_name'     => 'New Neighborhood Name',
//				'menu_name'         => 'Neighborhoods',
//			),
//			'description'           => '',
//			'public'                => true,
//			'publicly_queryable'    => null,
//			'show_in_nav_menus'     => true,
//			'show_ui'               => true,
//			'show_in_menu'          => true,
//			'show_tagcloud'         => true,
//			'show_in_rest'          => true,
//			'rest_base'             => null,
//			'hierarchical'          => true,
//			'rewrite'               => true,
//			'capabilities'          => array(),
//			'meta_box_cb'           => null,
//			'show_admin_column'     => true,
//			'_builtin'              => false,
//			'show_in_quick_edit'    => null,
//		) );
//	}
//
//	add_action( 'init', 'register_neighborhoods_building' );


//	function register_amenities_building(){
//		register_taxonomy('building_amenity', array('building'), array(
//			'label'                 => '',
//			'labels'                => array(
//				'name'              => 'Amenities',
//				'singular_name'     => 'Amenity',
//			),
//			'description'           => '',
//			'public'                => true,
//			'publicly_queryable'    => null,
//			'show_in_nav_menus'     => true,
//			'show_ui'               => true,
//			'show_in_menu'          => true,
//			'show_tagcloud'         => true,
//			'show_in_rest'          => true,
//			'rest_base'             => null,
//			'hierarchical'          => true,
//			'rewrite'               => true,
//			'capabilities'          => array(),
//			'meta_box_cb'           => null,
//			'show_admin_column'     => true,
//			'_builtin'              => false,
//			'show_in_quick_edit'    => null,
//		) );
//	}
//
//	add_action( 'init', 'register_amenities_building' );
