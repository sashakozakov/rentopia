<?php

add_role( 'agent', __( 'Agent' ), array(
	'read' => true, // Allows a user to read
	'create_posts' => true, // Allows user to create new posts
	'edit_posts' => true, // Allows user to edit their own posts
) );

add_role( 'manager', __( 'Manager' ), array(
	'read' => true, // Allows a user to read
	'create_posts' => true, // Allows user to create new posts
	'edit_posts' => true, // Allows user to edit their own posts
) );

add_role( 'nonactive', __( 'Non-Active Agent' ), array(
	'read' => false, // Allows a user to read
	'create_posts' => false, // Allows user to create new posts
	'edit_posts' => false, // Allows user to edit their own posts
) );

add_role( 'pending', __( 'Pending Agent' ), array(
	'read' => false, // Allows a user to read
	'create_posts' => false, // Allows user to create new posts
	'edit_posts' => false, // Allows user to edit their own posts
) );


function get_user_role($id) {
	$user = new WP_User($id);
	return array_shift($user->roles);
}


add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}
