<?php
/**
 * IT Starter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package _it_start
 */

add_filter('wpcf7_autop_or_not', '__return_false');
add_filter('wpcf7_load_css', '__return_false');

define('IT_DIR', get_template_directory());
define('IT_URL', get_template_directory_uri());
define('IT_DIST', get_template_directory_uri() . '/dist/');
define('IT_CSS', get_template_directory_uri() . '/dist/css/');
define('IT_JS', get_template_directory_uri() . '/dist/js/');
define('IT_IMG', get_template_directory_uri() . '/dist/img/');
define('JUST_PIXEL', 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==');

require IT_DIR . '/inc/after-theme-setup.php'; // all hooks that needs to be done on after_theme_setup
require IT_DIR . '/inc/acf.php'; // ACF related functions
require IT_DIR . '/inc/ajax.php'; // AJAX functions
require IT_DIR . '/inc/custom-post-type.php'; // Custom post types
require IT_DIR . '/inc/disables.php'; // Disable of extra unwanted features
require IT_DIR . '/inc/editor.php'; // Editor functions
require IT_DIR . '/inc/help-func.php'; // Helper functions
require IT_DIR . '/inc/lazy-load.php'; // Images and iframes lazyload
require IT_DIR . '/inc/login.php'; // Login screen customisation
require IT_DIR . '/inc/scripts-styles.php'; // Scripts and styles enqueue | dequeue
require IT_DIR . '/inc/svg-support.php'; // Adds support for SVG upload
require IT_DIR . '/inc/widgets.php'; // Sidebars and widgets
require IT_DIR . '/inc/custom-login.php';
require IT_DIR . '/inc/main-menu-walker.php'; // Menu walker
require IT_DIR . '/inc/roles.php'; // Menu walker

//if (class_exists('WooCommerce')) {
//	require IT_DIR . '/inc/woo.php'; // Woocommerce functions
//}


//
//function change_client_password() {
//	$current_user     = $_POST['current_user'];
//	$current_password = $_POST['current_password'];
//	$new_password     = $_POST['new_password'];
//	$confirm_password = $_POST['confirm_password'];
//	$user             = get_user_by( 'ID', $current_user );
//
//	$result = wp_check_password( $current_password, $user->data->user_pass, $current_user );
//
//	if ( $result ) {
//		if ( $new_password == $confirm_password ) {
//			wp_set_password( $new_password, $current_user );
//			wp_set_auth_cookie ( $current_user );
//			wp_set_current_user( $current_user );
//			do_action('wp_login', $user->user_login, $user );
//			echo 'Your new password is changed.';
//		} else {
//			echo 'Your current password is correct, but the new and confirm passwords do not match.';
//		}
//	} else {
//		echo 'Your current password is incorrect.';
//	}
//
//	wp_die();
//}


add_action('show_user_profile', 'extra_user_profile_fields');
add_action('edit_user_profile', 'extra_user_profile_fields');

// in admin pangel
function extra_user_profile_fields($user)
{ ?>
	<h3><?php _e("User Info", "blank"); ?></h3>

	<p>
		<label for="job_position"><?php _e("Job position"); ?></label>
		<input type="text" name="job_position" id="job_position"
			   value="<?php echo esc_attr(get_the_author_meta('job_position', $user->ID)); ?>"
			   class="text-input input"/><br/>
	</p>
	<p>
		<label for="languages"><?php _e("Languages"); ?></label>
		<input type="text" name="languages" id="languages"
			   value="<?php echo esc_attr(get_the_author_meta('languages', $user->ID)); ?>"
			   class="text-input input"/><br/>
	</p>
	<p>
		<label for="experience"><?php _e("Experience"); ?></label>
		<input type="text" name="experience" id="experience"
			   value="<?php echo esc_attr(get_the_author_meta('experience', $user->ID)); ?>"
			   class="text-input input"/><br/>
	</p>
	<p>
		<label for="phone"><?php _e("Phone"); ?></label>
		<input type="text" name="phone" id="phone"
			   value="<?php echo esc_attr(get_the_author_meta('phone', $user->ID)); ?>"
			   class="text-input input"/><br/>
	</p>
	<p>
		<label for="phone"><?php _e("WhatsApp"); ?></label>
		<input type="text" name="whatsapp" id="whatsapp"
			   value="<?php echo esc_attr(get_the_author_meta('whatsapp', $user->ID)); ?>"
			   class="text-input input"/><br/>
	</p>

	<p>
		<label for="linkedin"><?php _e("Linkedin"); ?></label>
		<input type="text" name="linkedin" id="linkedin"
			   value="<?php echo esc_attr(get_the_author_meta('linkedin', $user->ID)); ?>"
			   class="text-input input"/><br/>
	</p>
	<p>
		<label for="instagram"><?php _e("Instagram"); ?></label>
		<input type="text" name="instagram" id="instagram"
			   value="<?php echo esc_attr(get_the_author_meta('instagram', $user->ID)); ?>"
			   class="text-input input"/><br/>
	</p>
	<p>
		<label for="facebook"><?php _e("Facebook"); ?></label>
		<input type="text" name="facebook" id="facebook"
			   value="<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>"
			   class="text-input input"/><br/>
		<!-- span class="description"><?php //_e("Please enter your facebook."); ?></span-->
	</p>
	<p>
		<label for="twitter"><?php _e("Twitter"); ?></label>
		<input type="text" name="twitter" id="twitter"
			   value="<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>"
			   class="text-input input"/><br/>


		<!--- span class="description"><?php //_e("Please enter your twitter."); ?></span -->
	</p>


<?php }

add_action('personal_options_update', 'save_extra_user_profile_fields');
add_action('edit_user_profile_update', 'save_extra_user_profile_fields');

function save_extra_user_profile_fields($user_id)
{
	if (!current_user_can('edit_user', $user_id)) {
		return false;
	}
	update_user_meta($user_id, 'languages', $_POST['languages']);
	update_user_meta($user_id, 'experience', $_POST['experience']);
	update_user_meta($user_id, 'phone', $_POST['phone']);
	update_user_meta($user_id, 'whatsapp', $_POST['whatsapp']);
	update_user_meta($user_id, 'linkedin', $_POST['linkedin']);
	update_user_meta($user_id, 'instagram', $_POST['instagram']);
	update_user_meta($user_id, 'twitter', $_POST['twitter']);
	update_user_meta($user_id, 'facebook', $_POST['facebook']);
}


function add_ajaxurl_cdata_to_front()
{ ?>
	<script type="text/javascript"> //<![CDATA[
		ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		//]]> </script>
<?php }

add_action('wp_head', 'add_ajaxurl_cdata_to_front', 1);





function slugify($text, string $divider = '-')
{
	// replace non letter or digits by divider
	$text = preg_replace('~[^\pL\d]+~u', $divider, $text);

	// transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	// remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);

	// trim
	$text = trim($text, $divider);

	// remove duplicate divider
	$text = preg_replace('~-+~', $divider, $text);

	// lowercase
	$text = strtolower($text);

	if (empty($text)) {
		return 'n-a';
	}

	return $text;
}




// add a link to the WP Toolbar
function wpb_custom_toolbar_link($wp_admin_bar) {
	$args = array(
		'id' => 'custom_admin',
		'title' => 'Custom Admin',
		'href' =>  home_url() .'/listing',
		'meta' => array(
			'class' => 'custom_admin',
			'title' => 'Custom Admin'
		)
	);
	$wp_admin_bar->add_node($args);
}
add_action('admin_bar_menu', 'wpb_custom_toolbar_link', 999);


function remove_plugin_filter() {
	global $wp_filter;

	// Check if the filter has been added by the plugin
	if (isset($wp_filter['simpay_before_register_public_styles'])) {
		// Remove all callbacks attached to the filter
		unset($wp_filter['simpay_before_register_public_styles']);
	}
}


 
// Wait until WP Simple Pay is loaded.
add_action( 'plugins_loaded', function() {

	require_once( SIMPLE_PAY_INC . 'pro/webhooks/class-webhook-base.php' );
	require_once( SIMPLE_PAY_INC . 'pro/webhooks/class-webhook-interface.php' );

	/**
	 * Adds handling for `coupon.updated` webhook.
	 *
	 * @param array $webhooks Registered webhooks.
	 * @return array
	 */
	function simpay_custom_webhooks_get_event_whitelist( $webhooks ) {
		$webhooks['charge.pending'] = '\Custom_Invoice_Charge_Pending_Webhook';

		return $webhooks;
	}
	add_filter( 'simpay_webhooks_get_event_whitelist', 'simpay_custom_webhooks_get_event_whitelist' );

$to ="pesach@gmail.com";
$subject = "1 Payment Notification";
$msg = 'Rentopia Group website got a new payment! ';
$msg .= 'Please notice that this payment may still be pending so please confirm it either in stripe or in wordpress. ';
$msg .= 'Thank you! ';
$msg .= $webhooks;
$msg .= $webhooks['charge.pending'];
	
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Rentopia Group <info@rentopiagroup.com>' . "\r\n";
//$headers .= 'CC: info@example.com' . "\r\n";
wp_mail($to, $subject, $msg, $headers);
	
	/**
	 * Callback for `charge.pending` webook.
	 */
	class Custom_Invoice_Charge_Pending_Webhook extends \SimplePay\Pro\Webhooks\Webhook_Base implements \SimplePay\Pro\Webhooks\Webhook_Interface {

		/**
		 * Handle the Webhook's data.
		 */
		public function handle() {
			$object = $this->event->data->object;

			wp_mail(
				$object->receipt_email,  // to
				'Your payment is processing.', // subject
				'Your payment is processing.'  // message
			);
			
			
			
$to ="pesach@gmail.com";
$subject = "2 Payment Notification";
$msg = 'Rentopia Group website got a new payment! ';
$msg .= 'Please notice that this payment may still be pending so please confirm it either in stripe or in wordpress. ';
$msg .= 'Thank you! ';
$msg .= $webhooks;
			
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: Rentopia Group <info@rentopiagroup.com>' . "\r\n";
//$headers .= 'CC: info@example.com' . "\r\n";
wp_mail($to, $subject, $msg, $headers);
		}
	}

} );

add_action('init', 'remove_plugin_filter');

