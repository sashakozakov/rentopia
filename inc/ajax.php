<?php
/**
 * AJAX functions
 *
 * @link https://developer.wordpress.org/reference/hooks/wp_ajax_action/
 */

//add_action( 'wp_ajax_it_custom_action', 'it_custom_action' );
//add_action( 'wp_ajax_nopriv_it_custom_action', 'it_custom_action' );
//function it_custom_action() {
//
//	wp_die();
//}


add_action( 'wp_ajax_load_more_neighborhoods', 'load_more_neighborhoods' );
add_action( 'wp_ajax_nopriv_load_more_neighborhoods', 'load_more_neighborhoods' );
function load_more_neighborhoods() {
	$next = $_POST['next'];
	$html = '';

	$terms = get_terms( array(
		'taxonomy' => 'neighborhood',
		'orderby'  => 'term_id',
		'number'   => 12,
		'offset'   => $next - 1,
		'order'    => 'ASC',
	) );

	get_template_part( 'template-parts/components/neighborhoods_loop', null, [ 'terms' => $terms ] );

	echo $html;
	wp_die();
}


add_action( 'wp_ajax_nopriv_load_more_collections', 'load_more_collections' );
add_action( 'wp_ajax_load_more_collections', 'load_more_collections' );
function load_more_collections() {

	$next = $_POST['next'];
	$html = '';

	$terms = get_terms( array(
		'taxonomy' => 'collections',
		'orderby'  => 'term_id',
		'number'   => 3,
		'offset'   => $next - 1,
		'order'    => 'ASC',
	) );
	ob_start();
	get_template_part( 'template-parts/components/collections_loop', null, [ 'terms' => $terms ] );

	echo $html;
	wp_die();
}


add_action( 'wp_ajax_nopriv_load_more_portfolio', 'load_more_portfolio' );
add_action( 'wp_ajax_load_more_portfolio', 'load_more_portfolio' );
function load_more_portfolio() {

	$next   = isset( $_POST['next'] ) ? intval( $_POST['next'] ) : 1;
	$pageID = isset( $_POST['pageID'] ) ? intval( $_POST['pageID'] ) : 1;

	$args  = array(
		'post_type'      => 'apartment',
		'posts_per_page' => 12,
		'offset'         => $next - 1,
	);
	if ($pageID) {
		$args['meta_query'] = array(
			'relation' => 'AND',
			array(
				'key'     => 'connected_building',
				'value'   => $pageID,
				'compare' => 'IN'
			),
		);
	}
	$query = new WP_Query( $args );

	$html = '';
	if ( $query->have_posts() ):
		while ( $query->have_posts() ): $query->the_post();
			$html .= '<div class="col-xl-3 col-lg-4 col-md-6">';
			ob_start();
			get_template_part( 'template-parts/builder/components/new_appartament_item' );
			$html .= ob_get_clean();
			$html .= '</div>';
		endwhile;
		wp_reset_postdata();
	endif;

	echo $html;
	wp_die();
}


add_action( 'wp_ajax_nopriv_load_more_buildings', 'load_more_buildings' );
add_action( 'wp_ajax_load_more_buildings', 'load_more_buildings' );
function load_more_buildings() {

	$next = isset( $_POST['next'] ) ? intval( $_POST['next'] ) : 1;
//	$next = $_POST['next'];

	$args  = array(
		'post_type'      => 'building',
		'posts_per_page' => 12,
		'offset'         => $next - 1,
		'order'          => 'DESC',
		'orderby'        => 'meta_value_num',
		'post_status'    => 'publish',
		'meta_query'     => array(
			'relation' => 'OR',
			array(
				'key'     => '_thumbnail_id',
				'compare' => 'EXISTS',
			),
			array(
				'key'     => '_thumbnail_id',
				'compare' => 'NOT EXISTS',
			),
		),
	);
	$query = new WP_Query( $args );

	$html = '';
	if ( $query->have_posts() ):
		while ( $query->have_posts() ): $query->the_post();
			ob_start();
			get_template_part( 'template-parts/components/buildings_loop' );
			$html .= ob_get_clean();
		endwhile;
		wp_reset_postdata();
	endif;

	echo $html;
	wp_die();
}


add_action( 'wp_ajax_nopriv_load_more_blog', 'load_more_blog' );
add_action( 'wp_ajax_load_more_blog', 'load_more_blog' );
function load_more_blog() {

	$next        = isset( $_POST['next'] ) ? intval( $_POST['next'] ) : 1;
	$category_id = isset( $_POST['termId'] ) ? intval( $_POST['termId'] ) : 1;

	$args = array(
		'post_type'      => 'post',
		'posts_per_page' => 9,
		'order'          => 'DESC',
		'offset'         => $next - 1,
		'post_status'    => 'publish',
	);
	if ( $category_id ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field'    => 'id',
				'terms'    => $category_id
			),
		);
	}
	$query = new WP_Query( $args );

	$html = '';
	if ( $query->have_posts() ):
		while ( $query->have_posts() ): $query->the_post();
			ob_start();
			get_template_part( 'template-parts/article' );
			$html .= ob_get_clean();
		endwhile;
		wp_reset_postdata();
	endif;

	echo $html;
	wp_die();
}


// load more on search page
add_action( 'wp_ajax_nopriv_load_more_search', 'load_more_search' );
add_action( 'wp_ajax_load_more_search', 'load_more_search' );
function load_more_search() {

	$next          = isset( $_POST['next'] ) ? intval( $_POST['next'] ) : 1;
	$filtersearch  = $_POST['dataFilter'] ? $_POST['dataFilter'] : null;
	$neighborhoods = $_POST['neighborhoods'] ? $_POST['neighborhoods'] : null;
	$bedrooms      = $_POST['bedrooms'] ? $_POST['bedrooms'] : null;
	$price         = $_POST['price'] ? $_POST['price'] : null;
	if ( $price ) {
		$price = array_map( 'intval', explode( '-', $price ) );
	}
	if ( $neighborhoods ) {
		$neighborhoods = array_map( 'trim', explode( ',', $neighborhoods ) );
	}
	if ( $bedrooms ) {
		$bedrooms = array_map( 'intval', explode( ',', $bedrooms ) );
	}

	$args = array(
		'posts_per_page' => 12,
		'post_type'      => $filtersearch,
		'order'          => 'DESC',
		'offset'         => $next - 1,
		'post_status'    => 'publish',
	);


	if ( $bedrooms && $price ) {
		$args['meta_query'] = array(
			'relation' => 'AND',
			array(
				'key'      => 'bedrooms',
				'value'    => $bedrooms,
				'operator' => 'IN'
			),
			array(
				'key'     => 'price',
				'value'   => $price,
				'type'    => 'numeric',
				'compare' => 'BETWEEN'
			),
		);
	} elseif ( $bedrooms ) {

		$args['meta_query'] = array(
			'relation' => 'AND',
			array(
				'key'      => 'bedrooms',
				'value'    => $bedrooms,
				'operator' => 'IN'
			),
		);
	} elseif ( $price ) {
		$args['meta_query'] = array(
			'relation' => 'AND',
			array(
				'key'     => 'price',
				'value'   => $price,
				'type'    => 'numeric',
				'compare' => 'BETWEEN'
			),
		);
	}

	$query = new WP_Query( $args );

	$html = '';
	if ( $query->have_posts() ):
		while ( $query->have_posts() ): $query->the_post();
			ob_start();
			?>
			<div class="col-xl-3 col-md-6 col-lg-4">
				<?php get_template_part( 'template-parts/builder/components/new_appartament_item' ); ?>
			</div>
			<?php $html .= ob_get_clean();
		endwhile;
		wp_reset_postdata();
	endif;

	echo $html;
	wp_die();
}


// load more on tax collections page
add_action( 'wp_ajax_nopriv_load_more_tax_collections', 'load_more_tax_collections' );
add_action( 'wp_ajax_load_more_tax_collections', 'load_more_tax_collections' );
function load_more_tax_collections() {

	$next    = isset( $_POST['next'] ) ? intval( $_POST['next'] ) : 1;
	$term_id = $_POST['dataTerm'] ? $_POST['dataTerm'] : null;

	$args = array(
		'post_type'      => 'apartment',
		'posts_per_page' => 12,
		'order'          => 'DESC',
		'offset'         => $next - 1,
		'post_status'    => 'publish',
		'tax_query'      => array(
			array(
				'taxonomy' => 'collections',
				'field'    => 'term_id',
				'terms'    => $term_id,
			),
		),
	);


	$query = new WP_Query( $args );

	$html = '';
	if ( $query->have_posts() ):
		while ( $query->have_posts() ): $query->the_post();
			ob_start();
			?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<?php get_template_part( 'template-parts/builder/components/new_appartament_item' ); ?>
			</div>
			<?php $html .= ob_get_clean();
		endwhile;
		wp_reset_postdata();
	endif;

	echo $html;
	wp_die();
}

// load more on tax neighborhoods page
add_action( 'wp_ajax_nopriv_load_more_tax_neighborhoods', 'load_more_tax_neighborhoods' );
add_action( 'wp_ajax_load_more_tax_neighborhoods', 'load_more_tax_neighborhoods' );
function load_more_tax_neighborhoods() {

	$next    = isset( $_POST['next'] ) ? intval( $_POST['next'] ) : 1;
	$term_id = $_POST['dataTerm'] ? $_POST['dataTerm'] : null;

	$args = array(
		'post_type'      => 'apartment',
		'posts_per_page' => 12,
		'order'          => 'DESC',
		'offset'         => $next - 1,
		'post_status'    => 'publish',
		'tax_query'      => array(
			array(
				'taxonomy' => 'neighborhood',
				'field'    => 'term_id',
				'terms'    => $term_id,
			),
		),
	);


	$query = new WP_Query( $args );

	$html = '';
	if ( $query->have_posts() ):
		while ( $query->have_posts() ): $query->the_post();
			ob_start();
			?>
			<div class="col-xl-3 col-lg-4 col-md-6">
				<?php get_template_part( 'template-parts/builder/components/new_appartament_item' ); ?>
			</div>
			<?php $html .= ob_get_clean();
		endwhile;
		wp_reset_postdata();
	endif;

	echo $html;
	wp_die();
}


// listing_filter
add_action( 'wp_ajax_listing_filter', 'listing_filter_function' ); // wp_ajax_{ACTION HERE}
add_action( 'wp_ajax_nopriv_listing_filter', 'listing_filter_function' );

function listing_filter_function() {


	$args = array(
		'post_type'      => array( $_POST['post_type'] ),
		'posts_per_page' => - 1,
	);
	if ( $_POST['text'] != 'all' ) {
		$args['s'] = $_POST['text'];
	}
	if ( $_POST['status'] != 'all' ) {
		$args['post_status'] = array( $_POST['status'] );
	} else {
		$args['post_status'] = array( 'publish', 'active', 'pending', 'draft' );
	}

	if ( $_POST['neighborhood'] ) {
		$args['tax_query'] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'neighborhood',
				'field'    => 'slug',
				'terms'    => $_POST['neighborhood'],
				'operator' => 'IN'
			),
		);
	}

	if ( $_POST['user_agent'] ) {

		$args['meta_query'] = array(
			'relation' => 'AND',
			array(
				'key'      => 'user_agent',
				'value'    => $_POST['user_agent'],
				'operator' => 'IN'
			),
		);
	}


	$query = new WP_Query( $args );
	?>

	<?php if ( $query->have_posts() ): ?>
		<?php while ( $query->have_posts() ): $query->the_post(); ?>
			<?php get_template_part( 'admin-templates/listing_grid_row', null, [ 'post-type' => $_POST['post_type'] ] ); ?>
		<?php endwhile; ?>
	<?php
	else:
		_e( 'No Results', '_it_start' );
	endif;
	wp_reset_postdata();


	die();
}


// edit listing only page
//add_action( 'wp_ajax_ajax_edit_listing', 'ajax_edit_listing' );
//add_action( 'wp_ajax_nopriv_ajax_edit_listing', 'ajax_edit_listing' );
//function ajax_edit_listing() {
////	parse_str( $_POST['form_data'], $form_data );
//
//	if ( isset( $_POST['title'] ) ) {
//		$id      = $_POST['post_id'];
//		$status  = $_POST['status'];
//		$my_post = array(
//			'ID'          => $_POST['post_id'],
//			'post_title'  => $_POST['title'],
//			'post_status' => $status,
//		);
//		wp_update_post( $my_post );
//
//
//		if ( isset( $_POST['subway_lines_title'] ) == true ) {
//			$type     = $_POST['subway_lines_type'];
//			$title    = $_POST['subway_lines_title'];
//			$location = $_POST['subway_lines_location'];
//			$result   = array();
//			for ( $i = 0; $i < count( $_POST['subway_lines_type'] ); $i ++ ) {
//				$result[] = array(
//					'field_649efe942c9c6' => $type[ $i ],
//					'field_6429d459b5615' => $title[ $i ],
//					'field_6429d464b5616' => $location[ $i ]
//				);
//			}
//			update_field( 'subway_lines', $result, $_POST['post_id'] );
//		}
//
//
//		// Save categories
//		if ( isset( $_POST['collections'] ) ) {
//			$collections_cat = $_POST['collections'];
//			wp_set_post_categories( $id, $collections_cat, 'collections' ); // Assign categories to 'collections' taxonomy
//		}
//
//		if ( isset( $_POST['building_neighborhood'] ) ) {
//			$building_neighborhood_terms    = $_POST['building_neighborhood'];
//			$building_neighborhood_term_ids = array();
//			foreach ( $building_neighborhood_terms as $term_slug ) {
//				$term = get_term_by( 'slug', $term_slug, 'neighborhood' );
//				if ( $term ) {
//					$building_neighborhood_term_ids[] = $term->term_id;
//				}
//			}
//			wp_set_post_terms( $id, $building_neighborhood_term_ids, 'neighborhood' );
//		}
//
//		if ( isset( $_POST['building_amenities'] ) ) {
//			$building_amenities_terms    = $_POST['building_amenities'];
//			$building_amenities_term_ids = array();
//			foreach ( $building_amenities_terms as $term_slug ) {
//				$term = get_term_by( 'slug', $term_slug, 'building_amenities' );
//				if ( $term ) {
//					$building_amenities_term_ids[] = $term->term_id;
//				}
//			}
//			wp_set_post_terms( $id, $building_amenities_term_ids, 'building_amenities' );
//		}
//
//		if ( isset( $_POST['apartment_amenities'] ) ) {
//			$apartment_amenities_terms     = $_POST['apartment_amenities'];
//			$apartment_amenities_terms_ids = array();
//			foreach ( $apartment_amenities_terms as $term_slug ) {
//				$term = get_term_by( 'slug', $term_slug, 'apartment_amenities' );
//				if ( $term ) {
//					$apartment_amenities_terms_ids[] = $term->term_id;
//				}
//			}
//			wp_set_post_terms( $id, $apartment_amenities_terms_ids, 'apartment_amenities' );
//		}
//	}
//
//	if ( isset( $_POST['location'] ) ) {
//		$location = $_POST['location'];
//		update_field( 'buildings_subtitle', $location, $id ); // Update the 'location' field value
//	}
//
//	if ( isset( $_POST['price'] ) ) {
//		$new_price = $_POST['price'];
//		update_field( 'price', intval( $new_price ), $id ); // Update the 'price' field value
//	}
//
//	if ( isset( $_POST['bedrooms'] ) ) {
//		$new_price = $_POST['bedrooms'];
//		update_field( 'bedrooms', intval( $new_price ), $id ); // Update the 'bedrooms' field value
//	}
//
//	if ( isset( $_POST['bathrooms'] ) ) {
//		$new_price = $_POST['bathrooms'];
//		update_field( 'bathrooms', intval( $new_price ), $id ); // Update the 'bathrooms' field value
//	}
//
//	if ( isset( $_POST['squares_ft'] ) ) {
//		$new_price = $_POST['squares_ft'];
//		update_field( 'squares_ft', intval( $new_price ), $id ); // Update the 'squares_ft' field value
//	}
//
//	if ( isset( $_POST['move_in'] ) ) {
//		$move_in = $_POST['move_in'];
//		update_field( 'move_in', $move_in, $id ); // Update the 'move_in' field value
//	}
//
//	// overview_content
//	if ( isset( $_POST['overview_content'] ) ) {
//		$move_in = $_POST['overview_content'];
//		update_field( 'overview_content', $move_in, $id ); // Update the 'overview_content' field value
//	}
//
//	// new_to_market
//	if ( isset( $_POST['new_to_market'] ) ) {
//		$new_to_market = true;
//	} else {
//		$new_to_market = false;
//	}
//	update_field( 'new_to_market', $new_to_market, $id ); // Update the 'new_to_market' field value
//
//	// $first_month_free
//	if ( isset( $_POST['first_month_free'] ) ) {
//		$first_month_free = true;
//	} else {
//		$first_month_free = false;
//	}
//	update_field( 'first_month_free', $first_month_free, $id ); // Update the 'first_month_free' field value
//
//	if ( isset( $_POST['user_agent'] ) ) {
//		$move_in = $_POST['user_agent'];
//		update_field( 'user_agent', $move_in, $id ); // Update the 'user_agent' field value
//	}
//
//	if ( isset( $_POST['collections'] ) ) {
//		wp_set_object_terms( $id, $_POST['collections'], 'collections' );
//	}
//
//	// Gallery
//	if ( isset( $_FILES['gallery'] ) ) {
//		$listing_image_input = $_POST['listing_image_input'];
//
////	TODO: Gallery uploading not opening WP Media
//		$files            = $_FILES['gallery'];
//		$old_images       = $_POST['gallery_ids'];
//		$old_images_array = explode( ",", $old_images[0] );
//		if ( isset( $files ) ) {
//			for ( $i = 0; $i < count( $files['name'] ); $i ++ ) {
//				$file = array(
//					'name'     => $files['name'][ $i ],
//					'type'     => $files['type'][ $i ],
//					'tmp_name' => $files['tmp_name'][ $i ],
//					'error'    => $files['error'][ $i ],
//					'size'     => $files['size'][ $i ]
//				);
//
//				$attachment_id = media_handle_sideload( $file, $_POST['post_id'] );
//				if ( ! is_wp_error( $attachment_id ) ) {
//					$image_ids[] = $attachment_id;
//				}
//
//				$image_ids[] = $attachment_id;
//			}
//
//			foreach ( $old_images_array as $val ) {
//				$image_ids[] = $val;
//			}
//			$update_result = update_field( 'gallery', $image_ids, $_POST['post_id'] );
//
//
//			if ( isset( $listing_image_input ) ) {
//				$set_thumb = set_post_thumbnail( $_POST['post_id'], $listing_image_input );
//			}
//		}
//	}
//
////	if ( isset( $_FILES['thumb'] ) ) {
////		$file = $_FILES['thumb'];
////
////		$file = array(
////			'name'     => $file['name'],
////			'type'     => $file['type'],
////			'tmp_name' => $file['tmp_name'],
////			'error'    => $file['error'],
////			'size'     => $file['size']
////		);
////		if ( ! empty( $file['name'] ) ) {
////			$attachment_id = media_handle_sideload( $file, $_POST['post_id'] );
////			set_post_thumbnail( $_POST['post_id'], $attachment_id );
////		}
////	}
//
//	// banner img
////	if ( isset( $_FILES['banner_img'] ) ) {
////		$file = $_FILES['banner_img'];
////
////		$file = array(
////			'name'     => $file['name'],
////			'type'     => $file['type'],
////			'tmp_name' => $file['tmp_name'],
////			'error'    => $file['error'],
////			'size'     => $file['size']
////		);
////		if ( ! empty( $file['name'] ) ) {
////			$attachment_id = media_handle_sideload( $file, $_POST['post_id'] );
////			$update_result = update_field( 'banner_image', $attachment_id, $_POST['post_id'] );
////		}
////	}
//
//	//    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
//	//        // This is an AJAX request
//	//        $response = array('success' => true);
//	//        wp_send_json($response);
//	//    } else {
//	//        // This is a regular form submission
//	//        // You can redirect or display a success message here
//	//    }
//	wp_die();
//}

// retrieves the attachment ID from the file URL
function pippin_get_image_id( $image_url ) {
	global $wpdb;
	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );

	return $attachment[0];
}


// new listing page
add_action( 'wp_ajax_ajax_new_listing', 'ajax_new_listing' );
add_action( 'wp_ajax_nopriv_ajax_new_listing', 'ajax_new_listing' );
function ajax_new_listing() {
//	parse_str( $_POST['form_data'], $form_data );

	if ( isset( $_POST['title'] ) ) {
		$id      = $_POST['post_id'];
		$status  = $_POST['status'];
		$cpt     = $_POST['cpt'];
		$my_post = array(
			//            'ID'         => $form_data['post_id'],
			'post_title'  => $_POST['title'],
			'post_type'   => $cpt,
			'post_status' => $status,
		);
		$id      = wp_insert_post( $my_post );


		// Save categories
		if ( isset( $_POST['collections'] ) ) {
			$collections_cat = $_POST['collections'];
			wp_set_post_categories( $id, $collections_cat, 'collections' ); // Assign categories to 'collections' taxonomy
		}

		if ( isset( $_POST['building_amenities'] ) ) {
			$building_amenities_terms    = $_POST['building_amenities'];
			$building_amenities_term_ids = array();
			foreach ( $building_amenities_terms as $term_slug ) {
				$term = get_term_by( 'slug', $term_slug, 'building_amenities' );
				if ( $term ) {
					$building_amenities_term_ids[] = $term->term_id;
				}
			}
			wp_set_post_terms( $id, $building_amenities_term_ids, 'building_amenities' );
		}


		if ( isset( $_POST['building_neighborhood'] ) ) {
			$building_neighborhood_terms    = $_POST['building_neighborhood'];
			$building_neighborhood_term_ids = array();
			foreach ( $building_neighborhood_terms as $term_slug ) {
				$term = get_term_by( 'slug', $term_slug, 'neighborhood' );
				if ( $term ) {
					$building_neighborhood_term_ids[] = $term->term_id;
				}
			}
			wp_set_post_terms( $id, $building_neighborhood_term_ids, 'neighborhood' );
		}


		if ( isset( $_POST['apartment_amenities'] ) ) {
			$apartment_amenities_terms     = $_POST['apartment_amenities'];
			$apartment_amenities_terms_ids = array();
			foreach ( $apartment_amenities_terms as $term_slug ) {
				$term = get_term_by( 'slug', $term_slug, 'apartment_amenities' );
				if ( $term ) {
					$apartment_amenities_terms_ids[] = $term->term_id;
				}
			}
			wp_set_post_terms( $id, $apartment_amenities_terms_ids, 'apartment_amenities' );
		}


		if ( isset( $_POST['subway_lines_title'] ) == true ) {
			$type     = $_POST['subway_lines_type'];
			$title    = $_POST['subway_lines_title'];
			$location = $_POST['subway_lines_location'];
			$result   = array();
			for ( $i = 0; $i < count( $_POST['subway_lines_type'] ); $i ++ ) {
				$result[] = array(
					'field_649efe942c9c6' => $type[ $i ],
					'field_6429d459b5615' => $title[ $i ],
					'field_6429d464b5616' => $location[ $i ]
				);
			}
			update_field( 'subway_lines', $result, $id );
		}

	}

	if ( isset( $_POST['apartment_number'] ) ) {
		$apartment_number = $_POST['apartment_number'];
		update_field( 'apartment_number', $apartment_number, $id ); // Update the 'apartment_number' field value
	}

	if ( isset( $_POST['city'] ) ) {
		$city = $_POST['city'];
		update_field( 'city', $city, $id );
	}

	if ( isset( $_POST['state'] ) ) {
		$state = $_POST['state'];
		update_field( 'state', $state, $id );
	}

	if ( isset( $_POST['zip'] ) ) {
		$zip = $_POST['zip'];
		update_field( 'zip', $zip, $id );
	}

	if ( isset( $_POST['propertytype'] ) ) {
		$propertytype = $_POST['propertytype'];
		update_field( 'propertytype', $propertytype, $id );
	}

	if ( isset( $_POST['price'] ) ) {
		$new_price = $_POST['price'];
		update_field( 'price', intval( $new_price ), $id ); // Update the 'price' field value
	}

	if ( isset( $_POST['bedrooms'] ) ) {
		$new_price = $_POST['bedrooms'];
		update_field( 'bedrooms', intval( $new_price ), $id ); // Update the 'bedrooms' field value
	}

	if ( isset( $_POST['bathrooms'] ) ) {
		$new_price = $_POST['bathrooms'];
		update_field( 'bathrooms', intval( $new_price ), $id ); // Update the 'bathrooms' field value
	}

	if ( isset( $_POST['squares_ft'] ) ) {
		$new_price = $_POST['squares_ft'];
		update_field( 'squares_ft', intval( $new_price ), $id ); // Update the 'squares_ft' field value
	}

	if ( isset( $_POST['move_in'] ) ) {
		$move_in = $_POST['move_in'];
		update_field( 'move_in', $move_in, $id ); // Update the 'move_in' field value
	}

	// overview_content
	if ( isset( $_POST['overview_content'] ) ) {
		$move_in = $_POST['overview_content'];
		update_field( 'overview_content', $move_in, $id ); // Update the 'overview_content' field value
	}

	// new_to_market
	if ( isset( $_POST['new_to_market'] ) ) {
		$new_to_market = true;
	} else {
		$new_to_market = false;
	}
	update_field( 'new_to_market', $new_to_market, $id ); // Update the 'new_to_market' field value

	// $first_month_free
	if ( isset( $_POST['first_month_free'] ) ) {
		$first_month_free = true;
	} else {
		$first_month_free = false;
	}
	update_field( 'first_month_free', $first_month_free, $id ); // Update the 'first_month_free' field value

	if ( isset( $_POST['user_agent'] ) ) {
		$move_in = $_POST['user_agent'];
		update_field( 'user_agent', $move_in, $id ); // Update the 'user_agent' field value
	}

	if ( isset( $_POST['collections'] ) ) {
		wp_set_object_terms( $id, $_POST['collections'], 'collections' );
	}

	// Gallery
	if ( isset( $_FILES['gallery'] ) ) {
//		$listing_image_input = $_POST['listing_image_input'];

//	TODO: Gallery uploading not opening WP Media
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$files = $_FILES['gallery'];
		var_dump( $files );
//		$old_images       = $_POST['gallery_ids'];
//		$old_images_array = explode( ",", $old_images[0] );
		if ( isset( $files ) ) {
			for ( $i = 0; $i < count( $files['name'] ); $i ++ ) {
				$file          = array(
					'name'     => $files['name'][ $i ],
					'type'     => $files['type'][ $i ],
					'tmp_name' => $files['tmp_name'][ $i ],
					'error'    => $files['error'][ $i ],
					'size'     => $files['size'][ $i ]
				);
				$attachment_id = media_handle_sideload( $file, $id );
				if ( ! is_wp_error( $attachment_id ) ) {
					$image_ids[] = $attachment_id;
				}

				$image_ids[] = $attachment_id;
			}

//			foreach ( $old_images_array as $val ) {
//				$image_ids[] = $val;
//			}


			$update_result = update_field( 'gallery', $image_ids, $id );


//
//			if ( isset( $listing_image_input ) ) {
//				$set_thumb = set_post_thumbnail( $id, $listing_image_input );
//			}
		}
	}


	if ( ! is_wp_error( $id ) ) {
		wp_send_json_success( array( 'post_id' => $id ) );
	}

	wp_die();
}


// new building page
add_action( 'wp_ajax_ajax_new_building', 'ajax_new_building' );
add_action( 'wp_ajax_nopriv_ajax_new_building', 'ajax_new_building' );
function ajax_new_building() {
//	parse_str( $_POST['building_form_data'], $form_data );

	if ( isset( $_POST['title'] ) ) {
		$id      = $_POST['post_id'];
		$status  = $_POST['status'];
		$my_post = array(
			'post_title'  => $_POST['title'],
			'post_type'   => 'building',
			'post_status' => $status,
		);
		$id      = wp_insert_post( $my_post );


		// Save categories
		if ( isset( $_POST['building_amenities'] ) ) {
			$building_amenities_terms    = $_POST['building_amenities'];
			$building_amenities_term_ids = array();
			foreach ( $building_amenities_terms as $term_slug ) {
				$term = get_term_by( 'slug', $term_slug, 'building_amenities' );
				if ( $term ) {
					$building_amenities_term_ids[] = $term->term_id;
				}
			}
			wp_set_post_terms( $id, $building_amenities_term_ids, 'building_amenities' );
		}

		if ( isset( $_POST['building_neighborhood'] ) ) {
			$building_neighborhood_terms    = $_POST['building_neighborhood'];
			$building_neighborhood_term_ids = array();
			foreach ( $building_neighborhood_terms as $term_slug ) {
				$term = get_term_by( 'slug', $term_slug, 'neighborhood' );
				if ( $term ) {
					$building_neighborhood_term_ids[] = $term->term_id;
				}
			}
			wp_set_post_terms( $id, $building_neighborhood_term_ids, 'neighborhood' );
		}

		if ( isset( $_POST['building_posts'] ) ) {
			$building_posts = $_POST['building_posts'];

			update_field( 'connected_apartaments', $building_posts, $id ); // Update the 'building_posts' field value
		}

	}

	if ( isset( $_POST['location'] ) ) {
		$location = $_POST['location'];
		update_field( 'buildings_subtitle', $location, $id ); // Update the 'location' field value
	}


//	require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
//	require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
//	require_once( ABSPATH . "wp-admin" . '/includes/media.php' );

	if ( isset( $_FILES['thumb'] ) ) {
		$file = $_FILES['thumb'];

		$file = array(
			'name'     => $file['name'],
			'type'     => $file['type'],
			'tmp_name' => $file['tmp_name'],
			'error'    => $file['error'],
			'size'     => $file['size']
		);
		if ( ! empty( $file['name'] ) ) {
			$attachment_id = media_handle_sideload( $file, $id );
			set_post_thumbnail( $id, $attachment_id );
		}
	}

	// banner img
	if ( isset( $_FILES['banner_img'] ) ) {
		$file = $_FILES['banner_img'];

		$file = array(
			'name'     => $file['name'],
			'type'     => $file['type'],
			'tmp_name' => $file['tmp_name'],
			'error'    => $file['error'],
			'size'     => $file['size']
		);
		if ( ! empty( $file['name'] ) ) {
			$attachment_id = media_handle_sideload( $file, $id );
			$update_result = update_field( 'banner_image', $attachment_id, $id );
		}
	}


	if ( ! is_wp_error( $id ) ) {
		wp_send_json_success( array( 'post_id' => $id ) );
	}

	wp_die();
}


// Deal with images uploaded from the front-end while allowing ACF to do it's thing
function my_acf_pre_save_post( $post_id ) {

	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}

	// Move file to media library
	$movefile = wp_handle_upload( $_FILES['my_image_upload'], array( 'test_form' => false ) );

	// If move was successful, insert WordPress attachment
	if ( $movefile && ! isset( $movefile['error'] ) ) {
		$wp_upload_dir = wp_upload_dir();
		$attachment    = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $movefile['file'] ),
			'post_mime_type' => $movefile['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', ”, basename( $movefile['file'] ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);
		$attach_id     = wp_insert_attachment( $attachment, $movefile['file'] );

		// Assign the file as the featured image
		set_post_thumbnail( $post_id, $attach_id );
		update_field( 'my_image_upload', $attach_id, $post_id );

	}

	return $post_id;

}

add_filter( 'acf/pre_save_post', 'my_acf_pre_save_post' );


// delete agent/listing
add_action( 'wp_head', 'my_action_javascript' );
function my_action_javascript() {

	?>
	<script type="text/javascript">
		jQuery(document).ready(function () {

			jQuery(".delete_user").click(function () {
				var current_element_var = jQuery(this);

				// Show a confirmation dialog
				var confirmDelete = confirm("Are you sure you want to delete this user?");
				if (!confirmDelete) {
					return false; // Cancel the delete action
				}

				var data = {
					'action': 'delete_user_action',
					'user_id': current_element_var.attr('delete-user-id'),
					'security': '<?php echo wp_create_nonce( "security-special-string" ) ?>'
				};

				jQuery.post('<?php echo admin_url( 'admin-ajax.php' ) ?>', data, function (response) {
					if (response === 'deleted_successfully') {
						current_element_var.closest('.agents_grid--row').addClass('removed');
						current_element_var.parent().find('a').hide();
						console.log(current_element_var);
						current_element_var.parent().after('<span> Deleted </span>');
						current_element_var.remove();
					}
				});

				return false;
			});

			jQuery(".delete_listing").click(function () {
				var current_element_var = jQuery(this);

				// Show a confirmation dialog
				var confirmDelete = confirm("Are you sure you want to delete post?");
				if (!confirmDelete) {
					return false; // Cancel the delete action
				}

				var data = {
					'action': 'delete_listing_action',
					'user_id': current_element_var.attr('delete-listing-id'),
					'security': '<?php echo wp_create_nonce( "security-special-string" ) ?>'
				};

				jQuery.post('<?php echo admin_url( 'admin-ajax.php' ) ?>', data, function (response) {
					if (response === 'deleted_successfully') {
						current_element_var.closest('.listing_grid--row').addClass('removed');
						current_element_var.parent().find('a').hide();
						// console.log(current_element_var);
						current_element_var.parent().after('<span> Deleted </span>');
						current_element_var.remove();
					}
				});

				return false;
			});

		});
	</script>
	<?php

}

add_action( 'wp_ajax_delete_user_action', 'delete_user_action_callback' );
add_action( 'wp_ajax_nopriv_delete_user_action', 'delete_user_action_callback' );

function delete_user_action_callback() {
	check_ajax_referer( 'security-special-string', 'security' );
	wp_delete_user( $_POST['user_id'] );
	echo 'deleted_successfully';
	die();
}

add_action( 'wp_ajax_delete_listing_action', 'delete_listing_action_callback' );
add_action( 'wp_ajax_nopriv_delete_listing_action', 'delete_listing_action_callback' );

function delete_listing_action_callback() {
	check_ajax_referer( 'security-special-string', 'security' );
	wp_delete_post( $_POST['user_id'] );
	echo 'deleted_successfully';
	die();
}


// agents page
add_action( 'wp_ajax_agents_search', 'agents_search_function' ); // wp_ajax_{ACTION HERE}
add_action( 'wp_ajax_nopriv_agents_search', 'agents_search_function' );

function agents_search_function() {

	$args  = array(
		'role'           => 'agent',
		'search'         => '*' . $_POST['text'] . '*',
		'search_columns' => array(
			'user_login',
			'user_nicename',
			'user_email',
			'display_name',
		),
	);
	$users = get_users( $args );
	if ( $users ) {
		foreach ( $users as $user ) :
			$user_id_prefixed = 'user_' . $user->ID;
			get_template_part( 'admin-templates/agents_grid_row', null, [
				'user'    => $user,
				'user_id' => $user_id_prefixed
			] );
		endforeach;
	} else {
		_e( 'No Results', '_it_start' );
	}
	die();
}



