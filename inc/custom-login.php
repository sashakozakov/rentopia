<?php

//Customize login page

add_action('login_header', 'custom_login_header');

function custom_login_header()
{
	get_header();

	echo '<div class="login-layout" style="background-image: url(' . get_field('login_background', 'option') . ')">
	<div class="hidden-md-up login-layout--img">
	<div>
	<img src="' . get_field('login_background', 'option') . '" alt="" >
</div>
	</div>
<svg class="visible-md-up" width="1728" height="248" viewBox="0 0 1728 248" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1211 208C1149.23 215.208 1052 217 1052 217L903 219L747.5 215.5C598.294 209.461 396 196.5 374 195C352 193.5 240.188 183.781 154.5 176C120.715 172.932 68 168 68 168L0.5 161V247.5H1729.5L1728 0C1728 0 1710.5 17.5 1686 37C1661.5 56.5 1656 60.5 1641 69.5C1626 78.5 1586 101 1576 106C1566 111 1531 127.5 1509 136.5C1487 145.5 1428 163.5 1428 163.5L1353.5 183.5C1353.5 183.5 1267.09 201.456 1211 208Z" fill="white"/>
</svg>
            <div class="login-box">';

	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : ($_REQUEST['registration'] ? 'register' : 'login');


	switch ($action) {
		case 'login':
//			$title = 'Log in';
			$title = null;
			break;

		case 'register':
//			$title = 'Sign up';
			$title = null;
			break;

		case 'lostpassword':
			$title = 'Restore';
			break;
	}

	if ($title) {
		echo '<h2 class="text-primary text-center">' . $title . '</h2>';
	}
}

add_action('login_footer', 'custom_login_footer');

function custom_login_footer()
{
//	echo "<script>
//                jQuery('#login [type=\"submit\"]').val('Submit');
//
//                jQuery('#login input').filter('[type=\"text\"], [type=\"email\"], [type=\"password\"]').each(function(){
//                    jQuery(this).attr('placeholder', jQuery(this).closest('label').text().split(' ')[0]);
//                });
//    </script>";
//
//	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
//	$message = '';
//
//	switch ($action) {
//		case 'login':
//			$message = 'Don\'t have an account? <a href="' . esc_url(wp_registration_url()) . '">Sign up</a>';
//			break;
//
//		case 'register':
//			$message = 'Do you have an account? <a href="' . esc_url(wp_login_url()) . '">Sign In</a>';
//			break;
//
//		case 'lostpassword':
//			$message = '';
//			break;
//	}
//
//	echo '<div class="text-notice text-center">' . $message . '</div>';
//
//	echo '</div>
//         </div>';
	get_footer();
}


// TODO: check login redirection
//function login_redirect($redirect_to, $request, $user)
//{
//	//is there a user to check?
//	global $user;
//	if (isset($user->roles) && is_array($user->roles)) {
//
//		if (in_array('subscriber', $user->roles)) {
//
//
//			return '/member';
//		} else {
//			return $redirect_to;
//		}
//	} else {
//		return $redirect_to;
//	}
//
//	return $redirect_to;
//}
//
//add_filter('login_redirect', 'login_redirect', 10, 3);


// disable language switcher on login page
add_filter('login_display_language_dropdown', '__return_false');


// custom error message on login page
function no_wordpress_errors()
{
	return __('Wrong password. Try again or click "Lost your password" to reset it. ', 'rentopia');
}

add_filter('login_errors', 'no_wordpress_errors');


// custom text on login page
function custom_login_message()
{
	$message = '<div class="login_text">';
	$message .= '<p class="text-center">';
	$message .= __('Please enter your email address and password to log in', 'rentopia');
	$message .= '</p>';
	$message .= '</div>';
	return $message;
}

add_filter('login_message', 'custom_login_message');
